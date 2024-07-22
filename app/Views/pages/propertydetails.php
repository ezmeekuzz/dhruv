<?=$this->include('templates/header');?>
<style>
    .main-section.inner-list-section {
        padding: 20px;
    }

    .list-content .owl-carousel .prop-image {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .owl-carousel {
        width: 100%;
    }

    .owl-nav button {
        background-color: #000;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1000;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .owl-nav button.owl-prev {
        left: 10px;
    }

    .owl-nav button.owl-next {
        right: 10px;
    }

    .owl-nav button:hover {
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
    }

    @media (max-width: 768px) {
        .owl-nav button {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }
    }
</style>
<section class="main-section inner-list-section">
    <div class="main-inner-sec inner-list-content">
        <div class="list-content">
            <div class="listing-info">
                <a href="/">Back To Properties</a>
                <div class="owl-carousel owl-theme">
                    <?php if($propertyGallery) : ?>
                        <?php foreach($propertyGallery as $list) : ?>
                            <div class="item">
                                <img class="prop-image" src="<?=$list['location'];?>">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="prop-header">
                    <div class="prop-title">
                        <h3><?=$propertyDetails['property_name'];?></h3>
                        <p><?=$propertyDetails['location'].', '.$propertyDetails['cityname'].', '.$propertyDetails['state_code'].' '.$propertyDetails['zipcode'];?></p>
                    </div>
                    <div class="prop-price">
                        <img src="images/export-img.png" id="copyURL">
                        <h3>$<?=number_format($propertyDetails['price'], 2);?></h3>
                    </div>
                </div>
                <table class="list-table">
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
                            <td data-label="Price Per SF">$<?=$propertyDetails['price_per_sf'];?></td>
                            <td data-label="Year Built"><?=$propertyDetails['yearbuilt'];?></td>
                            <td data-label="Building Size"><?=$propertyDetails['buildingsize'];?></td>
                            <td data-label="Property Type"><?=$propertyDetails['property_type'];?></td>
                        </tr>
                    </tbody>
                </table>
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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.1815412175465!2d75.79079398611258!3d26.86597270197075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db42f4d8d62a3%3A0x5492a559e14bd6b0!2sDhruv%20Reality%20%26%20Marketing!5e0!3m2!1sen!2sph!4v1720105099225!5m2!1sen!2sph" width="100%" height="500" style="border:0; border-radius:20px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="listing-sidebar">
                <a href="#" class="offer-btn">
                    <p>OFFERING MEMORANDUM</p>
                    <img src="images/colored-btn.png">
                </a>
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
                            <img src="<?=$list['profileimage'];?>">
                            <p>
                                <b><?=$list['fullname'];?></b><br>
                                <?=$list['position'];?>
                            </p>
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
<script>
$(document).ready(function() {
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
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        items: 1,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            },
            1200: {
                items: 1
            },
            1600: {
                items: 1
            }
        }
    });

    $('.owl-prev').html('<span class="fa fa-chevron-left"></span>');
    $('.owl-next').html('<span class="fa fa-chevron-right"></span>');

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success popover using Tippy.js
            tippy('#copyURL', {
                content: 'Copied!',
                trigger: 'manual',
                onShow(instance) {
                    setTimeout(() => {
                        instance.hide();
                    }, 2000);
                }
            }).show();
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
