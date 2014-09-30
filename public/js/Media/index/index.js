function set_folder_path(obj){
	var path = $(obj).parent().attr('path');
	if(path){
		var idTreeList = $(obj).parent().attr('id_tree');
		$('#folder_path > ol li:gt(0)').remove();
		var arrPath = path.split(sapDir);
		var arrIdTree = idTreeList.split('/');
		for(var i = 1; i < arrPath.length -1; i++){
			var liObj = $('<li id_tree="'+arrIdTree[i]+'"><a href="#"><span class = "folder_open"></span><span class = "folder_name">'+arrPath[i]+'</span></a></li>');
			liObj.bind('click',function(){
				$('li#'+$(this).attr('id_tree') + ' > a.folder_name').trigger('click');
			});
			$('#folder_path > ol').append(liObj);

		}
		$('#folder_path > ol').append('<li class="active"><span class = "folder_open"></span><span class = "folder_name">'+arrPath[i]+'</li>');
	}
}
var option = { width: 150
               ,onClick:function(){
               		$('#file_list').html('');
               		set_folder_path(this);
               		var obj = this;
               		$.ajax({
                        url: urlGetFile,
                        type: "POST",
                        cache: true,
                        data:{path:$(this).parent().attr('path')},
                        success: function(string){
                            if(string){
                                $('#file_list').html(string);
                            }
                        }
                    });
               }
               ,urlGetData:urlGetTree
               ,urlGetDataParams:['id','name','path', 'id_tree']
               ,items: [
                    { title: "Quản lý media", path:"", id_tree:"", name: "", hasItems: "1", icon: "ip_16x16_edit", alias:"2"}
                ]
};
$('#iptree').iptree(option);


