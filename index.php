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

    <section id="hero">
        <h4>Information Technology Company</h4>
        <h2>SpeedTech IT</h2>
        <h1>Store and Services</h1>
        <p>Fast and Reliable IT coming to your doorstep</p>
        <a href="shop.php"><button class="normal">Shop Now</button></a>
    </section>

    <section id="feature" class="section-p1"> 
        <div class="fe-box">
            <img src="./images/f1.png" alt="">
            <h6>Hardware Repair</h6>
        </div>
        <div class="fe-box">
            <img src="./images/f2.png" alt="">
            <h6>Hardware Replacement</h6>
        </div>
        <div class="fe-box">
            <img src="./images/f3.png" alt="">
            <h6>Hardware Upgrade</h6>
        </div>
        <div class="fe-box">
            <img src="./images/f4.png" alt="">
            <h6>Software Upgrade</h6>
        </div>
        <div class="fe-box">
            <img src="./images/f5.png" alt="">
            <h6>Warranty</h6>
        </div>
        <div class="fe-box">
            <img src="./images/f6.png" alt="">
            <h6>Fast Services</h6>
        </div>

    </section>

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Best Tech, Best Future.</p>
        <div class="pro-container">
            <?php
                $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                if (mysqli_connect_errno()) {
                    printf("Connection failed: %s\n", mysqli_connect_error());
                    exit();
                }

                $query = 'SELECT * FROM products limit 8';

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

    <section id="banner" class="section-m1">
        <h4>Repair Services</h4>
        <h2>Up to <span>30% Off</span> All Gadgets & Accessories</h2>
        <a href="contact.php"><button class="normal">Reach us for more details</button></a>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrivals</h2>
        <p>Best Tech, Best Future.</p>
        <div class="pro-container">
            <?php
                $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

                if (mysqli_connect_errno()) {
                    printf("Connection failed: %s\n", mysqli_connect_error());
                    exit();
                }

                $query = 'SELECT * FROM products order by id desc limit 8';

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

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>Crazy Deals</h4>
            <h2>Buy now, to save more</h2>
            <span>A power that Shines you.</span>
        </div>
        <div class="banner-box banner-box2">
            <h4>Christmas Sales</h4>
            <h2>Perfect Bundles</h2>
            <span>Building the Future with Tech.</span>
        </div>
    </section>

    <section id="banner3">
        <div class="banner-box"> 
            <h2>ACCESSORIES</h2>
            <h3>Affordable accessories for every PC</h3>
        </div>
        <div class="banner-box banner-box2"> 
            <h2>SERVICES</h2>
            <h3>Computers made even better</h3>
        </div>
        <div class="banner-box banner-box3"> 
            <h2>PCs & LAPTOPS</h2>
            <h3>Loaded with amazing features</h3>
        </div>
    </section>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>