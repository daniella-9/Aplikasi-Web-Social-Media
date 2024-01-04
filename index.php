<?php 
    session_start();
    require_once "func/isLogin.php";
    require_once "func/isHasError.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login Page</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="proses.php?action=login" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="username" type="text" placeholder="Username" />
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-3">
                                                <a href="google.php" class="btn btn-danger"><i class="fa-brands fa-google"></i> Atau Login Dengan Google</a>
                                            </div>
                                            <div class="mb-3 d-flex justify-content-center">
                                                <div class="g-recaptcha" data-sitekey="6Lc24zIpAAAAAL8r6E-a3xaAIuBkxL8xF0HKdxl8" data-callback="recaptchaCallback" onchange="checkRecaptcha()"></div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary" id="submit" disabled>Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Belum punya akun? Daftar!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script>
            function recaptchaCallback() {
                submit.removeAttribute("disabled");
            };
        </script>
    </body>
</html>
