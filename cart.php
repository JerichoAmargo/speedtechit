<?php 
    include 'variables.php';

    $total_amount = 0;

    if(!empty($_GET['remove'])) {
        $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

        if (mysqli_connect_errno()) {
            printf("Connection failed: %s\n", mysqli_connect_error());
            exit();
        }

        $delete = 'DELETE FROM cart_items where id = '.$_GET['remove'];
        mysqli_query($conn, $delete);

        mysqli_close($conn);
    }

    if(!empty($_GET['checkout'])) {
        if($_GET['checkout'] == 'success'){
            $success_message = 'Transaction was successfully completed.';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['payment_method'])) {
            $errors['add-cart'] = 'Please choose a payment method.';
        } 

        if (empty($_POST['delivery'])) {
            $errors['add-cart'] = 'Please choose a delivery or claim.';
        }

        if(empty($errors)) {
            $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }

            $query = 'SELECT SUM(subtotal) as total FROM cart_items WHERE user_id='.$current_user_id.' AND transaction_id IS NULL';
            $res = mysqli_query($conn, $query);

            if ($res) {
                $data = mysqli_fetch_assoc($res);
                $total_amount = $data['total'];

                mysqli_free_result($res);
            }else{
                header('Location: cart.php');
                exit();
            }

            
            $query = 'INSERT INTO transactions (user_id, total_amount, payment_method, delivery, status)';
            $query = $query.'VALUES (\''.$current_user_id.'\', \''.$total_amount.'\', \''.$_POST['payment_method'].'\', \''.$_POST['delivery'].'\', \'pending\')';

            $res = mysqli_query($conn, $query);
            
            if ($res) {
                $last_id = mysqli_insert_id($conn);

                $updateQuery = 'UPDATE cart_items SET transaction_id = '.$last_id.' WHERE user_id='.$current_user_id.' AND transaction_id IS NULL';
                mysqli_query($conn, $updateQuery);

                mysqli_close($conn);
                header('Location: cart.php?checkout=success');
                exit();
            }else{
                $errors['register'] = 'Cannot create a product. Please try again.';
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

    <section id="page-header" class="about-header">

        <h2>#Cart</h2>

        <p>Cart Now!</p>

    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                    if (mysqli_connect_errno()) {
                        printf("Connection failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $query = 'SELECT products.image as image, products.name as name, products.price as price, cart_items.quantity as quantity, cart_items.subtotal as subtotal, cart_items.id as id
                                FROM cart_items INNER JOIN products on products.id = cart_items.product_id WHERE user_id='.$current_user_id.' AND transaction_id IS NULL';

                    $res = mysqli_query($conn, $query);
                
                    if ($res) {
                        $rows = mysqli_fetch_all($res);

                        if($rows > 0) {
                            foreach($rows as $row) {
                                echo '<tr>';
                                echo '<td><a href="cart.php?remove='.$row[5].'"><i class="far fa-times-circle"></i></a></td>';
                                echo '<td><img src="'.$row[0].'" alt=""></td>';
                                echo '<td>'.ucwords($row[1]).'</td>';
                                echo '<td>Php '.$row[2].'</td>';
                                echo '<td>'.$row[3].'</td>';
                                echo '<td>Php '.$row[4].'</td>';
                                echo '</tr>';

                                $total_amount += $row[4];
                            }
                            
                        }

                        mysqli_free_result($res);
                    }
                ?>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter Your Coupon">
                <button class="normal">Apply</button>
            </div>
        </div>

        <div id="subtotal">
            <h3>Cart Information</h3>
            
            <form class="checkout-form" method="POST" action="cart.php">
                <select name="payment_method" placeholder="Select Payment">
                    <option value="cash">Cash</option>
                    <option value="gcash">GCash</option>
                </select>

                <select name="delivery">
                    <option value="deliver">Deliver</option>
                    <option value="claim">To Claim</option>
                </select>

                <table>
                    <tr>
                        <td>Shipping</td>
                        <td>Free</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>Php <?php echo number_format((float)$total_amount, 2, '.', ''); ?></strong></td>
                    </tr>
                </table>

                <?php
                    if(!empty($success_message)) {
                        echo '<div class="success-message"><span>'.$success_message.'</span></div>';
                    }
                ?>
                
                <button type="submit" class="checkout normal">Proceed to checkout</button>
            </form>
        </div>
    </section>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>