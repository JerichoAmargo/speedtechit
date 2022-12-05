<?php
    include 'variables.php';

    if($current_user_id == null) {
        header('Location: index.php');
        exit();
    }

    $user = null;

    $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

    if (mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    $query = 'SELECT * FROM users where id = '.$current_user_id;

    $res = mysqli_query($conn, $query);

    if ($res) { 
        $user = mysqli_fetch_assoc($res);
    }

    mysqli_free_result($res);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST["password"] <> $_POST["confirm-password"]) {
            $errors['confirm-password'] = 'Password did not match.';
        }


        if (empty($errors)) {
            $query = 'UPDATE users';

            if(!empty($_POST["name"])) {
                $query = $query.' set name = \''.$_POST["name"].'\'';
            }

            if(!empty($_POST["address"])) {
                $query = $query.', address = \''.$_POST["address"].'\'';
            }

            if(!empty($_POST["contact"])) {
                $query = $query.', contact_number = \''.$_POST["contact"].'\'';
            }

            $query = $query.'where id = '.$current_user_id;

            $updateUser = mysqli_query($conn, $query);

            if($updateUser) {
                $success_message = 'Account has been updated successfully.';
            }else{
                $errors['update-account'] = 'There is an error updating account details. Please try again.';
            }
        }
    }

    mysqli_close($conn);
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

    <div class="account">
        <h3 class="form-title">MY ACCOUNT</h3>

        <form class="account-form" method="POST" action="account.php">
            <label class="form-label" for="name">Name</label>
            <input type="name" name="name" value="<?php echo $user['name'] <> null ? $user['name'] : '' ?>">
            <?php 
                if(!empty($errors['name'])) {
                    echo '<div class="form-error"><span>'.$errors['name'].'</span></div>';
                }
            ?>
            <label class="form-label" for="address">Address</label>
            <input type="text" name="address" value="<?php echo $user['address'] <> null ? $user['address'] : '' ?>">
            <?php 
                if(!empty($errors['address'])) {
                    echo '<div class="form-error"><span>'.$errors['address'].'</span></div>';
                }
            ?>
            <label class="form-label" for="contact">Contact number</label>
            <input type="text" name="contact" value="<?php echo $user['contact_number'] <> null ? $user['contact_number'] : '' ?>">
            <?php 
                if(!empty($errors['contact'])) {
                    echo '<div class="form-error"><span>'.$errors['contact'].'</span></div>';
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

                if(!empty($errors['update-account'])) {
                    echo '<div class="form-error"><span>'.$errors['update-account'].'</span></div>';
                }

                if(!empty($success_message)) {
                    echo '<div class="success-message"><span>'.$success_message.'</span></div>';
                }
            ?>
            <button type="submit" class="update-account-button">Update</button>
        </form>
    </div>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>