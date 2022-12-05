<?php
    include 'variables.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['name'])) {
            $errors['name'] = 'Name is required.';
        } 

        if (empty($_POST['email'])) {
            $errors['email'] = 'Email is required.';
        } 
    
        if (empty($_POST["password"])) {
            $errors['password'] = 'Password is required.';
        }

        if (empty($_POST["confirm-password"])) {
            $errors['confirm-password'] = 'Confirm password is required.';
        }

        if ($_POST["password"] <> $_POST["confirm-password"]) {
            $errors['confirm-password'] = 'Password did not match.';
        }
        

        if(empty($errors)) {
            $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $query = 'INSERT INTO users (name, email, password, admin) 
                      VALUES (\''.$_POST['name'].'\', \''.$_POST['email'].'\', \''.sha1($_POST['password']).'\', 0)';

            $res = mysqli_query($conn, $query);
            
            if ($res) {
                mysqli_close($conn);
                header('Location: login.php?register=success');
                exit();
            }else{
                $errors['register'] = 'Cannot create an account. Please try again.';
            }
            
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

    <div class="register">
        <center><h3 class="form-title">CREATE ACCOUNT</h3></center>

        <form class="register-form" method="POST" action="register.php">
            <label class="form-label" for="name">Name</label>
            <input type="text" name="name">
            <?php 
                if(!empty($errors['name'])) {
                    echo '<div class="form-error"><span>'.$errors['name'].'</span></div>';
                }
            ?>
            <label class="form-label" for="email">Email</label>
            <input type="text" name="email">
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
            ?>
            <label class="form-label" for="confirm-password">Confirm password</label>
            <input type="password" name="confirm-password">
            <?php 
                if(!empty($errors['confirm-password'])) {
                    echo '<div class="form-error"><span>'.$errors['confirm-password'].'</span></div>';
                }

                if(!empty($errors['register'])) {
                    echo '<div class="form-error"><span>'.$errors['register'].'</span></div>';
                }
            ?>
            <button type="submit" class="register-button">Create</button>
        </form>
    </div>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>