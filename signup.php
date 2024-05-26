<?php 

include('config.php');

if(isset($_POST['email_check'])) {
    $email = $_POST['email_check'];
    $sql_check = mysqli_query($mysqli,"SELECT * FROM user WHERE email='".$email."'");
    if(mysqli_num_rows($sql_check) > 0){
        echo 1; // Email exists
    }else{
        echo 0; // Email doesn't exist
    }
    exit(); // Stop the script after sending the response
}


 include("Layout/header.php");
?>





<?php

	if(isset($_POST['dangky'])) {
		$fullname= $_POST['hovaten'];
        $tendangnhap  = $_POST['tendangnhap'];
		$email = $_POST['email'];
        $diachi = $_POST['diachi'];
        $matkhau = $_POST['matkhau'];
		$dienthoai = $_POST['dienthoai'];
		$sql_dangky = mysqli_query($mysqli,"INSERT INTO user(fullname,tendangnhap,email,diachi,matkhau,dienthoai) VALUE('".$fullname."','".$tendangnhap."','".$email."','".$diachi."','".$matkhau."','".$dienthoai."')");
		if($sql_dangky){
			if($fullname!="" && $tendangnhap!="" && $email!="" && $diachi!="" && $dienthoai!="" && $matkhau!=""){
                echo '<script>alert("Đăng ký thành công.");
                window.location.href="login.php";
                </script>';
                
			} 
		
		}
	}
?>

<script>
 $(document).ready(function(){
    $('input[name="email"]').on('blur', function(){
    var email = $(this).val();
    if(email.trim() !== '') { // Check if the textbox is not empty
        console.log('Sending AJAX request with email:', email);

        $.ajax({
            url: 'signup.php',
            type: 'post',
            data: {email_check: email},
            success: function(response){
                console.log('Received response:', response);
                if(response.trim() == '0'){
                    alert("Tài khoản không có trong hệ thống");
                    $('input[name="email"]').val(''); // Clear the textbox
                }
            }
        });
    } else {
        console.log('Textbox is empty, not sending AJAX request');
    }
});
});
</script>

<!-- pages-title-start -->
<section class="contact-img-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="con-text">
                                <h2 class="page-title">Shop</h2>
                                <p><a href="#">Home</a> | shop</p>
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
                            <h5 class="tb-title">Đăng ký</h5>
                            <p>Đăng ký tài khoản để có thể mua sắm tại Luxury Store</p>
                            <!-- <div class="tb-social-login">
                                <a class="tb-facebook-login" href="#">
                                    <i class="fa fa-facebook"></i>
                                    Sign In With Facebook
                                </a>
                                <a class="tb-twitter-login res" href="#">
                                    <i class="fa fa-twitter"></i>
                                    Sign In With Twitter
                                </a>
                            </div> -->
                            <form action="#" method="POST">
                                <p class="checkout-coupon top log a-an">
                                    <label class="l-contact">
                                        Họ và tên
                                        <em>*</em>
                                    </label>
                                    <input type="text" name="hovaten" required>
                                </p>
                                <p class="checkout-coupon top-down log a-an">
                                    <label class="l-contact">
                                        Tên đăng nhập
                                        <em>*</em>
                                    </label>
                                    <input type="text" name="tendangnhap" required>
                                </p>
                                <p class="checkout-coupon top-down log a-an">
                                    <label class="l-contact">
                                        Email
                                        <em>*</em>
                                    </label>
                                    <input type="text" name="email" required>
                                </p>
                                <p class="checkout-coupon top-down log a-an">
                                    <label class="l-contact">
                                    Số điện thoại
                                        <em>*</em>
                                    </label>
                                    <input type="text" name="dienthoai" required>
                                </p>
                                <p class="checkout-coupon top-down log a-an">
                                    <label class="l-contact">
                                        Mật khẩu
                                        <em>*</em>
                                    </label>
                                    <input type="text" name="matkhau" required>
                                </p>
                                <p class="checkout-coupon top-down log a-an">
                                    <label class="l-contact">
                                        Địa chỉ
                                        <em>*</em>
                                    </label>
                                    <input type="text" name="diachi" required>
                                </p>
                                <!-- <div class="forgot-password1">
                                    <label class="inline2">
                                        <input type="checkbox" name="rememberme7">
                                        Remember me! <em>*</em>
                                    </label>
                                    <a class="forgot-password" href="#">Forgot Your password?</a>
                                </div> -->
                                <p class="login-submit5">
                                    <input class="button-primary" type="submit" name="dangky" value="Đăng ký">
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
<?php require_once('Layout/footer.php'); ?>