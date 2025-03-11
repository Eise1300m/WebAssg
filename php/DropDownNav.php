<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Dropdown.css">


</head>

<body>
    <div class="sidebar">
        <div class="category category-1" onclick="toggleSubcategory(this)">Novel</div>
        <div class="subcategory-list">
            <div class="subcategory">Romance</div>
            <div class="subcategory">Mystery & Thriller</div>
            <div class="subcategory">Science Fiction</div>
            <div class="subcategory">Fantasy</div>
            <div class="subcategory">Horror</div>
        </div>
        
        <div class="category category-2" onclick="toggleSubcategory(this)">Comic</div>
        <div class="subcategory-list">
            <div class="subcategory">Superhero</div>
            <div class="subcategory">Horror</div>
            <div class="subcategory">Romance</div>
            <div class="subcategory">Comedy</div>
            <div class="subcategory">Adventure</div>
        </div>
        
        <div class="category category-3" onclick="toggleSubcategory(this)">Education</div>
        <div class="subcategory-list">
            <div class="subcategory">Mathematics</div>
            <div class="subcategory">History</div>
            <div class="subcategory">Language Learning</div>
            <div class="subcategory">Computer Science</div>
            <div class="subcategory">Business & Economics</div>
            <div class="subcategory">Psychology</div>
        </div>
        
        <div class="category category-4" onclick="toggleSubcategory(this)">Children</div>
        <div class="subcategory-list">
            <div class="subcategory">Pictures</div>
            <div class="subcategory">Fairy Tales</div>
            <div class="subcategory">Educational Stories</div>
            <div class="subcategory">Moral Stories</div>
            <div class="subcategory">Animal Stories</div>
        </div>
    </div>

    <script>
        function toggleSubcategory(element) {
            element.classList.toggle('active');
            const subcategoryList = element.nextElementSibling;
            subcategoryList.classList.toggle('open');
        }
    </script>
</body>
</html>