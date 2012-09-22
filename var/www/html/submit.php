<?php

function isStringAllowed($input) {
  $allowed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
  $chars = str_split($input);
  for($i=0;$i<count($chars);$i++){
    if(strstr($allowed, $chars[$i]) == false ) {
      echo $chars[$i] . "<br/>";
      return false;
    }
  }
  return true;
}

function getArg($argname) {
  if (empty($_POST[$argname])) {
    echo "no $argname";
    return "";
  } else {
    $arg = $_POST[$argname];
    if (!(isStringAllowed($arg))) {
      echo "illegal character in $argname";
      return "";
    }
  }
  return $_POST[$argname];
}

$name = getArg("name");
if (empty($name)) {return;}

$password = getArg("password");
if (empty($password)) {return;}

$passwordverify = getArg("passwordverify");
if (empty($passwordverify)) {return;}


ob_start();
exec("/usr/bin/id $name", $output);
$str = trim(implode($output));
if (strlen($str) > 0 ) { ob_clean(); echo 'account name already taken, please <a href="/">try again</a> with a different acccount name'; return;}
ob_clean();
if (strcmp($password, $passwordverify) != 0) {echo "password and passwordverify do not match, please try again."; return; }


if (empty($_POST["email"])) {
  echo "no email";
  return;
} else {
  $email = $_POST["email"];
}

$myFile = "/usr/local/etc/tarbackup/userstocreate.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
$stringData = $name . ":" . $password . ":" . $email . "\n";
fwrite($fh, $stringData);
fclose($fh);

echo "user '$name' registered. it may take up to 5 minutes for your account to be created.";

?>