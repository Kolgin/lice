<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.06.2015
 * Time: 10:52
 */

class Product extends Module{
    public $module = "Product";
    public $title;
    public $description;
    public $keywords;
    public $product;
    public $sale;
    public $id;

    function __construct($str){
        parent::__construct();

        if(App::POST('button buy')){
            $this -> getCookie(App::POST('button buy'));
        }

        if(App::POST('button buy_credit')){
            $this -> getCookie(App::POST('button buy_credit'));
        }


        $this -> sendMessage(
                App::POST('comment_item_id'), App::POST('comment_author'), App::POST('comment_text')
        );

        $this -> product = $this -> get_product($str);
        $this -> sale = $this -> get_sale();
        parent::template('product');
    }

    function get_product($id) {
        $result = App::$db -> query("
                            SELECT * FROM product WHERE id = '" .$id. "'");
        $result -> setFetchMode(PDO::FETCH_ASSOC);


        while($category = $result->fetch()) {
            $product[] = $category;
        }
        return $product;
    }

    private function get_sale(){
        $result = App::$db -> query("
                            SELECT id, title, price_g, price_d, img FROM product WHERE sale = 1");
        $result -> setFetchMode(PDO::FETCH_ASSOC);

        if($result -> rowCount() != 0) {
            while ($category = $result->fetch()) {
                $sale[] = $category;
            }
        }
        return $sale;
    }

    function get_status($status){
        switch ($status){
            case 'Есть в наличии':
                $a = '<div class="product_status_4">' .$status. '</div>'; break;
            case 'Нет в наличии':
                $a = '<div class="product_status_3">' .$status. '</div>'; break;
            case 'Наличие уточняйте':
                $a = '<div class="product_status_1">' .$status. '</div>'; break;
        }
        return $a;
    }


    public function view_sale($arr){
        for($i = 0; $i < count($arr);$i++) {

            echo '
                    <li>
                        <div class="description f_r">
                            <div class="d_t-c">
                                <a href="?module=Product/' .$arr[$i]['id']. '">' .$arr[$i]['title']. '</a>
                                <div class="price-f-s_14"><span class="grn">' .$arr[$i]['price_g']. ' грн</span><span class="dol">' .$arr[$i]['price_d']. ' $</span></div>
                            </div>
                        </div>
                        <a href="?module=Product/' .$arr[$i]['id']. '" class="photo_block">
                            <figure>
                                                                    <img src="/images/product/' .$arr[$i]['img']. '_small.jpg">

                            </figure>
                        </a>
                    </li>
            ';
        }
    }

    private function getCookie($id){
        parent::setCookie($id);
        header("location: index.php?module=Product/' .$id. '");
    }

    private function sendMessage($id, $username, $text){
        if(isset($_POST['button comment'])) {
            $datetime = date("Y-m-d H:i:s");
            $errors = array();

            if (empty($username)) {
                $errors[] = 'имя';
            }
            if (empty($text)) {
                $errors[] = 'текст';
            }
            if (count($errors) > 0) {
                parent::showErrors($errors, 'Заполните ');
            } else {
                $result = App::$db->query("
                                        INSERT INTO comment (id_product, author, text, datetime)
                                        VALUES ('$id', '$username', '$text', '$username', '$datetime')
                                        ");

                $text_mail = "Имя: $username \nПродукт: $id \n\nТекст сообщения:\n$text";
                mail("vovik425@gmail.com", "SeaTuning", $text_mail);

                if ($result) {
                    header("location: index.php?module=Product/' .$id. '");
                }
            }
        }
    }
}