<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kamil Wyżgoł - blog</title>
    <?php require_once("req/scripts_info.php"); ?>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="container">
    <?php require_once("req/header.php"); ?>
    <?php require_once("req/navigation.php"); ?>
    <div id="content">
        <section>
            <?php
            if(isset($_SESSION["user_id"]))
            {
                echo "<div class='article'>
                        <h4>Dodaj pracę konkursową</h4>
                        <form action='upload.php' method='post' enctype='multipart/form-data'>
                        <input type='file' accept='image/png' name='toUpload' required>        
                        <button type='submit' class='button'>Wyślij</button>
                        </form>
                        </div>";
            }
            else
            {
                echo "Aby wyświetlić stronę należy się zalogować";
            }
            ?>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>
