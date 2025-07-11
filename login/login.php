<?php
include "function.php";
include "db_connect.php";

if (isset($_SESSION['login_userid'])) {
    header('location: ../admin/home.php');
    exit;
}

// Handle AJAX search request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'search') {
    header('Content-Type: application/json');

    $category = $_POST['category'];
    $value = trim($_POST['value']);
    $found = false;

    // Masking function per word
    function mask($str) {
        $words = explode(" ", $str);
        $maskedWords = [];
        foreach ($words as $word) {
            $len = strlen($word);
            if ($len <= 1) {
                $maskedWords[] = "*";
            } elseif ($len == 2) {
                $maskedWords[] = $word[0] . "*";
            } else {
                $maskedWords[] = $word[0] . str_repeat("*", $len - 2) . $word[$len - 1];
            }
        }
        return implode(" ", $maskedWords);
    }

    if ($category === 'marriage') {
        // Full name search using multiple LIKEs
        $words = explode(" ", $value);
        $likeClauses = [];
        $params = [];
        $types = "";

        foreach ($words as $word) {
            $likeClauses[] = "husband_name LIKE ?";
            $params[] = "%" . $word . "%";
            $types .= "s";
        }

        $sql = "SELECT * FROM marriage_tbl WHERE " . implode(" AND ", $likeClauses) . " LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
    } else {
        // First name search
        $stmt = $conn->prepare("SELECT * FROM {$category}_tbl WHERE firstname LIKE ? LIMIT 10");
        $searchTerm = "%" . $value . "%";
        $stmt->bind_param("s", $searchTerm);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $records = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($category === 'marriage') {
                $display = mask($row['husband_name']) . ", " . mask($row['wife_name']);
            } else {
                $last = isset($row['lastname']) ? mask($row['lastname']) : '';
                $display = mask($row['firstname']) . " " . $last;
            }
            $records[] = $display;
        }
        $found = true;
    }

    echo json_encode([
        "found" => $found,
        "count" => count($records),
        "records" => $records,
        "message" => $found ? "Found {$records[0]}" : "No record found."
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Page</title>

    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            position: relative;
            background-image: url('../assets/img/loginp.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            filter: blur(5px);
            z-index: -1;
        }
        body::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(255, 255, 255, 0.3);
            z-index: -1;
        }
        .card {
            background: rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .left-form {
            background: linear-gradient(rgb(0, 0, 0), rgb(2, 97, 2));
        }
    </style>
</head>

<body>
<div class="d-flex flex-column min-vh-100">
    <div class="container d-flex justify-content-center align-items-center flex-grow-1">
        <div class="card w-100 shadow">
            <div class="row">
                <div class="col-md-6 d-none d-md-flex justify-content-center p-3 left-form">
                    <div class="container">
                        <div id="carouselExample" class="carousel slide w-100" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="../assets/img/logologin.png" class="d-block w-100" alt="Slide" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-3">
                    <div class="container p-4">
                        <h1 class="mb-4 text-center" style="font-weight:bold; font-size: 48px;">
                            Sign In
                        </h1>
                        <form action="#" method="post">
                            <div class="form-group mb-4">
                                <label for="username">Username</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="username"
                                    id="username"
                                    placeholder="Enter your username"
                                    autofocus
                                    autocomplete="on"
                                />
                            </div>
                            <div class="form-group mb-4">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    id="password"
                                    placeholder="Enter your password"
                                    autocomplete="on"
                                />
                                <small
                                    id="togglePassword"
                                    class="text-primary"
                                    style="cursor: pointer; display: block; margin-top: 5px;"
                                >
                                    View Password
                                </small>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-50" name="btn-login">
                                    Login
                                </button>
                            </div>
                            <hr />
                            <div class="login-footer mt-3 text-center">
                                <a href="forgot_password.php" style="text-decoration: underline; margin-right: 20px;">Forgot Password?</a>
                                <a href="#" id="searchDetails" style="text-decoration: underline;">Search</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto text-white py-4">
        <div class="container text-center">
            <p class="mb-2">PRMS-Matalom. All Rights Reserved &copy; <?php echo date("Y"); ?></p>
            <p class="mb-2">
                By
                <a
                    href="https://web.facebook.com/superjansnoww"
                    target="_blank"
                    rel="noopener noreferrer"
                    style="text-decoration: underline; color: white;"
                    >BULALA BOYZ</a
                >
            </p>
        </div>
    </footer>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        const passwordField = document.getElementById("password");
        passwordField.type = passwordField.type === "password" ? "text" : "password";
    });

    $(document).ready(function () {
        $('#searchDetails').click(function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Search Records',
                html: `
                    <div class="mb-3">
                        <select id="category" class="form-select">
                            <option value="baptism">Baptism</option>
                            <option value="confirmation">Confirmation</option>
                            <option value="marriage">Marriage</option>
                            <option value="death">Death</option>
                        </select>
                    </div>
                    <input type="text" id="searchValue" class="form-control" placeholder="Search by first name (e.g. Juan)">
                `,
                didOpen: () => {
                    const select = Swal.getPopup().querySelector('#category');
                    const input = Swal.getPopup().querySelector('#searchValue');
                    select.addEventListener('change', () => {
                        input.placeholder = select.value === 'marriage'
                            ? 'Search by full name (e.g. Juan Dela Cruz)'
                            : 'Search by first name (e.g. Juan)';
                    });
                },
                showCancelButton: true,
                confirmButtonText: 'Search',
                preConfirm: () => {
                    const category = Swal.getPopup().querySelector('#category').value;
                    const value = Swal.getPopup().querySelector('#searchValue').value.trim();
                    if (!value) {
                        Swal.showValidationMessage('Please enter a name.');
                        return false;
                    }
                    return { category, value };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "", // same page
                        data: {
                            action: "search",
                            category: result.value.category,
                            value: result.value.value
                        },
                        dataType: "json",
                        success: function (response) {
                            let htmlMsg = response.records && response.records.length > 0
                                ? response.records.map(r => `<li>${r}</li>`).join('')
                                : '';

                            let buttons = '';

                            if (response.count > 3) {
                                buttons = `
                                    <button id="viewPage" class="btn btn-primary mt-3">View on a Separate Page</button>
                                `;
                            }

                            Swal.fire({
                                icon: response.found ? 'success' : 'error',
                                title: response.found ? `Found ${response.count} record(s)` : 'No Record',
                                html: `<ul style="text-align:left;">${htmlMsg}</ul>${buttons}`,
                                showCloseButton: true,
                                showConfirmButton: !buttons, // hide confirm if buttons shown
                            });

                            if (response.count > 3) {
                                $(document).one('click', '#viewPage', function () {
                                    const cat = result.value.category;
                                    const val = encodeURIComponent(result.value.value);
                                    window.location.href = `client_search.php?category=${cat}&value=${val}`;
                                });
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Server error occurred.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
</body>
</html>
