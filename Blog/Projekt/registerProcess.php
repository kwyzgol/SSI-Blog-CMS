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

    $reCaptchaNotEmpty = isset($_POST["reCaptchaResult"]);

    if($reCaptchaNotEmpty)
    {
        $reCaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $reCaptchaSecretKey = 'KEY';
        $reCaptchaResult = $_POST["reCaptchaResult"];

        $reCaptcha = file_get_contents("{$reCaptchaUrl}?secret={$reCaptchaSecretKey}&response={$reCaptchaResult}");
        $reCaptcha = json_decode($reCaptcha);
    }

    if(isset($reCaptcha->success) && $reCaptcha->success) $score = $reCaptcha->score;
    else $score = 0;

    if (isset($_POST["firstName"]))
    {
        $fnameNotEmpty = true;
        $fname = $_POST["firstName"];
    }

    if (isset($_POST["lastName"]))
    {
        $lnameNotEmpty = true;
        $lname = $_POST["lastName"];
    }

    if (isset($_POST["email"]))
    {
        $emailNotEmpty = true;
        $email = $_POST["email"];
    }

    if (isset($_POST["password"]))
    {
        $passwordNotEmpty = true;
        $password = $_POST["password"];
    }

$canRegister= true;

if(substr($email, -1) == '"' || substr($email, -1) =="'") $canRegister= false;
if(substr($fname, -1) == '"' || substr($fname, -1) =="'") $canRegister= false;
if(substr($lname, -1) == '"' || substr($lname, -1) =="'") $canRegister= false;

$password = password_hash($password, PASSWORD_BCRYPT);

if($canRegister && $emailNotEmpty && $passwordNotEmpty && $score >= 0.5)
{
    $str = "INSERT INTO user(user_id, email, password, role_id";
    if($fnameNotEmpty) $str = $str . ", first_name";
    if($lnameNotEmpty) $str = $str . ", last_name";
    $str = $str . ") VALUES(NULL, '{$email}', '{$password}', 1";
    if($fnameNotEmpty) $str = $str . ", '{$fname}'";
    if($lnameNotEmpty) $str = $str . ", '{$lname}'";
    $str = $str . ")";

    echo nl2br("Podgląd komendy ".$str."\n");
    $command = array($str);

    if(transaction($mysqli, $command))
    {
        echo("Operacja udana");
    }
    else echo ("Operacja nieudana");
}
else
    if($score == 0) "Problemy z reCAPTCHA";
    else
        echo("Sprawdź swoje dane i spróbuj ponownie.");
?>
</section>
</div>
<?php require_once("req/footer.php"); ?>
</div>

<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('KEY', {action: 'submit'}).then(function(token) {
            var reCaptchaResult = document.getElementById("reCaptchaResult");
            reCaptchaResult.value = token;
        });
    });
</script>

<?php require_once("req/scripts.php") ?>

</body>
</html>