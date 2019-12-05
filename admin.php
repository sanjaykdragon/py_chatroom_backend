<?php
include "funcs.php";
//handle admin commands

//make sure they sent valid info
if(!isset($_POST["user"]) || !isset($_POST["cmd"]) || !isset($_POST["password"]) || !isset($_POST["index"]))
  die();

$user = $_POST["user"];
$cmd = $_POST["cmd"];
$password = $_POST["password"];
$index = $_POST["index"];

//should probably do some type of serverside auth here, like check passwords and such

$file = fopen("users.txt", "r") or die("failed to read users.txt");
$count = 0;
while(!feof($file))
{
  if($count != $index)
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
          if($cur_line_json["is_admin"] == true)
          {
            //handle the actual command
            if($cmd == "/reset" || $cmd == "/clear")
            {
                $clear_msg = array("time" => "", "user" => "system", "message" => "chat has been cleared.", "color" => "green");
                //system: chat has been cleared.
                file_put_contents("messages.txt", json_encode($clear_msg) . "\n");
                fclose($file);
                die("cleared chat.");
            }
            else
            {
                die("unknown command.");
            }
          }
          else
          {
              fclose($file);
              die("no permissions");
          }
      }
      else
      {
          fclose($file);
          die("invalid password");
      }
  }
}
fclose($file);
die("no permissions");
?>
