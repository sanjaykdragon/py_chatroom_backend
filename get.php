<?php
//give us all the messages from messages.txt 

if(!isset($_POST["user"]))
    die(); //invalid username

die(file_get_contents("messages.txt"));
?>
