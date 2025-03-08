<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Login' ?></title>
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">


</head>

<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_image" required>
        <button type="submit" name="upload">Upload</button>
    </form>

</body>

