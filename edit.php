<html>
<head>
    <meta charset="utf-8">
    <title>Библиотека</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>

<?php
$db = @mysqli_connect('localhost', 'root', '', 'knigi') or die ('Ошибка соединения с БД');
if (!$db) die(mysqli_connect_error());
mysqli_set_charset($db, "utf8") or die ('Не установлена кодировка');
if ($_GET['ed'] == 1) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo "<form method=\"POST\" action=\"edit.php?id=$id\">";
    }
else
    echo "<form method=\"POST\" action=\"edit.php\">";
    $resu = mysqli_query($db, "SELECT * FROM izdat
                ORDER BY izdatn");
    $resul = mysqli_query($db, "SELECT * FROM avtor ORDER BY fname");
    echo "<p><input type='text' name='books'> Название книги</p>
<p><select name='izd'>";
    while ($lne = mysqli_fetch_array($resu, MYSQLI_ASSOC)) {
        $ida = $lne['idizdat'];
        echo "<option value=\"$ida\">" . $lne['izdatn'] . "</option>";
    }
    echo "</select>Издательство</p>
      <p><input type='text' name='godv'> Год издания</p>
      <p><input type='text' name='kolvostr'> Кол-во страниц</p>
      <p><input type='checkbox' name='ilus'> Иллюстрации</p>
      <p><select name='avt'> ";
    while ($lie = mysqli_fetch_array($resul, MYSQLI_ASSOC)) {
        $idi = $lie['idab'];
        echo "<option value=\"$idi\">" . $lie['fname'] . " " . $lie['lname'] . " " . $lie['sname'] . "</option> " ;
    }
    echo "</select> Авторы</p>";
    if (isset($_GET['id']))
        echo "<input type='submit' name='ss' value='Изменить' class='btn'></form>";
    else
        echo "<input type='submit' name='ss' value='Добавить' class='btn' ></form>";
}
if ($_GET['ed'] == 2) {
    echo "<form method=\"POST\" action=\"edit.php\">";
    echo "<p><input type='text' name='fname'> Имя автора</p>
<p><input type='text' name='lname'> Фамилия автора</p>
<p><input type='text' name='sname'> Отчество автора</p>
<p><input type='submit' name='sa' value='Добавить' class='btn'></p></form>";
}
if ($_GET['ed'] == 3) {
    echo "<form method=\"POST\" action=\"edit.php\">";
    echo "<p><input type='text' name='izd'> Название издательства</p>
<p><input type='submit' name='si' value='Добавить' class='btn'></p>


</form>";
}
 if ($_POST['ss']){
     $nbook = $_POST['books'];
     $avt = $_POST['avt'];
     $godv = $_POST['godv'];
     $kolvostr = $_POST['kolvostr'];
     $izd = $_POST['izd'];
     $ilus = 0;
     if ($_POST['ilus'] == "on")
         $ilus = 1;
     if (isset($_GET['id'])){
         $id = $_GET['id'];
         $res = mysqli_query($db,'UPDATE knigs SET nbooks=\''.$nbook.'\',god=\''.$godv.'\',str =\''.$kolvostr.'\',ilustr=\''.$ilus.'\',kodi=\''.$izd.'\',koda=\''.$avt.'\' WHERE id = '.$id);
         echo "Запись изменена";

     }

     else
         $res = mysqli_query($db,'INSERT INTO knigs (nbooks, god, str, ilustr, kodi, koda) 
VALUES (\''.$nbook.'\',\''.$godv.'\',\''.$kolvostr.'\',\''.$ilus.'\',\''.$izd.'\',\''.$avt.'\')');
 }
else if ($_POST['sa']){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $sname = $_POST['sname'];
$res = mysqli_query($db,'INSERT INTO avtor (fname, lname, sname) VALUES (\''.$fname.'\',\''.$lname.'\',\''.$sname.'\')');
 }
else if ($_POST['si']){
    $izd = $_POST['izd'];
$res = mysqli_query($db,'INSERT INTO izdat (izdatn) VALUES (\''.$izd.'\')');

}

 
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css.css">
</head>
<body>
<a href='index.php' class='btn'>На главную</a>
</body>
</html>