(function ($) {
$.fn.hasAttr = function(name) {  
   return this.attr(name) !== undefined;
};

        //****************
var id_arr;
$().ready(function () {
/*    
    if (S_ID_ARR != '')
{
    id_arr = S_ID_ARR.split(',');
    console.log(id_arr);
    id_arr.forEach(function(item, index) {
        var id = item.trim();
        var parentId = 'clps_' + id;
        $("#"+ id).wrap('<div id="' +  parentId + '"class="collapsethis"  data-status="0" aria-hidden="false"></div>');
        
     }); 
     alert('1');
     return;
     var blockParent = $("#"+ id).filter(function(index){
        return $(this).parent().hasAttr('data-status');
    });
    $(blockParent).each(function () {
        var block_status = $(this).attr('data-status');
        if (parseInt(block_status) == 0)
            return '<div class="collapsetrigger collapseactive" ></div>';
        else
            return '<div class="collapsetrigger collapseinactive" ></div>';
//        $(this).before(function () {
////        var post_block = $(this).parents('div.forabg').prev();
//            var forum_id = $(post_block).attr('id').replace(/cat/g, '');
//            var cat_status = $(post_block).attr('data-status');
// 
//            if ($(this).hasClass('topics') || $(this).hasClass('forums'))
//            {
//                if (parseInt(cat_status) == 0)
//                    return '<div class="collapsetrigger collapseactive" ></div>';
//                else
//                    return '<div class="collapsetrigger collapseinactive" ></div>';
//            }
//        });
    });

//    $("ul.topics").wrap('<div class="collapsethis" aria-hidden="false"></div>');
//    $("ul.forums").wrap('<div class="collapsethis" aria-hidden="false"></div>');
    
<!--<div id="cat486" data-status="0" data-user_id="54"></div>-->    
    
    
    
}
    
*/    
});
        //*****************
  // $('#headerbar-custom').css({ opacity: '0.0' }).animate({ opacity: '1.0' }, 100);

    if (S_CATEGORIES_COLLAPSEBALED)
    {
   var topiclist = $(".topiclist").filter(function(index){
        return $(this).parents('div.forabg').prev().hasAttr('data-status');
    });
    $(topiclist).each(function () {
        $(this).before(function () {
        var post_block = $(this).parents('div.forabg').prev();
            var forum_id = $(post_block).attr('id').replace(/cat/g, '');
            var cat_status = $(post_block).attr('data-status');
 
            if ($(this).hasClass('topics') || $(this).hasClass('forums'))
            {
                if (parseInt(cat_status) == 0)
                    return '<div class="collapsetrigger collapseactive" ></div>';
                else
                    return '<div class="collapsetrigger collapseinactive" ></div>';
            }
        });
    });

    $("ul.topics").wrap('<div class="collapsethis" aria-hidden="false"></div>');
    $("ul.forums").wrap('<div class="collapsethis" aria-hidden="false"></div>');

      var collapsethis = $(".collapsethis").filter(function(index){
        return $(this).parents('div.forabg').prev().hasAttr('data-status');
    });
      $(collapsethis).each(function () {
            var post_block = $(this).parents('div.forabg').prev();
            var forum_id = $(post_block).attr('id').replace(/cat/g, '');
            var cat_status = parseInt ( $(post_block).attr('data-status'));
            if (cat_status >0)
            {
            var collapse_block = $(this).parents('div.forabg').find('.collapsethis');
            var unread = $(collapse_block).find('dl').filter(function(index){
                return $(this).hasClass('forum_unread') ||$(this).hasClass('forum_unread_subforum');
                });
            if (unread.length >0)
            {
                var cat = $(this).parents('div.forabg').find('.header').find('a');
                //var catHidden = $(this).parents('div.forabg').find('.collapseinactive');
               // console.log(catHidden);
                $( "<div class='collapse-unread_post' title='" + COLLAPSE_CATEGORIES_UNREAD_POST + "'></div>" ).insertBefore(cat );
            }
            $(collapse_block).attr('aria-hidden', 'true').hide();
          }


    });



    var active      = "collapseactive";
    var inactive    = "collapseinactive";




    $('.collapsetrigger').click(function () {

        var status;
        var post_block = $(this).parents('div.forabg').prev();
        var forum_id = $(post_block).attr('id').replace(/cat/g, '');
        var user_id = $(post_block).attr('data-user_id');

        var unread_div = $(this).parents('div.forabg').find('.collapse-unread_post');
        console.log(unread_div);
        if ($(this).next().attr('aria-hidden') == "false") 
        {
            var collapse_block = $(this).parents('div.forabg').find('.collapsethis');
            var unread = $(collapse_block).find('dl').filter(function(index){
                return $(this).hasClass('forum_unread') ||$(this).hasClass('forum_unread_subforum');
                });
            if (unread.length >0)
            {
                var cat = $(this).parents('div.forabg').find('.header').find('a');
                $( "<div class='collapse-unread_post' title='" + COLLAPSE_CATEGORIES_UNREAD_POST + "'></div>" ).insertBefore(cat );
            }

            status = 1;
            $(this).next().attr('aria-hidden', 'true');
            $(this).next().slideUp(500);
            $(this).removeClass(active);
            $(this).addClass(inactive);
        } else 
        {
             $(unread_div).remove();
            status = 0;
            $(this).next().attr('aria-hidden', 'false');
            $(this).next().slideDown(500);
            $(this).removeClass(inactive);
            $(this).addClass(active);
        }
        var path = './app.php/collapsecategories/' + forum_id + '/' + status + '/' +  user_id;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: path,
   
        });

    });
}/*if (S_CATEGORIES_COLLAPSEBALED)*/

// alert('3');
 console.log($('[id^="clps_"]'));
    if (S_ID_ARR != '')
{
//   id_arr.forEach(function(item, index) {
//        var id = item.trim();
//        var parentId = id + '_' + 'clps';
//  alert('2');
 console.log($('[id^="clps_"]'));
     var blockParent = $('[id^="clps_"]').filter(function(index){
        return $(this).hasAttr('data-status');
        //console.log(this);
    });
    console.log(blockParent);
//    return;
//alert('5')
    $(blockParent).each(function () {
    console.log(this);
        var block_status = $(this).attr('data-status');
        console.log('block_status=' + block_status);
//        if (parseInt(block_status) == 0)
//            return '<div class="collapsetrigger collapseactive" ></div>';
//        else
//            return '<div class="collapsetrigger collapseinactive" ></div>';
//        $(this).before(function () {
////        var post_block = $(this).parents('div.forabg').prev();
//            var forum_id = $(post_block).attr('id').replace(/cat/g, '');
//            var cat_status = $(post_block).attr('data-status');
// 
//            if ($(this).hasClass('topics') || $(this).hasClass('forums'))
//            {
//                if (parseInt(cat_status) == 0)
//                    return '<div class="collapsetrigger collapseactive" ></div>';
//                else
//                    return '<div class="collapsetrigger collapseinactive" ></div>';
//            }
//        });
    });

//    $("ul.topics").wrap('<div class="collapsethis" aria-hidden="false"></div>');
//    $("ul.forums").wrap('<div class="collapsethis" aria-hidden="false"></div>');
    
<!--<div id="cat486" data-status="0" data-user_id="54"></div>-->    
    
    
    
}

$('.collapsetrigger-custom').click(function () {
//alert('6')
    console.log(this);
    var button_id = $(this).attr('id');
    var id = button_id.replace('clps_', '' );
    var icon_id = 'icon_' + id;
    var status = $(this).attr('data-status');
    var txt_toggle;
    var icon_class;
//    $.each(collapse_blocks_arr, function( index, item ) {
    var collapse_blocks_arr = $.parseJSON(S_COLLAPSE_BLOCKS);
    var blockInfo = $(collapse_blocks_arr).filter(function(index, item){
        return item.block_id.trim() == id;
        //console.log(this);
    });
    blockInfo = $(blockInfo).first()[0];
    console.log(blockInfo);
    txt_toggle;
    var new_status;
    if (parseInt(status) == 0)
    {
        //hide block
        new_status = 1;
        txt_toggle = blockInfo.text_open ;
        icon_class = "fa-eye";
        $("#" + id).hide();
        
        
    }
    else
    {
        //show block
        new_status = 0;
        txt_toggle = blockInfo.text_close;
        icon_class = "fa-eye-slash";
        $("#" + id).show();
        
    }
    $('#' + icon_id).removeClass('fa-chevron-up').removeClass('fa-chevron-down').addClass(icon_class);
    $(this).attr('data-status', new_status).html(txt_toggle);
    //save status-block
    localStorage.setItem(id, new_status);
    
});
})(jQuery);