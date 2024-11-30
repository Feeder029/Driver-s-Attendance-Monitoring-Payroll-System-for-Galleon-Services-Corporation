/**
 * __________________________________________________________________
 *
 * Phillipine Address Selector
 * __________________________________________________________________
 *
 * MIT License
 * 
 * Copyright (c) 2020 Wilfred V. Pine
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package Phillipine Address Selector
 * @author Wilfred V. Pine <only.master.red@gmail.com>
 * @copyright Copyright 2020 (https://dev.confired.com)
 * @link https://github.com/redmalmon/philippine-address-selector
 * @license https://opensource.org/licenses/MIT MIT License
 */
$(function () {
    // Populate provinces dropdown on page load
    const provinceDropdown = $('#updateprovince');
    const provinceUrl = '../Dropdown-Json/ph-json/province.json';
    const selectedProvince = $('#updateprovince-text').val();

    console.log("Selected Province on load:", selectedProvince);

    $.getJSON(provinceUrl, function (data) {
        console.log("Provinces JSON loaded:", data);

        provinceDropdown.empty();
        provinceDropdown.append('<option disabled>Select a Province</option>');
        $.each(data, function (_, entry) {
            provinceDropdown.append(
                `<option value="${entry.province_code}" ${
                    entry.province_name === selectedProvince ? 'selected' : ''
                }>${entry.province_name}</option>`
            );
        });

        // If there's a selected province, trigger change to load its cities
        if (selectedProvince) {
            console.log("Triggering change for selected province:", selectedProvince);
            provinceDropdown.trigger('change');
        }
    }).fail(function () {
        console.error("Error loading provinces JSON.");
    });

    // Province change handler
    provinceDropdown.on('change', function () {
        const provinceCode = $(this).val();
        const provinceText = $(this).find('option:selected').text();

        console.log("Province selected:", provinceText, "Code:", provinceCode);

        // Update hidden input for province
        $('#updateprovince-text').val(provinceText);

        // Reset and populate cities
        const cityDropdown = $('#updatecity');
        const cityUrl = '../Dropdown-Json/ph-json/city.json';
        const selectedCity = $('#updatecity-text').val();

        console.log("Selected City:", selectedCity);

        cityDropdown.empty().append('<option disabled>Loading cities...</option>');
        $.getJSON(cityUrl, function (data) {
            console.log("Cities JSON loaded:", data);

            const filteredCities = data.filter((city) => city.province_code === provinceCode);
            cityDropdown.empty().append('<option disabled>Select a City/Municipality</option>');
            $.each(filteredCities, function (_, city) {
                cityDropdown.append(
                    `<option value="${city.city_code}" ${
                        city.city_name === selectedCity ? 'selected' : ''
                    }>${city.city_name}</option>`
                );
            });

            // If there's a selected city, trigger change to load its barangays
            if (selectedCity) {
                console.log("Triggering change for selected city:", selectedCity);
                cityDropdown.trigger('change');
            }
        }).fail(function () {
            console.error("Error loading cities JSON.");
        });

        // Reset barangays
        $('#updatebarangay').empty().append('<option disabled>Select a Barangay</option>');
    });

    // City change handler
    $('#updatecity').on('change', function () {
        const cityCode = $(this).val();
        const cityText = $(this).find('option:selected').text();

        console.log("City selected:", cityText, "Code:", cityCode);

        // Update hidden input for city
        $('#updatecity-text').val(cityText);

        // Reset and populate barangays
        const barangayDropdown = $('#updatebarangay');
        const barangayUrl = '../Dropdown-Json/ph-json/barangay.json';
        const selectedBarangay = $('#updatebarangay-text').val();

        barangayDropdown.empty().append('<option disabled>Loading barangays...</option>');
        $.getJSON(barangayUrl, function (data) {
            console.log("Barangays JSON loaded:", data);

            const filteredBarangays = data.filter((brgy) => brgy.city_code === cityCode);
            barangayDropdown.empty().append('<option disabled>Select a Barangay</option>');
            $.each(filteredBarangays, function (_, brgy) {
                barangayDropdown.append(
                    `<option value="${brgy.brgy_code}" ${
                        brgy.brgy_name === selectedBarangay ? 'selected' : ''
                    }>${brgy.brgy_name}</option>`
                );
            });
        }).fail(function () {
            console.error("Error loading barangays JSON.");
        });
    });

    // Barangay change handler
    $('#updatebarangay').on('change', function () {
        const barangayText = $(this).find('option:selected').text();

        console.log("Barangay selected:", barangayText);

        // Update hidden input for barangay
        $('#updatebarangay-text').val(barangayText);
    });
});
