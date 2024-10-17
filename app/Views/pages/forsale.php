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
            }).format(locations.price);
            let purposeUnit = locations.purpose;
            // Set the purposeUnit conditionally based on purpose and sold status
            if (locations.purpose === 'For Sale' && locations.soldstatus === 'sold') {
                purposeUnit = 'Sold Unit';
            }

            const contentString = `
                <div style="text-align: center; width: 200px;">
                    <div style="padding: 12px;"><center><h3>${purposeUnit}</h3></center></div>
                    <img src="${locations.image_url}" alt="State Image" style="width: 100%; height: auto;" />
                    <div class="info-window-content">
                        <label class="label-info">${formattedPrice}</label>
                        <div class="location-name">${locations.location}</div>
                        <div class="property-name"><strong>${locations.property_name}</strong></div><br/>
                        <div class="cap-rate">
                            <label><strong>Cap Rate</strong></label><br/>
                            <span>${locations.caprate}%</span>
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
<?php $url = ($propertyDetails['soldstatus'] == 'sold') ? '/sold-listings' : '/'; ?>
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
                        <h3><span class="askinPrice"><?=($propertyDetails['soldstatus'] == 'sold') ? 'Sold Price' : 'Asking Price'; ?></span> $<?=number_format($propertyDetails['price'], 0);?></h3>
                    </div>
                </div>
                <table class="list-table">
                    <thead>
                        <tr>
                            <th>Asking Cap Rate</th>
                            <?php if($propertyDetails['soldstatus'] == 'sold') : ?>
                            <th>Recorded Date</th>
                            <?php else : ?>
                            <th>NOI</th>
                            <?php endif; ?>
                            <th>Lease structure</th>
                            <th>Occupancy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Asking Cap Rate"><?=$propertyDetails['askingcaprate'];?>%</td>
                            <?php if($propertyDetails['soldstatus'] == 'sold') : ?>
                            <td data-label="Recorded Date"><?=date('F d, Y', strtotime($propertyDetails['solddate']));?></td>
                            <?php else : ?>
                            <td data-label="NOI">$<?=number_format($propertyDetails['noi'], 0);?></td>
                            <?php endif; ?>
                            <td data-label="Lease structure"><?=$propertyDetails['leasestructure'];?></td>
                            <td data-label="Occupancy"><?=$propertyDetails['occupancy'];?>%</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th>Price Per SF</th>
                            <th>Year Built</th>
                            <th>Building Size</th>
                            <th>Property Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Price Per SF">$<?=number_format($propertyDetails['price_per_sf'], 0);?></td>
                            <td data-label="Year Built"><?=$propertyDetails['yearbuilt'];?></td>
                            <td data-label="Building Size"><?=$propertyDetails['buildingsize'];?></td>
                            <td data-label="Property Type"><?=$propertyDetails['property_type'];?></td>
                        </tr>
                    </tbody>
                </table>
                <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                <button class="offer-btn mobile open-om" >
                    <p>OFFERING MEMORANDUM</p>
                    <img src="images/colored-btn.png">
                </button>
                <?php endif; ?>
                <div class="list-description">
                    <h4>Investment Highlights</h4>
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
                <form class="prop-form mobile" id="sendMessageMobile">
                    <h5>Interested in this property?</h5>
                    <div class="input-form">
                        <input type="hidden" name="link" id="linkMobile" value="<?=base_url().'/'.$propertyDetails['slug'];?>">
                        <input type="hidden" name="property" id="propertyMobile" value="<?=$propertyDetails['property_name'];?>">
                        <h6>First Name*</h6>
                        <input type="text" name="fname" id="fnameMobile">
                        <br>
                        <h6>Last Name*</h6>
                        <input type="text" name="lname" id="lnameMobile">
                        <br>
                        <h6>Email*</h6>
                        <input type="email" name="email-prop" id="email-propMobile">
                        <br>
                        <h6>Phone Number*</h6>
                        <input type="text" name="phonenumber" id="phonenumberMobile">
                        <br>
                        <h6>Note</h6>
                        <textarea  rows="4" name="note" id="noteMobile"></textarea>
                        <div class="prop-submit">
                            <input type="submit" name="prop-submit" value="Send Message">
                            <img src="images/colored-btn.png">
                        </div>
                    </div>
                </form>
                <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                <div class="prop-listing-map desktop">
                    <div class="map"></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="listing-sidebar">
                <?php if($propertyDetails['soldstatus'] != 'sold') : ?>
                <button class="offer-btn desktop open-om">
                    <p>OFFERING MEMORANDUM</p>
                    <img src="images/colored-btn.png">
                </button>
                <?php endif; ?>
                <div class="modal-om">
                    <form class="form-modal" id="omConsent">
                        <i class="fas fa-times close"></i>
                        <h5> Offering Memorandum</h5>
                        <div class="input-form">
                            <h6>Full Name*</h6>
                            <input type="text" name="om-name" required>
                            <br>
                            <h6>Email*</h6>
                            <input type="email" name="om-email" required>
                            <br>
                            <h6>Phone Number*</h6>
                            <input type="tel" name="om-phone" required>
                            <br>
                            <input type="hidden" name="offering-memorandum-link" value="<?=$propertyDetails['offering_memorandum']?>">
                            <input type="hidden" name="property_id" value="<?=$propertyDetails['property_id']?>">
                            <input type="hidden" name="link" value="<?=$propertyDetails['slug']?>">
                            <input type="hidden" name="property" value="<?=$propertyDetails['property_name']?>">
                            <div class="om-accept">
                                <input type="checkbox" name="om-accept" id="om-accept-checkbox">
                                <h6 for="om-accept-checkbox"><a href="/confidentiality" target="_blank" class="confiLink">Accept  Confidentiality Agreement</a></h6>
                            </div>
                            <div class="prop-submit">
                                <input type="submit" name="prop-submit" value="Confirm">
                                <img src="images/colored-btn.png">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="list-agent-info">
                    <h5>LEAD LISTING AGENT</h5>
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
                    <h5>ADDITIONAL LISTING AGENT</h5>
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
                <div class="prop-listing-map mobile">
                    <div class="map"></div>
                </div>
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
</script>