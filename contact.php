<?php
    include 'variables.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

        if (mysqli_connect_errno()) {
            printf("Connection failed: %s\n", mysqli_connect_error());
            exit();
        }

        if (empty($_POST['name'])) {
            $errors['name'] = 'Name is required.';
        } 

        if (empty($_POST['email'])) {
            $errors['email'] = 'Email is required.';
        } 

        if (empty($_POST["subject"])) {
            $errors['subject'] = 'Subject is required.';
        }

        if (empty($_POST["message"])) {
            $errors['message'] = 'Message is required.';
        }

        if(empty($errors)) {
            $query = 'INSERT INTO customer_messages (name, email, subject, message)';
            $query = $query.'VALUES (\''.$_POST['name'].'\', \''.$_POST['email'].'\', \''.$_POST['subject'].'\', \''.$_POST['message'].'\')';

            $res = mysqli_query($conn, $query);
            
            if ($res) {
                $success_message = 'Your message has been sent. Please wait and we will reach out to you via email. Thank you.';

                mysqli_close($conn);
                header('Location: contact.php');
                exit();
            }else{
                $errors['contact'] = 'There is a problem with sending a message. Please try again.';
            }
        }
        
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

    <section id="page-header" class="about-header">

        <h2>#Let's_talk</h2>

        <p>LEAVE A MESSAGE, We love to hear from you!</p>

    </section>

    <section id="form-details">
        <form method="POST" action="contact.php">
            <span>LEAVE A MESSAGE</span>
            <h2>We love to hear from you</h2>
            <?php 
                if(!empty($errors['name'])) {
                    echo '<div class="form-error"><span>'.$errors['name'].'</span></div>';
                }

                if(!empty($success_message)) {
                    echo '<div class="success-message"><span>'.$success_message.'</span></div>';
                }
            ?>
            <input type="text" name="name" placeholder="Your Name">
            <?php 
                if(!empty($errors['email'])) {
                    echo '<div class="form-error"><span>'.$errors['email'].'</span></div>';
                }
            ?>
            <input type="email" name="email" placeholder="E-mail">
            <?php 
                if(!empty($errors['subject'])) {
                    echo '<div class="form-error"><span>'.$errors['subject'].'</span></div>';
                }
            ?>
            <input type="text" name="subject" placeholder="Subject">
            <?php 
                if(!empty($errors['message'])) {
                    echo '<div class="form-error"><span>'.$errors['message'].'</span></div>';
                }
            ?>
            <textarea name="message" id="" cols="30" rows="10" placeholder="Your Message"></textarea>
            <?php 
                if(!empty($errors['contact'])) {
                    echo '<div class="form-error"><span>'.$errors['contact'].'</span></div>';
                }
            ?>
            <button class="normal">Submit</button>
        </form>

        <div class="people">
            <div>
                <img src="./images/spdt.jpg" alt="">
                <p><span>SpeedTech I.T. Services <br> - Metro Manila, Batangas & Rizal</span>Facebook Page <br>Phone: 0947-538-4018 <br> Link: <a href="https://www.fb.com/speedtechitbatangas">@speedtechitbatangas</a></p>
            </div>
        </div>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit our store location or contact us today</h2>
            <h3>Shop</h3>
            <div>
                <li>
                    <i class="fal fa-map"></i>
                    <p>Dandan Street, Poblacion, San Juan, Batangas</p>
                </li>
                <li>
                    <i class="fab fa-facebook-f"></i>
                    <p>SpeedTech I.T. Services - Metro Manila, Batangas & Rizal</p>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <p>0947-538-4018</p>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <p>AM 9:00 - PM 7:00, Mon - Sat</p>
                </li>
            </div>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.2202327532
            486!2d121.38973641485254!3d13.825810090299589!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13
            .1!3m3!1m2!1s0x33bd39ff5b529eeb%3A0x12104fb55e942f34!2sMetrobank%20Batangas%20-%20S
            an%20Juan!5e0!3m2!1sen!2sph!4v1669539575046!5m2!1sen!2sph" width="600" height="450" 
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-d
            owngrade"></iframe>
        </div>
    </section>

    <?php 
        include 'footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>