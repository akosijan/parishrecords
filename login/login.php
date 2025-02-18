<?php

include "function.php";

if (isset($_SESSION['login_userid'])) {
    header('location: ../admin/home.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- jquery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>

    <!-- bootstrap -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- adminlte -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">

</head>

<style>
    /* Fullscreen video background */
    .video-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        /* Make sure the video stays behind content */
        object-fit: fill;
        /* Cover the entire screen */
    }

    body {
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(5px);
        z-index: -1;
    }

    body::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.3);
        z-index: -1;
    }

    .card {
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .left-form {
        background: linear-gradient(rgb(0, 0, 0), rgb(2, 97, 2));
    }
</style>


<body>
    <!-- Background video -->
    <video autoplay muted loop class="video-background">
        <source src="../assets/img/background video.mp4" type="video/mp4">
        <!-- You can also add other formats if you want to support more browsers -->
        <!-- <source src="your-video-file.webm" type="video/webm"> -->
    </video>


    <div class="d-flex flex-column min-vh-100">
        <!-- Main Content -->
        <div class="container d-flex justify-content-center align-items-center flex-grow-1">
            <div class="card w-100 shadow">
                <div class="row">
                    <!-- Left Form (Carousel) - Hidden on Mobile -->
                    <div class="col-md-6 d-none d-md-flex justify-content-center p-3 left-form">
                        <div class="container">
                            <div id="carouselExample" class="carousel slide w-100" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="../assets/img/logologin.png" class="d-block w-100" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/img/janjan.png" class="d-block w-100" alt="Second slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/img/bigboy.png" class="d-block w-100" alt="Third slide">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Form (Login Form) -->
                    <div class="col-12 col-md-6 p-3">
                        <div class="container p-4">
                            <h1 class="mb-4 text-center" style="font-weight:bold; font-size: 48px;">Sign In</h1>
                            <form action="#" method="post">
                                <div class="form-group mb-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" autofocus autocomplete="on">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" autocomplete="on">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-50" name="btn-login">Login</button>
                                </div>
                                <hr>
                                <div class="login-footer mt-3 text-center">
                                    <a href="forgot_password.php" style="text-decoration:underline;">Forgot Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-auto text-white py-4">
            <div class="container text-center">
                <!-- <p class="mb-2">
                    EVSU-OC Entry & Exit Verification System. All Rights Reserved &copy; 2024-<span id="year"></span>
                </p>
                <p class="mb-2">
                    A Capstone Project by <a href="https://github.com/Kaelx" target="_blank" rel="noopener noreferrer" style="text-decoration: underline; color: white;">Elevatech</a>
                </p> -->
            </div>
        </footer>


    </div>
</body>

</html>