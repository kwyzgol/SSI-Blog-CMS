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

        <?php
        if((isset($_SESSION["post_permission"])  &&  $_SESSION["post_permission"]) == false) echo("<script type='text/javascript'>location.href='index.php'</script>");

        $title = "";
        $text = "";
        $tag = "";

        if(isset($_SESSION["article_mode"])) $mode = $_SESSION["article_mode"];
        else $mode = "preview";

        if(isset($_SESSION["article_title"])) $title = $_SESSION["article_title"];
        if(isset($_SESSION["article_text"])) $text = $_SESSION["article_text"];
        if(isset($_SESSION["tag"])) $tag = $_SESSION["tag"];

        if($mode == "approved")
        {
            $user_id = $_SESSION["user_id"];
            $title = $_SESSION["tmpTitle"];
            $content = $_SESSION["tmpContent"];
            $tag = htmlspecialchars($_SESSION["tag"]);
            $array = array("INSERT INTO article(title, content, user_id, tag) VALUES ('{$title}', '{$content}', {$user_id}, '{$tag}')");
            if(transaction($mysqli, $array)) header("Location: index.php");
            else echo ("Wystąpił błąd");

            unset($_SESSION["tmpTitle"]);
            unset($_SESSION["tmpContent"]);
            unset($_SESSION["article_mode"]);
            unset($_SESSION["article_title"]);
            unset($_SESSION["article_text"]);
            unset($_SESSION["tag"]);
        }

        ?>

        <section>
            <div id='newPost'>
                <h5>Dodawanie posta</h5>
                <h4>Informacje</h4>
                <ul>
                    <li>Opcje formatowania dotyczą wyłącznie pola "Treść".</li>
                    <li>Przyciski formatujące tekst powodują wstawienie odpowiednich znaczników wokół zaznaczonego obszaru (lub w miejscu kursora tekstowego).</li>
                </ul><br>
                <form method='post' action='preview.php'>
                    <label for="title">Tytuł: </label><input type='text' name='title' id='title' size='70' value=<?php echo "'{$title}'"; ?> required><br><br>
                    <button type="button" class="button" onclick="editButton('paragraph')">Nowy akapit</button>
                    <button type="button" class="button" onclick="editButton('link')">Hiperłącze</button>
                    <button type="button" class="button" onclick="editButton('bold')">Pogrubienie</button>
                    <button type="button" class="button" onclick="editButton('italic')">Kursywa</button>
                    <button type="button" class="button" onclick="editButton('underline')">Podkreślenie</button>
                    <button type="button" class="button" onclick="editButton('strikethrough')">Przekreślenie</button>
                    <br><br>
                    <label for="text">Treść:</label><br><textarea name='text' id='text' rows='20' cols='90' required><?php echo $text; ?></textarea><br>
                    <label for="tag">Tag: </label><input type='text' name='tag' id='tag' size='70' maxlength="20" value=<?php echo "'{$tag}'"; ?> ><br><br>
                    <input type='submit' value='Podgląd' class='button'>
                </form>
            </div>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<script>
    function editButton(buttonType)
    {
        var textarea = document.getElementById("text");
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;

        switch (buttonType)
        {
            case "link":
                textarea.value = textarea.value.slice(0, start) + "[url=ADRES_URL]" + textarea.value.slice(start, end) + "[/url]" + textarea.value.slice(end);
                break;

            case "paragraph":
                textarea.value = textarea.value.slice(0, start) + "[p]" + textarea.value.slice(start, end) + "[/p]" + textarea.value.slice(end);
                break;

            case "bold":
                textarea.value = textarea.value.slice(0, start) + "[b]" + textarea.value.slice(start, end) + "[/b]" + textarea.value.slice(end);
                break;

            case "italic":
                textarea.value = textarea.value.slice(0, start) + "[i]" + textarea.value.slice(start, end) + "[/i]" + textarea.value.slice(end);
                break;

            case "underline":
                textarea.value = textarea.value.slice(0, start) + "[u]" + textarea.value.slice(start, end) + "[/u]" + textarea.value.slice(end);
                break;

            case "strikethrough":
                textarea.value = textarea.value.slice(0, start) + "[s]" + textarea.value.slice(start, end) + "[/s]" + textarea.value.slice(end);
                break;
        }
    }
</script>
<?php require_once("req/scripts.php") ?>

</body>
</html>
