<?php
include "funcs.php";

$file = fopen("users.txt", "r") or die("failed to read users.txt");
$response = array("status" => "failed", "detail" => "");
$count = 0;
while(!feof($file))
{
  $cur_line = fgets($file);
  $cur_line_json = json_decode($cur_line, true);
  if(strtolower($_POST["user"]) == $cur_line_json["user"])
  {
      if(password_verify($_POST["password"], $cur_line_json["password"]))
      {
          $response["status"] = "success";
          $response["detail"] = "logged in.";
          $response["index"] = $count;
          die(json_encode($response));
      }
      else
      {
          $response["detail"] = "wrong password";
          die(json_encode($response));
      }
  }
  $count++;
}
fclose($file);
$response["status"] = "success";
$response["detail"] = "registered new acccount";
$response["index"] = $count + 1;

$account = array("user" => $_POST["user"], "password" => password_hash($_POST["password"], PASSWORD_BCRYPT), "creation_time" => time(), "is_admin" => false);
append(json_encode($account), "users.txt");
die(json_encode($response));
?>
