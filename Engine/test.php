<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 03.07.2015
 * Time: 1:44
 */
header("Content-Type: text/html; charset=utf-8");

$login = 'root';
$password = '';
$host = 'localhost';
$db = 'site';

mysql_connect($host, $login, $password);
mysql_select_db($db);


if($_POST['submit']){
    header('location: index.php?module=Basket&thank=1');


}


?>

<form action="" method="post">
    <span class="title">Телефон<span class="must">*</span></span>
    <span class="frame_title"><input class="required" type="text" name="phone" value=""></span>
    <span class="title">Телефон<span class="must">*</span></span>
    <span class="frame_title"><input  type="submit"  name="submit"></span>
</form>



