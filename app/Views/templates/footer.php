<footer class="main-section footer-section">
    <div class="main-inner-sec footer-inner-sec">
        <div class="top-footer">
            <div class="footer-content">
                <img class="footerLogo" src="images/szs.png">
                <h2>
                    Request A<br>
                    Free Quote,<br>
                    Contact Us Now
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
                            <a href="/listing.html">Properties <img src="images/drop-Icon.png"></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/properties-main-page/">Residential</a></li>
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/properties-hide-map/">Commercial</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Services <img src="images/drop-Icon.png"></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/investment-sales/">Investment Sales</a></li>
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/leasing/">Leasing</a></li>
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/1031-exchange/">1031 Exchange</a></li>
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/consulting/">Consulting</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Insights <img src="images/drop-Icon.png"></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/insights-inner/">In The News</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">The Brokerage <img src="images/drop-Icon.png"></a>
                            <ul class="menu-dropdown">
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/company/">Company</a></li>
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/leadership/">Leadership</a></li>
                                <li><a href="https://riftofheroes.com/programming/dhruvinternational/our-agents/">Our Agents</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="https://riftofheroes.com/programming/dhruvinternational/our-agents/">Contact</a>
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
                    <li><a href="#">Privacy Policy </a></li>
                    <li><a href="#">Terms & conditions</a></li>
                </ul>
            </div>
        </div>
    </footer>   
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/js.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    
    var typingTimer;
    var doneTypingInterval = 300; // Time in ms, adjust as needed

    // On keyup, start the countdown
    $('input[name="query"]').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    // On keydown, clear the countdown 
    $('input[name="query"]').on('keydown', function() {
        clearTimeout(typingTimer);
    });

    // User is "finished typing," send the AJAX request
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