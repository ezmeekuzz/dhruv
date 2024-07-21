<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?=$title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta content="Empowering clients through integrity and personalized service, Dhurv is dedicated to exceeding expectations in real estate transactions. With a commitment to trust and transparency, we aim to build lasting relationships based on exceptional results and client satisfaction." name="description" />
    <meta content="Rustom Codilan" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="<?=base_url();?>images/favIcon.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nanum+Gothic&family=Quicksand:wght@300..700&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Ruda:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/vendors.css" />
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/css/customstyle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <style>
        body, select, input, textarea, .js-basic-single, label {
            color: #000;
        }
        .chosen-container-single .chosen-single {
            height: 40px; /* Adjust the height as needed */
        }
        .chosen-container-single .chosen-single div b {
            top: 60%;
            transform: translateY(0%);
        }
        .is-invalid {
            border-color: red;
        }
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            padding: 20px;
        }

        .upload-area h2 {
            margin: 0;
        }

        .upload-area p {
            margin: 10px 0;
        }

        .upload-area button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .upload-area button:hover {
            background-color: #0056b3;
        }

        #fileList {
            margin-top: 20px;
        }

        .file-item {
            margin-bottom: 10px;
        }
        canvas {
            display: block; 
        }
        .file-icon {
            max-width: 100%;
        }
        @media (min-width: 768px) {
            .file-container {
                margin-bottom: 150px;
            }
            .file-icon {
                max-width: 60%;
            }
        }

        @media (max-width: 767px) {
            .file-container {
                margin-bottom: 150px;
            }
            .file-icon {
                max-width: 60%;
            }
        }
        .delete-image-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px; /* Adjust size as needed */
            height: 40px; /* Adjust size as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px; /* Adjust size as needed */
            cursor: pointer;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .carousel-item:hover .delete-image-btn {
            opacity: 1;
        }
    </style>
</head>

<body class="dark-sidebar">
    <div class="app">
        <div class="app-wrap">
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="<?=base_url();?>assets/img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>
            <header class="app-header top-bar">
                <nav class="navbar navbar-expand-md">
                    <div class="navbar-header d-flex align-items-center">
                        <a href="javascript:void:(0)" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
                        <a class="navbar-brand" href="/">
                            <img src="<?=base_url();?>images/szs.png" class="img-fluid logo-desktop" alt="logo" />
                            <img src="<?=base_url();?>images/szs.png" class="img-fluid logo-mobile" alt="logo" />
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-align-left"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navigation d-flex">
                            <ul class="navbar-nav nav-right ml-auto">
                                <li class="nav-item dropdown user-profile">
                                    <a href="javascript:void(0)" class="nav-link dropdown-toggle " id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?=base_url();?>assets/img/avatar.png" alt="avtar-img">
                                        <span class="bg-success user-status"></span>
                                    </a>
                                    <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                                        <div class="bg-gradient px-4 py-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="mr-1">
                                                    <h4 class="text-white mb-0">DHRUV Realty Administrator</h4>
                                                </div>
                                                <a href="/admin/logout" class="text-white font-20 tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout">
                                                    <i class="zmdi zmdi-power"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>