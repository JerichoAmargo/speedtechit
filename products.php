<?php 
    include 'variables.php';

    $PRODUCT_IMAGES = [
        './images/p1.png',
        './images/p2.png',
        './images/p3.png',
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['name'])) {
            $errors['name'] = 'Product name is required.';
        } 

        if (empty($_POST['code'])) {
            $errors['code'] = 'Code is required.';
        } 
    
        if (empty($_POST["price"])) {
            $errors['price'] = 'Price is required.';
        }

        if (empty($_POST["stock"])) {
            $errors['stock'] = 'Stock must be atleast 1.';
        }
        

        if(empty($errors)) {
            $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $query = 'INSERT INTO products (name, code, image, price, stock) VALUES 
                        (\''.$_POST['name'].'\', \''.$_POST['code'].'\', \''.$PRODUCT_IMAGES[rand(0,2)].'\', \''.$_POST['price'].'\', \''.$_POST['stock'].'\' )';

            $res = mysqli_query($conn, $query);
            
            if ($res) {
                mysqli_close($conn);
                header('Location: products.php');
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

    <div class="products">
        <center><h3 class="title">PRODUCTS</h3></center>

        <div class="body">
            <div class="list">
                <table width="100%">
                    <thead>
                        <tr>
                            <td></td>
                            <td>Product</td>
                            <td>Code</td>
                            <td>Price</td>
                            <td>Available stock</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                            if (mysqli_connect_errno()) {
                                printf("Connection failed: %s\n", mysqli_connect_error());
                                exit();
                            }

                            $query = 'SELECT * FROM products order by id desc';

                            $res = mysqli_query($conn, $query);
                            
                            if ($res) {
                                $rows = mysqli_fetch_all($res);

                                if($rows > 0) {
                                    foreach($rows as $row) {
                                        echo '<tr>';
                                        echo '<td><img class="product-img-listing" src="'.$row[3].'" alt=""></td>';
                                        echo '<td><a href="edit-product.php?id='.$row[0].'">'.$row[1].'</a></td>';
                                        echo '<td>'.$row[2].'</td>';
                                        echo '<td>'.$row[4].'</td>';
                                        echo '<td>'.$row[5].'</td>';
                                        echo '</tr>';
                                    }
                                    
                                }

                                mysqli_free_result($res);
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="form">
                <center><h4>Add a product</h4></center>

                <form class="add-product-form" method="POST" action="products.php">
                    <label class="form-label" for="name">Product</label>
                    <input type="name" name="name">
                    <?php 
                        if(!empty($errors['name'])) {
                            echo '<div class="form-error"><span>'.$errors['name'].'</span></div>';
                        }
                    ?>
                    <label class="form-label" for="code">Code</label>
                    <input type="text" name="code">
                    <?php 
                        if(!empty($errors['code'])) {
                            echo '<div class="form-error"><span>'.$errors['code'].'</span></div>';
                        }
                    ?>
                    <label class="form-label" for="price">Price</label>
                    <input type="number" name="price" min="1">
                    <?php 
                        if(!empty($errors['price'])) {
                            echo '<div class="form-error"><span>'.$errors['price'].'</span></div>';
                        }
                    ?>
                    <label class="form-label" for="stock">Stock</label>
                    <input type="number" name="stock" min="1">
                    <?php 
                        if(!empty($errors['stock'])) {
                            echo '<div class="form-error"><span>'.$errors['stock'].'</span></div>';
                        }

                        if(!empty($errors['add-product'])) {
                            echo '<div class="form-error"><span>'.$errors['add-product'].'</span></div>';
                        }

                        if(!empty($success_message)) {
                            echo '<div class="success-message"><span>'.$success_message.'</span></div>';
                        }
                    ?>
                    <button type="submit" class="add-product-button">Add</button>
                </form>
            </div>
        </div>
    </div>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>