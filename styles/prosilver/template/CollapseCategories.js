(function ($) {
	$.fn.hasAttr = function(name) {  
	   return this.attr(name) !== undefined;
	};

	var id_arr;
	$().ready(function () {
	// console.log('qwerty');
	});
  
	if (S_CATEGORIES_COLLAPSEBALED)
	{
	var topiclist = $(".topiclist").filter(function(index){
		return $(this).parents('div.forabg').prev().hasAttr('data-status');
	});
	var active      = "collapseactive";
	var inactive    = "collapseinactive";	
	$(topiclist).each(function () {
		$(this).before(function () {
		var post_block = $(this).parents('div.forabg').prev();
			var forum_id = $(post_block).attr('id').replace(/cat/g, '');
			var cat_status = $(post_block).attr('data-status');

			if ( $(this).hasClass('topics') || $(this).hasClass('forums') )
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
	$(collapsethis).each(function (index, item) 
	{
		var post_block = $(this).parents('div.forabg').prev();
		var cat_status = parseInt ( $(post_block).attr('data-status'));
		var isCat = parseInt ( $(post_block).attr('data-category')) == 1;
		if (cat_status > 0)
		{
			var hasUnread = $(item).find('dl').hasClass('forum_unread')
			||  $(item).find('dl').hasClass('forum_unread_subforum')
			||  $(item).find('dl').hasClass('topic_unread')
			||  $(item).find('a').hasClass('unread');

			if (hasUnread)
			{
				// var cat = $(this).parents('div.forabg').find('.header').find('a');
				var cat = $(this).parents('div.forabg').find('.header');	
				$( "<div class='collapse-unread_post' title='" + COLLAPSE_CATEGORIES_UNREAD_POST + "'></div>" ).insertBefore(cat );
			}
			$(item).attr('aria-hidden', 'true').hide();
		}
	});
	
   	$('.collapsetrigger').click(function () {
		var status;
		var blockInfo;
        var post_block = $(this).parents('div.forabg').prev();
        var forum_id = $(post_block).attr('id').replace(/cat/g, '');
		var custom_block_id = forum_id.replace(/clps_/g, '');
		var user_id = $(post_block).attr('data-user_id');
		var parent = $("#" + forum_id);
		var unread_div = $(this).parents('div.forabg').find('.collapse-unread_post');
		var isCat = parseInt ( $(post_block).attr('data-category')) == 1;
		var block_id = isCat ? forum_id : custom_block_id;
		if (!isCat)
		{
			blockInfo = $(collapse_blocks_arr).filter(function(index, item){
				return item.block_id.trim() == custom_block_id;
			});
			blockInfo = $(blockInfo).first()[0];
		}
		if ($(this).next().attr('aria-hidden') == "false") 
		{
			var collapse_block = $(this).parents('div.forabg').find('.collapsethis');
			var hasUnread = $(collapse_block).find('dl').hasClass('forum_unread')
			||  $(collapse_block).find('dl').hasClass('forum_unread_subforum')
			||  $(collapse_block).find('dl').hasClass('topic_unread')
			||  $(collapse_block).find('a').hasClass('unread');			
			if (hasUnread)
			{
				// var cat = $(this).parents('div.forabg').find('.header').find('a');
				var cat = $(this).parents('div.forabg').find('.header');
				$( "<var isCat = parseInt ( $(post_block).attr('data-category')) == 1;div class='collapse-unread_post' title='" + COLLAPSE_CATEGORIES_UNREAD_POST + "'></div>" ).insertBefore(cat );
			}

			status = 1;
			$(this).next().attr('aria-hidden', 'true');
			$(this).next().slideUp(500);
			$(this).removeClass(active);
			$(this).addClass(inactive);
			if ((isCat && S_COLLAPSECATEGORIES_SAVE_DB != 1))
			{
				closedArray.push(forum_id);
			}
			if(!isCat  )
			{
				if (parent && blockInfo)
				{
					var cutom_icon = $("#icon_" + custom_block_id);
					var cutom_text = $("#text_" + custom_block_id);
					if(blockInfo.icon_close != 0)
					{
						$(cutom_icon).removeClass("fa-chevron-up").addClass("fa-chevron-down");
					}
					$(cutom_text).text(blockInfo.text_close);
				}
				if (S_COLLAPSECATEGORIES_SAVE_DB != 1)
					closedArray.push(custom_block_id);
			}
		} 
		else 
		{
			$(unread_div).remove();
			status = 0;
			$(this).next().attr('aria-hidden', 'false');
			$(this).next().slideDown(500);
			$(this).removeClass(inactive);
			$(this).addClass(active)
			if ((isCat && S_COLLAPSECATEGORIES_SAVE_DB != 1))
			{
				closedArray = $.grep(closedArray, function(value) {
					return value != forum_id;
				});
			}
			if(!isCat  )
			{
				if (parent && blockInfo)
				{
					var cutom_icon = $("#icon_" + custom_block_id);
					var cutom_text = $("#text_" + custom_block_id);
					if(blockInfo.icon_close != 0)
					{
						$(cutom_icon).removeClass("fa-chevron-down").addClass("fa-chevron-up");
					}
					$(cutom_text).text(blockInfo.text_open);
				}
				if (S_COLLAPSECATEGORIES_SAVE_DB != 1)
				{
					closedArray = $.grep(closedArray, function(value) {
						return value != custom_block_id;					
					});
				}
			}
		}
		$(parent).attr('data-status', status);
		if (S_COLLAPSECATEGORIES_SAVE_DB == 1)
		{
			var path = './app.php/collapsecategories/' + block_id + '/' + status + '/' +  S_USER_ID;
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: path,

			});
		}
		else
		{
			localStorage.setItem('u'+S_USER_ID, closedArray);	
		}

    });

}/*if (S_CATEGORIES_COLLAPSEBALED)*/

$('.collapsetrigger-custom').click(function () {
	var block_id = $(this).attr('id');
    var id = block_id.replace('clps_', '' );
	var icon_id = 'icon_' + id;
	var text_id = 'text_' + id;
    var status = $(this).attr('data-status');
    var txt_toggle;
    var icon_class;
    var blockInfo = $(collapse_blocks_arr).filter(function(index, item){
        return item.block_id.trim() == id;
	});
	var collapse_block = $(this).find('.collapsethis');
    blockInfo = $(blockInfo).first()[0];
    txt_toggle;
    var new_status;
    if (parseInt(status) == 0)
    {
        //hide block
        new_status = 1;
        txt_toggle = blockInfo.text_close ;
        icon_class = "fa-chevron-down";
		$(this).next().hide();
		closedArray.push(id);      
        
    }
    else
    {
        //show block
        new_status = 0;
        txt_toggle = blockInfo.text_open;
        icon_class = "fa-chevron-up";
		$(this).next().show();
		closedArray = $.grep(closedArray, function(value) {
			return value != id;
		});
        
    }
	$('#' + icon_id).removeClass('fa-chevron-up').removeClass('fa-chevron-down').addClass(icon_class);
	$('#' + text_id).text(txt_toggle);
	$(this).attr('data-status', new_status);
    //save status-block
	if (S_COLLAPSECATEGORIES_SAVE_DB == 1)
	{
		var path = './app.php/collapsecategories/' + id + '/' + status + '/' +  S_USER_ID;
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: path,

		});
	}
	else
	{
		localStorage.setItem('u'+S_USER_ID, closedArray);	
		// console.log(closedArray);      
	}
});

})(jQuery);