<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 15.06.2015
 * Time: 15:12
 */

class Main extends Module{
    public $module = "Main";
    public $catalog;
    public $brand;
    public $title;
    public $description;
    public $keywords;

    function __construct(){
        parent::__construct();

        $this -> catalog = $this -> get_catalog();
        $this -> brand = $this -> get_brands();
        parent::template('slider_main', 'sliderBrend_main', 'catalog_main');
    }

    private function get_catalog(){
        $categories = array();
        $result = App::$db -> query("
				SELECT * FROM categories WHERE parent_id = 0
			");
        $result -> setFetchMode(PDO::FETCH_ASSOC);

        while($category = $result->fetch()) {
            $categories[] = $category;
        }
        foreach($categories AS $cat){
            $res = App::$db -> query("
		      		SELECT * FROM categories WHERE parent_id = '".$cat['id']."'
		      	");
            $res -> setFetchMode(PDO::FETCH_ASSOC);

            for($i = 0; $i < $res -> rowCount();$i++){
                $row = $res->fetch();
                $categories[$row['parent_id']][] = $row;
            }
        }
        return $categories;
    }

    private function get_brands(){
        $result = App::$db -> query("
				SELECT * FROM brands
			");
        $result -> setFetchMode(PDO::FETCH_ASSOC);

        while($brand = $result->fetch()) {
            $brands[] = $brand;
        }
        return $brands;
    }


    public function view_catalog($arr,$parent_id = 0){
        for($i = 0; $i < count($arr);$i++) {
            echo '
            <li >
        <div >
            <a class="water_b cat_img" href = "?module=Category/' .$arr[$parent_id][$i]['title'].'" >
                <span >' .$arr[$parent_id][$i]['title'].'</span >
            </a >
            <ul >
                ' .$this -> view_dcatalog($arr,$arr[$parent_id][$i]['id']). '
            </ul >
            <a href = "index.php/#" class="all_show t-d_n up" ><span class="d_l_g" > Все категории </span ></a >    </div >
    </li >
            ';
            }
    }

    public function view_dcatalog($arr,$parent_id = 0){
        for($i = 0; $i < count($arr);$i++) {


            echo '
                <li ><a href = "?module=Category/' . $arr[$parent_id][$i]['title'] . '" >' . $arr[$parent_id][$i]['title'] . '</a ></li >

                ';
        }
    }

    public function view_brand($arr){
        echo '<ul style="margin: 0px; padding: 0px; position: relative; list-style-type: none; z-index: 1; width: 4080px; left: -850px;">';
        for($i = 0; $i < count($arr); $i++){
            echo '
            <li style="overflow: hidden; float: left; width: 170px; height: 32px;">
                <a href="?module=Brands/' .$arr[$i]['id'].'""><img src="/images/brands/' . $arr[$i]['img'] . '" alt="' . $arr[$i]['title'] . '"></a>
            </li>
                ';
        }
        echo '</ul>';
    }

}