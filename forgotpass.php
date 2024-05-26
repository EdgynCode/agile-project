<?php 

    include("config.php");
    require ('vendor/autoload.php');// Include PHPMailer autoloader
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    

    //check email co ton tai trong database hay khong va gui 6 so
    if(isset($_POST['email_check'])) {
        $email = $_POST['email_check'];
        $sql_check = mysqli_query($mysqli,"SELECT * FROM user WHERE email='".$email."'");
        if(mysqli_num_rows($sql_check) > 0){
            $code = rand(0, 999999); // Generate a random number between 0 and 999999
            $code = str_pad($code, 6, "0", STR_PAD_LEFT); // Add leading zeros if necessary
            $_SESSION['code'] = $code; // Store the code in the session
            $subject = "Your verification code";
            $message = "Your verification code is: " . $code;
            //sendEmail($email, $subject, $message);
            echo $code; // Echo the generated code
        }else{
            echo 0; // Email doesn't exist
        }
        exit(); // Stop the script after sending the response
    }


    //check code co dung hay khong
    if(isset($_POST['code'])) {
        $user_code = $_POST['code'];
        if($user_code == $_SESSION['code']) {
            echo "Correct code";
            // ... proceed with password reset
        } else {
            echo "Incorrect code";
        }
    }


   


    
    include("Layout/header.php"); 


    //gui email khi quen mat khau
    function sendEmail($to, $subject, $message) {
        $mail = new PHPMailer(true);


    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 
        $mail->isSMTP();                                      
        $mail->Host       = 'smtp.gmail.com';               
        $mail->SMTPAuth   = true;                             
        $mail->SMTPAuth = true;                               
        $mail->Username = 'nhatdang082000@gmail.com';                 
        $mail->Password = 'jhsi qvii tnuu ounv';                           
        $mail->SMTPSecure = 'tls';                            
        $mail->Port = 587;                           

        //Recipients
        $mail->setFrom('nhatdang082000@gmail.com', 'Mailer');
        $mail->addAddress($to);     

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    }   




?>

<script>

$(document).ready(function(){
    $('#guiid').on('click', function(event){ // Add 'event' as a parameter
        event.preventDefault(); // Prevent the default action

        var email = $('input[name="email"]').val();
        if(email.trim() !== '') { // Check if the textbox is not empty
            console.log('Sending AJAX request with email:', email);

            $.ajax({
                url: 'forgotpass.php', // Point the AJAX request to 'forgotpass.php'
                type: 'post',
                data: {email_check: email},
                success: function(response){
                    console.log('Received response:', response);
                    if(response.trim() == '0'){
                        alert("Tài khoản không có trong hệ thống");
                        $('input[name="email"]').val(''); // Clear the textbox
                    } else {
                        console.log('Generated code:', response); // Log the generated code
                        // Create a new textbox for the user to input the 6-digit code
                        var codeInput = $('<input type="text" class="form-control form-control-lg" name="code" placeholder="Enter the 6-digit code"; style="width: 50%; height: 50px; margin: 0 auto; display: block;"  />');
                        var changePasswordButton = $('<button type="button" style="display: flex; justify-content: center; align-items: center; margin: 0 auto; padding: 1rem; width: auto;" class="btn btn-success">Change Password</button>')
                        $('.otp-container').append(codeInput); // Append the textbox to the body
                        $('.otp-button').append(changePasswordButton);
                    }
                }
            });
        } else {
            console.log('Textbox is empty, not sending AJAX request');
        }
    });
});
</script>



<script>
$(document).on('click', '.otp-button', function(event){
    event.preventDefault();

    var code = $('input[name="code"]').val();
    var email = $('input[name="email"]').val(); // Retrieve the email
    if(code.trim() !== '') {
        console.log('Sending AJAX request with code:', code);

        $.ajax({
            url: 'forgotpass.php',
            type: 'post',
            data: {code: code},
            success: function(response){
                console.log('Received response:', response);
                if(response.trim() == 'Incorrect code'){
                    alert("The entered code is incorrect");
                    $('input[name="code"]').val('');
                } else {
                    console.log('Code is correct, redirecting to next page');
                    alert("OTP is correct");
                    window.location.href = 'changePass2.php?email=' + encodeURIComponent(email); // Append the email to the URL
                }
            }
        });
    } else {
        console.log('Textbox is empty, not sending AJAX request');
    }
});
</script>




<section class="contact-img-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="con-text">
                                <h2 class="page-title">Wên mật khẩu?</h2>
                            </div>
                        </div>
                    </div>
                </div>
</section>

<div class="login-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="tb-login-form ">
                            <h5 class="tb-title">Quên mật khẩu</h5>
                            <p>Nhập email của bạn để lấy lại mật khẩu</p>
                            <form action="#" method="POST">
                                <p class="checkout-coupon top log a-an">
                                    <label class="l-contact">
                                        Email
                                        <em>*</em>
                                    </label>
                                    <input type="text" name="email" required>
                                </p>
                                <div class="login-submit">
                                    <button type="submit" id="guiid" class="button-primary" style="width: 100%; margin-bottom: 2rem; font-size:larger;">Gửi</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>

<div class="otp-container"> </div>
<div class="otp-button"> </div>
            
        
</div>



<style>
.otp-button {
    padding: 1rem;
}
</style>




<?php require_once('Layout/footer.php'); ?>