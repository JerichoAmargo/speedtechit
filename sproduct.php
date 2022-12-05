<?php 
    include 'variables.php';

    $product_id = $_GET['productid'];
    $product = null;

    $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

    if (mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
    }

    $query = 'SELECT * FROM products where id = '.$product_id;

    $res = mysqli_query($conn, $query);

    if ($res) { 
        $row = mysqli_fetch_assoc($res);

        if($row > 0) {
            $product = $row;

            mysqli_free_result($res);
            mysqli_close($conn);
        }else{
            mysqli_close($conn);
            header('Location: index.php');
            exit();
        }
    }else{
        mysqli_close($conn);
        header('Location: index.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(empty($errors)) {
            $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $query = 'INSERT INTO cart_items (user_id, product_id, price, quantity, subtotal) VALUES 
                        (\''.$current_user_id.'\', \''.$product_id.'\', \''.$product['price'].'\', \''.$_POST['quantity'].'\', \''.($product['price']*$_POST['quantity']).'\' )';

            $res = mysqli_query($conn, $query);
            
            if ($res) {
                mysqli_close($conn);
                header('Location: cart.php');
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

    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="<?php echo $product['image'] ?>" width="100%" id="MainImg" alt="">
        </div>
        <div class="single-pro-details">
            <h6>Home / Laptop</h6>
            <?php
                echo '<h4>'.$product['name'].'</h4>';
                echo '<h2>Php '.$product['price'].'</h2>';
            ?>

            <form method="POST" action="sproduct.php?productid=<?php echo $product_id; ?>">
                <input type="number" name="quantity" value="1" min=1>
                <button type="submit" class="normal">Add to Cart</button>
            </form>

            <h4>Product Details</h4>

            <span> 
                * Windows 11 Home <br>
                * Intel Core i5 <br>
                * 8GB Memory <br>
                * 512GB SSD <br>
                * 15' & Intel Iris Xe Graphics
            </span>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Feature Products</h2>
        <p>Best Tech, Best Future.</p>
        <div class="pro-container">
            <?php
                $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                if (mysqli_connect_errno()) {
                    printf("Connection failed: %s\n", mysqli_connect_error());
                    exit();
                }

                $query = 'SELECT * FROM products limit 4';

                $res = mysqli_query($conn, $query);
                
                if ($res) {
                    $rows = mysqli_fetch_all($res);

                    if($rows > 0) {
                        foreach($rows as $row) {
                            echo '<div class="pro" onclick="window.location.href=\'sproduct.php\';">';
                            echo '<img src="'.$row[3].'" alt="">';
                            echo '<div class="des">';
                            echo '<span>Laptop</span>';
                            echo '<h5>'.ucwords($row[1]).'</h5>';
                            echo '<div class="star">';
                            echo '<i class="fas fa-star"></i>';
                            echo '<i class="fas fa-star"></i>';
                            echo '<i class="fas fa-star"></i>';
                            echo '<i class="fas fa-star"></i>';
                            echo '<i class="fas fa-star"></i>';
                            echo '</div>';
                            echo '<h4>Php '.$row[4].'</h4>';
                            echo '</div>';
                            echo '</div>';
                        }
                        
                    }

                    mysqli_free_result($res);
                }
            ?>
        </div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Notification</h4>
            <p>Get E-mail Updates about our shop and <span> special offers.</span>
            </p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your Email Addres">
            <button class="normal">Sign Up</button>
        </div>
    </section>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>