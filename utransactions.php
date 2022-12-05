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

    <div class="utransactions">
        <center><h3 class="title">MY TRANSACTIONS</h3></center>

        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>Transaction Details</td>
                        <td>Total Amount</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                        if (mysqli_connect_errno()) {
                            printf("Connection failed: %s\n", mysqli_connect_error());
                            exit();
                        }

                        $query = 'SELECT id, total_amount, status FROM transactions WHERE user_id='.$current_user_id;
                        $res = mysqli_query($conn, $query);
                        
                        if ($res) {
                            $rows = mysqli_fetch_all($res);

                            if($rows > 0) {
                                foreach($rows as $row) {
                                    echo '<tr>';
                                    echo '<td>';
                                        $query2 = 'SELECT products.name, cart_items.quantity, cart_items.subtotal FROM cart_items INNER JOIN products on products.id = cart_items.product_id WHERE cart_items.transaction_id = '.$row[0];
                                        $res2 = mysqli_query($conn, $query2);

                                        if ($res2) {
                                            $items = mysqli_fetch_all($res2);

                                            foreach($items as $item) {
                                                echo '<ul>';
                                                echo '<li>'.$item[0].' ('.$item[1].') Php '.$item[2].'</li>';
                                                echo '</ul>';
                                            }

                                            mysqli_free_result($res2);
                                        }
                                    echo '</td>';
                                    echo '<td>'.$row[1].'</td>';
                                    echo '<td>'.ucwords($row[2]).'</td>';
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