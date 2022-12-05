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
    
    $updateQuery = 'UPDATE users set session = null where id = '.$current_user_id;

    mysqli_query($conn, $updateQuery);
    
    mysqli_close($conn);

    unset($_SESSION['SESSION']);
    unset($_SESSION['USER_ID']);

    header('Location: index.php');
    exit();
?>