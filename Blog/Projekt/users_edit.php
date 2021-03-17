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

            if($allowed)
            {
                echo ("<article>
                        <div class='article'>
                            <h3>Lista użytkowników</h3>
                            <ul>");

                $command_permission = $mysqli->query("SELECT u.user_id, u.email, r.name FROM user u JOIN role r ON u.role_id = r.role_id");
                while($row = $command_permission->fetch_assoc())
                {
                    $id = $row["user_id"];
                    $email = $row["email"];
                    $role = $row["name"];
                    echo("<li><a href='user_modify.php?id={$id}'>ID: {$id}, e-mail: {$email}, rola: {$role}</a></li>");
                }
                echo ("</ul></div></article>");
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
