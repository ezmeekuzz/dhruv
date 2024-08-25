<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favIcon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Listing | DHRUV</title>
    <style>
        .mainSlider .slick-prev i, .mainSlider .slick-next i {
            background-color: #BCAC79;
            border-radius: 50px;
        }
        .mainSlider .slick-next:before, .mainSlider .slick-prev:before{
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 35px;
        }
        .mainSlider .slick-prev { 
            position: absolute;
            top: 50%!important;
            left: 25px!important;
            z-index: 1;
            /* background-color: #BCAC79; */
            color: #fff;
            border-radius: 50px;
            font-size: 0px;
        }
        .mainSlider .slick-next { 
            position: absolute;
            top: 50%!important;
            right:25px!important;
            z-index: 1;
            /* background-color: #BCAC79; */
            color: #fff;
            border-radius: 50px;
            font-size: 0px;
        }
        .dropdown-results {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            width: calc(100% - 30px); /* Adjust based on your design */
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        .dropdown-results .result-item {
            padding: 10px;
            cursor: pointer;
        }
        .dropdown-results .result-item:hover {
            background-color: #f0f0f0;
        }
        .header-search {
            height: 40px; /* Set the height of the search bar */
        }
        .dropdown-results {
            height: 40px; /* Match the height of the search bar */
        }
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <script type="text/javascript">
        const locations = <?php echo json_encode($locations); ?>;

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
                
                // Add a marker for each location
                new google.maps.Marker({
                    position: markerPosition,
                    map: map,
                    title: location.state_name,
                });

                // Extend the bounds to include each marker's position
                bounds.extend(markerPosition);
            });

            // Adjust the map to fit all markers within view
            map.fitBounds(bounds);
        }

        window.initMap = initMap;
    </script>
</head>
<body>
    <nav class="header-main">
        <div class="header-content">
            <a class="top-num" href="tel:3527730153">(352) 773-0153</a>
            <div class="header-nav-section">
                <div class="header-brand mobile">
                    <a href="https://dhruv-realty.com/"><img src="images/szs.png"></a>
                </div>
                <div class="menu-toggle">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
                <ul class="nav-menu">
                    <li>
                        <a class="menuList">Properties <i class="fas fa-chevron-down"></i></a>
                        <ul class="menu-dropdown">
                            <!-- <li><a href="https://app.dhruv-realty.com/">Residential</a></li> -->
                            <li><a href="https://app.dhruv-realty.com/">Commercial Listings</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="menuList" >Services <i class="fas fa-chevron-down"></i></a>
                        <ul class="menu-dropdown">
                            <li><a href="https://dhruv-realty.com/investment-sales/">Investment Sales</a></li>
                            <li><a href="https://dhruv-realty.com/leasing/">Leasing</a></li>
                            <li><a href="https://dhruv-realty.com/1031-exchange/">1031 Exchange</a></li>
                            <li><a href="https://dhruv-realty.com/consulting/">Consulting</a></li>
                            <li><a href="https://dhruv-realty.com/other-services/">Other Services</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="menuList" >Insights <i class="fas fa-chevron-down"></i></a>
                        <ul class="menu-dropdown">
                            <li><a href="https://dhruv-realty.com/insights/">Insights</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="menuList" >The Brokerage <i class="fas fa-chevron-down"></i></a>
                        <ul class="menu-dropdown">
                            <li><a href="https://dhruv-realty.com/company/">Company</a></li>
                            <li><a href="https://dhruv-realty.com/leadership/">Leadership</a></li>
                            <li><a href="https://dhruv-realty.com/our-agents/">Our Agents</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="contactMenu menuList">Contact Us <i class="fas fa-chevron-down"></i></a>
                        <ul class="menu-dropdown">
                            <li><a class="contactMenu" href="https://dhruv-realty.com/contact-us/">Contact Us</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="header-brand desktop">
                    <a href="https://dhruv-realty.com/"><img src="images/szs.png"></a>
                </div>

                <div class="haeder-search">
                    <form id="searchForm">
                        <input class="header-search" type="text" name="query" placeholder="Search here">
                        <div class="search-btn">
                            <input type="submit" value="Search">
                            <img src="images/searchBtn.png">
                        </div>
                    </form>
                    <div class="dropdown-results" id="dropdownResults"></div>
                </div>
            </div>
        </div>
    </nav>
    <section class="main-section banner" style="background-image: url('images/image1.webp');">
        <div class="main-inner-sec inner-banner-sec">
            <h2 class="banner-title">Explore Our Listings</h2>
            <div class="search-section">
                <form class="banner-search">
                    <input type="text" placeholder="Commercial">
                    <div class="search-btn">
                        <input type="submit">
                        <img src="images/wthIcon.png">
                    </div>
                </form>
                <form class="banner-search">
                    <input type="text" placeholder="Residential">
                    <div class="search-btn">
                        <input type="submit">
                        <img src="images/wthIcon.png">
                    </div>
                </form>
            </div>
        </div>
        <img src="images/bot-Line.png">
    </section>
    <section class="main-section listing-sec" style="background-image: url('images/image.webp');">
        <div class="main-inner-sec listing-content">
            <form class="listing-filter" id="filter-form">
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
                                    <label><input type="checkbox" value="Single Tenant" name="tenancy[]">
                                    Single Tenant</label>
                                </li>
                                <li>
                                    <label><input type="checkbox" value="Multi-Tenant" name="tenancy[]">
                                    Multi Tenant</label>
                                </li>
                                <input type="submit" value="APPLY">
                            </ul>
                        </div>

                        <div class="result-btn">
                            <input type="submit" id="clear-filters" value="Clear Filter">
                            <img src="images/colored-btn.png">
                        </div>
                    </div>
                </div>
                <div class="select-view">
                    <h5>SELECT VIEW</h5>
                    <div class="view-sel">
                        <i id="grid"  class="fas fa-th"></i>
                        <i id="list"  class="fas fa-list"></i>
                        <i id="mapSection"  class="fas fa-map"></i>
                        <!-- <img id="grid" src="images/grid.svg"> -->
                        <!-- <img id="list" src="images/list-solid.svg"> -->
                        <!-- <img id="map" src="images/map-solid.svg"> -->
                    </div>
                </div>
            </form>


            <div class="listing-result">
                <div class="list-items">
                    <div class="card-items grid" id="item-container">
                        
                    </div>
                    <div class="pagination">
                       
                    </div>
                    <div class="card-items list" id="item-tabular-container">

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


    <footer class="main-section footer-section">
        <div class="main-inner-sec footer-inner-sec">
            <div class="top-footer">
                <div class="footer-content">
                    <a href=""><img class="footerLogo" src="images/szs.png"></a>
                    <h2>
                        Request a Free <br>
                        Property Analysis,<br>
                        Contact Us Now
                    </h2>
                    <p>Get Customized Property And Industry News Sent Right To Your Inbox!</p>
                    <form class="footerForm" id="subscribe">
                        <input type="email" name="emailaddress" id="emailaddress" placeholder="Email Address">
                        <div class="result-btn">
                            <input type="submit" value="Submit">
                            <img src="images/colored-btn.png">
                        </div>
                    </form>
                </div>
                <div class="footer-content footer-menu">
                   <div class="footer-cont-top">
                    <ul class="nav-menu">
                        <li>
                            <a class="menuList" >Properties <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <!-- <li><a href="https://app.dhruv-realty.com/">Residential</a></li> -->
                                <li><a href="https://app.dhruv-realty.com/">Commercial Listings</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList" >Services <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://dhruv-realty.com/investment-sales/">Investment Sales</a></li>
                                <li><a href="https://dhruv-realty.com/leasing/">Leasing</a></li>
                                <li><a href="https://dhruv-realty.com/1031-exchange/">1031 Exchange</a></li>
                                <li><a href="https://dhruv-realty.com/consulting/">Consulting</a></li>
                                <li><a href="https://dhruv-realty.com/other-services/">Other Services</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList" >Insights <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://dhruv-realty.com/insights/">Insights</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList" >The Brokerage <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://dhruv-realty.com/company/">Company</a></li>
                                <li><a href="https://dhruv-realty.com/leadership/">Leadership</a></li>
                                <li><a href="https://dhruv-realty.com/our-agents/">Our Agents</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="contactMenu menuList" >Contact Us <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a class="contactMenu" href="https://dhruv-realty.com/contact-us/">Contact Us</a></li>
                            </ul>
                        </li>
                    </ul>
                        <div class="footer-info">
                            <p>Office Locations</p>
                            <p>License Information & Online Disclosures</p>
                            <p>Texas Real Estate Commission Information About Brokerage Services</p>
                        </div>
                   </div>
                   <div class="footer-cont-bot">
                        <h3>Connect With Us</h3>
                        <div class="social-icons">
                            <a href="#"><img src="images/fb.png"></a>
                            <a href="#"><img src="images/inst.png"></a>
                            <a href="#"><img src="images/x.png"></a>
                        </div>
                   </div>
                </div>
            </div>
            <div class="bot-footer">
                <h5>© Dhurv Realty. 2024 all rights reserved</h5>
                <ul>
                    <li><a href="https://dhruv-realty.com/privacy-policy/">Privacy Policy </a></li>
                    <li><a href="https://dhruv-realty.com/terms-and-conditions/">Terms & conditions</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/js.js"></script>
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

        $('#subscribe').on('submit', function(event) {
            event.preventDefault();

            var emailaddress = $('#emailaddress').val().trim();

            if (emailaddress === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill out all required field (Email).'
                });
                return false;
            }

            Swal.fire({
                title: 'Sending...',
                text: 'Please wait while we send your message.',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: '/subscribe',  // Replace with the actual URL to your PHP script
                type: 'POST',
                data: { emailaddress: emailaddress },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Subscribed',
                        text: 'You successfully subscribed!'
                    });

                    $('#subscribe')[0].reset();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while sending your message. Please try again later.'
                    });
                }
            });
        });

        var typingTimer;
        var doneTypingInterval = 300; // Time in ms, adjust as needed

        $('input[name="query"]').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $('input[name="query"]').on('keydown', function() {
            clearTimeout(typingTimer);
        });

        function doneTyping() {
            var query = $('input[name="query"]').val();

            if (query.trim() === '') {
                $('#dropdownResults').hide();
                return;
            }

            $.ajax({
                url: '<?= base_url('search') ?>',
                method: 'POST',
                data: { query: query },
                success: function(response) {
                    var results = response.results;
                    var html = '';

                    if (results.length > 0) {
                        results.forEach(function(result) {
                            html += '<div class="result-item">';
                            html += '<h4><a href="' + result.slug + '" target="_blank">' + result.property_name + '</a></h4>';
                            html += '</div>';
                        });
                        $('#dropdownResults').html(html).show();
                    } else {
                        $('#dropdownResults').html('<div class="result-item">No results found.</div>').show();
                    }
                }
            });
        }

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.haeder-search').length) {
                $('#dropdownResults').hide();
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

        function loadProperties(formData = null) {
            $.ajax({
                url: '/home/getGridProperties',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#item-container').html(response);
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

        function loadTabularProperties(formData = null) {
            $.ajax({
                url: '/home/getTabularProperties',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#item-tabular-container').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        // Handle form submission
        function setupFormSubmission() {
            $('.listing-filter').off('submit').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                loadProperties(formData);
                loadTabularProperties(formData);
            });
        }

        // Initial load of properties and setup form submission
        loadProperties();
        loadTabularProperties();
        setupFormSubmission();

        // Clear filters and reinitialize form submission
        $('#clear-filters').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Uncheck all checkboxes without affecting other input values
            $('#filter-form').find('input[type="checkbox"]').prop('checked', false);

            // Preserve the current values of state_id and city_id
            const stateIdValue = $('#state_id').val();
            const cityIdValue = $('#city_id').val();

            // Reset other inputs (text inputs) except for state_id and city_id
            $('#filter-form').find('input[type="text"]').not('.location-search').val('');

            // Set the preserved values back to the dropdowns
            $('#state_id').val(stateIdValue);
            $('#city_id').val(cityIdValue);

            // Optionally, you can reload the form with the current filters
            const formData = $('#filter-form').serialize();
            loadProperties(formData);
            loadTabularProperties(formData);

            // Reinitialize form submission handling
            setupFormSubmission();
        });
    });
</script>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALqBsjd6GtBlG1JSn_Ux4c8t5QSTBf-0A&callback=initMap&v=weekly"
      defer
    ></script>
</html>