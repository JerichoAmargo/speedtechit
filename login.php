<?php
    include 'variables.php';

    if(!empty($_GET['register'])) {
        $success_message = 'Account has been created successfully. You may now sign in.';
    }
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['email'])) {
            $errors['email'] = 'Email is required.';
        } 
    
        if (empty($_POST["password"])) {
            $errors['password'] = 'Password is required.';
        }

        if(empty($errors)) {
            $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $query = 'SELECT * FROM users  where email = \''.$_POST['email'].'\' AND password = \''.sha1($_POST['password']).'\'';

            $res = mysqli_query($conn, $query);
            
            if ($res) {
                $row = mysqli_fetch_assoc($res);

                if($row > 0) {
                    mysqli_free_result($res);

                    $session = hash('sha512', date('dmYH'));

                    $_SESSION['SESSION'] = $session;
                    $_SESSION['USER_ID'] = $row['id'];
                    $_SESSION['IS_ADMIN'] = $row['admin'] ? true : false;

                    $updateQuery = 'UPDATE users set session = \''.$session.'\' where id = '.$row['id'];
                    mysqli_query($conn, $updateQuery);

                    mysqli_close($conn);

                    header('Location: index.php');
                    exit();
                }else{
                    $errors['login'] = 'Incorrect email or password.';
                }
            
            }
            
            mysqli_free_result($res);
            mysqli_close($conn);
        }
    }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" contents="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedTech IT Store & Services</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php 
        include 'header.php';
    ?>

    <div class="login">
        <center><h3 class="form-title">LOGIN</h3></center>

        <form class="login-form" method="POST" action="login.php">
            <label class="form-label" for="email">Email</label>
            <input type="email" name="email">
            <?php 
                if(!empty($errors['email'])) {
                    echo '<div class="form-error"><span>'.$errors['email'].'</span></div>';
                }
            ?>
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password">
            <?php 
                if(!empty($errors['password'])) {
                    echo '<div class="form-error"><span>'.$errors['password'].'</span></div>';
                }

                if(!empty($errors['login'])) {
                    echo '<div class="form-error"><span>'.$errors['login'].'</span></div>';
                }

                if(!empty($success_message)) {
                    echo '<div class="success-message"><span>'.$success_message.'</span></div>';
                }
            ?>
            <button type="submit" class="login-button">Sign In</button>
            
            <label class="form-label">Don't have the account yet?</label>
            <a class="text-link" href="register.php">Create an account</a>
        </form>
    </div>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>