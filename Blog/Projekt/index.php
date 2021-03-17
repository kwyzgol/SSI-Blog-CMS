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

            if(isset($_GET["tag"]))
            {
                $tag = "tag = '{$_GET['tag']}'";
            }

            if(isset($_SESSION["date1_command"]) || isset($_SESSION["date2_command"]))
            {
                $command_time = " WHERE ";

                if(isset($tag)) $command_time .= "{$tag} AND ";

                if(isset($_SESSION["date1_command"])) $command_time .= "time >= '{$_SESSION["date1_command"]}'";
                if(isset($_SESSION["date1_command"]) && isset($_SESSION["date2_command"])) $command_time .= " AND ";
                if(isset($_SESSION["date2_command"])) $command_time .= "time <= '{$_SESSION["date2_command"]}'";
                $command_time .= " ORDER BY time DESC";
            }
            else
            {
                if(isset($tag)) $tag = " WHERE {$tag}";
                else $tag = "";
                $command_time = "{$tag} ORDER BY time DESC";
            }


            class article
            {
                public $title;
                public $content;
                public $author_id;
                public $article_id;
            }

            $articles_array = array();

            $article_command = $mysqli->query("SELECT title, content, user_id, article_id  FROM article{$command_time}");

            $article_command->data_seek(0);
            while ($row = $article_command->fetch_assoc())
            {
                $tmp = new article();
                $tmp->title = $row["title"];
                $tmp->content = $row["content"];
                $tmp->author_id = $row["user_id"];
                $tmp->article_id = $row["article_id"];

                array_push($articles_array, $tmp);
            }


            if(isset($_GET["str"]) && is_numeric($_GET["str"]) && $_GET["str"] >= 0 && $_GET["str"] <= count($articles_array)-1)
            {
                $tmp = $_GET["str"];

                $tmpTitle = $articles_array[$tmp]->title;
                $tmpContent = $articles_array[$tmp]->content;

                echo("
                    <article>
                        <div class='article'>
                            <h3>{$tmpTitle}</h3>
                            {$tmpContent}
                        </div>
                    </article>");
                if(isset($_SESSION["user_id"]) == false)
                echo("<section>
                        <div id='commentPanel'>
                            <h5>Dodawanie komentarza</h5>
                            <form method='post' action='validation.php'>
                                Nick: <input type='text' name='nick' ><br><br>
                                E-mail: <input type='text' name='email' size='25'><br><br>
                                Treść komentarza:<br><textarea name='comment' rows='4' cols='30'></textarea><br>
                                <input type='submit' value='Dodaj' class='button'>
                                <input type='hidden' name='reCaptchaResult' id='reCaptchaResult'>
                                <input type='hidden' name='article_id' value={$articles_array[$tmp]->article_id}> 
                            </form>                    
                        </div>
                    </section>
                    ");
                else
                {
                    echo("<section>
                        <div id='commentPanel'>
                            <h5>Dodawanie komentarza</h5>
                            <form method='post' action='user_comment.php'>
                                Treść komentarza:<br><textarea name='comment' rows='4' cols='30'></textarea><br>
                                <input type='submit' value='Dodaj' class='button'>
                                <input type='hidden' name='article_id' value={$articles_array[$tmp]->article_id}> 
                            </form>                    
                        </div>
                    </section>
                    ");
                }
                $comment_command = $mysqli->query("SELECT type, nickname, email, content, user_id FROM comment WHERE article_id ={$articles_array[$tmp]->article_id} ");
                $comment_command->data_seek(0);
                while ($row = $comment_command->fetch_assoc())
                {
                    if($row["type"] == "anonymous")
                    {
                        echo("
                            <div class='article'>
                                <h5>Komentarz, autor: {$row["email"]}</h5>
                                <p>{$row["content"]}</p>
                            </div>
                        ");
                    }
                    else
                    {
                        $email_command = $mysqli->query("SELECT email FROM user WHERE user_id = {$row["user_id"]}");
                        $email_command->data_seek(0);
                        $email = $email_command->fetch_assoc();
                        $email = $email["email"];
                        echo("
                            <div class='article'>
                                <h5>Komentarz, autor: {$email}</h5>
                                <p>{$row["content"]}</p>
                            </div>
                        ");
                    }
                }

            }
            else
                for ($i = 0; $i < count($articles_array); $i++)
                {
                    $tmpTitle = $articles_array[$i]->title;
                    $tmpContent = $articles_array[$i]->content;
                    $tmpId = $articles_array[$i]->article_id;

                    echo("
                        <article>
                            <div class='article'>
                                <h3>{$tmpTitle}</h3>
                                {$tmpContent}");
                    if(isset($_SESSION["user_id"]) &&  $_SESSION["user_id"] == $articles_array[$i]->author_id)
                        echo("<a href='delete.php?str=$tmpId'><button class='button comment'>Usuń</button></a>");
                    echo("<a href='index.php?str=$i'><button class='button comment'>Skomentuj</button></a>
                            </div>
                        </article>
                        ");
                }
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
