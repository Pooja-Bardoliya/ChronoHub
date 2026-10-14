<?php
session_start();
include("connect.php");
?>
<!doctype html>
<html lang="en">

<head>
    <title>ChronoHub — Sign In</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS v5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- External Login CSS -->
    <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="login-card">

        <!-- Brand Header -->
        <div class="brand-header text-center mb-5 pb-1">
            <a href="home.php" class="brand-logo text-decoration-none d-inline-block mb-1" style="font-size: 1.85rem; font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.04em; color: #0f1115; text-transform: uppercase;">
                <span class="brand-text" style="color: #0f1115; font-weight: 700; display: inline-flex; align-items: center;">CHR<img src="uploads/watch_o.png" class="watch-o-letter" alt="O" style="height: 1.08em; width: auto; vertical-align: -0.15em; margin: 0 2px 0 1px;">NO<span class="brand-gold" style="color: #c5a059;">HUB</span></span>
            </a>
            <p class="brand-tagline text-muted small text-uppercase font-nav fw-semibold tracking-wider mb-0" style="font-size: 0.65rem; letter-spacing: 0.15em;">LUXURY TIMEPIECES</p>
        </div>

        <form action="" method="post">

            <!-- Email / Username Field -->
            <div class="mb-3 text-start">
                <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">USERNAME OR EMAIL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="form-control font-nav py-2" placeholder="Enter username or email" name="txtemail">
                </div>
            </div>

            <!-- Password Field -->
            <div class="mb-4 text-start">
                <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">PASSWORD</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="passwordInput" class="form-control font-nav py-2" placeholder="Enter password" name="txtpassword">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-luxury-signin" name="btnsubmit">
                SIGN IN
            </button>

        </form>

        <div class="text-center font-nav small text-muted">
            Don't have an account? <a href="register.php" class="fw-bold text-dark text-decoration-underline ms-1">Register Here</a>
        </div>

    </div>

    <!-- Bootstrap Bundle & SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

<?php

if (isset($_POST['btnsubmit'])) {

    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];

    if (empty($email)) {
        echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Enter Email..!',
                });</script>";
    } elseif (empty($password)) {
        echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Enter Password..!',
                });</script>";
    } else {
        if (strcmp($email, "admin@gmail.com") == 0 && strcmp($password, "admin123") == 0) {
            $_SESSION['isadmin'] = true;
            header("location:admin_home.php");
        } else {
            $query = "SELECT * FROM `tbl_user` WHERE `email`='$email' AND `password`='$password';";
            $res = mysqli_query($con,$query);
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                $row = mysqli_fetch_assoc($res);
                $_SESSION['isloggedin'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['userid'] = $row['user_id'];
                header("location:home.php");
            } else {
                echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid Email and Password!',
                });</script>";
            }
        }
    }
}

?>
