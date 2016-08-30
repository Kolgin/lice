<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 15.07.2015
 * Time: 20:42
 */

class Brands extends Module{
    public $module = 'Brands';
    public $brand;
    public $title;
    public $description;
    public $keywords;
    public $products;

    function __construct($id){
        parent::__construct();

        if(empty($id) or !is_numeric($id)){
            parent::page_404();
        } else {
            $this->brand = $this->get_brand($id);
            $this->products = $this->get_brandProduct($id);
        }
    }

    private function get_brand($id){
        $result = App::$db -> query("
				SELECT * FROM brands WHERE id = '" .$id."'
			");
        if($result -> rowCount() != 0) {
            $result->setFetchMode(PDO::FETCH_ASSOC);

            while ($brand = $result->fetch()) {
                $brands[] = $brand;
            }
            parent::template('brands');
        }
        return $brands;
    }

    private function get_brandProduct($id){
        $result = App::$db -> query("
				SELECT * FROM product WHERE id_brand = '" .$id."'
			");
        if($result -> rowCount() != 0) {
            $result->setFetchMode(PDO::FETCH_ASSOC);

            while ($brand = $result->fetch()) {
                $product[] = $brand;
            }
            parent::template('brands');
        }
        return $product;
    }

    public function view_brandProduct($arr){
        for($i = 0; $i < count($arr[$i]);$i++){
            echo '
                            <li>
                                <div class="description f_r">
                                    <a href="?module=Product/' .$arr[$i]['id']. '">' .$arr[$i]['title']. '</a>
                                    <div class="f_l">
                                        <div class="price-f-s_24 clearfix">
                                            <span class="grn">' .$arr[$i]['price_g']. ' грн.</span><br>
                                            <span class="dol">
                                                <span class="val_sum ">' .$arr[$i]['price_d']. '</span>
                                                <span class="pointer"><span class="d_l_r">$</span><span class="icon arrow_red"></span></span>
                                        </span>
                                        </div>
                                            <button class="but_buy_m f_l goBuy" type="submit" name="button" value="' .$arr[$i]['id']. '"><span>В корзину</span></button>
                                        <button class="but_order_b f_l goCart d_n_">
                                            <span><span>Оформить заказ</span><span>товар уже в корзине</span></span>
                                        </button>
                                        <span class="pointer f_l-c_l toCompare" data-prodid="' .$arr[$i]['id']. '"><span class="icon add_to_c"></span><span class="d_l_r f-s_11em">Добавить к сравнению</span></span>
                                        <a href="?module=Compare/' .$arr[$i]['id']. '" class="f_l-c_l compare_this d_n_ f-s_10"><span class="icon add_to_c"></span><span class="f-s_11">Сравнить</span></a>
                                    </div>
                                </div>

                                <a href="?module=Product/' .$arr[$i]['id']. '" class="photo_block f_l">
                                    <figure>
                                        <img src="/images/product/' .$arr[$i]['price_d']. '_small.jpg" alt="' .$arr[$i]['title']. '">
                                    </figure>

                                </a>
                            </li>
            ';
        }
    }

}