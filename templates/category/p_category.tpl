    <div class="container_s">
    	<div class="inside">
	        <div class="container_sm-st_2">
	            <h1><?=$app -> module -> category?></h1>
	            <ul class="sub_category f_l">
                    <?php $app -> module -> view_category($app -> module -> categories); ?>
				</ul>

				<div class="right_inside">
                        <a href="?module=Category/Котлы" class="baner_catalog">
                            <figure>
                                <img src="/images/menu/kotel_leb.jpg" alt="banner">
                            </figure>
                        </a>
                    <div class="action_block">
	                    <div class="title_h2">Акционные товары</div>
	                    <ul class="items items_small">
						<?php $app -> module -> view_sale($app -> module -> sale); ?>
						</ul>
						
					</div>
				</div>
			</div>
		</div>
        <div class="shadow_inside"></div>
    </div>