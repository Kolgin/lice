
    <div class="container_s">
        <div class="inside">
            <div class="container_sm-st">
                <div class="catalog_content search_content">
                    <div class="f_l">
                        <div class="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                            <div class="f-s_16">Результаты поиска по запросу <b>"<?=$app -> module -> search?>"</b>:</div>
                        </div>
                        <ul class="items items_middle">
                            <?=$app -> module -> view_product($app -> module -> product)?>
                        </ul>
                        <div class="pagination">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow_inside"></div>
    </div>