<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.11/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- Javascript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.9/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

    <!-- Custom Styles -->
    <link href="<?php echo base_url('assets/css/styles.scss') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Varela+Round|Archivo+Black&display=swap" rel="stylesheet">

    <!-- Font Icons -->
    <script src="https://kit.fontawesome.com/f083cf2118.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('.select').selectpicker();
        });
    </script>

</head>

<body>
    <div id="loader"></div>
    <?php
    $url = $_SERVER['REQUEST_URI'];
    $url_check = substr($url, 11, strlen($url) - 1);

    if ((strpos($url_check, 'login') || strpos($url_check, 'signup') || strpos($url_check, 'logout') || strpos($url_check, 'landing') || empty($url_check)) == false) { ?>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <div class="container">
                <ul class="navbar-nav">
                    <li>
                        <a href="<?php echo base_url() ?>index.php/Dashboard">
                            <img src="<?php echo base_url('assets/images/logo_2.png') ?>" alt="" width="50px;">
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>index.php/Dashboard">
                            <h2 class="custom-font" style="line-height: 1.5; color: #000;"><span style="color: #BD0B0A;">Ear</span>bender</h2>
                        </a>
                    </li>
                </ul>
                <ul style="color: #000;" class="navbar-nav navbar-right">
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="<?php echo base_url() ?>index.php/Dashboard">Home</a> -->
                    </li>
                    <li class="nav-item">
                        <a style="display: inline-block; color: #000;" class="nav-link" href="<?php echo base_url('index.php/Profile') ?>"><?php echo $this->session->uname; ?></a>
                    </li>
                    <li style="font-size: 1rem; line-height: 2.4; padding-left: 10px;">
                        <a style="display: inline-block; color: #000;" href="<?php echo base_url('index.php/logout') ?>">
                            Logout
                            <i style="display: inline; color: #BD0B0A;" class="fas fa-sign-out-alt"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php } ?>