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
    const provinceDropdown = $('#province');
    const provinceUrl = '../Dropdown-Json/ph-json/province.json';
    const selectedProvince = $('#province-text').val();

    $.getJSON(provinceUrl, function (data) {
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
        if (selectedProvince) provinceDropdown.trigger('change');
    });

    // Province change handler
    provinceDropdown.on('change', function () {
        const provinceCode = $(this).val();
        const provinceText = $(this).find('option:selected').text();

        // Update hidden input for province
        $('#province-text').val(provinceText);

        // Reset and populate cities
        const cityDropdown = $('#city');
        const cityUrl = '../Dropdown-Json/ph-json/city.json';
        const selectedCity = $('#city-text').val();

        cityDropdown.empty().append('<option disabled>Loading cities...</option>');
        $.getJSON(cityUrl, function (data) {
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
            if (selectedCity) cityDropdown.trigger('change');
        });

        // Reset barangays
        $('#barangay').empty().append('<option disabled>Select a Barangay</option>');
    });

    // City change handler
    $('#city').on('change', function () {
        const cityCode = $(this).val();
        const cityText = $(this).find('option:selected').text();

        // Update hidden input for city
        $('#city-text').val(cityText);

        // Reset and populate barangays
        const barangayDropdown = $('#barangay');
        const barangayUrl = '../Dropdown-Json/ph-json/barangay.json';
        const selectedBarangay = $('#barangay-text').val();

        barangayDropdown.empty().append('<option disabled>Loading barangays...</option>');
        $.getJSON(barangayUrl, function (data) {
            const filteredBarangays = data.filter((brgy) => brgy.city_code === cityCode);
            barangayDropdown.empty().append('<option disabled>Select a Barangay</option>');
            $.each(filteredBarangays, function (_, brgy) {
                barangayDropdown.append(
                    `<option value="${brgy.brgy_code}" ${
                        brgy.brgy_name === selectedBarangay ? 'selected' : ''
                    }>${brgy.brgy_name}</option>`
                );
            });
        });
    });

    // Barangay change handler
    $('#barangay').on('change', function () {
        const barangayText = $(this).find('option:selected').text();

        // Update hidden input for barangay
        $('#barangay-text').val(barangayText);
    });
});


