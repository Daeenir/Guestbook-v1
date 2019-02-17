<?php
$message = [];
if (isset($_POST['namn'])) {
  $ok = TRUE;
  $namn = strip_tags($_POST['namn']);
  $namn = str_replace('#;', '', $namn);
  if (empty($_POST['namn'])) {
    $message[] = 'Du har inte angett något namn.';
    $ok = FALSE;
  }
}
else {
  $namn = '';
}
if (isset($_POST['rubrik'])) {
  $ok = TRUE;
  $rubrik = strip_tags($_POST['rubrik']);
  $rubrik = str_replace('#;', '', $rubrik);
  if (empty($_POST['rubrik'])) {
    $message[] = 'Du har inte angett någon rubrik.';
    $ok = FALSE;
  }
}
else {
  $rubrik = '';
}
if (isset($_POST['text'])) {
  $text = strip_tags($_POST['text']);
  $text = str_replace('#;', '', $text);
  if (empty($_POST['text'])) {
    $message[] = 'Du måste skriva något i ditt inlägg.';
    $ok = FALSE;
  }
}
else {
  $text = '';
}
if (isset($_POST['email'])) {
  $email = strip_tags($_POST['email']);
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  }
  else {
    $ok = FALSE;
    $message[] = 'Din mailaddress är inte giltig.';
  }
}
else {
  $email = '';
}
$tal = mt_rand(3, 10);

if (isset($_POST['captcha'])) {
  $summa = 5 + $_POST['correct'];
  if ($_POST['captcha'] == $summa) {
  }
  else {
    $ok = FALSE;
    $message[] = 'Du kan inte räkna.';
  }
}
if (isset($ok)) {
  $fil = file_get_contents('input.txt');
  $arr = explode('\!/', $fil);
  for ($i = 0; $i <= count($arr); $i++) {
  }
  if ($ok == TRUE) {
    $input = str_replace('\!/', '', $text);
    $input = str_replace('#;', '', $text);
    file_put_contents('input.txt', $i . '#;' . $rubrik . '#;' . $namn . '#;' . $email . '#;' . nl2br($input) . '#;' . date("Y-m-d") . ', ' . date("H:i:s") . '\!/', FILE_APPEND);
    header('location: gb.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style1.css"/>
    <title>Gästbok</title>
</head>

<body>

<?php
for ($i = 0; $i < count($message); $i++) {
  echo '<div class="error"><h3>' . $message[$i] . '</h3></div>';
}
echo '<fieldset><legend>Gör ditt inlägg här</legend>
<form method="post">
<div class="box">
	<h3>Rubrik:</h3> <input type="text" placeholder="Rubrik" name="rubrik" maxlength="20" value="' . $rubrik . '"><br>
	<h3>Namn:</h3> <input type="text" placeholder="Förnamn Efternamn" maxlength="30" name="namn" value="' . $namn . '"><br>
	<h3>Email:</h3> <input type="text" placeholder="Email" maxlength="40" name="email"' . $email . '></div>
	<div class="box">
	<h3>Inlägg:</h3> <textarea placeholder="Skriv något" maxlength="400" name="text">' . $text . '</textarea><br>
	<h3>Lägg ihop 5 och ' . $tal . '</h3><input type="text" placeholder="Visa att du kan räkna" name="captcha">
	<input type="hidden" name="correct" value="' . $tal . '">
	<input type="Submit" name="Submit" value="Skicka"></div>
</form></fieldset>';

echo '<h2 id="text">Tidigare Inlägg</h2>';
$fil = file_get_contents('input.txt');
if (empty($fil)) {
  echo '<div class="listbox"><h2 class="rubrik">Det finns inga inlägg än.</h2>';
}
else {
  $arr1 = explode('\!/', $fil);
  rsort($arr1);
  for ($i = 0; $i < (count($arr1) - 1); $i++) {
    $row = explode('#;', $arr1[$i]);
    echo '<div class="listbox"><h2 class="rubrik">' . $row[1] . '</h2><br>Inlägg av: ' . '<b>' . $row[2] . '</b>   ' . $row[5] . '<br> E-mail: <a href="mailto:' . $row[3] . '">' . $row[3] . '</a><br><p class="message">' . $row[4] . '</p></div>';
  }
}

?>
</body>
</html>