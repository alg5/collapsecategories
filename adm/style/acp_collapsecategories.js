(function ($) {
 $().ready(function () {
//--->button > edit > start	
$(document).on('click', '.clps-action-edit', function(e) 
{
	e.preventDefault();
	var tbl_row = $(this).closest('tr');
	var block_id = tbl_row.attr('data-block_id');
	tbl_row.find('.btn_save').show();
	tbl_row.find('.btn_cancel').show();
    tbl_row.find('input').prop('disabled', false);
	//hide edit and delete buttons
	tbl_row.find('.clps-action-edit').hide(); 
	tbl_row.find('.clps-action-delete').hide(); 

	//make the whole row editable
	tbl_row.find('.row_data')
	.attr('contenteditable', 'true')
	.attr('edit_type', 'button')
	.addClass('bg-warning')

	//--->add the original entry > start
	tbl_row.find('.row_data').each(function(index, val) 
	{  
		//this will help in case user decided to click on cancel button
		$(this).attr('original_entry', $(this).html());
	}); 		
	//--->add the original entry > end

});
//--->button > edit > end

//--->button > cancel > start	
$(document).on('click', '.btn_cancel', function(e) 
{
	e.preventDefault();

	var tbl_row = $(this).closest('tr');
	var block_id = tbl_row.attr('data-block_id');

	//hide save and cacel buttons
	tbl_row.find('.btn_save').hide();
	tbl_row.find('.btn_cancel').hide();

	//show edit and delete buttons
	tbl_row.find('.clps-action-edit').show(); 
	tbl_row.find('.clps-action-delete').show(); 

	//make the whole row editable
	tbl_row.find('.row_data')
	.attr('edit_type', 'click')	 
	.removeClass('bg-warning')

	tbl_row.find('.row_data').each(function(index, val) 
	{   
		$(this).html( $(this).attr('original_entry') ); 
	});  
});
//--->button > cancel > end

//--->save whole row entery > start	
$(document).on('click', '.btn_save', function(e) 
{
	e.preventDefault();
	var tbl_row = $(this).closest('tr');
	var block_id = tbl_row.attr('data-block_id');
	
	//hide save and cacel buttons
	tbl_row.find('.btn_save').hide();
	tbl_row.find('.btn_cancel').hide();

	//show edit and delete buttons
	tbl_row.find('.clps-action-edit').show(); 
	tbl_row.find('.clps-action-delete').show(); 

	//make the whole row editable
	tbl_row.find('.row_data')
	.attr('edit_type', 'click')	
	.removeClass('bg-warning');
    
    tbl_row.find('input').prop('disabled', true);


	//--->get row data > start
    var path = U_COLLAPSECATEGORIES_PATH_EDIT;
    var data = '';
 	tbl_row.find('.row_data').each(function(index, val) 
	{   
		var col_name = $(this).attr('col_name');  
		var col_val  =  $(this).text();
        // console.log(col_name);
        if (col_name.indexOf("icon")> -1)
        {

            col_val = $(val).find('input').prop('checked') ? 1 : 0;
        }

        data += col_name + '=' + col_val + '&'
		
	});
//	//--->get row data > end
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: data,
        url:  U_COLLAPSECATEGORIES_PATH_EDIT ,
        success: function (data) {
        //block_edit_response(data);
        output_info_new(data.MESSAGE, 'warning');
        }
    });            
 
});
//--->save whole row entery > end

     
$("#btnSend").on('click', function (e) {
	e.preventDefault();
	$("#btnSend").hide(); //debug
	$("#loader_save").css('display', 'inline-block');

	var path = U_COLLAPSECATEGORIES_PATH_SAVE;
	data_to_send = $("#acp_collapsecategories").serialize();
	// console.log(data_to_send);
	 $.ajax({
		 type: 'POST',
		 dataType: 'json',
		 data: data_to_send,
		 url: path,
		 success: function (data) {
//			 console.log(data);
			 $("#btnSend").show();
			 $("#loader_save").hide();
			 output_info_new(data.MESSAGE, 'warning');
		}
	});
});
    $("#blocksSaved").on("click", ".clps-action-delete", function(){
        var tds = $(this).closest('td');
        //hide save and cacel buttons
        var btnActions = $(this).closest('td').find('.clps-action');
        $(btnActions).hide();
        $(".loader_small").show();
        var path = U_COLLAPSECATEGORIES_PATH_DELETE  ;
        var data = "block_id=" + $(this).attr("data-block_id") + '&row_id=' + $(this).closest("tr").index();
        var row_id = $(this).closest("tr").index();
//            console.log(data);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url:  U_COLLAPSECATEGORIES_PATH_DELETE ,
            success: function (data) {
            block_delete_response(data);
            }
        });
    });   
//--->button > saveNewBlock > start        
        $("#btnSaveNewBlock").on("click", function(e){
		e.preventDefault();
		$("#btnSaveNewBlock").hide(); //debug
		$("#loader_save").css('display', 'inline-block');
        var path = U_COLLAPSECATEGORIES_PATH_ADD  ;
        var data = $("#acp_collapsecategories").serialize();
        // console.log(data);    
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url:  U_COLLAPSECATEGORIES_PATH_ADD ,
            success: function (data) {
            block_add_new_response(data);
            }
        });
    }); 
 //--->button > saveNewBlock > end
 
        $("#btnAddNewBlock").on("click", function(e){
            e.preventDefault();
            $(this).hide();
            $("#newBlock").show();
        });
 });
    function block_delete_response(data)
    {
	//show edit and delete buttons
	var btnActions = $(this).closest('td').find('.clps-action');
	$(btnActions).show();
	$(".loader_small").hide();	
	
	if (data[0] && data[0].ERROR) 
       {
           output_info_new(data[0].ERROR, 'error');
           return;
       }
       output_info_new(data.MESSAGE, 'success');
       $("#tblBlocksSaved tr:eq(" +  (data.ROW_ID + 1) + ")").remove();
//       console.log('tbl rows count = ' + $('#tblBlocksSaved > tbody > tr').length);
       if($('#tblBlocksSaved > tbody > tr').length <= 1)
       {
           $("#noSavedBlocks").show();
           $("#tblBlocksSaved").hide();
       }

    }
    function block_add_new_response(data)
    {
		$("#btnSaveNewBlock").show(); 
		$("#loader_save").hide();
//        console.log(data);
       if (data[0] && data[0].ERROR) 
       {
           output_info_new(data[0].ERROR, 'error');
           return;
       }
       output_info_new(data.MESSAGE, 'success');        
        //update table, add new row
        var icon_open = '<input type="checkbox" name="icon-open"'
        if(data.ICON_OPEN == 1)
        {
            icon_open += ' checked'
        }
        icon_open += ' class="radio" disabled/>';
        var icon_close = '<input type="checkbox" name="icon-close"'
        if(data.ICON_CLOSE == 1)
        {
            icon_close += ' checked'
        }
        icon_close += ' class="radio" disabled />';        
        var $tr    =$("#tblBlocksSaved").find('tr.clps-hide');
        var $trClone = $tr.clone().removeClass('clps-hide');
        var tds = $trClone.find('td');
        
        $(tds).eq(0).find("div").html(data.BLOCK_ID);
        $(tds).eq(1).find("div").html(data.TEXT_OPEN);
        $(tds).eq(2).find("div").html(icon_open);
        $(tds).eq(3).find("div").html(data.TEXT_CLOSE);
        $(tds).eq(4).find("div").html(icon_close);
        $(tds).eq(5).find("div").html(data.CUSTOM_CSS);
        var attrs = $(tds).eq(6).find( '[data-block_id]' );
        $.each( attrs, function( index, item ) {
            //console.log(item);
            $(item).attr("data-block_id", data.BLOCK_ID);
          });
        $tr.before($trClone); 
//        console.log(tds)
       
        resetNewBlock();
        $("#tblBlocksSaved").show();
        $("#btnAddNewBlock").show();
        $("#newBlock").hide();   
    }

    function resetNewBlock()
    {
        $("#block_id").val("");
        $("#text_open").val(L_ACP_COLLAPSECATEGORIES_TEXT_OPEN_DEFAULT);
        $("#text_close").val(L_ACP_COLLAPSECATEGORIES_TEXT_CLOSE_DEFAULT);
        $("#icon_open").prop('checked', true); 
        $("#icon_close").prop('checked', true); 
        $("#custom_css").val("");
        
    }
    function output_info_new(message, type, expire, is_reload) {
        if (type == null) type = 'notification';
        if (expire == null) expire = 4000;
        var n = noty({
            text: message,
            type: type,
            timeout: expire,
            layout: 'topRight',
            theme: 'defaultTheme',
            callback: {
                afterClose: function () {
                    if (is_reload == null || is_reload == '' || is_reload != true) return;
                    window.location.reload();
                }
            }
        });
    }
})(jQuery);                                                                         // Avoid conflicts with other libraries




