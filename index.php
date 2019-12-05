<?php
// this file is for saving the messages we get from the client 
// the php code in this project was made entirely by @sanjaykdragon
// client code: https://repl.it/@sanjaykdragon/pychatroom
include "funcs.php";

//make sure they are sending a valid get request
if(!isset($_POST["user"]) || !isset($_POST["message"]) || !isset($_POST["index"]) || !isset($_POST["password"]))
  die();

$file = fopen("users.txt", "r") or die("failed to read users.txt");
$count = 0;
while(!feof($file))
{
  if($count != (int)$_POST["index"])
  {
      $count++;
      continue;
  }
  $cur_line = fgets($file);
  $cur_line_json = json_decode($cur_line, true);
  if(strtolower($_POST["user"]) == $cur_line_json["user"])
  {
      if(password_verify($_POST["password"], $cur_line_json["password"]))
      {
        $color = "white";
        if($cur_line_json["is_admin"] == true)
            $color = "blue";
        
        //create an array with user info
        $msg_as_array = array("time" => "[" . date("m/d h:i:s") . "]", "user" => $_POST["user"], "message" => $_POST["message"], "color" => $color);
        //json encode the array above and write it to file
        append(json_encode($msg_as_array), "messages.txt");
      }
  }
}
fclose($file);
?>
