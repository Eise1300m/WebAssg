<!DOCTYPE html>
<html lang="en">



<head>  

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf' ?></title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/HomeScript.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    </head>


    <header>
        
        <h1><a href="MainPage.php" class="Logo">Secret Shelf</a></h1>

        <div class="search-container">

        <input type = "text" class="searchbar" placeholder= "Search..." id="searchInput">
        
        <button id="searchButton" class="search-btn">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
        
        </div>

        <a href="CustomerLogin.php"class="Login-Btn">Login / Sign up</a>

    
    
    </header>

    <nav>

        <div class="nav">

  
            <a href="#Edu">Education</a>
            <a href="#Cm">Comic</a>
            <a href="#Nl">Novel</a>
            <a href="#Edu">Children</a>

        </div>

    </nav>

    <!-- javascript -->
    <script>
        function performSearch(){
            let query = document.getElementById("searchInput").value; // Get user input
            if (query) {
                alert("Searching for: " + query); // Simulated search action
            } else {
                alert("Please enter a search query."); // Alert if empty
            }
        }

        document.getElementById("searchButton").addEventListener("click", function() {
            performSearch();
        });

        // When the Enter key is pressed inside the search box
        document.getElementById("searchInput").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                performSearch();
            }
        });
    </script>



    <body> 

        <div class="Recommendation-Container">

        <span id="back" class="material-symbols-outlined">arrow_back_ios_new</span>

        <img id = "img" src="/img/image1.jpg" alt="BookCover">
        <p id="desc">Ichigo Kurosaki never asked for the ability to see ghosts -- he was born with the gift. When his family is attacked by a Hollow -- a malevolent lost soul -- Ichigo becomes a Soul Reaper, dedicating his life to protecting the innocent and helping the tortured spirits themselves find peace.</p>

        <span id="next" class="material-symbols-outlined">arrow_forward_ios</span>

        <script>
            const coverArr = [
            '/img/image1.jpg',
            '/img/image2.jpg',
            '/img/image3.jpg',
            '/img/image4.jpg',
        ];

        const descriptionArr= [
            "Ichigo Kurosaki never asked for the ability to see ghosts -- he was born with the gift. When his family is attacked by a Hollow -- a malevolent lost soul -- Ichigo becomes a Soul Reaper, dedicating his life to protecting the innocent and helping the tortured spirits themselves find peace.",
            "Hunter × Hunter is a Japanese manga series written and illustrated by Yoshihiro Togashi. It has been serialized in Shueisha's shōnen manga magazine Weekly Shōnen Jump since March 1998, although the manga has frequently gone on extended hiatuses since 2006.",
            "Fullmetal Alchemist is a Japanese manga series written and illustrated by Hiromu Arakawa. It was serialized in Square Enix's shōnen manga anthology magazine Monthly Shōnen Gangan between July 2001 and June 2010; the publisher later collected the individual chapters in 27 tankōbon volumes.",
            "One-Punch Man is a Japanese superhero manga series created by One. It tells the story of Saitama, an independent superhero who, having trained to the point that he can defeat any opponent with a single punch, grows bored from a lack of challenge. ",
        
        ];

        let i = 0;
        let total = coverArr.length;

        function updateContent(){

            $('#img').fadeOut(300,function(){
                $(this).prop('src',coverArr[i]).fadeIn(1500);
            });

            $('#desc').fadeOut(300,function(){
                $(this).text(descriptionArr[i]).fadeIn(1500);
            });
        }

        $('#next').on('click', function() {
             i = (i +1)% total;
             updateContent();
  
        });

        $('#back').on('click', function() {
             i = (i - 1 + total)% total;
             updateContent();
  
        });

        

        </script>

        </div>



    </body>


        <footer>

        <p>&copy; 2025 Secret Shelf. All Rights Reserved.</p>
             <nav>
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Service</a> | 
                <a href="#">Contact Us</a>
             </nav>
        </footer>

        <style>
        footer {
        background-color: transparent;
        color: white;
        text-align: center;
        padding: 20px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
        font-size: 23px;

        }
        footer a {
        color: #00ADEF;
        text-decoration: none;
        margin: 0 10px;
        font-size: 15px;
        }
        footer a:hover {
        text-decoration: underline;
        }
        </style>



</html>

