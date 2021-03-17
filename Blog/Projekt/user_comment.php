<?php

require_once("req/db.php");

if(isset($_SESSION["user_id"]))
{
    $article_id = htmlspecialchars($_POST["article_id"]);
    $comment = htmlspecialchars($_POST["comment"]);

    $insert = "INSERT INTO comment(type, content, user_id, article_id) VALUES('registered', '{$comment}', {$_SESSION["user_id"]}, {$article_id})";
    $insert = array($insert);

    transaction($mysqli, $insert);
    header("Location: index.php");
}

?>