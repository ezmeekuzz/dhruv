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
                                <li><a href="/">Commercial Listings</a></li>
                                <li><a href="/leasing">Leasing Listings</a></li>
                                <li><a href="/sold-listings">Sold Listings</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList" >Services <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://dhruv-realty.com/investment-sales/">Investment Sales</a></li>
                                <li><a href="https://dhruv-realty.com/dhruv-property-management/">Property Management</a></li>
                                <li><a href="https://dhruv-realty.com/leasing/">Leasing</a></li>
                                <li><a href="https://dhruv-realty.com/1031-exchange/">1031 Exchange</a></li>
                                <li><a href="https://dhruv-realty.com/consulting/">Consulting</a></li>
                                <li><a href="https://dhruv-realty.com/other-services/">Other Services</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menuList" >Insights <i class="fas fa-chevron-down"></i></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://dhruv-realty.com/insigths/">Insigths</a></li>
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
                            <a href="https://www.facebook.com/profile.php?id=61564660882709"><img src="images/fb.png"></a>
                            <a href="https://www.instagram.com/dhruvcommercial?igsh=ajczNzNsenk1cmw2"><img src="images/inst.png"></a>
                            <a href="https://www.linkedin.com/company/dhruv-realty/"><img src="images/linkIn.png"></a>
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
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js" integrity="sha512-ztxZscxb55lKL+xmWGZEbBHekIzy+1qYKHGZTWZYH1GUwxy0hiA18lW6ORIMj4DHRgvmP/qGcvqwEyFFV7OYVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/js.js"></script>
<script>
     $(document).ready(function(){
        $('.mainSlider').slick({
            dots: false, // Disable pagination
            infinite: true, // Infinite looping
            speed: 300, // Transition speed
            slidesToShow: 1, // Number of slides to show
            slidesToScroll: 1, // Number of slides to scroll
            prevArrow: "<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
            nextArrow: "<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>"
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
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALqBsjd6GtBlG1JSn_Ux4c8t5QSTBf-0A&callback=initMap&v=weekly" defer></script>
</html>