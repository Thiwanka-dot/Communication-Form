<?php
session_start();

date_default_timezone_set('Asia/Colombo');

if(isset($_SESSION['name'])){
    if(isset($_POST['text'])) {
        $text = htmlspecialchars($_POST['text']);
        $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".$text."<br></div>";
        file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
    }
}
?>
