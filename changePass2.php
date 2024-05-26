<?php 

require_once('config.php');
require_once('database/dbhelper.php');
if(isset($_GET['email'])) {
    $email = $_GET['email'];
    // Use the email to identify the user
    //echo "Email: " . $email . "<br>";

    $sql = "SELECT id_user FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        //echo "User ID: " . $user['id_user'] . "<br>"; // Output the user ID
    }
}

if(isset($_POST['newpassword']) && isset($_POST['renewpassword'])) {
    $newpassword = $_POST['newpassword'];
    $renewpassword = $_POST['renewpassword'];

    if($newpassword == $renewpassword) {
        $sql = "UPDATE user SET matkhau = ? WHERE email = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param('ss', $newpassword, $email);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            header('Location: login.php?passwordChanged=true'); // Redirect to login.php with a parameter
            exit();
        } else {
            echo "<script>alert('404 Server');</script>";
        }
    } else {
        echo "<script>alert('Xin hãy nhập lại pass, chú ý hai pass giống nhau');</script>";
    }
}







?>


<?php 
 include("Layout/header.php");
?>


<script>

</script>

<section class="contact-img-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="con-text">
                                <h2 class="page-title">ĐỔI MẬT KHẨU</h2>
                                <p><a href="#">Home</a> | Đổi mật khẩu</p>
                            </div>
                        </div>
                    </div>
                </div>
</section>
<!-- login content section start -->
<div class="login-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="tb-login-form ">
                            <h5 class="tb-title">Đổi mật khẩu</h5>
                            <p>Đổi mật khẩu tài khoản để trải nghiệm mua sắm tại Luxury Store</p>
                            <form action="#" method="POST">
                                <p class="checkout-coupon top-down log a-an">
                                    <label class="newpass">
                                        Mật khẩu mới
                                        <em>*</em>
                                    </label>
                                    <input type="password" name="newpassword" required>
                                </p>
                                <p class="checkout-coupon top-down log a-an">
                                    <label class="renewpass">
                                        Nhập lại mật khẩu mới
                                        <em>*</em>
                                    </label>
                                    <input type="password" name="renewpassword" required>
                                </p>
                                
                                <p class="login-submit5">
                                    <input class="button-primary" type="submit" name="submit" value="Đổi mật khẩu">
                                </p>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="col-md-6 col-xs-12">
                        <div class="tb-login-form res">
                            <h5 class="tb-title">Create a new account</h5>
                            <p>Hello, Welcome your to account</p>
                            <form action="#">
                                <p class="checkout-coupon top log a-an">
                                    <label class="l-contact">
                                        Email Address
                                        <em>*</em>
                                    </label>
                                    <input type="email">
                                </p>
                                <p class="login-submit5 ress">
                                    <input value="SignUp" class="button-primary" type="submit">
                                </p>
                            </form>
                            <div class="tb-info-login ">
                                <h5 class="tb-title4">SignUp today and you'll be able to:</h5>
                                <ul>
                                    <li>Speed your way through the checkout.</li>
                                    <li>Track your orders easily.</li>
                                    <li>Keep a record of all your purchases.</li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
		<!-- login  content section end -->
        <hr class="opacity-20">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<?php require_once('Layout/footer.php'); ?>