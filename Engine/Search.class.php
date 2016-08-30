<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 07.07.2015
 * Time: 14:52
 */

class Search extends Module{
    public $module = "Search";
    public $description;
    public $keywords;
    public $search;
    public $product;

    function __construct($str){
        parent::__construct();

        $this -> search = $str;
        $this -> product = $this -> get_product($str);
        parent::template('search');
    }

    /**
     * @param $str
     * @return array
     */
    private function get_product($str){
        $result = App::$db -> query("
                            SELECT * FROM product WHERE title LIKE '%" .$str. "%'");
        $result -> setFetchMode(PDO::FETCH_ASSOC);

        while($category = $result->fetch()) {
            $product[] = $category;
        }
        return $product;
    }

    /**
     * @param $arr
     */
    public function view_product($arr){
        if(!empty($arr)){
            for($i = 0; $i < count($arr);$i++) {
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

                                        ' .$this -> get_status($arr[$i]['status']). '
                                        <button class="but_buy_m f_l goBuy" name="button buy" type="submit" value="' .$arr[$i]['id']. '">
                                            <span>В корзину</span>
                                        </button>

                                    </div>
                                    <p>
                                    </p>
                                </div>
                                <a href="?module=Product/' .$arr[$i]['id']. '" class="photo_block f_l">
                                    <figure>
                                        <img src="/images/product/' .$arr[$i]['img']. '_small.jpg">
                                    </figure>
                                </a>
                            </li>
                ';
            }
        }
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
}