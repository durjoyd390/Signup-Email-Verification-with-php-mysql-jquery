<?php
session_start();
include 'db.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'mail_vandor/autoload.php';


if (isset($_POST['fullname'], $_POST['email'], $_POST['password'])) {
$name = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
if (empty($name)) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please Enter Your Name!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
elseif (empty($email)) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please Enter E-mail !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please Enter a Valid E-mail !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
elseif (empty($password)) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please Enter password !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
else if(strlen($password) < 6) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please enter a minimum password of 6 digits or longer !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}else{

$check_email_exists = mysqli_query($con, "SELECT * FROM member WHERE email ='$email'");
if(mysqli_num_rows($check_email_exists) != 0) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">This email address already exists !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}else{

unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['password']);
			
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
$_SESSION['otp_code'] = rand(100000, 999999);

$_SESSION['expire'] = time()+(5 * 60);

// preparing mail content
$messagecontent = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
  <div style="margin:50px auto;width:70%;padding:20px 0">
    <div style="border-bottom:1px solid #eee">
      <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Demo Company</a>
    </div>
    <p style="font-size:1.1em">Hi,</p>
    <p>Thank you for choosing Demo Company. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes.</p>
    <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$_SESSION['otp_code'].'</h2>
    <p style="font-size:0.9em;">Regards,<br />Demo Company</p>
    <hr style="border:none;border-top:1px solid #eee" />
   
  </div>
</div>';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  //Enable verbose debug output

    $mail->isSMTP();//Send using SMTP
    $mail->Host       = '';//Set the SMTP server to send through
    $mail->SMTPAuth   = true;//Enable SMTP authentication
    $mail->Username   = '';//SMTP username
    $mail->Password   = '';//SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    //Recipients
    $mail->setFrom('demo@demo.com', 'Demo Company'); // Sender E-mail & Name
    $mail->addAddress($email);
    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Account Verification';
    $mail->Body    = $messagecontent;

    $mail->send();
    echo 'ok';
} 
catch (Exception $e) {
echo 'Something Wrong to Send Verification E-mail !';
}


}
}
}

// --------- --------------- otp Verification
if (isset($_POST['otp_v_code'])) {
$otp_v_code = $_POST['otp_v_code'];
$now = time();

if (!isset($_SESSION['expire'])) {
echo 'no_otp';
exit();
}else{
if ($now > $_SESSION['expire']) { 
session_destroy();
echo 'no_otp';
exit();
}
else{
if(!isset($_SESSION['otp_code'])){
echo 'no_otp';
exit();
}
else{

if(empty($otp_v_code)) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please enter Verification Code !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
else if ($_SESSION['otp_code'] != $otp_v_code) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Verification Code is Wrong!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}else{

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$password = md5($_SESSION['password']);

$sql = "INSERT INTO member (name, email, password) VALUES ('$name', '$email', '$password')";
$stmt = mysqli_query($con, $sql);
if ($stmt) {
echo 'ok';
session_destroy();
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['otp_code']);
}



}

}
}
}
}
?>