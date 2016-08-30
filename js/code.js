$.exists = function(selector) {
    return ($(selector).length > 0);
}
$.exists_nabir = function(nabir){
    return (nabir.length > 0);
}
var	ie = $.browser.msie,
ieV = $.browser.version,
ltie7 = ie&&(ieV <= 7),
ltie8 = ie&&(ieV <= 8);

$(document).ready(function(){
    $('#category_filter').live("change",function(){
      //  alert($(this).val());
       $(location).attr('href',"/shop/category/"+$(this).val());

        //$(this).parents('form').attr('action',"/shop/category/"+$(this).val()).submit();
    })

    $('.sort_current span').on("click", function(){
        $(this).parent().find('input').attr("value", $(this).data('order'));
        $(this).parents('form').submit();
    })


    $('.formCost input[type="text"], .count input').keypress(function(event){
        var key, keyChar;
        if(!event) var event = window.event;

        if (event.keyCode) key = event.keyCode;
        else if(event.which) key = event.which;

        if(key==null || key==0 || key==8 || key==13 || key==9 || key==46 || key==37 || key==39 ) return true;
        keyChar=String.fromCharCode(key);

        if(!/\d/.test(keyChar))	return false;
    });
    $('.place_hold').each(function(){
        $(this).attr('data-value',$(this).val())
    });
    $('.place_hold').bind({
        focus : function()
        {
            if ($(this).data('value') == $(this).val()){
                $(this).val('');
            }
        },
        blur : function()
        {
            if ($(this).val() == ''){
                $(this).val($(this).attr('data-value'));
            }
        }
    });

    //not_standart_checks----------------------
    if ($.exists('.niceCheck')) {
        $(".niceCheck").each(function() {
            changeCheckStart($(this));
        });
    }
    $(".frame_label > *").click(function() {
        changeCheck($(this).find('> span:eq(0)'));
        $(this).parents('.frame_label').find('input').change();
        return false;
    });
    function changeCheck(el)
    {
        var el = el,
        input = el.find("input");
        if (input.is("[type='checkbox']")){
            active_b_p = '-207px -21px';
            n_active_b_p = '-196px -21px';
        }
        else if (input.is("[type='radio']")){
            active_b_p = '-268px 0';
            n_active_b_p = '-255px 0';
        }
        if(!input.attr("checked")) {
            el.css("background-position", active_b_p);
            el.parent().parent().addClass('active');
            input.attr("checked", true);
        }
        else if(input.is("[type='checkbox']:checked")){
            el.css("background-position", n_active_b_p);
            input.attr("checked", false);
        }
        if(input.is("[type='radio']")) {
            no_check_radio = $("[name="+input.attr('name')+"]").not(':checked').parent();
            no_check_radio.css("background-position", n_active_b_p);
            no_check_radio.parent().parent().removeClass('active');
            no_check_radio.find('input').attr("checked", false);
        }
    //if(!input.is("[type='radio']")) return inp_change(input);
    }
    function changeCheckStart(el)
    {
        var el = el,
        input = el.find("input");
        if (input.is("[type='checkbox']")){
            active_b_p = '-207px -21px';
            n_active_b_p = '-196px -21px';
        }
        else if (input.is("[type='radio']")){
            active_b_p = '-268px 0';
            n_active_b_p = '-255px 0';
        }
        if(input.attr("checked")){
            el.css("background-position", active_b_p);
            el.parent().parent().addClass('active');
            input.attr("checked", true);
        }
        else {
            el.css("background-position", n_active_b_p);
            el.parent().parent().removeClass('active');
            input.attr("checked", false);
        }
        el.removeClass('b_n');
    }
    //close_not_standart_checks----------------------
    /*
    function inp_change(input){
        input = input;
        if($.exists(input.parent().parent().parent(':not(.disabled)'))){
            input.parents('form').find('.filter_ajax_checks').find('.frame_label.active').not(input.parent().parent().parent()).toggleClass('active').find('.apply').stop().hide(200);
            input.parent().parent().parent().addClass('active');
            left = input.parent().parent().outerWidth(true)-3;
            if(!$.exists_nabir(input.parent().parent().parent().find('.apply'))){
                win=input.parent().parent().parent().append("<span class='apply'><span><a href='#'>Показать</a>"+'Найдено <span>'+apply_value+'</span> товаров'+"</span></span>");
                input.parent().parent().parent().find('.apply').stop().show(200);
            }
            else{
                input.parent().parent().parent().find('.apply').stop().show(200);
            }
            win.find('.apply').css('left',left);
        }
    }
     */
    if ($.exists($('.block_filter'))){
        $('.block_filter .frame_label, .block_filter li').each(function(){
            if ($(this).outerWidth() > 110)
            {
                $(this).parent().addClass('one_column');
            }
        });
    }
    $('body').click( function(event) {
        if($(event.target).parents().filter('.active_parent')[0]==undefined){
            $(event.target).find('.active_drop').prev().click();
        }
        if($(event.target).parents().filter('.frame_label.active')[0]==undefined){
            act_frame_lab = $(event.target).find('.frame_label.active');
            if ($.exists_nabir(act_frame_lab.find('.apply'))){
                act_frame_lab.find('input').attr('checked', false).removeAttr('style');
                act_frame_lab.find('.niceCheck').removeAttr('style');
                act_frame_lab.find('.apply').hide();
                act_frame_lab.removeClass('active');
            }
        }
        if($(event.target).parents().filter('.block_filter:eq(1)')[0]==undefined){
            $(event.target).find('.block_filter:eq(1)').find('.apply').hide();
        }
    });
    $('body').keydown(function(event){
        var key, keyChar;
        if(!event) var event = window.event;

        key = event.keyCode;
        if(key==27)
        {
            if ($.exists($('.active_drop'))){
                $('.active_drop').prev().click();
            }
            fr_l_a = $('.frame_label.active');
            if ($.exists_nabir(fr_l_a.find('.apply'))){
                $(fr_l_a).children().click();
                $(fr_l_a).find('.apply').hide();
                $(fr_l_a).removeClass('active');
            }
            slider_apply = $('.block_filter:eq(0)').find('.apply')
            if ($.exists_nabir(slider_apply)){
                slider_apply.hide();
            }
        }
    });
    $('.all_show').click(function(){
        $(this).prev().slideToggle();
        $(this).toggleClass('up');
        return false;
    });
    $('.leave_coment .pointer, .dol .pointer, .sort .pointer').live("click", function(){
        $(this).next().toggle('300').toggleClass('active_drop').end().find('.icon').toggleClass('up').end().parent().toggleClass('active_parent');
    });
    $('.leave_coment > span').live("click", function(){
        $(this).toggleClass('active_b_com');
    });

    time_dur_m = 300;
    $('#nav > li').hover(
        function(){
            $this = $(this).children('div');
            hover_t_o = setTimeout(function(){
                $this.show();
            }, time_dur_m);
        },function(){
            $this = $(this).children('div');
            clearTimeout(hover_t_o);
            $this.hide();
        });

        $('#nav > li:first-child').hover(function(){
            art_h = $('article').outerHeight();
            if (art_h < 20604 ){
                $('article').css('height','700')
            }},
        function(){
            art_h = $('article').outerHeight();
            if (art_h < 20704 ){
                $('article').css('height','auto');
            }
        });


    $('#nav').hover(function(){
        time_dur_m = 0;
    }, function(){
        time_dur_m = 300;
    });

    if ($.exists('#nav')) {
        $('.not-js').removeClass();
    }
    bef = $('.bef');
    bef.each(function(){
        $(this).css('height',$(this).parents('.drop_menu').height());
    })

    function tabs(elem){
        tab_li_a = $(elem);
        tab_li_d_t = tab_li_a.data('tab');
        $('div[data-tab]').hide();
        $('div[data-tab="'+tab_li_d_t+'"]').show();
        tab_li_a.addClass('active');
    }
    tabs( $('.inside .tabs li:eq(0)') );
    $('.inside .tabs li').click(function(){
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        tabs($(this));
    });
   try{
        var params = {
            changedEl: ".lineForm select",
            visRows: 5,
            scrollArrows: true
        }
        cuSel(params);
    }catch(e){}

    if ($.exists($('a[rel="group"]'))){
        $('a[rel="group"]').fancybox({
            'padding' : '70px',
            'margin' : 0,
            'overlayOpacity' : 0.8,
            'overlayColor' : '#060e01',
            'scrolling' : 'no',
            'showNavArrows' : true,
            'onStart' : function(){
                if (ltie8) $('#fancybox-content').css('behavior', 'url(PIE/PIE.htc)');
            }
        })
    }
    //    bugs ie
    if (ltie7){
        $("form").on("keypress", "input,select", function(e){
            if (e.keyCode == 13)
                $("button:first:not(disabled)", this.form).trigger('click');
        });
        $("button:not(disabled)").click(function(){
            $(this).parents('form').submit();
        });
        l_d_w = 0;
        $('.comparison_slider_right').each(function(){
            $(this).find('.list_desire').each(function(){
                l_d_w+= $(this).outerWidth(true)
            });
            $(this).css('width',l_d_w);
            l_d_w = 0;
        })
    }

});
$(window).load(function(){
    if ($.exists($('.baner'))){
        $this = $('.baner ul');
        $this.cycle({
            fx:         'fade',
            timeout:    7000,
            pager:      '.pager',
            pagerAnchorBuilder: function(idx, slide) {
                return '<a href="#"></a>';
            }
        });
    }
    if ($.exists($('#scroll-box'))){
        function scroll_n_n(){
            l_d_w = 0;
            $('#scroll-box li').each(function(){
                l_d_w+= $(this).outerWidth(true);
            });

            $('#scroll-box ul').css('width',l_d_w);
            jsp_hor_scr = $('#scroll-box');
            jsp_hor_scr.jScrollPane({
                'showArrows':true,
                'arrowButtonSpeed':'282'
            });

            jsp_c_h = $('.jspContainer').outerHeight();
            $('#scroll-box').css('height',jsp_c_h)
            w_w_old = $(this).width();
            $(window).resize(function(){
                w_w = $(this).width();
                if (w_w < 1030 || w_w_old < 1030){
                    jsp_hor_scr.jScrollPane({
                        'showArrows':true,
                        'arrowButtonSpeed':'282'
                    });
                }
                w_w_old = $(this).width();
            });
            $('.jspPane').unbind('mousewheel');
        }
        scroll_n_n();

        $('.hit_tabs li').on("click", function(){
            var catid = $(this).data('catid');
            $(this).parent().find('li').removeClass('active');
            $(this).addClass('active');
            $('.jspPane').removeAttr('style');

            $.ajax({
                type: "post",
                data: {
                    catId:catid
                },
                url: '/shop/ajax/getHitCatId',
                beforeSend: function(){
                    //alert(catid);
                    $('#preloader').show();
                },
                success: function(data){
                    $('.item_scroll').html(data);
                    $('#preloader').hide();
                    scroll_n_n();
                }
            });
            return false;
        });
    }

    if ($.exists($('.brands .carusel'))){
        $this = $('.brands');
        visible = 5;
        if ($this.find('li').length <= visible){
            $this.find('.next').hide();
            $this.find('.prev').hide();
            next = prev = '';
        }
        else {
            next = $this.find('.next');
            prev = $this.find('.prev');
        }
        $this.find('.carusel').jCarouselLite({
            btnNext: next,
            btnPrev: prev,
            visible: visible
        });
    }
    if ($.exists($('.complects'))){
        $this = $('.complects');
        visible = 1;
        if ($this.find('li').length <= visible){
            $this.find('.next').hide();
            $this.find('.prev').hide();
            next = prev = '';
        }
        else {
            next = $this.find('.next');
            prev = $this.find('.prev');
        }
        $this.find('.carusel').jCarouselLite({
            btnNext: next,
            btnPrev: prev,
            visible: visible
        });
    }
    jsp_hor = $('.comparison_tovars');
    if ($.exists(jsp_hor)){
        function def_height($this){
            $this = $this;
            h=0;
            li = $this.find('.field_container_character').add($this.find('.comparison_slider_left'));
            if ($.exists_nabir($this.find('.field_container_character')))
            {
                li_i_length = $this.find('.comparison_slider_left').children('span').length;
                li_i_h = new Array();

                for (j = 0; j < li_i_length; j++){
                    li.each(function(index){
                        this_ch = $(this).find('> span:eq('+j+') > span');
                        li_i_h[index] = this_ch.outerHeight();
                        li_i_h[index] > h ? h = li_i_h[index] : h = h;
                    });
                    if (!ltie7){
                        li.find('> span:eq('+j+') > span').css('height',h);
                    }
                    else {
                        if (h < 30) h = 30;
                        li.find('> span:eq('+j+')').css({
                            'height':h
                        })
                    }
                    li_i_h = [];
                    h=0;
                }
            }
        }
        $('.comparison_slider').each(function(){
            max_h=0;
            $this = $(this);
            $this.find('.list_desire .item_scroll').each(function(){
                curr_h = $(this).outerHeight()
                curr_h > max_h ? max_h=curr_h : max_h=max_h;
            });
            $this.find('.list_desire .item_scroll .photo_block').each(function(){
                $(this).next().css('top',$(this).find('span').height()+25);
            });
            $this.find('.list_desire .item_scroll').css('min-height',max_h);
            $this.find('.comparison_slider_left').css('margin-top',max_h+20);
            $this.find('.parameters_compr').css('top',max_h-106);
            def_height($this);
        });
        $(function(){
            jsp_hor.jScrollPane({
                'showArrows':true
            });
        });
    }
});

/*початкові зміні для слайдера*/
def_min=0;
def_max=10000;
cur_min=0;
cur_max=8000;
/**/