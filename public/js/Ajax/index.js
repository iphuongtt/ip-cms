function menuAction() {
    alert(alert(event.target.id));
}
var iptarget, ipobj;
function menuAction2(obj, target) {
    alert($(obj).attr('class'))
    iptarget = target;
    ipobj = obj;
}
var option = { width: 150
			   ,items: [
			        { text: "Thêm mới22", icon: "ip_16x16_add",tac:"test", alias: "1-1", action: menuAction2 },
			        { text: "Sửa", icon: "ip_16x16_edit", alias: "1-2", action: menuAction },
			        //this is normal menu item, menuAction will be called if this item is clicked on 
			        { text: "Sửa nhanh", icon: "ip_16x16_quickedit", alias: "1-3", action: menuAction },
			        { text: "Xóa", icon: "ip_16x16_delete", alias: "1-3", action: menuAction },
        		]
};
$(".context-menu-one").contextmenu(option); 
var option = { width: 150
				,alias:'menu2'
			   ,items: [
			        { text: "Thêm mới11", icon: "ip_16x16_add",tac:"test", alias: "1-1", action: function(){$("#showform").trigger('click');} },
			        { text: "Sửa", icon: "ip_16x16_edit", alias: "1-2", action: menuAction },
			        //this is normal menu item, menuAction will be called if this item is clicked on 
			        { text: "Sửa nhanh", icon: "ip_16x16_quickedit", alias: "1-3", action: menuAction },
			        { text: "Xóa", icon: "ip_16x16_delete", alias: "1-3", action: menuAction },
        		]
};
$(".context-menu-one-more").contextmenu(option); 