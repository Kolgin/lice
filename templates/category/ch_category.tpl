<script type="text/javascript" src="/js/imagecms.filter.js"></script>
<script type="text/javascript" src="/js/jquery.ui-slider.js"></script>



    <div class="container_s">

        <div class="inside">
            <div class="container_sm-st">
                <div class="catalog_content">
                    <div class="f_l">
                        <div class="block_d-i">
                            <input class="helper">
                            <h1><?=$app -> module -> category?></h1>
                        </div>

                        <form name="sort" method="POST" action="">
                            <div class="f_l f-s_12em sort">
                                <input class="helper">
                                <span>Сортировать:</span>
                                <span class="pointer"><span class="d_l_r">По цене</span><span class="icon arrow_red"></span></span>
                                    <span class="drop sort_current">
                                        <span>Сначала дешевые<input type="submit" value="" name="order_price"></span>
                                        <span>Сначала дорогие<input type="submit" value="" name="order_price_desc"></span>
                                    </span>
                            </div>
                        </form>

                        <form name="product" method="POST" action="">
                            <ul class="items items_middle">
                                <?php $app -> module -> view_product($app -> module -> product); ?>
                            </ul>
                        </form>
                        <div class="shadow_catalog"></div>
                    </div>
                    <div class="right_inside">
                        <div class="action_block">
                            <div class="title_h2">Акционные товары</div>
                            <ul class="items items_small">
                                <?php $app -> module -> view_sale($app -> module -> sale); ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="left_inside">

                    <div class="block_filter p_0">
                        <div class="title title_first">Тип</div>
                        <div class="padding_filter">
                            <div id="typecat">
                                <?php $app -> module -> view_padding_category($app -> module -> categories); ?>
                            </div>
                        </div>
                    </div>


                    <form name="sortPrice" method="POST" action="">

                        <div class="block_filter">
                            <div class="title">Цена</div>
                            <div class="sliderCont">
                                <div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" id="left_slider" style="left: 0%;"></a>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" id="right_slider" style="left: 50%;"></a>
                                    <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 80%;"></div></div>
                            </div>
                            <?php
                            foreach($app -> module -> price as $sort) {
                            echo '
                            <div class="formCost">
                                <label class="f_l">
                                    от
                                    <input type="text" id="minCost" value="' .$sort['pricemin']. '" name="pricemin">
                                </label>
                                <label class="f_r">
                                    до
                                    <input type="text" id="maxCost" value="' .$sort['pricemax']. '" name="pricemax">
                                </label>
                                <button type="submit" ><span>Поиск</span></button>
                            </div>
                            ';
                            }
                            ?>
                        </div>
                    </form>


                    <div class="block_filter filter_ajax_checks">
                        <form name="sortBrand" method="POST" action="">
                            <div class="padding_filter check_frame">
                                <div class="title">Бренды</div>
                                <?php $app -> module -> view_categoryBrandSort($app -> module -> brands); ?>
                                <button type="submit"><span>Поиск</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow_inside"></div>