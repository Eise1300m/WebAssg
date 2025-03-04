$(document).ready(function () {
    function performSearch() {
        let query = $("#searchInput").val();
        if (query) {
            alert("Searching for: " + query);
        } else {
            alert("Please enter a search query.");
        }
    }

    $("#searchButton").click(function () {
        performSearch();
    });

    $("#searchInput").keypress(function (event) {
        if (event.key === "Enter") {
            performSearch();
        }
    });

    // Image slider functionality
    const coverArr = [
<<<<<<< HEAD
        '../img/image1.jpg',
        '../img/image2.jpg',
        '../img/image3.jpg',
        '../img/image4.jpg'
    ];

    const descriptionArr= [
        "Ichigo Kurosaki never asked for the ability to see ghosts -- he was born with the gift. When his family is attacked by a Hollow -- a malevolent lost soul -- Ichigo becomes a Soul Reaper, dedicating his life to protecting the innocent and helping the tortured spirits themselves find peace.",
        "Hunter × Hunter is a Japanese manga series written and illustrated by Yoshihiro Togashi. It has been serialized in Shueisha's shōnen manga magazine Weekly Shōnen Jump since March 1998, although the manga has frequently gone on extended hiatuses since 2006.",
        "Fullmetal Alchemist is a Japanese manga series written and illustrated by Hiromu Arakawa. It was serialized in Square Enix's shōnen manga anthology magazine Monthly Shōnen Gangan between July 2001 and June 2010; the publisher later collected the individual chapters in 27 tankōbon volumes.",
        "One-Punch Man is a Japanese superhero manga series created by One. It tells the story of Saitama, an independent superhero who, having trained to the point that he can defeat any opponent with a single punch, grows bored from a lack of challenge. ",
    
    ];
    let i = 0;
    let total = coverArr.length;

    function updateContent() {
        $("#img").fadeOut(300, function () {
            $(this).attr("src", coverArr[i]).fadeIn(1500);
        });

        $("#desc").fadeOut(300, function () {
            $(this).text(descriptionArr[i]).fadeIn(1500);
        });
    }

    $("#next").click(function () {
        i = (i + 1) % total;
        updateContent();
    });

    $("#back").click(function () {
        i = (i - 1 + total) % total;
        updateContent();
    });
});
=======

        '../img/Intro3.png',
        '../img/Intro2.png',
        '../img/Intro1.png'
    ];


    let i = 0;
    let total = coverArr.length;
    let slideInterval;


    function updateContent() {
        $("#mainImg").fadeOut(500, function () {
            $(this).attr("src", coverArr[i]).fadeIn(1500);
        });
    }

    function nextSlide() {
        i = (i + 1) % total;
        updateContent();
    }

    function prevSlide() {
        i = (i - 1 + total) % total;
        updateContent();
    }

    function startAutoSlide() {
        stopAutoSlide(); // Ensure no duplicate intervals
        slideInterval = setInterval(nextSlide, 3500); // Change image every 3 seconds
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    // Manual navigation buttons
    $("#next").click(function () {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    $("#back").click(function () {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    startAutoSlide(); // Start auto-slide on page load
});

>>>>>>> 6a36f37 (3/5 2.27)
