<?php

$to = "receive@mail.com";
$subject = "Nowa wiadomość z formularza kontaktowego";

$who = "Nadawca: ".$_POST["who"];
$id = $_POST["id"];
$content = "Treść: ".$_POST["content"];
$message = $who."\n"."User ID: ".$id."\n".$content;

$headers = "From: send@mail.com";

mail($to, $subject, $message, $headers);

echo "Wysłano";
?>