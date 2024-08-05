<?=$this->include('templates/header');?>
<section class="main-section inner-list-section">
    <div class="main-inner-sec inner-list-content">
        <div class="list-content">
            <div class="listing-info">
                <a href="/">Back To Properties</a>
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
                        <p><?=$propertyDetails['location'].', '.$propertyDetails['cityname'].', '.$propertyDetails['state_code'].' '.$propertyDetails['zipcode'];?></p>
                    </div>
                    <div class="prop-price">
                        <i class="fas fa-download" id="copyURL"></i>
                        <h3>$<?=number_format($propertyDetails['price'], 2);?></h3>
                    </div>
                </div>
                <table class="list-table">
                    <thead>
                        <tr>
                            <th>Asking Cap Rate</th>
                            <th>NOI</th>
                            <th>Lease Structure</th>
                            <th>Occupancy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Price Per SF"><?=$propertyDetails['askingcaprate'];?>%</td>
                            <td data-label="Price Per SF">$<?=number_format($propertyDetails['noi'], 2);?></td>
                            <td data-label="Year Built"><?=$propertyDetails['leasestructure'];?></td>
                            <td data-label="Building Size"><?=$propertyDetails['occupancy'];?></td>
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
                            <td data-label="Price Per SF">$<?=number_format($propertyDetails['price_per_sf'], 2);?></td>
                            <td data-label="Year Built"><?=$propertyDetails['yearbuilt'];?></td>
                            <td data-label="Building Size"><?=$propertyDetails['buildingsize'];?></td>
                            <td data-label="Property Type"><?=$propertyDetails['property_type'];?></td>
                        </tr>
                    </tbody>
                </table>
                    <a href="/images/Offering Memorandum Template.pdf" target="_blank" class="offer-btn mobile">
                        <p>OFFERING MEMORANDUM</p>
                        <img src="images/colored-btn.png">
                    </a>
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
                <div class="list-record">
                    <h4>Broker Of Record</h4>
                    <div class="record-items">
                        <ul>
                            <li>Dhruv Realty</li>
                            <li>License No. CQ1066435 (FL)</li>
                            <li>(866) 889-0550</li>
                        </ul>
                        <ul>
                            <li>Dhruv Realty</li>
                            <li>1600 West End,</li>
                            <li>Ste. 1500 Nashville, TN 37203</li>
                        </ul>
                    </div>
                </div>
                <div class="prop-listing-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3514.3558105848006!2d-82.71037352451286!3d28.25722597587179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88c2904600b15555%3A0x69ada1cc8b402578!2sDhruv%20Management!5e0!3m2!1sen!2sph!4v1721664274393!5m2!1sen!2sph" width="100%" height="500" style="border:0; border-radius:20px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="listing-sidebar">
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
                <form class="prop-form" id="sendMessage">
                    <h5>Interested in this property?</h5>
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
                        <h6>Note</h6>
                        <textarea  rows="4" name="note" id="note"></textarea>
                        <div class="prop-submit">
                            <input type="submit" name="prop-submit" value="Send Message">
                            <img src="images/colored-btn.png">
                        </div>
                    </div>
                </form>
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
                <a href="#" class="subs-btn">
                    <p>Subscribe</p>
                    <img src="images/colored-btn.png">
                </a>
            </div>
        </div>
    </div>
</section>
<?=$this->include('templates/footer');?>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
$(document).ready(function() {
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
    $('#sendMessage').on('submit', function(event) {
        event.preventDefault();

        var fname = $('#fname').val().trim();
        var lname = $('#lname').val().trim();
        var email = $('#email-prop').val().trim();
        var note = $('#note').val().trim();
        var link = $('#link').val().trim();
        var property = $('#property').val().trim();

        if (fname === '' || lname === '' || email === '') {
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
});
</script>
