(function($){
    $.fn.focusTextToEnd = function(){
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    }
}(jQuery));
$('input[name="search_category"]').focus();
$('tbody tr').hover(
	function(){
		$(this).find('div.rowActions').css('visibility', 'visible');
	},function(){
		$(this).find('div.rowActions').css('visibility', 'hidden');
	}
);
$('a.editinline').click(function(){
	var objBtn = this;
	$(document).bind('keydown', 'return', function() {
		$(objBtn).parents('tr').next().find('button.inline-update').trigger('click');
   	});
	$(this).parents('table').find('tr.inline-edit-row').remove();
	$(this).parents('table').find('tr:not(.inline-edit-row)').show();
	$(this).parents('tr').hide();
	$(this).parents('tr').after($('tbody#inlineedit').html());
	$(this).parents('tr').next().show();
	$(this).parents('tr').next().find('input#cat_name').val($(this).parents('td').children('div.hidden').children('span.name').html());
	$(this).parents('tr').next().find('input#cat_slug').val($(this).parents('td').children('div.hidden').children('span.slug').html());
	$(this).parents('tr').next().find('input#cat_name').focusTextToEnd();
	$('button.inline-cancel').click(function(){
		$(this).parents('tr').prev().show();
		$(this).parents('tr').remove();
		$(document).unbind('keydown', 'return');
	});
	$('button.inline-update').click(function(){
		var name = $(this).parents('tr').find('input#cat_name').val();
		var slug = $(this).parents('tr').find('input#cat_slug').val();
		var id = $(this).parents('tr').prev().find('input.cat_id').val();
		var objBtn = this;
		$.ajax({
			url: "editinline",
			type: "POST",
			cache: true,
			data:{	name:name, slug: slug, id:id},
			success: function(string){
				if(string){
					var arrResult = $.parseJSON(string);
					if(arrResult['error']){
						$(objBtn).parents('tr').find('span.error').html(arrResult['error']);
					}else{
						$(document).unbind('keydown', 'return');
						$(objBtn).parents('tr').prev().show();
						$(objBtn).parents('tr').prev().find('span.name').html(name);
						$(objBtn).parents('tr').prev().find('span.slug').html(slug);
						$(objBtn).parents('tr').remove();
					}
				}else{
					$(document).unbind('keydown', 'return');
					$(objBtn).parents('tr').prev().show();
					$(objBtn).parents('tr').prev().find('span.name').html(name);
					$(objBtn).parents('tr').prev().find('span.slug').html(slug);
					$(objBtn).parents('tr').remove();
				}
			}
		});
	});
});

var option = { width: 150
			   ,items: [
			        { text: "Thêm mới", icon: "ip_16x16_add", alias:"1", action: function(){
			        	window.location = urlAdd;
			        } },
			        { text: "Sửa", icon: "ip_16x16_edit", alias:"2", action: function(obj){
			        	window.location = urlEdit + '/' + $(obj).find('.taxonomy_id').val();
			        } },
			        { text: "Sửa nhanh", icon: "ip_16x16_quickedit", alias:"3", action: function(obj){
			        	$(obj).find('.editinline').trigger('click');
			        } },
			        { text: "Xóa", icon: "ip_16x16_delete", alias:"4", action: function(obj){
			        	window.location = urlDelete + '/' + $(obj).find('.taxonomy_id').val();
			        } },
        		]
};
$("tbody tr").contextmenu(option);
