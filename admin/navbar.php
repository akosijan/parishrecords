<style>
    /* Custom Dropdown Styles */
    .custom-dropdown {
        background-color: #a9a9a9 !important;
        /* Change dropdown background color */
        border: none;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        /* Optional: Adds shadow */
    }

    .custom-dropdown .dropdown-item {
        color: #fff !important;
        /* Change text color */
        padding: 10px 20px;
    }

    .custom-dropdown .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.27) !important;
        /* Hover effect */
        color: #fff !important;
    }

    /* Footer Styles */
    .sidebar-footer {
        position: absolute;
        bottom: 10px;
        width: 100%;
        padding: 5px;
        text-align: center;
        color: #fff;
        font-size: 14px;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw mr-1"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="account_settings.php"><i class="fa-solid fa-user-gear"></i> Change Password</a></li>
                <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </li>

    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link hover">
        <img src="assets/img/logologin.png" alt="icon" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">DENR-CENRO</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header">Main</li>

                <li class="nav-item">
                    <a href="home.php" class="nav-link">
                        <i class="fa-solid fa-gauge nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="app_entry.php" class="nav-link">
                        <i class="fa-regular fa-folder-open nav-icon"></i>
                        <p>Application Entry</p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="collapse" data-target="#transmittalFormMenu" aria-expanded="false" aria-controls="transmittalFormMenu">
                        <i class="fa-solid fa-file nav-icon"></i>
                        <p>Transmittal Form</p>
                    </a>
                    <div id="transmittalFormMenu" class="collapse dropdown-menu-end ms-auto">
                        <a class="dropdown-item" href="transmittal_form.php">
                            <i class="fa-solid fa-laptop-file me-2"></i> ICT
                        </a>
                        <a class="dropdown-item" href="documents.php">
                            <i class="fa-solid fa-folder me-2"></i> Documents
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="travel_form.php" class="nav-link">
                        <i class="fa-regular fa-paper-plane nav-icon"></i>
                        <p>Travel Order Form</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="inventory.php" class="nav-link">
                        <i class="fa-solid fa-computer nav-icon"></i>
                        <p>ICT Equipment Inventory</p>
                    </a>
                </li>

                <li class="nav-header">Others</li>

                <li class="nav-item">
                    <a href="manage_users.php" class="nav-link">
                        <i class="fa-solid fa-users nav-icon"></i>
                        <p>Manage Users</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <!-- All Rights Reserved 2025<br>©DENR-CENRO ORMOC -->
         Made With Love
         <!-- All Rights Reserved 2025 -->
    </div>
</aside>
<!-- end Sidebar -->
