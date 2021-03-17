<?php
require_once("req/db.php");

if(isset($_POST["email"])) $email = $_POST["email"];
if(isset($_POST["password"])) $password = $_POST["password"];

$canLogin = true;

if(substr($email, 0, 1) == '"' || substr($email, 0, 1) =="'") $canLogin= false;

if($canLogin)
{
    $command_user = $mysqli->query("SELECT user_id, password FROM user WHERE email = '{$email}' AND activate = 1");
    if($result = $command_user->fetch_assoc())
    {
        $hash = $result["password"];
        if(password_verify($password, $hash))
        {
            $_SESSION["user_id"] = $result["user_id"];
            header("Location: index.php");
        }
        else $komunikat = "Błędne dane logowania";
    } else $komunikat = "Błędne dane logowania lub nieaktywne konto";
}
else
    $komunikat = "Nie można zalogować";
?>
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
            <?php echo $komunikat; ?>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>
