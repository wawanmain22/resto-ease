<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login - Resto Ease</title>
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        .invalid-feedback {
            color: red;
            font-size: 1.2em;
            margin-top: 5px;
            display: none;
            align-items: center;
        }

        .invalid-feedback .fas {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">
                                <form id="loginForm" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                            required autofocus placeholder="Enter your email">
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label">Password</label>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required placeholder="Enter your password">
                                        <div class="invalid-feedback">
                                            Please fill in your password
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            loginForm.addEventListener('submit', function (event) {
                event.preventDefault();
                let valid = true;

                if (!emailInput.value) {
                    emailInput.classList.add('is-invalid');
                    emailInput.nextElementSibling.style.display = 'flex';
                    valid = false;
                } else {
                    emailInput.classList.remove('is-invalid');
                    emailInput.nextElementSibling.style.display = 'none';
                }

                if (!passwordInput.value) {
                    passwordInput.classList.add('is-invalid');
                    passwordInput.nextElementSibling.style.display = 'flex';
                    valid = false;
                } else {
                    passwordInput.classList.remove('is-invalid');
                    passwordInput.nextElementSibling.style.display = 'none';
                }

                if (valid) {
                    const formData = new FormData(loginForm);

                    fetch('proses/proses_login.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = 'dashboard.php';
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Failed',
                                    text: data.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat memproses login',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });

            emailInput.addEventListener('input', function () {
                if (emailInput.value) {
                    emailInput.classList.remove('is-invalid');
                    emailInput.nextElementSibling.style.display = 'none';
                }
            });

            passwordInput.addEventListener('input', function () {
                if (passwordInput.value) {
                    passwordInput.classList.remove('is-invalid');
                    passwordInput.nextElementSibling.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>