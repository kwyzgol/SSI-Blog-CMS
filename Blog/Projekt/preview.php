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

                //after buttons are used
                if(isset($_GET["status"]) )
                {
                    if($_GET["status"] == "approved") $_SESSION["article_mode"] = "approved";
                    else $_SESSION["article_mode"] = "preview";
                    echo("<script type='text/javascript'>location.href='new_article.php'</script>");
                }

                //title
                if(isset($_POST["title"]) && empty($_POST["title"]) == false)
                {
                    $_SESSION["article_title"] = $_POST["title"];
                    $title = $_POST["title"];
                }
                else
                {
                    if(isset($_GET["status"]) == false) $_SESSION["article_title"] = "";
                    $title = "[Brak tytułu]";
                }

                //text
                if(isset($_POST["text"]) && empty($_POST["text"]) == false)
                {
                    $_SESSION["article_text"] = $_POST["text"];
                    $text = $_POST["text"];
                }
                else
                {
                    if(isset($_GET["status"]) == false) $_SESSION["article_text"] = "";
                    $text = "[Brak treści]";
                }

                if(isset($_POST["tag"]))
                {
                    $_SESSION["tag"] = $_POST["tag"];
                }

                //deleting HTML
                $title = htmlspecialchars($title);
                $text = htmlspecialchars($text);

                //links
                $pattern = "#\[url=(.*?)\](.*?)\[/url\]#";
                $replace = "<a href='$1'>$2</a>";
                $text = preg_replace($pattern, $replace, $text);

                //paragraph
                $pattern = "#\[p\](.*?)\[/p\]#";
                $replace = "<p>$1</p>";
                $text = preg_replace($pattern, $replace, $text);

                //bold
                $pattern = "#\[b\](.*?)\[/b\]#";
                $replace = "<b>$1</b>";
                $text = preg_replace($pattern, $replace, $text);

                //italic
                $pattern = "#\[i\](.*?)\[/i\]#";
                $replace = "<i>$1</i>";
                $text = preg_replace($pattern, $replace, $text);

                //underline
                $pattern = "#\[u\](.*?)\[/u\]#";
                $replace = "<ins>$1</ins>";
                $text = preg_replace($pattern, $replace, $text);

                //strikethrough
                $pattern = "#\[s\](.*?)\[/s\]#";
                $replace = "<del>$1</del>";
                $text = preg_replace($pattern, $replace, $text);

                //converting \n to <br>
                $text = nl2br($text);

                if(isset($_SESSION["article_mode"]) == false || (isset($_SESSION["article_mode"]) && $_SESSION["article_mode"] !=  "approved"))
                {
                    $_SESSION["tmpTitle"] = $title;
                    $_SESSION["tmpContent"] = $text;
                }

                //preview
                echo("
                    <article>
                        <div class='article'>
                            <h2>Podgląd</h2>
                            <h3>{$title}</h3>
                            {$text}
                            <br><br>
                            <a href='preview.php?status=approved'><button class='button comment'>Zatwierdź</button></a>
                            <a href='preview.php?status=preview'><button class='button comment'>Edytuj</button></a>
                        </div>
                    </article>");
            ?>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>
