<?php 
    include 'variables.php';
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

    <div class="messages">
        <center><h3 class="title">MESSAGES</h3></center>

        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Subject</td>
                        <td>Message</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                        if (mysqli_connect_errno()) {
                            printf("Connection failed: %s\n", mysqli_connect_error());
                            exit();
                        }

                        $query = 'SELECT * FROM customer_messages';

                        $res = mysqli_query($conn, $query);
                        
                        if ($res) {
                            $rows = mysqli_fetch_all($res);

                            if($rows > 0) {
                                foreach($rows as $row) {
                                    echo '<tr>';
                                    echo '<td>'.$row[1].'</td>';
                                    echo '<td>'.$row[2].'</td>';
                                    echo '<td>'.$row[3].'</td>';
                                    echo '<td>'.$row[4].'</td>';
                                    echo '</tr>';
                                }
                                
                            }

                            mysqli_free_result($res);
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>