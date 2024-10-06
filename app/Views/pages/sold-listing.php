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
                purpose = 'Sold Unit';
                dataPricing = `
                        <div class="cap-rate">
                            <label><strong>Cap Rate</strong></label><br/>
                            <span>${location.caprate}%</span>
                        </div>`;
            } else if (location.purpose === 'For Leasing') {
                moneyValue = formatCurrency(location.rental_rate) + ' PSF/Yr';
                markerIcon = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'; // Blue marker for leasing
                purpose = 'Leased Unit';
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
<style>
@import url('https://fonts.googleapis.com/css2?family=General+Sans:wght@600&display=swap');

.image-container {
    position: relative; /* Position relative to center the SOLD label on the image */
}

.sold-watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Centers the text */
    color: rgba(255, 255, 255, 0.7); /* Semi-transparent white text */
    font-family: 'General Sans', sans-serif; /* Apply General Sans font */
    font-weight: 600; /* Semi-bold */
    font-size: 74px; /* Adjust the font size as needed */
    text-transform: uppercase; /* Uppercase text */
    z-index: 10; /* Ensure it appears above other elements */
    pointer-events: none; /* Ensure watermark doesn't block interactions */
    text-align: center;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); /* Black shadow behind text */
}

.prop-orderBy {
    width: 100%; /* Ensure container takes up full width */
    position: relative;
}

.transparent-select {
    width: 100%; /* Make select element fill the container */
    background-color: transparent; /* Transparent background */
    border: none; /* Remove the border */
    font-size: 16px;
    color: #000; /* Text color */
    appearance: none; /* Remove default browser styling */
    padding: 20px; /* Add vertical padding to center the text vertically */
    height: auto; /* Allow height to adjust based on content */
    cursor: pointer;
    box-sizing: border-box; /* Ensure padding is included in width and height calculation */
}

.transparent-select option {
    color: #000; /* Ensure option text is visible */
}

.transparent-select:focus {
    outline: none; /* Prevent any visible outline on focus */
}
.prop-orderBy::after {
    content: '';
    position: absolute;
    right: 15px; /* Position arrow on the right side */
    top: 50%;
    transform: translateY(-50%); /* Vertically center the arrow */
    border-left: 9px solid transparent;
    border-right: 9px solid transparent;
    border-top: 15px solid #BCAC79; /* Increased arrow height and set color to #BCAC79 */
    pointer-events: none; /* Prevent arrow from blocking interactions */
}
@media screen and (max-width:500px) {
    .prop-orderBy, .prop-type {
        width: 100% !important;
    }
}
</style>
<section class="main-section banner" style="background-image: url('images/Floridanight.png');">
    <div class="main-inner-sec inner-banner-sec leasingbannerSec">
        <h2 class="banner-title">Recent Transactions</h2>
        <div class="search-section leasingSearchBanner">
            <button class="banner-search activeBtn" id="forsalebtn">
                Sold Units
                <img src="images/wthIcon.png">
            </button>
            <button class="banner-search" id="forleasebtn">
                Lease Units
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
                <div class="list-filtering">
                    <div class="dropdown-field">
                        <div class="prop-orderBy" style="width: 40%;">
                            <select name="orderBy" id="orderBy" class="transparent-select">
                                <option hidden></option>
                                <option disabled selected>Order By</option>
                                <option value="Price_Asc">Price : Low to High</option>
                                <option value="Price_Desc">Price : High to Low</option>
                                <option value="Cap_Asc">Cap Rate : Low to High</option>
                                <option value="Cap_Desc">Cap Rate : High to Low</option>
                            </select>
                        </div>
                        <div class="prop-type" style="width: 40%; position: relative;">
                            <div class="input-wrapper">
                                <input type="date" class="transparent-input" name="solddate" id="solddate" placeholder="Select Date Sold">
                            </div>
                        </div>
                        <div class="prop-type" style="width: 40%;">
                            <div class="prop-name">
                                <h5>Property Type</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list main-prop-list" style="width: 100%; padding: 20px; z-index: 99999;">
                                <?php if($propertyTypes) : ?>
                                    <?php foreach($propertyTypes as $list) : ?>
                                        <li><label><input type="checkbox" value="<?=$list['property_type_id'];?>" name="property_type_id[]"><?=$list['property_type'];?></label></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li><label><input type="checkbox" name="Other">Other</label></li>
                                <input type="submit" class="apply" value="APPLY">
                            </ul>
                        </div>
                        <div class="result-btn">
                            <input type="submit" value="To Search">
                            <img src="images/colored-btn.png">
                        </div>
                    </div>
                </div>
            </form>
            <form class="listing-filter" id="forLease">
                <div class="list-filtering">
                    <div class="dropdown-field leasingSection">
                        <div class="prop-orderBy" style="width: 40%;">
                            <select name="orderBy2" id="orderBy2" class="transparent-select">
                                <option hidden></option>
                                <option disabled selected>Order By</option>
                                <option value="PriceSF_Asc">Price Per SF : Low to High</option>
                                <option value="PriceSF_Desc">Price Per SF : High to Low</option>
                                <option value="Rental_Asc">Rental Rate : Low to High</option>
                                <option value="Rental_Desc">Rental Rate : High to Low</option>
                            </select>
                        </div>
                        <div class="prop-type" style="width: 40%; position: relative;">
                            <div class="input-wrapper">
                                <input type="date" class="transparent-input" name="leaseddate" id="leaseddate" placeholder="Select Date Sold">
                            </div>
                        </div>
                        <div class="prop-type" style="width: 40%;">
                            <div class="prop-name">
                                <h5>Space Use</h5>
                                <img class="chevo" src="images/Polygon.png">
                            </div>
                            <ul class="prop-list main-prop-list" style="width: 100% !important; padding: 20px; z-index: 99999;">
                                <?php if($spaces) : ?>
                                    <?php foreach($spaces as $list) : ?>
                                        <li><label><input type="checkbox" value="<?=$list['space_id'];?>" name="property_type_id2[]"><?=$list['spacetype'];?></label></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li><label><input type="checkbox" name="Other">Other</label></li>
                                <input type="submit" class="apply" value="APPLY">
                            </ul>
                        </div>
                        <div class="result-btn">
                            <input type="submit" value="To Search">
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
                url: '/soldlistings/getForSaleGridProperties',
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
                url: '/soldlistings/getForLeasingGridProperties',
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
                url: '/soldlistings/getForSaleTabularProperties',
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
                url: '/soldlistings/getForLeasingTabularProperties',
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
        $('#orderBy').on('change', function() {
            const orderBy = $(this).val();
            const formData = { orderBy: orderBy };

            // Load the properties based on the selected order
            loadForSaleProperties(formData);
            loadForSaleTabularProperties(formData);
        });
        $('#orderBy2').on('change', function() {
            const orderBy = $(this).val();
            const formData = { orderBy: orderBy };

            // Load the properties based on the selected order
            loadForLeasingProperties(formData);
            loadForLeasingTabularProperties(formData);
        });
        $('#solddate').on('change', function() {
            const soldDate = $(this).val();
            const formData = { solddate: soldDate };
            loadForSaleProperties(formData);
            loadForSaleTabularProperties(formData);
        });

        // Load properties on date change for "For Lease"
        $('#leaseddate').on('change', function() {
            const leasedDate = $(this).val();
            const formData = { leaseddate: leasedDate };
            loadForLeasingProperties(formData);
            loadForLeasingTabularProperties(formData);
        });
        // Initial load of properties and setup form submission
        loadForSaleProperties();
        loadForLeasingProperties();
        loadForSaleTabularProperties();
        loadForLeasingTabularProperties();
        setupForSaleFormSubmission();
        setupForLeaseFormSubmission();
    });
</script>