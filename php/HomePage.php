<!DOCTYPE html>
<html lang="en">



<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf' ?></title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/HomeScript.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders:opsz,wght@10..72,100..900&family=Roboto+Condensed:wght@344&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>



<header>
    <?php include_once("navbar.php"); ?>
</header>

<body>


    <div class="up">

        <div class="nav2">


            <a href="#Edu">Education</a>
            <a href="#Cm">Comic</a>
            <a href="#Nl">Novel</a>
            <a href="#Edu">Children</a>

        </div>


        <div class="Recommendation-Container">

            <span id="back" class="material-symbols-outlined">arrow_back_ios_new</span>

            <img id="mainImg" src="../img/Intro3.png" alt="BookCover">

            <span id="next" class="material-symbols-outlined">arrow_forward_ios</span>

        </div>

    </div>

    <div class="down">
        <div class="Category-part">


            <div class="Category-Section">

                <p>Best-seller</p>

                <div class="cat-img">

                    <figure>
                        <img id="bookImg" src="../img/image1.jpg" title="Bleach">
                        <figcaption>Bleach</figcaption>
                    </figure>
                    <figure>
                        <img id="bookImg" src="../img/image2.jpg">
                        <figcaption>Hunter</figcaption>
                    </figure>
                    <figure>
                        <img id="bookImg" src="../img/image3.jpg">
                        <figcaption>Full Metal Alchemist</figcaption>
                    </figure>
                    <figure>
                        <img id="bookImg" src="../img/image4.jpg">
                        <figcaption>One Punch Man</figcaption>
                    </figure>
                    <figure>
                        <img id="bookImg" src="../img/image5.jpg">
                        <figcaption>Jujutsu Kaisen</figcaption>
                    </figure>

                    <span class="material-symbols-outlined">add</span>

                </div>


            </div>

            <div class="Category-Section">

                <p>What New</p>

                <div class="cat-img">

                    <img id="bookImg" src="/img/fate1.jpg">
                    <img id="bookImg" src="/img/fate2.jpg">
                    <span class="material-symbols-outlined">add</span>

                </div>


            </div>

            <div class="Category-Section">

                <p>Recommendation</p>

                <div class="cat-img">

                    <img id="bookImg" src="../img/image1.jpg">
                    <img id="bookImg" src="../img/image2.jpg">
                    <img id="bookImg" src="../img/image3.jpg">
                    <img id="bookImg" src="../img/image4.jpg">
                    <span class="material-symbols-outlined">add</span>

                </div>


            </div>


        </div>

    </div>

</body>


<footer>

    <div class="Bottom-Area">


        <div class="Bot1">

            <p style="font-size: 20px;">&copy; 2025 Secret Shelf. All Rights Reserved.</p> <br>

            <a href="#">Privacy Policy</a> <br>
            <a href="#">Terms of Service</a> <br>
            <a href="#">About Us</a> <br>


        </div>

        <div class="Bot2">

            <h3>Contact Us</h3>

            <p> Monday to Saturday: 9:00am to 6:00 </p>
            <p> (Lunch break: 1:00pm to 2:00pm) </p>
            <p> Closed on Sunday & Public Holidays </p><br>
            <p> No tel: +603 1122 3344 </p>
            <p> Email: SecretShelfmy@gmail.com</p>

        </div>


    </div>


</footer>





</html>