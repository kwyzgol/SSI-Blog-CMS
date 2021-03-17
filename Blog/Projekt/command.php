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
        <section>
            <?php
            require_once("req/db.php");
            if(isset($_SESSION["modify_users_permission"])) $allowed = $_SESSION["modify_users_permission"];
            else $allowed = false;

            if(isset($_GET["id"]) && is_numeric($_GET["id"])) $id = $_GET["id"];
            else $allowed = false;

            if(isset($_GET["command"]) && is_numeric($_GET["command"])) $command_id = $_GET["command"];
            else $allowed = false;

            if(isset($_GET["password"])) $password = $_GET["password"];

            if($allowed && $command_id >= 1 && $command_id <= 6)
            {
                switch ($command_id)
                {
                    case 1: //user
                        $command = "UPDATE user SET role_id = 1 WHERE user_id = {$id}";
                        break;
                    case 2: //autor
                        $command = "UPDATE user SET role_id = 4 WHERE user_id = {$id}";
                        break;
                    case 3: //admin
                        $command = "UPDATE user SET role_id = 2 WHERE user_id = {$id}";
                        break;
                    case 4: //password
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        $command = "UPDATE user SET password = '{$password}' WHERE user_id = {$id}";
                        break;
                    case 5: //delete
                        $command = "DELETE FROM user WHERE user_id = {$id}";
                        if($_SESSION["user_id"] == $id)
                        {
                            session_destroy();
                            $_SESSION = [];
                        }
                        break;
                    case 6: //activate
                        $command = "UPDATE user SET activate = 1 WHERE user_id = {$id}";
                        break;
                }

                $command = array($command);

                if(transaction($mysqli, $command))
                {
                    echo("Operacja udana");
                }
                else echo ("Operacja nieudana");

                if(isset($_SESSION["user_id"]) == false) //gdy skasowano własne konto
                    header("Location: index.php");
            }
            else
            {
                header("Location: index.php");
            }
            ?>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>
