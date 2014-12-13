(function ($) {
$.fn.hasAttr = function(name) {  
   return this.attr(name) !== undefined;
};
   $('#headerbar-custom').css({ opacity: '0.0' }).animate({ opacity: '1.0' }, 100);

   var topiclist = $(".topiclist").filter(function(index){
        return $(this).parents('div.forabg').prev().hasAttr('status');
    });
    $(topiclist).each(function () {
        $(this).before(function () {
        var post_block = $(this).parents('div.forabg').prev();
            var forum_id = $(post_block).attr('id').replace(/cat/g, '');
            var cat_status = $(post_block).attr('status');
 
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
        return $(this).parents('div.forabg').prev().hasAttr('status');
    });
      $(collapsethis).each(function () {
            var post_block = $(this).parents('div.forabg').prev();
            var forum_id = $(post_block).attr('id').replace(/cat/g, '');
            var cat_status = parseInt ( $(post_block).attr('status'));
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
        var user_id = $(post_block).attr('user_id');

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
        var path = './app.php/CollapseCategories/' + forum_id + '/' + status + '/' +  user_id;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: path,
   
        });

    });

})(jQuery);