<?php
session_start();
require_once('classes/admin.class.php');
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
} else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('modules/head.php'); ?>
    <title>Bech.pk - Harjaga, Harpal</title>
    <link rel="stylesheet" href="assets/css/index.css" />
</head>

<body class="grey lighten-4">
    <?php include('modules/index_nav.php'); ?>

    <div class="parallax-container valign-wrapper">
        <div class="parallax hide-on-small-only">
            <img src="assets/img/backgrounds/index_desktop.webp" alt="" />
        </div>
        <div class="parallax show-on-small hide-on-med-and-up">
            <img src="assets/img/backgrounds/index_mobile.webp" alt="" />
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12 m6 offset-m3 l4 offset-l4 grey lighten-4">
                    <form action="includes/form-handlers/admin_login.php" method='POST' id="adminLogin">
                        <div class="row">
                            <h4 class="grey-text text-darken-4 center-align">
                                Login
                            </h4>
                            <p class="center-align">
                                <b class="red-text" id="fallback-error">

                                </b>
                            </p>
                            <div class="col s10 offset-s1 input-field">
                                <input type="email" name="admin_email" id="admin_email" />
                                <label for="admin_email">Admin Email</label>
                                <span class="helper-text red-text right" id="email-error"></span>
                            </div>
                            <div class="col s10 offset-s1 input-field">
                                <input type="password" name="admin_password" id="admin_password" />
                                <label for="admin_password">Admin Password</label>
                                <span class="helper-text red-text right" id="password-error"></span>
                            </div>
                            <div class="col s12 center-align">
                                <button class="btn green admin-login-btn">LOGIN</button>
                            </div>
                        </div>
                    </form>
                    <div class="row valign-wrapper" id='login_loader'>
                        <div class="col s12 center-align">
                            <h3 class="flow-text">Please wait!</h3>
                        </div>
                        <div class="col s6 offset-s3">
                            <div class="progress">
                                <div class="indeterminate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('modules/footer.php'); ?>
    
    <?php include('modules/scripts.php'); ?>
</body>

</html>

<?php
}
?>