<?=$this->include('templates/header');?>
<script type="text/javascript">
    const locations = <?php echo json_encode($locations); ?>;
    let currentInfoWindow = null; // Variable to track the currently open info window

    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    }

    function initMap() {
        // Create the map and set the initial zoom level
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
        });

        // Create a LatLngBounds object to store the bounds of all markers
        const bounds = new google.maps.LatLngBounds();

        // Loop through the locations array and create markers
        locations.forEach(function(location) {
            const markerPosition = { 
                lat: parseFloat(location.latitude), 
                lng: parseFloat(location.longitude) 
            };
            
            // Determine the marker color based on the purpose
            let markerIcon = '';
            let dataPricing = '';
            let moneyValue = '';
            let purpose = '';
            if (location.purpose === 'For Sale') {
                moneyValue = formatCurrency(location.price);
                markerIcon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'; // Red marker for sale
                purpose = 'For Sale';
                dataPricing = `
                        <div class="cap-rate">
                            <label><strong>Cap Rate</strong></label><br/>
                            <span>${location.caprate}%</span>
                        </div>`;
            } else if (location.purpose === 'For Leasing') {
                moneyValue = formatCurrency(location.rental_rate) + ' PSF/Yr';
                markerIcon = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'; // Blue marker for leasing
                purpose = 'For Lease';
                dataPricing = `
                        <div class="cap-rate">
                            <label><strong>Size SF</strong></label><br/>
                            <span>${location.size_sf}</span>
                        </div>`;
            }

            // Add a marker for each location with a custom color based on purpose
            const marker = new google.maps.Marker({
                position: markerPosition,
                map: map,
                icon: markerIcon
            });

            // Create the content for the info window
            const contentString = `
                <div style="text-align: center; width: 200px;">
                    <div style="padding: 12px;"><center><h3>${purpose}</h3></center></div>
                    <img src="${location.image_url}" alt="State Image" style="width: 100%; height: auto;" />
                    <div class="info-window-content">
                        <label class="label-info">${moneyValue}</label>
                        <div class="location-name">${location.location}</div>
                        <div class="property-name"><strong>${location.property_name}</strong></div><br/>
                        ${dataPricing}
                    </div>
                </div>`;

            // Create an info window with the structured content
            const infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            // Display the info window when the marker is clicked
            marker.addListener('click', function() {
                // Close the previous info window if it's open
                if (currentInfoWindow) {
                    currentInfoWindow.close();
                }

                // Open the new info window and set the map's center to the marker's position
                infowindow.open(map, marker);
                //map.panTo(markerPosition);
                //map.setZoom(8); // Optional: Zoom in on the marker for a more focused view

                // Set the current info window to the new one
                currentInfoWindow = infowindow;
            });

            // Extend the bounds to include each marker's position
            bounds.extend(markerPosition);
        });

        // Adjust the map to fit all markers within view
        map.fitBounds(bounds);
    }

    // Initialize the map when the page loads
    window.initMap = initMap;
</script>

<section class="main-section banner" style="background-image: url('images/image1.webp');">
    <div class="main-inner-sec inner-banner-sec leasingbannerSec">
        <h2 class="banner-title">Explore Our Listings</h2>
        <div class="search-section leasingSearchBanner">
            <button class="banner-search activeBtn" id="forsalebtn">
                For Sale
                <img src="images/wthIcon.png">
            </button>
            <button class="banner-search" id="forleasebtn">
                For Lease
                <img src="images/wthIcon.png">
            </button>
        </div>
    </div>
    <img src="images/bot-Line.png">
</section>
<section class="main-section listing-sec" style="background-image: url('images/image.webp');">
    <div class="main-inner-sec listing-content">
        <div class="formSectionFilter">
            <form class="listing-filter active" id="forSale">
                <h3>Find a Property</h3>
                <div class="location-input">
                    <input type="text" class="location-search" name="location" placeholder="Search By Location">
                    <div class="result-btn">
                        <input type="submit" value="Search">
                        <img src="images/colored-btn.png">
                    </div>
                </div>
                <div class="list-filtering">
                    <div class="dropdown-field">
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Property Type</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list main-prop-list">
                                <?php if($propertyTypes) : ?>
                                    <?php foreach($propertyTypes as $list) : ?>
                                        <li><label><input type="checkbox" value="<?=$list['property_type_id'];?>" name="property_type_id[]"><?=$list['property_type'];?></label></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li><label><input type="checkbox" name="Other">Other</label></li>
                                <input type="submit" class="apply" value="APPLY">
                            </ul>
                        </div>
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Price</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list min-max">
                                <li>Min<input type="text" name="min_price" placeholder="$"></li>
                                <li>Max<input type="text" name="max_price" placeholder="$"></li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Location</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                             <ul class="prop-list loc">
                                <li>
                                    State
                                    <select name="state_id" id="state_id">
                                        <option value="">Select</option>
                                        <?php if($statesList) : ?>
                                            <?php foreach($statesList as $list) : ?>
                                                <option value="<?=$list['state_id'];?>"><?=$list['state_name'];?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </li>
                                <li>
                                    City
                                    <select name="city_id" id="city_id">
                                        <option value="">Select</option>
                                    </select>
                                </li>
                                <li>
                                    Zip Code
                                    <input type="text" name="zip_code">
                                </li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Cap Rate</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list min-max">
                                <li>Min<input type="text" placeholder="%" name="min_cr"></li>
                                <li>Max<input type="text" placeholder="%" name="max_cr"></li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Tenancy</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list tenant">
                                <li>
                                    <input type="checkbox" name="tenancy[]" value="Single Tenant">
                                    Single Tenant
                                </li>
                                <li>
                                    <input type="checkbox" name="tenancy[]" value="Multi-Tenant">
                                    Multi Tenant
                                </li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>
                        <div class="result-btn">
                            <input type="submit" value="Clear Filter" id="clear-filters">
                            <img src="images/colored-btn.png">
                        </div>
                    </div>
                </div>
            </form>
            <form class="listing-filter" id="forLease">
                <h3>Find a Property</h3>
                <div class="location-input">
                    <input type="text" class="location-search" name="location2" placeholder="Search By Location">
                    <div class="result-btn">
                        <input type="submit" value="Search">
                        <img src="images/colored-btn.png">
                    </div>
                </div>
                <div class="list-filtering">
                    <div class="dropdown-field leasingSection">
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Space Use</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list main-prop-list leasingDropdown">
                                <?php if($spaces) : ?>
                                    <?php foreach($spaces as $list) : ?>
                                        <li><label><input type="checkbox" value="<?=$list['space_id'];?>" name="property_type_id2[]"><?=$list['spacetype'];?></label></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li><label><input type="checkbox" name="Other">Other</label></li>
                                <input type="submit" class="apply" value="APPLY">
                            </ul>
                        </div>
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Rental Rate</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list min-max">
                                <li>Min<input type="text" name="rental_rate_min" placeholder="$"></li>
                                <li>Max<input type="text" name="rental_rate_max" placeholder="$"></li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>
                        <div class="prop-type leasingLoc">
                            <div class="prop-name">
                                <h5>Location</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list loc">
                                <li>
                                    State
                                    <select name="state_id2" id="state_id2">
                                        <option value="">Select</option>
                                        <?php if($statesList) : ?>
                                            <?php foreach($statesList as $list) : ?>
                                                <option value="<?=$list['state_id'];?>"><?=$list['state_name'];?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </li>
                                <li>
                                    City
                                    <select name="city_id2" id="city_id2">
                                        <option value="">Select</option>
                                    </select>
                                </li>
                                <li>
                                    Zip Code
                                    <input type="text" name="zip_code2">
                                </li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>
                        <div class="prop-type">
                            <div class="prop-name">
                                <h5>Size(SF)</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list min-max">
                                <li>Min<input type="text" placeholder="SF" name="size_sf_min"></li>
                                <li>Max<input type="text" placeholder="SF" name="size_sf_max"></li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>
                        <div class="result-btn">
                            <input type="submit" value="Clear Filter" id="clear-filters2">
                            <img src="images/colored-btn.png">
                        </div>
                    </div>
                </div>
            </form>
            <div class="select-view">
                <h5>SELECT VIEW</h5>
                <div class="view-sel">
                    <i id="grid"  class="fas fa-th"></i>
                    <i id="list"  class="fas fa-list"></i>
                    <i id="mapSection"  class="fas fa-map"></i>
                </div>
            </div>
        </div>
        <div class="listing-result">
            <div class="list-items">
                <div class="tblSale active">
                    <div class="card-items grid" id="forSaleGrid">
                            
                    </div>
                    <div class="pagination"></div>
                </div>
                <div class="tblLeas">
                    <div class="card-items grid" id="forLeasingGrid">
                        
                    </div>
                    <div class="pagination"></div>
                </div>
                <div class="card-items list">
                    <table class="tblSale active">
                        <thead>
                            <tr>
                                <th>Property Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Cap Rate</th>
                                <th>Price</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody id="forSaleTBL">
                            
                        </tbody>
                    </table>
                    <table class="tblLeas">
                        <thead>
                            <tr>
                                <th>Property Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Sf / Yr Rental Rate</th>
                                <th>Lease Structure</th>
                                <th>Space Use</th>
                            </tr>
                        </thead>
                        <tbody id="forLeasingTBL">
                            
                        </tbody>
                    </table>
                </div>
            </div>
                <div class="listing-map">
                    <div class="map-toggle">
                        <img src="images/maptoggle.png">
                    </div>

                    <div id="map"></div>
                </div>
            </div>
            <img src="images/bot-Line.png">
        </div>
    </section>
<?=$this->include('templates/footer');?>
<script>
     $(document).ready(function() {
        $('#state_id').change(function() {
            var state_id = $(this).val();
            if (state_id) {
                $.ajax({
                    url: '/home/getCitiesByState',
                    method: 'POST',
                    data: { state_id: state_id },
                    dataType: 'json',
                    success: function(response) {
                        $('#city_id').empty();
                        $('#city_id').append('<option value="">Select</option>');
                        $.each(response, function(index, city) {
                            $('#city_id').append(`<option value="${city.city_id}">${city.cityname}</option>`);
                        });
                    }
                });
            } else {
                $('#city_id').empty();
                $('#city_id').append('<option value="">Select</option>');
            }
        });
        $('#state_id2').change(function() {
            var state_id = $(this).val();
            if (state_id) {
                $.ajax({
                    url: '/home/getCitiesByState',
                    method: 'POST',
                    data: { state_id: state_id },
                    dataType: 'json',
                    success: function(response) {
                        $('#city_id2').empty();
                        $('#city_id2').append('<option value="">Select</option>');
                        $.each(response, function(index, city) {
                            $('#city_id2').append(`<option value="${city.city_id}">${city.cityname}</option>`);
                        });
                    }
                });
            } else {
                $('#city_id2').empty();
                $('#city_id2').append('<option value="">Select</option>');
            }
        });

        function initializeSlider() {
            $('.mainSlider').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: "<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
                nextArrow: "<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>"
            });
        }

        function createPagination($items) {
            const itemsPerPage = 6;
            const totalItems = $items.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const $pagination = $('.pagination');

            $pagination.empty(); // Clear existing pagination

            for (let i = 1; i <= totalPages; i++) {
                const $btn = $('<button>')
                    .addClass('pagination-btn')
                    .attr('data-page', i)
                    .text(i);
                $pagination.append($btn);
            }

            showPage(1, $items, itemsPerPage);
        }

        function showPage(pageNumber, $items, itemsPerPage) {
            $items.hide();
            $items.slice((pageNumber - 1) * itemsPerPage, pageNumber * itemsPerPage).show();
            updatePagination(pageNumber);
        }

        function updatePagination(currentPage) {
            $('.pagination-btn').removeClass('active');
            $(`.pagination-btn[data-page="${currentPage}"]`).addClass('active');
        }

        function loadForSaleProperties(formData = null) {
            $.ajax({
                url: '/home/getForSaleGridProperties',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#forSaleGrid').html(response);
                    initializeSlider();

                    const itemsPerPage = 6;
                    const $items = $('.list-item');
                    createPagination($items);

                    $(document).on('click', '.pagination-btn', function() {
                        const pageNumber = $(this).data('page');
                        showPage(pageNumber, $items, itemsPerPage);

                        const $firstItem = $items.filter(':visible').first();
                        $('html, body').animate({
                            scrollTop: $firstItem.offset().top
                        }, 500);
                    });
                    function truncateText(selector, maxLength) {
                        $(selector).each(function() {
                            var text = $(this).text();
                            if (text.length > maxLength) {
                                var truncated = text.substr(0, maxLength) + '...';
                                $(this).text(truncated);
                            }
                        });
                    }


                    truncateText('.sliderTitle', 20); 
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        function loadForLeasingProperties(formData = null) {
            $.ajax({
                url: '/home/getForLeasingGridProperties',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#forLeasingGrid').html(response);
                    initializeSlider();

                    const itemsPerPage = 6;
                    const $items = $('.list-item');
                    createPagination($items);

                    $(document).on('click', '.pagination-btn', function() {
                        const pageNumber = $(this).data('page');
                        showPage(pageNumber, $items, itemsPerPage);

                        const $firstItem = $items.filter(':visible').first();
                        $('html, body').animate({
                            scrollTop: $firstItem.offset().top
                        }, 500);
                    });
                    function truncateText(selector, maxLength) {
                        $(selector).each(function() {
                            var text = $(this).text();
                            if (text.length > maxLength) {
                                var truncated = text.substr(0, maxLength) + '...';
                                $(this).text(truncated);
                            }
                        });
                    }


                    truncateText('.sliderTitle', 20); 
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        function loadForSaleTabularProperties(formData = null) {
            $.ajax({
                url: '/home/getForSaleTabularProperties',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#forSaleTBL').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        function loadForLeasingTabularProperties(formData = null) {
            $.ajax({
                url: '/home/getForLeasingTabularProperties',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#forLeasingTBL').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        // Handle form submission
        function setupForSaleFormSubmission() {
            $('#forSale').off('submit').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                loadForSaleProperties(formData);
                loadForSaleTabularProperties(formData);
            });
        }
        function setupForLeaseFormSubmission() {
            $('#forLease').off('submit').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                loadForLeasingProperties(formData);
                loadForLeasingTabularProperties(formData);
            });
        }

        // Initial load of properties and setup form submission
        loadForSaleProperties();
        loadForLeasingProperties();
        loadForSaleTabularProperties();
        loadForLeasingTabularProperties();
        setupForSaleFormSubmission();
        setupForLeaseFormSubmission();

        // Clear filters and reinitialize form submission
        $('#clear-filters').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Uncheck all checkboxes without affecting other input values
            $('#forSale').find('input[type="checkbox"]').prop('checked', false);

            // Preserve the current values of state_id and city_id
            const stateIdValue = $('#state_id').val();
            const cityIdValue = $('#city_id').val();

            // Reset other inputs (text inputs) except for state_id and city_id
            $('#forSale').find('.location-search').val('');

            // Set the preserved values back to the dropdowns
            $('#state_id').val(stateIdValue);
            $('#city_id').val(cityIdValue);

            // Optionally, you can reload the form with the current filters
            const formData = $('#forSale').serialize();
            loadForSaleProperties(formData);
            loadForSaleTabularProperties(formData);

            // Reinitialize form submission handling
            setupForSaleFormSubmission();
        });
        $('#clear-filters2').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Uncheck all checkboxes without affecting other input values
            $('#forLease').find('input[type="checkbox"]').prop('checked', false);

            // Preserve the current values of state_id and city_id
            const stateIdValue2 = $('#state_id2').val();
            const cityIdValue2 = $('#city_id2').val();

            // Reset other inputs (text inputs) except for state_id and city_id
            $('#forLease').find('.location-search').val('');

            // Set the preserved values back to the dropdowns
            $('#state_id2').val(stateIdValue2);
            $('#city_id2').val(cityIdValue2);

            // Optionally, you can reload the form with the current filters
            const formData = $('#forLease').serialize();
            loadForLeasingProperties(formData);
            loadForLeasingTabularProperties(formData);

            // Reinitialize form submission handling
            setupForLeaseFormSubmission();
        });
    });
</script>