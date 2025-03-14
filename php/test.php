<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Design</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }
        
        .header {
            background-color:rgba(59, 189, 26, 0.62);
            height: 70px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 20px;
        }
        
        .button {
            background-color: #783b3b;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-size: 16px;
            cursor: pointer;
        }
        
        .content {
            min-height: calc(100vh - 70px);
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="button">Button</button>
    </div>
    <div class="content">
        <!-- Your content goes here -->
    </div>
    
    <?php
    // Your PHP code can go here
    ?>
</body>
</html>