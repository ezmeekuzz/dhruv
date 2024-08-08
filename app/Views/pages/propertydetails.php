<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/favIcon.jpg" type="image/x-icon">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Inner Listing | DHRUV</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">



    <style>
        
        .gallery {
    width: 100%;
    max-width: 100%;
    }

    .main-slider .slick-slide img {
        width: 100%;
        max-width: 100%;
        height: 550px;
        object-fit: cover;
        border-radius: 10px;
    }

    .thumbnail-slider{
        padding-top:20px;
        position: relative!important;
    }

    .thumbnail-slider .slick-list .slick-track{
        display: flex!important;
        gap:20px;
    }

    .thumbnail-slider .slick-slide img {
        cursor: pointer;
        border-radius: 10px;
        height: 160px;
        object-fit: cover;
        width: 100%;
    }

    .thumbnail-slider .slick-next:before, .thumbnail-slider .slick-prev:before{
        font-size: 35px;
    }


    .thumbnail-slider .slick-prev, .thumbnail-slider .slick-next{
        top:-150%!important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .thumbnail-slider .slick-prev{
        left: 50px!important;
    }

    .thumbnail-slider .slick-next{
        right:50px!important;
    }

    @media screen and (max-width:500px){
        .thumbnail-slider .slick-prev{
            left: 20px!important;
        }

        .thumbnail-slider .slick-next{
            right:20px!important;
        }

        .thumbnail-slider .slick-prev, .thumbnail-slider .slick-next{
            top:-180%!important;
        }

        .thumbnail-slider .slick-slide img{
            height: 45px;
        }


        .dropdown-results {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            width: calc(100% - 30px);
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
            height: 40px;
        }
        .dropdown-results {
            height: 40px;
        }

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
    </style>
</head>

<body>


    <nav class="header-main inner-listing">
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
                            <!-- <li><a href="https://app.dhruv-realty.com/listing.html">Residential</a></li> -->
                            <li><a href="https://app.dhruv-realty.com/">Commercial Listings</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="menuList">Services <i class="fas fa-chevron-down"></i></a>
                        <ul class="menu-dropdown">
                            <li><a href="https://dhruv-realty.com/investment-sales/">Investment Sales</a></li>
                            <li><a href="https://dhruv-realty.com/leasing/">Leasing</a></li>
                            <li><a href="https://dhruv-realty.com/1031-exchange/">1031 Exchange</a></li>
                            <li><a href="https://dhruv-realty.com/consulting/">Consulting</a></li>
                            <li><a href="https://dhruv-realty.com/other-services/">Other Services</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="menuList">Insights <i class="fas fa-chevron-down"></i></a>
                        <ul class="menu-dropdown">
                            <li><a href="https://dhruv-realty.com/insigths/">Insights</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="menuList">The Brokerage <i class="fas fa-chevron-down"></i></a>
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
                            <h3>$<?=number_format($propertyDetails['price'], 0);?></h3>
                        </div>
                    </div>

                    <table class="list-table">
                        <thead>
                            <tr>
                                <th>Asking Cap Rate</th>
                                <th>NOI</th>
                                <th>Lease structure</th>
                                <th>Occupancy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Asking Cap Rate"><?=$propertyDetails['askingcaprate'];?>%</td>
                                <td data-label="NOI">$<?=number_format($propertyDetails['noi'], 2);?></td>
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
                                <td data-label="Price Per SF">$<?=number_format($propertyDetails['price_per_sf'], 2);?></td>
                                <td data-label="Year Built"><?=$propertyDetails['yearbuilt'];?></td>
                                <td data-label="Building Size"><?=$propertyDetails['buildingsize'];?></td>
                                <td data-label="Property Type"><?=$propertyDetails['property_type'];?></td>
                            </tr>
                        </tbody>
                    </table>

                    <button class="offer-btn mobile open-om" >
                        <p>OFFERING MEMORANDUM</p>
                        <img src="images/colored-btn.png">
                    </button>

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

                    <div class="prop-listing-map desktop">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3514.355654808007!2d-82.71037352399357!3d28.257230701023616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88c2904600b15555%3A0x69ada1cc8b402578!2sDhruv%20Management!5e0!3m2!1sen!2sph!4v1721802837642!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>



                <div class="listing-sidebar">
                    <button href="" class="offer-btn desktop open-om">
                        <p>OFFERING MEMORANDUM</p>
                        <img src="images/colored-btn.png">
                    </button>
                    <div class="modal-om">
                        <form class="form-modal" id="omConsent">
                            <i class="fas fa-times close"></i>
                            <h5> Offering Memorandum</h5>
                            <div class="input-form">
                                <h6>Fullame*</h6>
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
                    <form class="prop-form desktop" id="sendMessage">
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
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3514.355654808007!2d-82.71037352399357!3d28.257230701023616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88c2904600b15555%3A0x69ada1cc8b402578!2sDhruv%20Management!5e0!3m2!1sen!2sph!4v1721802837642!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
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


    
    <footer class="main-section footer-section">
        <div class="main-inner-sec footer-inner-sec">
            <div class="top-footer">
                <div class="footer-content">
                    <img class="footerLogo" src="images/szs.png">
                    <h2>
                        Request a Free <br>
                        Property Analysis,<br>
                        Contact Us Now
                    </h2>
                    <p>Get Customized Property And Industry News Sent Right To Your Inbox!</p>
                    <form class="footerForm" id="subscribe">
                        <input type="email" name="emailaddress" id="emailaddress" placeholder="Email Address">
                        <div class="result-btn">
                            <input type="submit" value="Learn More">
                            <img src="images/colored-btn.png">
                        </div>
                    </form>
                </div>
                <div class="footer-content footer-menu">
                   <div class="footer-cont-top">
                    <ul class="nav-menu">
                        <li>
                            <a class="menuList">Properties <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <!-- <li><a href="https://app.dhruv-realty.com/listing.html">Residential</a></li> -->
                                <li><a href="https://app.dhruv-realty.com/">Commercial Listings</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList">Services <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://dhruv-realty.com/investment-sales/">Investment Sales</a></li>
                                <li><a href="https://dhruv-realty.com/leasing/">Leasing</a></li>
                                <li><a href="https://dhruv-realty.com/1031-exchange/">1031 Exchange</a></li>
                                <li><a href="https://dhruv-realty.com/consulting/">Consulting</a></li>
                                <li><a href="https://dhruv-realty.com/other-services/">Other Services</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList">Insights <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://dhruv-realty.com/insigths/">Insights</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList">The Brokerage <i class="fas fa-chevron-down"></i></a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="js/js.js"></script>

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
    });
</script>
</html>