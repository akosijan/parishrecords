<style>
    .custom-dropdown {
        background-color: #a9a9a9 !important;
        border: none;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }
    .custom-dropdown .dropdown-item {
        color: #fff !important;
        padding: 10px 20px;
    }
    .custom-dropdown .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.27) !important;
        color: #fff !important;
    }
    .sidebar-footer {
        position: absolute;
        bottom: 10px;
        width: 100%;
        padding: 5px;
        text-align: center;
        color: #fff;
        font-size: 18px;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link text-white">
                <i class="fa-solid fa-clock"></i> <span id="ph-time"></span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw mr-1"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="account_settings.php"><i class="fa-solid fa-user-gear"></i> Change Password</a></li>
                <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                <li><a class="dropdown-item" href="about.php"><i class="fa-solid fa-circle-info"></i> About</a></li>
            </ul>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="" class="brand-link hover">
        <img src="assets/img/loginlogo.png" alt="icon" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">PRMS-Matalom</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Main</li>
                <li class="nav-item">
                    <a href="encoder_home.php" class="nav-link">
                        <i class="fa-solid fa-house nav-icon"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="baptism.php" class="nav-link">
                        <i class="fa-solid fa-baby"></i>
                        <p>Baptism</p>
                    </a>
                </li>
                <!-- <li class="nav-item dropdown">
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
                </li> -->
                <li class="nav-item">
                    <a href="confirmation.php" class="nav-link">
                    <i class="fa-solid fa-square-check"></i>
                        <p>Confirmation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="marriage.php" class="nav-link">
                    <i class="fa-solid fa-heart"></i>
                        <p>Marriage</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="death.php" class="nav-link">
                    <i class="fa-solid fa-cross"></i>
                        <p>Death</p>
                    </a>
                </li>
                <!-- <li class="nav-header">IT</li> -->
                <!-- <li class="nav-item">
                    <a href="inventory.php" class="nav-link">
                        <i class="fa-solid fa-computer nav-icon"></i>
                        <p>ICT Inventory</p>
                    </a>
                </li> -->
                <!-- <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="collapse" data-target="#ROAPSMenu" aria-expanded="false" aria-controls="ROAPSMenu">
                        <i class="fa-solid fa-file nav-icon"></i>
                        <p>ROAPS</p>
                    </a>
                    <div id="ROAPSMenu" class="collapse dropdown-menu-end ms-auto">
                        <a class="dropdown-item" href="roaps_cds_import_export.php">
                            <i class="fa-solid fa-laptop-file me-2"></i>CDS
                        </a>
                        <a class="dropdown-item" href="roaps_rps.php">
                            <i class="fa-solid fa-folder me-2"></i>RPS
                        </a>
                        <a class="dropdown-item" href="roaps_mes.php">
                            <i class="fa-solid fa-folder me-2"></i>MES
                        </a>
                        <a class="dropdown-item" href="roaps_planning.php">
                            <i class="fa-solid fa-folder me-2"></i>PLANNING
                        </a>
                        <a class="dropdown-item" href="roaps_admin.php">
                            <i class="fa-solid fa-folder me-2"></i>ADMIN
                        </a>
                        <a class="dropdown-item" href="roaps_records.php">
                            <i class="fa-solid fa-folder me-2"></i>RECORDS
                        </a>
                    </div>
                </li> -->
                <!-- <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="collapse" data-target="#ProcedureMenu" aria-expanded="false" aria-controls="ProcedureMenu">
                    <i class="fa-solid fa-chalkboard-user"></i>
                        <p>Procedure</p>
                    </a>
                    <div id="ProcedureMenu" class="collapse dropdown-menu-end ms-auto">
                        <a class="dropdown-item" href="user_logs_analytics.php">
                            <i class="fa-solid fa-laptop-file me-2"></i>123
                        </a>
                        <a class="dropdown-item" href="documents.php">
                            <i class="fa-solid fa-folder me-2"></i>123
                        </a>
                        <a class="dropdown-item" href="documents.php">
                            <i class="fa-solid fa-folder me-2"></i>123
                        </a>
                    </div>
                </li> -->
                <li class="nav-header">Others</li>
                
                <!-- <li class="nav-item position-relative">
                    <a href="chat.php" class="nav-link position-relative">
                        <i class="fa-solid fa-comments"></i>
                        <p class="d-inline">Messages</p>
                        <span id="unread-dot" class="badge bg-danger position-absolute top-0 start-100 translate-middle d-none" 
                        style="width: 10px; height: 10px; border-radius: 50%;"></span>
                    </a>
                </li> -->
                <li class="nav-item position-relative">
                    <a href="view_data.php" class="nav-link position-relative">
                        <i class="fa-solid fa-comments"></i>
                        <p class="d-inline">View Data</p>
                        <span id="unread-dot" class="badge bg-danger position-absolute top-0 start-100 translate-middle d-none" 
                        style="width: 10px; height: 10px; border-radius: 50%;"></span>
                    </a>
                </li>
            
            </ul>
        </nav>
    </div>
</aside>
<script>
    function updatePhilippineTime() {
        let options = {
            timeZone: 'Asia/Manila',
            hour12: true,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        let phTime = new Intl.DateTimeFormat('en-US', options).format(new Date());
        document.getElementById('ph-time').textContent = phTime + " PST";
    }
    setInterval(updatePhilippineTime, 1000);
    updatePhilippineTime();
</script>
