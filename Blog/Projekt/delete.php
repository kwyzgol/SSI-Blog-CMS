<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kamil Wyżgoł - blog</title>
    <?php require_once("req/scripts_info.php"); ?>
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=KEY"></script>
</head>
<body>
<div id="container">
    <?php require_once("req/header.php"); ?>
    <?php require_once("req/navigation.php"); ?>
    <div id="content">
        <?php
            if(isset($_GET["str"]) && is_numeric($_GET["str"]))
            {
                $article_id = $_GET["str"];
                $check_command = $mysqli->query("SELECT user_id FROM article WHERE article_id = {$article_id}");
                $check_command->data_seek(0);
                $row = $check_command->fetch_assoc();
                if(isset($_SESSION["user_id"]) && $row["user_id"] == $_SESSION["user_id"])
                {
                    $array = array("DELETE FROM article WHERE article_id = {$article_id}");
                    if(transaction($mysqli, $array)) echo("Usunięto");
                    else echo ("Nie usunięto");
                }
            }
        ?>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>
