<?=$this->include('templates/header');?>
<script type="text/javascript">
    function initMap() {
        const locations = <?php echo json_encode($locations); ?>;

        const mapElements = document.querySelectorAll(".map");

        mapElements.forEach((mapElement) => {
            const myLatLng = {
                lat: parseFloat(locations.latitude),
                lng: parseFloat(locations.longitude)
            };

            const map = new google.maps.Map(mapElement, {
                zoom: 5,
                center: myLatLng,
            });

            const marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: locations.property_name,
            });

            const formattedPrice = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(locations.rental_rate);
            let purposeUnit = locations.purpose;

            // Set the purposeUnit conditionally based on purpose and sold status
            if (locations.purpose === 'For Leasing' && locations.soldstatus === 'sold') {
                purposeUnit = 'Leased Unit';
            }
            
            const contentString = `
                <div style="text-align: center; width: 200px;">
                    <div style="padding: 12px;"><center><h3>${purposeUnit}</h3></center></div>
                    <img src="${locations.image_url}" alt="State Image" style="width: 100%; height: auto;" />
                    <div class="info-window-content">
                        <label class="label-info">${formattedPrice} PSF/Yr</label>
                        <div class="location-name">${locations.location}</div>
                        <div class="property-name"><strong>${locations.property_name}</strong></div><br/>
                        <div class="cap-rate">
                            <label><strong>Size SF</strong></label><br/>
                            <span>${locations.size_sf}</span>
                        </div>
                    </div>
                </div>`;

            const infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        });
    }

    window.initMap = initMap;
</script>
<style>
.clickLabel {
    position: absolute; /* Changed from relative to absolute */
    bottom: 25px; /* Adjusts the distance from the bottom */
    right: 20px; /* Positions the label on the right */
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    color: white;
    padding: 5px 10px;
    font-size: 14px; /* Adjust the size as needed */
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
}
</style>
<?php $url = ($propertyDetails['soldstatus'] == 'sold') ? '/sold-listings' : '/leasing'; ?>
<section class="main-section inner-list-section">
    <div class="main-inner-sec inner-list-content">
        <div class="list-content">
            <div class="listing-info">
                <a href="<?=$url;?>">Back To Properties</a>
                <div class="gallery">
                    <div class="main-slider">
                    <?php if($propertyGallery) : ?>
                        <?php foreach($propertyGallery as $list) : ?>
                            <div class="item">
                                <img src="<?=$list['location'];?>">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                    <div class="thumbnail-slider">
                    <?php if($propertyGallery) : ?>
                        <?php foreach($propertyGallery as $list) : ?>
                            <div class="item">
                                <img src="<?=$list['location'];?>">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="prop-header">
                    <div class="prop-title">
                        <h3><?=$propertyDetails['property_name'];?></h3>
                        <p><?=$propertyDetails['location'];?></p>
                    </div>
                    <div class="prop-price">
                        <i class="fas fa-download" id="copyURL"></i>
                        <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                        <h3><span class="askinPrice">SF/YR Pricing</span> $<?=number_format($propertyDetails['starting_sf_yr'], 0);?></h3>
                        <?php endif; ?>
                    </div>
                </div>
                <table class="list-table">
                    <thead>
                        <tr>
                            <th>Anchor Tenant</th>
                            <th>Max Continuous SF</th>
                            <th>Lease Structure</th>
                            <th>ADDT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Anchor Tenant"><?=$propertyDetails['anchor_tenant'];?></td>
                            <td data-label="Max Continuous SF"><?=number_format($propertyDetails['ending_sf_yr'], 0);?> SF</td>
                            <td data-label="Lease Structure"><?=$propertyDetails['leasestructure'];?></td>
                            <td data-label="ADDT"><?=number_format($propertyDetails['addt'], 0);?></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th>SF/YR</th>
                            <th>Year Built</th>
                            <th>Building Size</th>
                            <th>Space Use</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="SF/YR"><?=$propertyDetails['sf_yr'];?></td>
                            <td data-label="Year Built"><?=$propertyDetails['yearbuilt'];?></td>
                            <td data-label="Building Size"><?=$propertyDetails['buildingsize'];?> SF</td>
                            <td data-label="Space Use"><?=$propertyDetails['spacetype'];?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="list-description">
                    <h4>Location Highlights</h4>
                    <ul>
                    <?php if($investmentHighlightLists) : ?>
                        <?php foreach($investmentHighlightLists as $list) : ?>
                    <li>
                        <img src="images/checkIcon.png">
                        <p>
                            <b><?=$list['title'];?></b><br>
                            <?=$list['content'];?>
                        </p>
                    </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </ul>
                </div>
                <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                <?php if($propertyDetails['leasing_flyer'] != "" || $propertyDetails['leasing_flyer'] != NULL) : ?>
                <button class="offer-btn mobile" >
                    <p>Leasing Flyer</p>
                    <img src="images/colored-btn.png">
                </button>
                <?php endif; ?>
                <?php endif; ?>
                    <!-- <form class="prop-form mobile">
                        <h5>Interested in this property?</h5>
                        <div class="input-form">
                            <h6>First Name*</h6>
                            <input type="text" name="fname">
                            <br>
                            <h6>Last Name*</h6>
                            <input type="text" name="lname">
                            <br>
                            <h6>Phone Number*</h6>
                            <input type="tel" name="phone-prop">
                            <br>
                            <h6>Email*</h6>
                            <input type="email" name="email-prop">
                            <br>
                            <h6>Note</h6>
                            <textarea  rows="4" name="note"></textarea>
                            <div class="prop-submit">
                                <input type="submit" name="prop-submit" value="Send Message">
                                <img src="images/colored-btn.png">
                            </div>
                        </div>
                    </form> -->
                <div class="space-available-section">
                    <div class="sas-title">
                        <h3><?=COUNT($leasingUnitsList);?> Space(s) Available</h3> <h3 class="sas-mobile">Site Plan</h3>
                    </div>
                    <?php if($leasingUnitsList) : ?>
                    <?php foreach($leasingUnitsList as $list) : ?>
                    <div class="unit-section-map">
                        <h5>Unit # : <?=$list['unit_number'];?></h5>
                        <div class="unit-details-sec">
                            <div class="unitDetail">
                                <h6>Rental Rate</h6>
                                <p>$<?=$list['leasing_rental_rate'];?></p>
                            </div>
                            <div class="unitDetail">
                                <h6>CAM</h6>
                                <p>$<?=$list['cam'];?></p>
                            </div>
                            <div class="unitDetail">
                                <h6>Space Available</h6>
                                <p><?=$list['space_available'];?></p>
                            </div>
                            <div class="unitDetail">
                                <h6>Space Use</h6>
                                <p><?=$list['space_use'];?></p>
                            </div>
                            <div class="unitDetail imageCol">
                                <a href="#ex1" rel="modal:open" class="open-modal" data-id="<?=$list['leasing_unit_id'];?>" style="min-height: 100px; object-fit: contain;">
                                    <img class="imageTrigger" src="/<?=$list['location'];?>" />
                                    <label class="clickLabel">Click Me <i class="fas fa-hand-point-left"></i></label>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <div id="ex1" class="modal">
                        <div id="modal-content">
                            
                        </div>
                    </div>
                </div>
                <div class="list-record desktop">
                    <h4>Broker Of Record</h4>
                    <div class="record-items">
                        <ul>
                            <li>JOSEPH CALDARELLI</li>
                            <li>LIC. NUMBER: BK3386144 (FL)</li>
                            <li>DHRUV Realty</li>
                        </ul>
                        <ul>
                            <li><img class="numberLsit" src="images/352-773-0153.png"></li>
                            <li>6903 Congress St,</li>
                            <li>New Port Richey,</li>
                            <li> FL 34653</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="listing-sidebar">
                <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                <?php if($propertyDetails['leasing_flyer'] != "" || $propertyDetails['leasing_flyer'] != NULL) : ?>
                <a href="<?=$propertyDetails['leasing_flyer'];?>" target="_blank" class="offer-btn desktop">
                    <p>Leasing Flyer</p>
                    <img src="images/colored-btn.png">
                </a>
                <?php endif; ?>
                <?php endif; ?>
                <div class="list-agent-info">
                    <h5>LEAD LEASING AGENT</h5>
                    <div class="lead-prop">
                        <img class="agent-img" src="<?=$propertyDetails['profileimage'];?>">
                        <p>
                            <b><?=$propertyDetails['fullname'];?></b><br>
                            <?=$propertyDetails['position'];?>
                        </p>
                        <img class="bot-Line" src="images/bot-Line.png">
                    </div>
                    <ul>
                        <li>
                            <img src="images/enve.png">
                            <p>
                                Email<br>
                                <a href="mailto:<?=$propertyDetails['email'];?>"><?=$propertyDetails['email'];?></a>
                            </p>
                        </li>
                        <li>
                            <img src="images/licen.png">
                            <p>
                                License No.<br>
                                <a href="#"><?=$propertyDetails['licenseno'];?></a>
                            </p>
                        </li>
                        <li>
                            <img src="images/phone.png">
                            <p>
                                Direct<br>
                                <a href="tel:<?=$propertyDetails['phonenumber'];?>"><?=$propertyDetails['phonenumber'];?></a>
                            </p>
                        </li>
                        <li>
                            <img src="images/phone.png">
                            <p>
                                Mobile<br>
                                <a href="tel:<?=$propertyDetails['mobilenumber'];?>"><?=$propertyDetails['mobilenumber'];?></a>
                            </p>
                        </li>
                    </ul>
                </div>
                <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                <div class="agent-list">
                    <h5>ADDITIONAL LEASING AGENT</h5>
                    <ul>
                    <?php if($additionaListingAgentLists) : ?>
                        <?php foreach($additionaListingAgentLists as $list) : ?>
                        <li>
                            <a href="<?=$list['url'];?>">
                                <img src="<?=$list['profileimage'];?>">
                                <p>
                                    <b><?=$list['fullname'];?></b><br>
                                    <?=$list['position'];?>
                                </p>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <form class="prop-form desktop" id="sendMessage">
                    <h5>Interested in selling a property?</h5>
                    <div class="input-form">
                        <input type="hidden" name="link" id="link" value="<?=base_url().'/'.$propertyDetails['slug'];?>">
                        <input type="hidden" name="property" id="property" value="<?=$propertyDetails['property_name'];?>">
                        <h6>First Name*</h6>
                        <input type="text" name="fname" id="fname">
                        <br>
                        <h6>Last Name*</h6>
                        <input type="text" name="lname" id="lname">
                        <br>
                        <h6>Email*</h6>
                        <input type="email" name="email-prop" id="email-prop">
                        <br>
                        <h6>Phone Number*</h6>
                        <input type="text" name="phonenumber" id="phonenumber">
                        <br>
                        <h6>Note</h6>
                        <textarea  rows="4" name="note" id="note"></textarea>
                        <div class="prop-submit">
                            <input type="submit" name="prop-submit" value="Send Message">
                            <img src="images/colored-btn.png">
                        </div>
                    </div>
                </form>
                    <?php if($propertyDetails['soldstatus'] == 'sold') : ?>
                    <div class="prop-listing-map desktop">
                        <div class="map"></div>
                    </div>
                    <?php endif; ?>
                <div class="list-record mobile">
                    <h4>Broker Of Record</h4>
                    <div class="record-items">
                        <ul>
                            <li>JOSEPH CALDARELLI</li>
                            <li>LIC. NUMBER: BK3386144 (FL)</li>
                            <li>DHRUV Realty</li>
                        </ul>
                        <ul>
                            <li><img class="numberLsit" src="images/352-773-0153.png"></li>
                            <li>6903 Congress St,</li>
                            <li>New Port Richey,</li>
                            <li> FL 34653</li>
                        </ul>
                    </div>
                </div>
                <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                <div class="prop-listing-map desktop">
                    <div class="map"></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<section class="main-section subs-section" >
    <div class="main-inner-sec subs-inner-sec" style="background-image: url(images/subs-img-bg.webp);">
        <div class="subs-sec-content">
            <img src="images/subs-img.webp">
            <div class="subs-text-sec">
                <h2>Subscribe For More Properties</h2>
                <a href="https://dhruv-realty.com/contact-us/" class="subs-btn">
                    <p>Subscribe</p>
                    <img src="images/colored-btn.png">
                </a>
            </div>
        </div>
    </div>
</section>
<?=$this->include('templates/footer');?>
<script>
    $('#sendMessage').on('submit', function(event) {
        event.preventDefault();

        var fname = $('#fname').val().trim();
        var lname = $('#lname').val().trim();
        var email = $('#email-prop').val().trim();
        var phonenumber = $('#phonenumber').val().trim();
        var note = $('#note').val().trim();
        var link = $('#link').val().trim();
        var property = $('#property').val().trim();

        if (fname === '' || lname === '' || email === '' || phonenumber === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill out all required fields (First Name, Last Name, and Email).'
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
            url: '/propertydetails/sendMessage',  // Replace with the actual URL to your PHP script
            type: 'POST',
            data: {
                fname: fname,
                lname: lname,
                email: email,
                phonenumber: phonenumber,
                link: link,
                property: property,
                note: note
            },
            success: function(response) {
                // Handle the response from the server
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent',
                    text: 'Your message has been sent successfully!'
                });

                // Clear the form fields
                $('#sendMessage')[0].reset();
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
    $('#sendMessageMobile').on('submit', function(event) {
        event.preventDefault();

        var fname = $('#fnameMobile').val().trim();
        var lname = $('#lnameMobile').val().trim();
        var email = $('#email-propMobile').val().trim();
        var phonenumber = $('#phonenumberMobile').val().trim();
        var note = $('#noteMobile').val().trim();
        var link = $('#linkMobile').val().trim();
        var property = $('#propertyMobile').val().trim();

        if (fname === '' || lname === '' || email === '' || phonenumber === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill out all required fields (First Name, Last Name, and Email).'
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
            url: '/propertydetails/sendMessage',  // Replace with the actual URL to your PHP script
            type: 'POST',
            data: {
                fname: fname,
                lname: lname,
                email: email,
                phonenumber: phonenumber,
                link: link,
                property: property,
                note: note
            },
            success: function(response) {
                // Handle the response from the server
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent',
                    text: 'Your message has been sent successfully!'
                });

                // Clear the form fields
                $('#sendMessage')[0].reset();
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

    $('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.thumbnail-slider'
    });
    $('.thumbnail-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.main-slider',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev">Previous</button>',
        nextArrow: '<button type="button" class="slick-next">Next</button>'
    });
    
    $('.unitDetailSlider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        autoplay: true, // Enable autoplay
        autoplaySpeed: 3000,
        prevArrow: '<button type="button" class="slick-prev">Previous</button>',
        nextArrow: '<button type="button" class="slick-next">Next</button>',
        initialSlide: 2 // This sets the 3rd slide (index 2) as the initial slide
    }).on('afterChange', function(event, slick, currentSlide){
        // Stop autoplay after the first slide change
        slick.slickPause();
    });
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Initialize Tippy.js and show the tooltip
            var tippyInstance = tippy('#copyURL', {
                content: 'Copied!',
                trigger: 'manual',
                onShow(instance) {
                    setTimeout(() => {
                        instance.hide();
                    }, 2000);
                }
            });

            // Show the tooltip
            tippyInstance[0].show();
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }

    document.getElementById('copyURL').addEventListener('click', function() {
        var url = window.location.href;
        copyToClipboard(url);
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
            data: {
                emailaddress: emailaddress,
            },
            success: function(response) {
                // Handle the response from the server
                Swal.fire({
                    icon: 'success',
                    title: 'Subscribed',
                    text: 'You successfully subscribed!'
                });

                // Clear the form fields
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
    $(document).ready(function() {
        $('#omConsent').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            // Clear any previous error messages
            $('.error').remove();
            
            // Validate form fields
            var isValid = true;
            var formData = $(this).serialize(); // Serialize form data

            // Check if all fields are filled
            $('#omConsent input[required]').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).after('<span class="error" style="color:red;">This field is required.</span>');
                }
            });

            // Check if the checkbox is checked
            if (!$('#om-accept-checkbox').is(':checked')) {
                isValid = false;
                $('#om-accept-checkbox').after('<span class="error" style="color:red;">You must accept the confidentiality agreement.</span>');
            }

            if (isValid) {
                Swal.fire({
                    title: 'Sending...',
                    text: 'Please wait while we send your request.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                // Submit the form data via AJAX
                $.ajax({
                    url: '/propertydetails/omConsent', // Replace with your server endpoint URL
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle successful response
                        var link = $('input[name="offering-memorandum-link"]').val();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Consent successfully received!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.open(link, '_blank');
                            $('#omConsent')[0].reset(); // Reset the form after successful submission
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        // Event delegation for dynamic content
        document.querySelectorAll('.open-modal').forEach(function (trigger) {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();

                var leasingUnitId = this.getAttribute('data-id'); // Get the leasing_unit_id from the clicked element

                // Open modal and fetch gallery
                fetchLeasingGallery(leasingUnitId);

                // Show the modal
                $('#ex1').modal(); // Assuming you're using a modal library like jQuery Modal
            });
        });
    });

    function fetchLeasingGallery(leasingUnitId) {
        // Perform AJAX request to CodeIgniter
        $.ajax({
            url: '/propertydetails/getGallery', // Replace with your actual route
            method: 'POST',
            data: { leasing_unit_id: leasingUnitId },
            dataType: 'json',
            success: function (response) {
                // Clear existing modal content
                $('#modal-content').empty();

                if (response.success && response.gallery.length > 0) {
                    // Inject the Owl Carousel structure dynamically
                    var owlCarouselHtml = `
                        <div class="owl-carousel owl-theme" id="owl-carousel">
                            <!-- Images will be dynamically inserted here -->
                        </div>
                    `;

                    // Append the carousel structure to the modal content
                    $('#modal-content').append(owlCarouselHtml);

                    // Populate the carousel with images
                    var galleryContent = '';
                    response.gallery.forEach(function (image) {
                        galleryContent += '<div class="item"><img src="/' + image.location + '" alt="Gallery Image" class="gallery-image" /></div>';
                    });

                    // Insert the images into the Owl Carousel
                    $('#owl-carousel').html(galleryContent);

                    // Initialize Owl Carousel
                    initOwlCarousel();
                } else {
                    // Display a message if no images are found
                    $('#modal-content').html('<p>No images available for this unit.</p>');
                }
            },
            error: function () {
                $('#modal-content').html('<p>Failed to load gallery. Please try again later.</p>');
            }
        });
    }

    // Initialize the Owl Carousel
    function initOwlCarousel() {
        $('#owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,  // Enable navigation buttons
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'], // Font Awesome icons
            items: 1,  // Display one image at a time
            autoHeight: true // Adjust height based on image
        });
    }

    // Destroy the carousel and clear content when the modal is closed
    $(document).on('closed.modal', '#ex1', function () {
        $('#owl-carousel').trigger('destroy.owl.carousel'); // Destroy carousel on modal close
        $('#modal-content').empty(); // Clear modal content
    });
</script>