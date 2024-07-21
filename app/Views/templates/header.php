<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="shortcut icon" href="<?=base_url();?>images/favIcon.jpg">
    <title><?=$title;?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
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
            <a class="top-num" href="tel:418-627-7001">418-627-7001</a>
            <div class="header-nav-section">
                <div class="menu-toggle">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
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
                <div class="header-brand">
                    <img src="images/szs.png">
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
