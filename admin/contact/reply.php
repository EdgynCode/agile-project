<?php 
session_start();
if(!isset($_COOKIE['tendangnhap_admin'])){
    header('Location: login.php');
}

header("content-type:text/html; charset=UTF-8");

require_once('../database/dbhelper.php');
require ('../../vendor/autoload.php');// Include PHPMailer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Query the database to get the email of the contact   
$sql = 'select * from contact where id = '.$id;
$contact = executeSingleResult($sql);
$email = $contact['email'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 
        $mail->isSMTP();                                      
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                               
        $mail->Username = 'nhatdang082000@gmail.com';                 
        $mail->Password = 'jhsi qvii tnuu ounv';                           
        $mail->SMTPSecure = 'tls';                            
        $mail->Port = 587;                                    

        //Recipients
        $mail->setFrom('nhatdang082000@gmail.com', 'Mailer');
        $mail->addAddress($email);     

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Here is the subject';
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';

        // Update the message_reply and replied columns in the contact table
        $sql = "UPDATE contact SET message_reply = '$message', replied = 1 WHERE email = '$email'";
        execute($sql);
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    header('Location: index.php');
    die();
}

$sql = "SELECT replied, message_reply FROM contact WHERE email = '$email'";
$result = executeSingleResult($sql);
$replied = $result['replied'];
$message_reply = $result['message_reply'];
?>



<!-- Rest of your HTML code -->

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phản hồi khách hàng</title>
  <link rel="stylesheet" href="../style.css">
  <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScrseipt -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="../script.js"></script>
</head>

<body>
<!-- Dashboard -->
<div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
    <!-- Vertical Navbar -->
    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg" id="navbarVertical">
        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                <h3 class="text-success"><img src="/Web/images/logo.png" width="40" ><span class="text-info">LUXURY</span>STORE</h3> 
            </a>
            <!-- User menu (mobile) -->
            <div class="navbar-user d-lg-none">
                <!-- Dropdown -->
                <div class="dropdown">
                    <!-- Toggle -->
                    <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-parent-child">
                            <img alt="Image Placeholder" src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar- rounded-circle">
                            <span class="avatar-child avatar-badge bg-success"></span>
                        </div>
                    </a>
                    <!-- Menu -->
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                        <a href="#" class="dropdown-item">Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Billing</a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="navbar-divider my-18 opacity-20">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <hr class="navbar-divider my-3 opacity-20">
                    <li class="nav-item">
                        <a class="nav-link" href="../product/index.php">
                            <i class="bi bi-bag-heart"></i>Quản Lý Sản Phẩm
                        </a>
                    </li>
                    <!-- Divider -->
                    <hr class="navbar-divider my-3 opacity-20">
                    <li class="nav-item">
                        <a class="nav-link" href="../user/index.php">
                            <i class="bi bi-person-check"></i>Quản Lý Khách Hàng
                        </a>
                    </li>
                    <hr class="navbar-divider my-3 opacity-20">
                    <li class="nav-item">
                        <a class="nav-link" href="../order.php">
                            <i class="bi bi-cash-stack"></i>Quản Lý Đơn Hàng
                        </a>
                    </li>
                    <hr class="navbar-divider my-3 opacity-20">
                    <li class="nav-item">
                        <a class="nav-link" href="../category/index.php">
                            <i class="bi bi-bag-heart"></i>Quản Lý Danh Mục
                        </a>
                    </li>
                    <hr class="navbar-divider my-3 opacity-20">
                    <li class="nav-item">
                        <a class="nav-link" href="../contact/index.php">
                            <i class="bi bi-chat"></i>Chăm sóc khách hàng
                        </a>
                    </li>
                    
                    
                </ul>
                <!-- Divider -->
                <hr class="navbar-divider my-18 opacity-20">
        
                <!-- Push content down -->
                <div class="mt-auto"></div>
                <!-- User (md) -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">
                            <i class="bi bi-house-heart-fill"></i></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../logout.php" onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="h-screen flex-grow-1 overflow-y-lg-auto">
        <!-- Header -->
        <header class="bg-surface-primary border-bottom pt-6">
            <div class="container-fluid">
                <div class="mb-npx">
                    <div class="row align-items-center">
                        <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                            <!-- Title -->
                            <h1 class="h2 mb-0 ls-tight">
                                <img src="/Web/images/logo.png" width="60"> Luxury Store</h1>
                        </div>
                        <!-- Actions -->
                        
                    </div>
                
                </div>
            </div>
        </header>
        <!-- Contact Form -->
        <div class="container-fluid py-6">
    <div class="row">
        <div class="col-lg-12">
            <!-- Card -->
            <div class="card mb-6">
                <div class="card-header">
                    <h5 class="mb-0">Trả lời liên hệ</h5>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlInput1">Email</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="Enter email" value="<?= $email ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlTextarea1">Message</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="5" placeholder="Enter your message" <?php echo $replied == 1 ? 'readonly' : ''; ?>><?php echo $replied == 1 ? $message_reply : ''; ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>
                            <button type="submit" class="btn btn-primary" <?php echo $replied == 1 ? 'disabled' : ''; ?>>Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
