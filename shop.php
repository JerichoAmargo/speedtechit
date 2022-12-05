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

    <section id="page-header">
        <h2>#ggwp</h2>
        <p>Save more with coupons & up to 30% off!</p>
    </section>

    <section id="product1" class="section-p1">
        <div class="pro-container">
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
                            echo '<div class="pro" onclick="window.location.href=\'sproduct.php?productid='.$row[0].'\';">';
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

    <!-- <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
        
    </section> -->

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>