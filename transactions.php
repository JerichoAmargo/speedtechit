<?php 
    include 'variables.php';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

        if (mysqli_connect_errno()) {
            printf("Connection failed: %s\n", mysqli_connect_error());
            exit();
        }

        $updateQuery = 'UPDATE transactions set status = \''.$_POST["status"].'\' where id = '.$_POST["transaction"];
        mysqli_query($conn, $updateQuery);
        
        mysqli_close($conn);
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

    <div class="transactions">
        <center><h3 class="title">TRANSACTIONS</h3></center>

        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <td>Customer</td>
                        <td>Contact Number</td>
                        <td>Address</td>
                        <td>Delivery</td>
                        <td>Transaction Details</td>
                        <td>Total Amount</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                        if (mysqli_connect_errno()) {
                            printf("Connection failed: %s\n", mysqli_connect_error());
                            exit();
                        }

                        $query = 'SELECT transactions.id, users.name, transactions.total_amount, transactions.status, transactions.delivery, users.contact_number, users.address FROM transactions INNER JOIN users on users.id = transactions.user_id';
                        $res = mysqli_query($conn, $query);
                        
                        if ($res) {
                            $rows = mysqli_fetch_all($res);

                            if($rows > 0) {
                                foreach($rows as $row) {
                                    echo '<tr>';
                                    echo '<td>'.$row[1].'</td>';
                                    echo '<td>'.$row[5].'</td>';
                                    echo '<td>'.$row[6].'</td>';
                                    echo '<td>'.ucwords($row[4]).'</td>';
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
                                    echo '<td>'.$row[2].'</td>';
                                    echo '<td>'.ucwords($row[3]).'</td>';
                                    echo '<td>';
                                    echo '<form class="update-transaction-form" method="POST" action="transactions.php">';
                                    echo '<input type="hidden" name="transaction" value="'.$row[0].'">';
                                    echo '<select name="status">';
                                    echo '<option value="pending">Pending</option>';
                                    echo '<option value="paid">Paid</option>';
                                    echo '<option value="shipping">Shipping</option>';
                                    echo '<option value="received">Received</option>';
                                    echo '</select>';
                                    echo '<button type="submit">Update</button>';
                                    echo '</form>';
                                    echo '</td>';
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