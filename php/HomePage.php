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

</head>



<header>

    <a href="HomePage.php" class="logo-link">
        <div class="logo-container">
            <img src="../img/Logo.png" alt="Logo">
            <h1>Secret Shelf</h1>
        </div>
    </a>

    <div class="search-container">

        <input type="text" class="searchbar" placeholder="Search..." id="searchInput">

        <button id="searchButton" class="search-btn">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>

    </div>

    <div class="nav-container">
        <nav>
            <a href="#Edu">Contact Us</a>
            <a href="#Edu">Promo</a>
            <a href="#Edu">Help</a>
        </nav>

        <a href="CustomerLogin.php" class="Login-Btn">Login / Sign up</a>
    </div>

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

<<<<<<< HEAD
            <img id="img" src="../img/image1.jpg" alt="BookCover">
            <p id="desc">Ichigo Kurosaki never asked for the ability to see ghosts -- he was born with the gift. When his family is attacked by a Hollow -- a malevolent lost soul -- Ichigo becomes a Soul Reaper, dedicating his life to protecting the innocent and helping the tortured spirits themselves find peace.</p>
=======
            <img id="mainImg" src="../img/Intro3.png" alt="BookCover">
>>>>>>> 6a36f37 (3/5 2.27)

            <span id="next" class="material-symbols-outlined">arrow_forward_ios</span>

        </div>

    </div>

    <div class="down">
        <div class="Category-part">


            <div class="Category-Section">

<<<<<<< HEAD
                <p>Novel</p>
=======
                <p>Best-seller</p>
>>>>>>> 6a36f37 (3/5 2.27)

                <div class="cat-img">

                    <figure>
<<<<<<< HEAD
                        <img src="../img/image1.jpg" title="Bleach">
                        <figcaption>Bleach</figcaption>
                    </figure>
                    <figure>
                        <img src="../img/image2.jpg">
                        <figcaption>Hunter</figcaption>
                    </figure>
                    <figure>
                        <img src="../img/image3.jpg">
                        <figcaption>Full Metal Alchemist</figcaption>
                    </figure>
                    <figure>
                        <img src="../img/image4.jpg">
                        <figcaption>One Punch Man</figcaption>
                    </figure>
                    <figure>
                        <img src="../img/image5.jpg">
=======
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
>>>>>>> 6a36f37 (3/5 2.27)
                        <figcaption>Jujutsu Kaisen</figcaption>
                    </figure>

                    <span class="material-symbols-outlined">add</span>

                </div>


            </div>

            <div class="Category-Section">

<<<<<<< HEAD
                <p>Comic</p>

                <div class="cat-img">

                    <img id="img" src="/img/fate1.jpg">
                    <img id="img" src="/img/fate2.jpg">
=======
                <p>What New</p>

                <div class="cat-img">

                    <img id="bookImg" src="/img/fate1.jpg">
                    <img id="bookImg" src="/img/fate2.jpg">
>>>>>>> 6a36f37 (3/5 2.27)
                    <span class="material-symbols-outlined">add</span>

                </div>


            </div>

            <div class="Category-Section">

<<<<<<< HEAD
                <p>Education</p>

                <div class="cat-img">

                    <img id="img" src="../img/image1.jpg">
                    <img id="img" src="../img/image2.jpg">
                    <img id="img" src="../img/image3.jpg">
                    <img id="img" src="../img/image4.jpg">
=======
                <p>Recommendation</p>

                <div class="cat-img">

                    <img id="bookImg" src="../img/image1.jpg">
                    <img id="bookImg" src="../img/image2.jpg">
                    <img id="bookImg" src="../img/image3.jpg">
                    <img id="bookImg" src="../img/image4.jpg">
>>>>>>> 6a36f37 (3/5 2.27)
                    <span class="material-symbols-outlined">add</span>

                </div>


            </div>

<<<<<<< HEAD
            <div class="Category-Section">

                <p>Children</p>

                <div class="cat-img">

                    <img id="img" src="/img/image1.jpg">
                    <img id="img" src="/img/image2.jpg">
                    <img id="img" src="/img/image3.jpg">
                    <img id="img" src="/img/image4.jpg">
                    <span class="material-symbols-outlined">add</span>

                </div>


            </div>
=======
>>>>>>> 6a36f37 (3/5 2.27)

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