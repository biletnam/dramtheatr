<?php

$recepient = "artem.matseruk@gmail.com";
$sitename = "Театр";

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$mail = trim($_POST["mail"]);
$text = trim($_POST["message"]);

$pagetitle = "Нове повідомлення з сайту Театр \"$sitename\"";
$message = "Ім'я: $name \nТелефон: $phone \nEmail: $mail \nПовідомлення: $text";
mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");