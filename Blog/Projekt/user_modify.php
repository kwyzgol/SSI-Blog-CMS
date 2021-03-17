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

            if($allowed)
            {
                $command_permission = $mysqli->query("SELECT u.email, r.name, u.activate FROM user u JOIN role r ON u.role_id = r.role_id WHERE u.user_id = {$id}");
                if($row = $command_permission->fetch_assoc())
                {
                    $email = $row["email"];
                    $role = $row["name"];
                    $activate = $row["activate"];
                }
                echo ("<article>
                        <div class='article'>
                            <h3>Edycja użytkownika - ID: {$id}, e-mail: {$email}, rola: {$role}</h3>
                            <div class='article'>
                                <h3>Edycja uprawnień</h3>
                                <ul>
                                <li><a href='command.php?command=1&id={$id}'>Użytkownik</a></li>
                                <li><a href='command.php?command=2&id={$id}'>Autor</a></li>
                                <li><a href='command.php?command=3&id={$id}'>Administrator</a></li>
                                </ul>
                            </div>
                            <div class='article'>
                                <h3>Zmiana hasła</h3>
                                <form method='get' action='command.php'>
                                    <input type='hidden' name='command' value=4>
                                    <input type='hidden' name='id' value={$id}>
                                    <input type='text' name='password' required>
                                    <button class='button' type='submit'>Zmień</button>                                  
                                </form>
                            </div>
                            <div class='article'>
                                <h3>Usuwanie konta</h3>
                                <a href='command.php?command=5&id={$id}'><button class='button'>Usuń</button></a>
                            </div>");
                if($activate == 0)
                {
                    echo ("<div class='article'>
                                <h3>Aktywacja konta</h3>
                                <a href='command.php?command=6&id={$id}'><button class='button'>Aktywuj</button></a>
                            </div>");
                }
                echo ("</div></article>");
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
