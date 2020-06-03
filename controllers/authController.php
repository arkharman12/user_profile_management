<!-- TITLE: Lab 6
AUTHOR: Harmanjot Singh
PURPOSE: Lab 6
ORIGINALLY CREATED ON: 15 Nov 2019
LAST MODIFIED ON: 15 Nov 2019
LAST MODIFIED BY: Harmanjot Singh
MODIFICATION HISTORY: Original Build -->

<?php

session_start();

require 'config/db.php';
require_once "inc/util.php";
require_once "mail/mail.class.php";

$errors = array();
$username = "";
$email = "";

// check if the user clicks the signup button
if(isset($_POST['signup-btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    if(empty($username)) {
        $errors['username'] = "Username required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid";
    }
    if(empty($email)) {
        $errors['email'] = "Email required";
    }

    if(empty($password)) {
        $errors['password'] = "Password required";
    }

    if($password != $passwordConf) {
        $errors['password'] = "The two passwords do not match";

    }

    if(count($errors) === 0) {

        $verified = false;

        $pdoQuery = "INSERT INTO USERS (`username`, `email`,`verified`, `password`) VALUES (:username,:email,:verified,:password)";
    
        $pdoResult = $pdoConnect->prepare($pdoQuery);
    
        $pdoExec = $pdoResult->execute(array(":username"=>$username, ":email"=>$email,":verified"=>$verified,":password"=>$password));

        //now send the email to the username registered for activating the account
        // $code = randomCodeGenerator(50);
        // $subject = "Email Activation";
                
        // $body = 'Welcome '.$username.'!<br/> <br/>
        // Please click on the link below to activate your account. <br/>
        // http://corsair.cs.iupui.edu:24061/lab6/index.php?a='.$code;
        
        // $mailer = new Mail();
        // if (($mailer->sendMail($email, $username, $subject, $body))==true)
        

        if($pdoExec) {
            // login user
            $user_id = $pdoConnect->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = $verified;

            // set flash message
            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            
            
            header('location: index.php');
            exit();

        } else {
            $errors['db_error'] = "Database error: failed to register";
        }
    }

    
}

// if user clicks on the login button
if(isset($_POST['login-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)) {
        $errors['username'] = "Username required";
    }

    if(empty($password)) { 
        $errors['password'] = "Password required";
    }

    if(count($errors) === 0) {
        $pdoQuery = "SELECT * FROM USERS WHERE username=:username AND password=:password";
        $pdoResult = $pdoConnect->prepare($pdoQuery);

        $pdoResult->execute(
            array(
                'username' => $_POST['username'],
                'password' => $_POST['password']
            )
        );

        $count = $pdoResult->rowCount();
        
        if($count > 0){
            $_SESSION["username"] = $_POST["username"];
            // set flash message
            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: index.php');
            exit(); 
        } else {
            $errors['login_fail'] = "Wrong credentials";
        }

    }
}

// logout the user
// if(isset($_GET['logout'])) {
//     session_destroy();
//     unset($_SESSION['id']);
//     unset($_SESSION['username']);
//     unset($_SESSION['email']);
//     unset($_SESSION['verified']);
//     header('location: index.php');
//     exit();
// }

?>