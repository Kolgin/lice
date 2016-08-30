<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 03.07.2015
 * Time: 1:12
 */

class Basket extends Module {
    public $module = "Basket";
    public $title;
    public $description;
    public $keywords;
    public $product;


    function __construct($id = NULL){
        parent::__construct();


        $this -> product = $this -> get_Product();


        $this -> checkout(
                $_POST['quantity'], $_POST['idProduct'], App::POST('fullName'), App::POST('phone'), App::POST('email'), App::POST('addres'), App::POST('commentText'), App::POST('deliveryMethodId'), App::POST('paymentMethodId')
            );


        if(App::GET('thank')) {
            echo "<script>alert('Спасибо, заказ принят')</script>";
        }

        if(isset($id)){
            $this -> dell_Product($id);
        }
    }


    /**
     * @return array
     */
    private function get_Product(){
        if(!empty($_COOKIE['Cookie'])) {
            foreach ($_COOKIE['Cookie'] AS $name => $value) {
                $value = htmlspecialchars($value);

                $sql = App::$db -> query("
                        SELECT id, title, price_g, price_d, img FROM product WHERE id = '" . $value . "'"
                );
                $sql -> setFetchMode(PDO::FETCH_ASSOC);

                if ($sql -> rowCount() != 0) {
                    for ($i = 0; $i < $sql -> rowCount(); $i++) {
                        $row = $sql -> fetch();
                        $product[] = $row;
                    }
                }
            }
            parent::template('basket');
        }else{
            parent::template('no_basket');
        }
        return $product;
    }

    /**
     * @param $arr
     */
    public function view_product($arr){
        if(empty($arr)) {
            return;
        }

        for($i = 0; $i < count($arr);$i++) {

            echo '
                    <tr>
                                                <td>
                                                    <ul class="items items_small">
                                                        <li>
                                                            <div class="description f_r">
                                                                <div class="d_t-c">
                                                                    <a href="?module=Product/' .$arr[$i]['id']. '">' .$arr[$i]['title']. '</a>
                                                                    <div class="price-f-s_14"><span class="grn">' .$arr[$i]['price_g']. ' грн.</span><span class="dol">' .$arr[$i]['price_d']. ' $</span></div>
                                                                </div>
                                                            </div>
                                                            <a href="?module=Product/' .$arr[$i]['id']. '" class="photo_block">
                                                                <figure>
                                                                    <img src="/images/product/' .$arr[$i]['img']. '_small.jpg" alt="">
                                                                </figure>
                                                            </a>
                                                            <a href="?module=Basket/' .$arr[$i]['id']. '" class="icon delete"></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="t-a_c">
                            <span class="d_i-b count">
                                <input onchange="total_score()" name="quantity[]" type="text" value="1"><span>шт.</span>
                                <input type="hidden" name="idProduct[]" value="' .$arr[$i]['id']. '">
                            </span>
                                                </td>
                                                <td>
                                                    <div class="price-f-s_30"><span class="grn">' .$arr[$i]['price_g']. ' грн.</span><br><span class="dol">' .$arr[$i]['price_d']. ' $</span></div>
                                                </td>
                                            </tr>
            ';
        }
    }

    public function view_priceProduct($arr){
        for($i = 0; $i < count($arr);$i++) {
            $grn += $arr[$i]['price_g'];
            $dol += $arr[$i]['price_d'];
        }
            echo '
            <span class="grn d_b">
            <span class="f-w_b" style="font-size:26px;color:#666666;">К оплате:</span>
            <span class="total_score">' .$grn. '</span> грн.
        </span>
        <span class="dol">
            <span class="val_sum">' .$dol. '</span>
            <span class="pointer"><span class="d_l_r">$</span><span class="icon arrow_red_b"></span></span>
        </span>
                ';
    }

    /**
     * @param $id
     */
    private function dell_Product($id){
        setcookie ("Cookie[$id]", "", time() - 3600);
        header('location: index.php?module=Basket');
        return;
    }

    /**
     * @param $fullName
     * @param $phone
     * @param $email
     * @param $addres
     * @param $commentText
     * @param $deliveryMethodId
     * @param $paymentMethodId
     * @param $sumGr
     * @param $sumDol
     * @array $quantity
     */
    private function checkout($quantity, $idProduct, $fullName, $phone, $email, $addres, $commentText, $deliveryMethodId, $paymentMethodId){
        if(isset($_POST['goToPay'])) {
            $datetime = date("Y-m-d H:i:s");
            $errors = array();

            if (empty($fullName)) {
                $errors[] = 'имя';
            }
            if (empty($phone)) {
                $errors[] = 'телефон';
            }


            if (count($errors) > 0) {
                parent::showErrors($errors, 'Заполните ');

            } else {

               for($i = 0; $i < count($quantity); $i++){
                   for($i = 0; $i < count($idProduct); $i++){
                       $sql = App::$db->query("
                                INSERT INTO orders (quantity, product_id)
			                    VALUES ('$quantity[$i]', '$idProduct[$i]')
			                    ");
                   }
               }


                $sql = App::$db->query("
                                INSERT INTO order_client (name, telephone, email, adr, comment, export_method, payment_method, datetime)
			                    VALUES ('$fullName', '$phone', '$email', '$addres', '$commentText', '$deliveryMethodId', '$paymentMethodId', '$datetime')
			                    ");
                if ($sql) {
                    setcookie ("Cookie", "", time() - 3600);
                    header('location: index.php?module=Basket&thank=1');
                }
            }
        }
    }

}