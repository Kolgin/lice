<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 29.07.2015
 * Time: 19:50
 */
include_once'../Module.class.php';
$login = 'root';
$password = '';
$host = 'localhost';
$Db = 'site';
$db = connectDB($login, $password, $host, $Db);


function connectDB($login, $password, $host, $db)
{
    try {
        $DBH = new PDO("mysql:host=$host;dbname=$db", $login, $password);
        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        file_put_contents('LogsErrors.txt', $e->getMessage(), FILE_APPEND);
    }
    return $DBH;
}

if($_POST['goToPay']){
    print_r($_POST);
}

function checkout($quantity, $idProduct, $fullName, $phone, $email, $addres, $commentText, $deliveryMethodId, $paymentMethodId){

    $datetime = date("Y-m-d H:i:s");
    $errors = array();

    if(empty($fullName)) {
        $errors[] = 'имя';
    }
    if(empty($phone)) {
        $errors[] = 'телефон';
    }



        //parent::showErrors($errors, 'Заполните ');



        for($i = 0; $i < count($quantity); $i++){
            $sql = App::$db -> query("
                                INSERT INTO orders (quantity, product_id)
			                    VALUES ('$quantity[$i]', '$idProduct[$i]')
			                    ");
        }

        $sql = App::$db -> query("
                                INSERT INTO order_client (name, telephone, email, adr, comment, export_method, payment_method, datetime)
			                    VALUES ('$fullName', '$phone', '$email', '$addres', '$commentText', '$deliveryMethodId', '$paymentMethodId', '$datetime')
			                    ");
        if ($sql) {
            header('location: index.php?module=Basket&thank=1');
        }

}