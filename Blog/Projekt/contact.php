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
                    echo("<div class='article'><h5>Formularz kontaktowy</h5>
                                E-mail: <input type='text' name='email' size='25'><br><br>
                                Treść:<br><textarea name='message' rows='4' cols='30'></textarea><br>
                                <button id='contactButton' class='button'>Wyślij</button>
                                <p><span id='status'></span></p></div>");
                }
                else
                {
                    echo "Aby użyć formularza trzeba się zalogować";
                }
            ?>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $("#contactButton").click(function (){

            var who = $("input[name=email]").val();
            var content = $("textarea[name=message]").val();
            var id = <?php echo $_SESSION["user_id"];?>;

            $.post("mailer.php", {
                who: who,
                id: id,
                content: content
            }, function (data){
                $("#status").text(data);
            });
        });
    });
</script>

<?php require_once("req/scripts.php") ?>

</body>
</html>
