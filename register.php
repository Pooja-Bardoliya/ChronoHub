<?php
    include("connect.php");

    if(isset($_POST['btnsubmit']))
    {
        $username = $_POST['txtusername'];
        $email = $_POST['txtemail'];
        $password = $_POST['txtpassword'];
        $cpassword = $_POST['txtcpassword'];
        $mobileno = $_POST['txtmobno'];
        $address = $_POST['txtaddress'];

        $error = "";

        if(empty($username))
        {
            $error = "Username Required \\n";
        }
        if(empty($email))
        {
            $error = $error . "Email Required \\n";
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $error = $error . "Enter Valid Email \\n";
        }
        if(empty($password))
        {
           $error = $error . "Password Required \\n";
        }
        if(empty($cpassword))
        {
            $error = $error . "Confirm Password Required \\n";
        }
        if(strlen($password)<6 || strlen($password)>8)
        {
            $error = $error . "Password must be between 6 to 8 character \\n";
        }
        if(strcmp($password,$cpassword))
        {
            $error = $error . "Password and Confirm password must match \\n";
        }
        if(empty($mobileno))
        {
            $error = $error . "Mobile No. Required \\n";
        }
        if(strlen($mobileno)!=10)
        {
            $error = $error . "Mobile No. must be 10 digit \\n";
        }
        if(empty($address))
        {
            $error = $error . "Address Required \\n";
        }
      
        if(empty($error))
        {
            $query = "INSERT INTO `tbl_user` (`user_id`, `username`, `email`, `password`, `address`, `mobileno`) VALUES (NULL, '$username', '$email', '$password', '$address', '$mobileno');";

            $res = mysqli_query($con,$query);
            if($res>0)
            {
                header("location:login.php");
                exit();
            }
            else
            {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
        else
        {
            echo "<script>alert('$error');</script>";
        }
    }
?>
<!doctype html>
<html lang="en">

<head>
    <title>ChronoHub — Create Account</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS v5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- External Register CSS -->
    <link rel="stylesheet" href="register.css?v=<?php echo time(); ?>">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="register-card">

        <!-- Brand Header -->
        <div class="brand-header text-center mb-5 pb-1">
            <a href="home.php" class="brand-logo text-decoration-none d-inline-block mb-1" style="font-size: 1.85rem; font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.04em; color: #0f1115; text-transform: uppercase;">
                <span class="brand-text" style="color: #0f1115; font-weight: 700; display: inline-flex; align-items: center;">CHR<img src="uploads/watch_o.png" class="watch-o-letter" alt="O" style="height: 1.08em; width: auto; vertical-align: -0.15em; margin: 0 2px 0 1px;">NO<span class="brand-gold" style="color: #c5a059;">HUB</span></span>
            </a>
            <p class="brand-tagline text-muted small text-uppercase font-nav fw-semibold tracking-wider mb-0" style="font-size: 0.65rem; letter-spacing: 0.15em;">LUXURY TIMEPIECES</p>
        </div>

        <form action="" method="post">

            <!-- Username Field -->
            <div class="mb-3 text-start">
                <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">USERNAME</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-circle-user"></i></span>
                    <input type="text" class="form-control font-nav py-2" placeholder="Enter username" name="txtusername">
                </div>
            </div>

            <!-- Email Field -->
            <div class="mb-3 text-start">
                <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">EMAIL ADDRESS</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" class="form-control font-nav py-2" placeholder="Enter email address" name="txtemail">
                </div>
            </div>

            <!-- Password & Confirm Password (2 Column) -->
            <div class="row g-3 mb-3">
                <div class="col-md-6 text-start">
                    <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control font-nav py-2" placeholder="Password" name="txtpassword">
                    </div>
                </div>

                <div class="col-md-6 text-start">
                    <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">CONFIRM PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-shield-halved"></i></span>
                        <input type="password" class="form-control font-nav py-2" placeholder="Confirm" name="txtcpassword">
                    </div>
                </div>
            </div>

            <!-- Mobile Number Field -->
            <div class="mb-3 text-start">
                <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">MOBILE NUMBER</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-phone"></i></span>
                    <input type="number" class="form-control font-nav py-2" placeholder="Enter mobile number" name="txtmobno">
                </div>
            </div>

            <!-- Address Field -->
            <div class="mb-4 text-start">
                <label class="form-label font-nav fw-bold text-uppercase text-dark mb-1.5" style="font-size: 0.82rem; letter-spacing: 0.05em;">SHIPPING ADDRESS</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-location-dot"></i></span>
                    <textarea class="form-control font-nav py-2" rows="2" placeholder="Enter shipping address" name="txtaddress"></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-luxury-signup" name="btnsubmit">
                CREATE ACCOUNT
            </button>

        </form>

        <div class="text-center font-nav small text-muted">
            Already a member? <a href="login.php" class="fw-bold text-dark text-decoration-underline ms-1">Login Now</a>
        </div>

    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>