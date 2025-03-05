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

