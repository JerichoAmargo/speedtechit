<section id="header">
    <a href="index.php"><img src="./images/logo.png" class="logo" alt=""></a>

    <div>
        <ul id="navbar">
            <li><a class="<?php echo $_SERVER['REQUEST_URI'] == $base_path.'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
            <li><a class="<?php echo $_SERVER['REQUEST_URI'] == $base_path.'shop.php' ? 'active' : '' ?>" href="shop.php">Shop</a></li>
            <li><a class="<?php echo $_SERVER['REQUEST_URI'] == $base_path.'about.php' ? 'active' : '' ?>" href="about.php">About</a></li>
            <li><a class="<?php echo $_SERVER['REQUEST_URI'] == $base_path.'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a></li>
            <?php
                if($current_user_id <> null){
                    if($is_admin) {
                        echo '<li><a class="'.($_SERVER['REQUEST_URI'] == $base_path.'transactions.php' ? 'active' : '').'" href="transactions.php">Transactions</a></li>';
                        echo '<li><a class="'.($_SERVER['REQUEST_URI'] == $base_path.'products.php' ? 'active' : '').'" href="products.php">Products</a></li>';
                        echo '<li><a class="'.($_SERVER['REQUEST_URI'] == $base_path.'messages.php' ? 'active' : '').'" href="messages.php">Messages</a></li>';
                    }else{
                        echo '<li><a class="'.($_SERVER['REQUEST_URI'] == $base_path.'utransactions.php' ? 'active' : '').'" href="utransactions.php">My Transactions</a></li>';
                    }
                    echo '<li><a class="'.($_SERVER['REQUEST_URI'] == $base_path.'account.php' ? 'active' : '').'" href="account.php">My Account</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';

                    if(!$is_admin) {
                        echo '<li id="lg-bag">';
                        echo '<a class="'.($_SERVER['REQUEST_URI'] === 'cart.php' ? 'active' : '').'" href="cart.php">';
                        echo '<i class="far fa-shopping-bag"></i>';
                        echo '</a>';
                        echo '</li>';
                    }
                }else{
                    echo '<li><a class="'.($_SERVER['REQUEST_URI'] == $base_path.'login.php' ? 'active' : '').'" href="login.php">Login / Sign In</a></li>';
                }
            ?>
        </ul>
    </div>
    <div id="mobile">
        <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
        <i id="bar" class='fas fa-outdent' style='color: #fff'></i>
    </div>
</section>