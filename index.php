<!-- TITLE: Lab 6
AUTHOR: Harmanjot Singh
PURPOSE: Lab 6
ORIGINALLY CREATED ON: 15 Nov 2019
LAST MODIFIED ON: 15 Nov 2019
LAST MODIFIED BY: Harmanjot Singh
MODIFICATION HISTORY: Original Build -->

<?php
require_once 'controllers/authController.php';
// if(!isset($_SESSION['id'])) {
//     header('location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Homepage</title>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">


                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert <?php echo $_SESSION['alert-class']; ?>">
                        <?php 
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        unset($_SESSION['alert-class']);
                        ?>
                    </div>
                <?php endif; ?>

                <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>

                <a href="login.php" class="logout">Logout</a>

                <?php if(!$_SESSION['verified']): ?>
                    <div class="alert alert-warning">
                        Unfortunately, you are not verified yet.
                        Please sign in to your email account and click on
                        the verification link we sent at <strong><?php echo $_SESSION['email']; ?></strong>
                    </div> 
                <?php endif; ?>

                <?php if($_SESSION['verified']): ?>
                    <button class="btn btn-block btn-lg btn-primary">I am verified!</button>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
</body>
</html>