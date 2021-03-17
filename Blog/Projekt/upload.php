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
            if(isset($_FILES["toUpload"]) && isset($_SESSION["user_id"]))
            {
                if($_FILES["toUpload"]["type"] = "image/png")
                {
                    $target = "files/{$_SESSION["user_id"]}.png";
                    if(move_uploaded_file($_FILES["toUpload"]["tmp_name"], $target))
                    {
                        $komunikat = "Udało się przesłać plik.";
                    }
                    else $komunikat = "Nie udało się przesłać pliku.";
                }
                else $komunikat = "Błędne rozszerzenie pliku.";
            echo $komunikat;
            }
            ?>

        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>


