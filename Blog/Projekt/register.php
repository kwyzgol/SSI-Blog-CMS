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
            <div class="article">
                <form name="registration" action="registerProcess.php" method="post">
                    <p><label for="firstName">Imię: </label><input name="firstName" id="firstName" placeholder="Wpisz imię" autofocus></p>
                    <p><label for="lastName">Nazwisko: </label><input name="lastName" id="lastName" placeholder="Wpisz nazwisko"></p>
                    <p><label for="email">Adres e-mail: </label><input type="email" name="email" id="email" placeholder="Wpisz adres e-mail" required></p>
                    <p><label for="password">Hasło: </label><input type="password" id="password" name="password" placeholder="Wpisz hasło" required></p><br><br>
                    <p><input type="checkbox" name="regulations" id="regulations" required>
                        <label for="regulations">Akceptuję postanowienia <a href="#" target="_blank">regulaminu</a></label></p>
                    <input type='hidden' name='reCaptchaResult' id='reCaptchaResult' required>
                    <button type="reset" class="button">Wyczyść</button>
                    <button type="submit" class="button">Zarejestruj</button>
                </form>
            </div>

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
