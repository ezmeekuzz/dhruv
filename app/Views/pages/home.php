<?=$this->include('templates/header');?>

<section class="main-section banner" style="background-image: url('images/image1.webp');">
    <div class="main-inner-sec inner-banner-sec">
        <h2 class="banner-title">Explore Our Listings</h2>
        <!--<div class="search-section">
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
        </div>-->
    </div>
    <img src="images/bot-Line.png">
</section>

<section class="main-section listing-sec" style="background-image: url('images/image.webp');">
    <div class="main-inner-sec listing-content">
        <form class="listing-filter" id="filterForm">
            <h3>Find a Property</h3>
            <div class="location-input">
                <input type="text" class="location-search" placeholder="Search By Location">
                <div class="result-btn">
                    <input type="button" value="Search">
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
                                    <option value="">Select</option> <!-- Change hidden to an empty value -->
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
                                    <option value="">Select</option> <!-- Change hidden to an empty value -->
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
                        <input type="button" value="Clear Filter">
                        <img src="images/colored-btn.png">
                    </div>
                </div>
            </div>
            <div class="select-view">
                <h5>SELECT VIEW</h5>
                <div class="view-sel">
                    <img id="grid" src="images/grid.svg">
                    <img id="list" src="images/list-solid.svg">
                    <img id="map" src="images/map-solid.svg">
                </div>
            </div>
        </form>
        <div class="listing-result">
            <div class="list-items">
                <div class="card-items grid" id="propertyGrid">
                    <!-- Property cards will be loaded here -->
                </div>
                <div class="card-items list" id="propertyList">
                    <table>
                        <thead>
                            <tr>
                                <th>Property Name</th>
                                <th>Location</th>
                                <th>Cap Rate</th>
                                <th>Price</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody id="propertyListBody">
                            <!-- Property list will be loaded here -->
                        </tbody>
                    </table>
                </div>
                <button class="view-more" id="viewMoreButton">View More <img src="images/colored-btn.png"></button>
            </div>
            <div class="listing-map">
                <div class="map-toggle">
                    <img src="images/maptoggle.png">
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3514.3558105848006!2d-82.71037352451286!3d28.25722597587179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88c2904600b15555%3A0x69ada1cc8b402578!2sDhruv%20Management!5e0!3m2!1sen!2sph!4v1721245807024!5m2!1sen!2sph" width="100%" height="810" style="border:0; border-radius:20px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <img src="images/bot-Line.png">
    </div>
</section>

<?=$this->include('templates/footer');?>

<script>
$(document).ready(function(){
    var currentPage = 1; // Track current page
    var maxPages = 1; // Track maximum pages available, initially 1

    // Fetch and display properties on page load
    fetchProperties();

    function fetchProperties(filters = {}, page = 1) {
        $.ajax({
            url: '/home/getProperties?page=' + page, // Add page parameter
            method: 'POST',
            data: filters,
            dataType: 'json',
            success: function(response) {
                $('#propertyGrid').empty();
                $('#propertyListBody').empty();

                // Check if response is empty (no more data)
                if (response.length === 0) {
                    $('#viewMoreButton').hide(); // Hide view more button
                    return;
                }

                // Update maxPages based on actual data received
                maxPages = page;

                $.each(response, function(index, property) {
                    // Populate Grid View
                    $('#propertyGrid').append(
                        '<div class="list-item" style="background-image: url(\'images/city1.png\');">' +
                        '<a class="list-tag">New</a>' +
                        '<div class="carousel">' +
                        '<div class="carousel-inner">' +
                        '<div class="carousel-item">' +
                        '<img src="images/city1.png" alt="Image 1">' +
                        '</div>' +
                        '<div class="carousel-item">' +
                        '<img src="images/city2.png" alt="Image 2">' +
                        '</div>' +
                        '<div class="carousel-item">' +
                        '<img src="images/city3.png" alt="Image 3">' +
                        '</div>' +
                        '</div>' +
                        '<a class="prev">&#10094;</a>' +
                        '<a class="next">&#10095;</a>' +
                        '</div>' +
                        '<div class="list-info-sec">' +
                        '<div class="item-info">' +
                        '<h3><a href="/' + property.slug + '">' + property.property_name + '</a></h3>' +
                        '<p>Cap Rate: ' + property.caprate + '%</p>' +
                        '<div class="item-price">' +
                        '<h5>Price: $' + numberWithCommas(property.price) + '</h5>' +
                        '<span>Type: ' + property.property_type + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );

                    // Populate List View
                    $('#propertyListBody').append(
                        '<tr>' +
                        '<td><a href="/' + property.slug + '">' + property.property_name + '</a></td>' +
                        '<td>' + property.state_name + ', ' + property.cityname + '</td>' +
                        '<td>' + property.caprate + '%</td>' +
                        '<td>$' + numberWithCommas(property.price) + '</td>' +
                        '<td>' + property.property_type + '</td>' +
                        '</tr>'
                    );
                });

                // Show or hide view more button based on current page and maxPages
                if (page >= maxPages) {
                    $('#viewMoreButton').hide();
                } else {
                    $('#viewMoreButton').show();
                }
            }
        });
    }

    // Utility function to format numbers with commas
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // State and city dropdown handling
    $('#state_id').change(function(){
        var state_id = $(this).val();
        if(state_id){
            $.ajax({
                url: '/home/getCitiesByState',
                method: 'POST',
                data: { state_id: state_id },
                dataType: 'json',
                success: function(response){
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select</option>');
                    $.each(response, function(index, city){
                        $('#city_id').append('<option value="'+city.city_id+'">'+city.cityname+'</option>');
                    });
                }
            });
        } else {
            $('#city_id').empty();
            $('#city_id').append('<option value="">Select</option>');
        }
    });

    // Handle filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        var filters = $(this).serializeArray();
        fetchProperties(filters);
    });

    // Handle "View More" button click
    $('#viewMoreButton').on('click', function() {
        currentPage++; // Increment current page
        var filters = $('#filterForm').serializeArray();
        fetchProperties(filters, currentPage);
    });

    // Clear filters
    $('#clearFilter').on('click', function() {
        $('#filterForm')[0].reset();
        currentPage = 1; // Reset current page
        maxPages = 1; // Reset max pages
        fetchProperties();
        $('#viewMoreButton').show(); // Ensure view more button is visible after reset
    });
});

</script>
