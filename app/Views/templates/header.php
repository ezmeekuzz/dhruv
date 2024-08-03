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
                
        .gallery {
            width: 100%;
            max-width: 100%;
        }
        .slick-slide img {
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .main-slider .slick-slide img {
            width: 100%;
            max-width: 100%;
            height: auto;
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
                            <li><a href="https://app.dhruv-realty.com/listing.html">Commercial Listings</a></li>
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
                            <li><a href="https://dhruv-realty.com/insights-inner/">In The News</a></li>
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