<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favIcon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css" integrity="sha512-T3VL1q6jMUIzGLRB9z86oJg9PgF7A55eC2XkB93zyWSqQw3Ju+6IEJZYBfT7E9wOHM7HCMCOZSpcssxnUn6AeQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title><?=$title;?></title>
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
            width: 100%;
            object-fit: cover;
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
            color: #fff;
            border-radius: 50px;
            font-size: 0px;
        }

        .mainSlider .slick-next { 
            position: absolute;
            top: 50%!important;
            right:25px!important;
            z-index: 1;
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
        .map {
            height: 100%;
        }
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        /* Style for label-info class */
        .label-info {
            display: inline-block;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            color: #ffffff;
            background-color: #5bc0de; /* Light blue background color */
            border-radius: 3px; /* Rounded corners */
            text-align: center;
            margin-bottom: 5px; /* Space below the label */
        }
        /* Navigation buttons for Owl Carousel */
        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel .owl-nav button.owl-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: black;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001; /* Higher z-index for visibility */
            font-size: 20px;
            opacity: 0.6; /* Reduced opacity */
        }

        /* Left arrow positioning */
        .owl-carousel .owl-nav button.owl-prev {
            left: 10px;
        }

        /* Right arrow positioning */
        .owl-carousel .owl-nav button.owl-next {
            right: 10px;
        }

        /* Hover effect on arrows */
        .owl-carousel .owl-nav button.owl-prev:hover,
        .owl-carousel .owl-nav button.owl-next:hover {
            background-color: rgba(0, 0, 0, 0.8);
            opacity: 1; /* Fully visible on hover */
        }

        /* Arrow symbols (Font Awesome) */
        .owl-carousel .owl-nav button.owl-prev::before,
        .owl-carousel .owl-nav button.owl-next::before {
            content: ''; /* Add arrow content here */
        }

        /* Mobile View: Make arrows smaller */
        @media (max-width: 767px) {
            .owl-carousel .owl-nav button.owl-prev,
            .owl-carousel .owl-nav button.owl-next {
                width: 25px; /* Smaller arrow size */
                height: 25px;
                font-size: 14px; /* Smaller font size */
                opacity: 0.3; /* Slightly reduced opacity */
            }
        }
        #ex1.modal {
            width: 100%; /* Wider width */
            max-width: 950px; /* Increase maximum width for larger screens */
            height: auto;
            padding: 20px;
            position: relative;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Prevent scrollbars inside the modal */
            background: transparent; /* Ensures a transparent background */
            border: none; /* No border */
            box-shadow: none; /* Remove any shadow effects */
        }

        /* Modal content */
        #modal-content {
            width: 100%;
            height: auto; /* Adjust height based on content */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        #ex1 a[rel="modal:close"] {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #000;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            z-index: 1001;
        }
    </style>
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
                            <li><a href="/">For Sale</a></li>
                            <li><a href="/leasing">For Lease</a></li>
                            <li><a href="/sold-listings">Recent Transactions</a></li>
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