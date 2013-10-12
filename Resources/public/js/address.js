/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

(function ($) {
    $.widget("custom.addressAutocomplete", {
        options: {
            url_id: null,
            url_parameter: null,
            input_text: null,
            input_object: null,
            button: null
        },

        _create: function () {
            if (this.options.url_id && this.options.url_parameter && this.options.input_text && this.options.input_object && this.options.button) {
                this._createAutocomplete();
                this._createShowAllButton();
            }
        },

        _createAutocomplete: function () {
            var input_object = this.options.input_object;
            var post_set = this.options.post_set;
            this.input = this.options.input_text
                .autocomplete({
                    delay: 300,
                    minLength: 0,
                    source: $.proxy(this, "_source"),
                    select: function (event, ui) {
                        event.preventDefault();
                        if (ui.item) {
                            $(this).val(ui.item.label);
                            input_object.val(ui.item.value);
                        }
                    },
                    focus: function (event, ui) {
                        event.preventDefault();
                    }
                });
        },

        _createShowAllButton: function () {
            var input = this.input,
                wasOpen = false;

            this.options.button
                .mousedown(function () {
                    wasOpen = input.autocomplete("widget").is(":visible");
                })
                .click(function () {
                    input.focus();

                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }

                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete('search', '');
                });
        },

        _source: function (request, response) {
            $.ajax({
                url: Routing.generate(this.options.url_id, { id: this.options.url_parameter }),
                dataType: "json",
                data: {
                    text: request.term
                },
                success: function (data) {
                    response($.map(data, function (item, id) {
                        return {
                            label: item,
                            value: id
                        }
                    }));
                }
            });

        }
    });

    $.fn.address_form = function () {
        var $addressForm = $(this);
        var $addressCountry = $addressForm.find('select.address_country:first option:selected');

        var $addressRegion = $addressForm.find('input[type=hidden].address_region:first');
        var $addressRegionName = $addressForm.find('input[type=text].address_region_name:first');

        var $addressCity = $addressForm.find('input[type=hidden].address_city:first');
        var $addressCityName = $addressForm.find('input[type=text].address_city_name:first');

        var $addressStreet = $addressForm.find('input[type=hidden].address_street:first');
        var $addressStreetName = $addressForm.find('input[type=text].address_street_name:first');

        var $addressHouse = $addressForm.find('input[type=hidden].address_house:first');
        var $addressHouseNumber = $addressForm.find('input[type=text].address_house_number:first');
        var $addressFlat = $addressForm.find('input[type=text].address_flat:first');
        var $addressPostCode = $addressForm.find('input[type=text].address_post_code:first');


        //Form sub object

        //Address region
        var $addressRegionForm = $addressForm.find('div.form_address_region:first');
        var $addressRegionUrl = $addressRegionForm.data('url_id');
        var $addressRegionButton = $addressForm.find('div.form_address_region:first div.address_button:first');

        //Address city
        var $addressCityForm = $addressForm.find('div.form_address_city:first');
        var $addressCityUrl = $addressCityForm.data('url_id');
        var $addressCityButton = $addressForm.find('div.form_address_city:first div.address_button:first');

        //Address street
        var $addressStreetForm = $addressForm.find('div.form_address_street:first');
        var $addressStreetUrl = $addressStreetForm.data('url_id');
        var $addressStreetButton = $addressForm.find('div.form_address_street:first div.address_button:first');

        $addressForm.find(".address_country").bind('change', function (event, ui) {
            $addressCountry = $addressForm.find('select.address_country:first option:selected');
            formAddressRegion($addressCountry.val());
            $addressRegionName.val('');
            $addressRegion.val('');
            $addressCityName.val('');
            $addressCity.val('');
            $addressStreetName.val('');
            $addressStreet.val('');
            cleanHouseFlatPostCode();
        });


        var formAddressRegion = function (url_parameter) {
            $addressRegionForm.addressAutocomplete({
                url_id: $addressRegionUrl,
                url_parameter: url_parameter,
                input_text: $addressRegionName,
                input_object: $addressRegion,
                button: $addressRegionButton
            }).bind('autocompleteselect', function (event, ui) {
                $addressRegion = $addressForm.find('input[type=hidden].address_region:first');
                    formAddressCity(ui.item.value);
                    $addressCityName.val('');
                    $addressCity.val('');
                    $addressStreetName.val('');
                    $addressStreet.val('');
                    cleanHouseFlatPostCode();
                });
        };

        if ($addressCountry.val()) {
            formAddressRegion($addressCountry.val());
        }

        var formAddressCity = function (url_parameter) {
            $addressCityForm.addressAutocomplete({
                url_id: $addressCityUrl,
                url_parameter: url_parameter,
                input_text: $addressCityName,
                input_object: $addressCity,
                button: $addressCityButton
            }).bind('autocompleteselect', function (event, ui) {
                $addressCity = $addressForm.find('input[type=hidden].address_city:first');
                formAddressStreet(ui.item.value);
                $addressStreetName.val('');
                $addressStreet.val('');
                cleanHouseFlatPostCode();
            });
        };


        if ($addressRegion.is(':enabled') && $addressRegion.val().length) {
            formAddressCity($addressRegion.val());
        }

        var formAddressStreet = function (url_parameter) {
            $addressStreetForm.addressAutocomplete({
                url_id: $addressStreetUrl,
                url_parameter: url_parameter,
                input_text: $addressStreetName,
                input_object: $addressStreet,
                button: $addressStreetButton
            }).bind('autocompleteselect', function (event, ui) {
                cleanHouseFlatPostCode();
            });
        };

        var cleanHouseFlatPostCode = function () {
            $addressHouse.val('');
            $addressHouseNumber.val('');
            $addressFlat.val('');
            $addressPostCode.val('');
        };

        if ($addressCity.is(':enabled') && $addressCity.val().length) {
            formAddressStreet($addressCity.val());
        }

        $addressHouseNumber.focusout(function () {
            if ($(this).val().length > 0 && $addressStreet.val().length) {
                $.ajax({
                    url: Routing.generate($addressPostCode.data('url_id'), { id: $addressStreet.val() }),
                    dataType: "json",
                    data: {
                        house: $(this).val()
                    },
                    success: function (data) {
                        if (data.post_code) {
                            $addressPostCode.attr('value', data.post_code);
                        }

                        if (data.house) {
                            $addressHouse.attr('value', data.house);
                        }
                    }
                });
            }
        });
    };
})(jQuery);
