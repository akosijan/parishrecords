<?php
include 'header.php';
include 'db_connect.php';
?>

<style>
    .bg-primary {
        background-color: rgb(240, 240, 240) !important;
    }

    .table .thead-dark th {
        color: #fff;
        background-color: rgba(204, 204, 204, 0.77);
        border-color: rgb(212, 212, 212);
    }
</style>

<body class="hold-transition layout-fixed">
    <div class="wrapper">
        <?php include 'navbar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 mx-auto mt-4">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h5 style="color: black;" class="mb-0 d-inline">Users List</h5>
                                <button id="addUserBtn" class="btn btn-success btn-sm float-right">+ Add User</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead class="">
                                        <tr>
                                            <th>Role</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT userid, role, username, email, created_at FROM users";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . ucfirst(htmlspecialchars($row['role'])) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                echo "<td>" . $row['created_at'] . "</td>";
                                                echo "<td>
                                                        <button class='btn btn-warning btn-sm editUserBtn' 
                                                            data-id='" . $row['userid'] . "' 
                                                            data-username='" . htmlspecialchars($row['username']) . "' 
                                                            data-email='" . htmlspecialchars($row['email']) . "' 
                                                            data-role='" . $row['role'] . "'>Edit</button>

                                                        <button class='btn btn-danger btn-sm deleteUserBtn' 
                                                            data-id='" . $row['userid'] . "'>Delete</button>
                                                    </td>";

                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No users found</td></tr>";
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- End of Row -->
            </div> <!-- End of Container -->
        </div> <!-- End of Content Wrapper -->
    </div> <!-- End of Wrapper -->

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tableBody = document.querySelector("tbody");

            // 🟢 ADD USER BUTTON FUNCTIONALITY
            document.getElementById('addUserBtn').addEventListener('click', function() {
                Swal.fire({
                    title: 'Add New User',
                    html: `
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <select id="swal-role" class="swal2-input">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="text" id="swal-username" class="swal2-input" placeholder="Username">
                <input type="email" id="swal-email" class="swal2-input" placeholder="Email">
                <input type="password" id="swal-password" class="swal2-input" placeholder="Password">
                <input type="password" id="swal-confirm-password" class="swal2-input" placeholder="Confirm Password">
                <div style="display: flex; align-items: center;">
                    <input type="checkbox" id="swal-show-password">
                    <label for="swal-show-password" style="margin-left: 5px;">Show Password</label>
                </div>
            </div>
        `,
                    confirmButtonText: 'Add User',
                    showCancelButton: true,
                    didOpen: () => {
                        document.getElementById("swal-show-password").addEventListener("change", function() {
                            const passwordField = document.getElementById("swal-password");
                            const confirmPasswordField = document.getElementById("swal-confirm-password");
                            const type = this.checked ? "text" : "password";
                            passwordField.type = type;
                            confirmPasswordField.type = type;
                        });
                    },
                    preConfirm: () => {
                        const role = document.getElementById("swal-role").value;
                        const username = document.getElementById("swal-username").value.trim();
                        const email = document.getElementById("swal-email").value.trim();
                        const password = document.getElementById("swal-password").value;
                        const confirmPassword = document.getElementById("swal-confirm-password").value;

                        if (!role || !username || !email || !password || !confirmPassword) {
                            Swal.showValidationMessage('❌ All fields are required!');
                            return false;
                        }
                        if (password !== confirmPassword) {
                            Swal.showValidationMessage('❌ Passwords do not match!');
                            return false;
                        }

                        return fetch('add_user.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `role=${role}&username=${username}&email=${email}&password=${password}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire('✅ User Added!', '', 'success').then(() => location.reload());
                                } else {
                                    Swal.fire('❌ Error!', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('❌ Error!', 'Something went wrong', 'error');
                            });
                    }
                });
            });


            // 🟠 EDIT USER BUTTON FUNCTIONALITY
            tableBody.addEventListener("click", function(event) {
                if (event.target.classList.contains("editUserBtn")) {
                    const button = event.target;
                    const userId = button.dataset.id;
                    const username = button.dataset.username;
                    const email = button.dataset.email;
                    const role = button.dataset.role;

                    Swal.fire({
                        title: 'Edit User',
                        html: `
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <select id="swal-role" class="swal2-input">
                                    <option value="user" ${role === 'user' ? 'selected' : ''}>User</option>
                                    <option value="admin" ${role === 'admin' ? 'selected' : ''}>Admin</option>
                                </select>
                                <input type="text" id="swal-username" class="swal2-input" value="${username}">
                                <input type="email" id="swal-email" class="swal2-input" value="${email}">
                            </div>
                        `,
                        confirmButtonText: 'Update User',
                        showCancelButton: true,
                        preConfirm: () => {
                            const updatedRole = document.getElementById("swal-role").value;
                            const updatedUsername = document.getElementById("swal-username").value.trim();
                            const updatedEmail = document.getElementById("swal-email").value.trim();

                            if (!updatedRole || !updatedUsername || !updatedEmail) {
                                Swal.showValidationMessage('❌ All fields are required!');
                                return false;
                            }

                            return fetch('update_user.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `userid=${userId}&role=${updatedRole}&username=${updatedUsername}&email=${updatedEmail}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire('✅ User Updated!', '', 'success').then(() => location.reload());
                                    } else {
                                        Swal.fire('❌ Error!', data.message, 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('❌ Error!', 'Something went wrong', 'error');
                                });
                        }
                    });
                }
            });
            tableBody.addEventListener("click", function(event) {
                if (event.target.classList.contains("deleteUserBtn")) {
                    const userId = event.target.dataset.id;
                    console.log("User ID to delete:", userId);

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action cannot be undone!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log("Deleting user...");

                            fetch("delete_user.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: `id=${userId}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log("Response from server:", data);
                                    if (data.status === "success") {
                                        Swal.fire("Deleted!", "User has been removed.", "success")
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire("Error!", data.message, "error");
                                    }
                                })
                                .catch(error => {
                                    console.error("Fetch error:", error);
                                    Swal.fire("Error!", "Something went wrong.", "error");
                                });
                        }
                    });
                }
            });
        });
    </script>

</body>

<?php include 'footer.php'; ?>