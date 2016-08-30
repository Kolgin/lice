
    <div class="container_s">
        <?php
        foreach($app -> module -> brand as $brands) {
        echo '
        <div class="inside">
            <div class="container_sm-st">
                <div class="catalog_content search_content">
                    <div class="f_l">
                        <div class="seo_text text block_brand clearfix">
                            <figure class="f_l">
                                <img src="/images/brands/' .$brands['img']. '" alt="' .$brands['title']. '">
                            </figure>
                            ' .$brands['text']. '

                        </div>

                        <div class="f_l block_d-i">
                            <h2>' .$brands['title']. '</h2><i></i>
                        </div>
                        ';
                        }
                        ?>
                        <form method="POST" action="">
                            <ul class="items items_middle">
                                <?php $app -> module -> view_brandProduct($app -> module -> products); ?>
                            </ul>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="shadow_inside"></div>
    </div>