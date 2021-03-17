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
            //reCaptcha
            $reCaptchaNotEmpty = isset($_POST["reCaptchaResult"]);

            if($reCaptchaNotEmpty)
            {
                $reCaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
                $reCaptchaSecretKey = 'KEY';
                $reCaptchaResult = $_POST["reCaptchaResult"];

                $reCaptcha = file_get_contents("{$reCaptchaUrl}?secret={$reCaptchaSecretKey}&response={$reCaptchaResult}");
                $reCaptcha = json_decode($reCaptcha);
            }

            //nick
            $nickNotEmpty = (isset($_POST["nick"]) && $_POST["nick"] != "");
            if($nickNotEmpty) $nick = $_POST["nick"];

            //email
            $emailNotEmpty = (isset($_POST["email"]) && $_POST["email"] != "");
            if($emailNotEmpty) $email = $_POST["email"];
            $pattern = "/^[a-z0-9_.]+@[a-z0-9]+\.[a-z]+$/i";
            if($emailNotEmpty) $validEmail = preg_match($pattern, $_POST["email"]);

            //comment
            $commentNotEmpty = (isset($_POST["comment"]) && $_POST["comment"] != "");
            if($commentNotEmpty) $comment = $_POST["comment"];

            echo("<div id='commentPanel'>");

            if($nickNotEmpty && $emailNotEmpty && $commentNotEmpty && isset($validEmail) && $validEmail == 1 && $reCaptchaNotEmpty && isset($reCaptcha->success) && $reCaptcha->success && isset($reCaptcha->score) && $reCaptcha->score >= 0.5)
                {
                    echo("<h3><span class='validationSuccess'>Komentarz zatwierdzony</span></h3>");
                    $insert = "INSERT INTO comment(type, nickname, email, content, article_id) VALUES('anonymous', '{$nick}', '{$email}', '{$comment}', {$_POST['article_id']})";
                    $insert = array($insert);
                    transaction($mysqli, $insert);
                }
            else
                echo("<h3><span class='validationFailure'>Komentarz odrzucony</span></h3>");

            if($reCaptchaNotEmpty && isset($reCaptcha->success) && $reCaptcha->success && isset($reCaptcha->score) && is_numeric($reCaptcha->score))
            {
                if($reCaptcha->score >= 0.5)
                {
                    echo("ReCAPTCHA: <span class='validationSuccess'>weryfikacja udana</span><br>");
                    echo("Wynik: <span class='validationSuccess'>{$reCaptcha->score}</span><br>");
                }
                else
                {
                    echo("ReCAPTCHA: <span class='validationFailure'>weryfikacja nieudana</span><br>");
                    echo("Wynik: <span class='validationFailure'>{$reCaptcha->score}</span><br>");
                }
            }
            else
            {
                echo("ReCAPTCHA: <span class='validationFailure'>weryfikacja nieudana (wystąpił błąd)</span><br>");
            }

            if($nickNotEmpty) echo("Przesłany nick: \"$nick\" <span class='validationSuccess'>Poprawny</span><br>");
            else echo("<span class='validationFailure'>Nie przesłano nicku</span><br>");

            if($emailNotEmpty)
            {
                echo("Przesłany adres e-mail: \"$email\" ");
                if ($validEmail) echo("<span class='validationSuccess'>Poprawny</span><br>");
                else echo("<span class='validationFailure'>Niepoprawny</span><br>");
            }
            else echo("<span class='validationFailure'>Nie przesłano adresu e-mail</span><br>");

            if($commentNotEmpty) echo("<br><b>Przesłany komentarz:</b> <p>\"$comment\" <span class='validationSuccess'>Poprawny</span></p><br>");
            else echo("<span class='validationFailure'>Nie przesłano komentarza</span><br>");

            echo("</div>");
        ?>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>
