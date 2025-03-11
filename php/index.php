<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Login' ?></title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

<body>
    <?php include_once("navbar.php") ?>


    <div class="up">
        <div class="nav2">
            <a href="../php/MainPage.php">All</a>
            <a href="#Edu">Education</a>
            <a href="#Cm">Comic</a>
            <a href="#Nl">Novel</a>
            <a href="#Edu">Children</a>
        </div>

        <div class="Recommendation-Container">
            <span id="back" class="material-symbols-outlined">arrow_back_ios_new</span>
            <img id="mainImg" src="../img/Intro3.png" alt="Featured Book">
            <span id="next" class="material-symbols-outlined">arrow_forward_ios</span>
        </div>
    </div>

    <div class="down">
        <div class="Category-part">

            <div class="Category-Section">
                <p>Best-seller</p>
                <div class="cat-img">
                    <figure>
                        <img class="bookImg" src="../img/image1.jpg" alt="Bleach">
                        <figcaption>Bleach</figcaption>
                    </figure>
                    <figure>
                        <img class="bookImg" src="../img/image2.jpg" alt="Hunter">
                        <figcaption>Hunter</figcaption>
                    </figure>
                    <figure>
                        <img class="bookImg" src="../img/image3.jpg" alt="Full Metal Alchemist">
                        <figcaption>Full Metal Alchemist</figcaption>
                    </figure>
                    <figure>
                        <img class="bookImg" src="../img/image4.jpg" alt="One Punch Man">
                        <figcaption>One Punch Man</figcaption>
                    </figure>
                    <figure>
                        <img class="bookImg" src="../img/image5.jpg" alt="Jujutsu Kaisen">
                        <figcaption>Jujutsu Kaisen</figcaption>
                    </figure>
                    <span class="material-symbols-outlined">add</span>
                </div>
            </div>

            <div class="Category-Section">
                <p>What's New</p>
                <div class="cat-img">
                    <img class="bookImg" src="../img/fate1.jpg" alt="New Book 1">
                    <img class="bookImg" src="../img/fate2.jpg" alt="New Book 2">
                    <span class="material-symbols-outlined">add</span>
                </div>
            </div>

            <div class="Category-Section">
                <p>Recommendation</p>
                <div class="cat-img">
                    <img class="bookImg" src="../img/image1.jpg" alt="Recommendation 1">
                    <img class="bookImg" src="../img/image2.jpg" alt="Recommendation 2">
                    <img class="bookImg" src="../img/image3.jpg" alt="Recommendation 3">
                    <img class="bookImg" src="../img/image4.jpg" alt="Recommendation 4">
                    <span class="material-symbols-outlined">add</span>
                </div>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>