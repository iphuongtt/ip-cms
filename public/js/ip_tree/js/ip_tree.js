/**
* copyright: Phuongtt
*/
(function($) {
    function returnfalse() { return false; };
    $.fn.iptree = function(option) {
        option = $.extend({width: 150 }, option);
        var   arrowTpl = '<a class="folder_arrow" href="javascript:void(0)"></a>',
              idTree = 0,
              ip_items = {};
        //var liTpl = '<li class="collapsed current_folder_location" id="$[id]"><a title="$[title]" name="$[name]" class="folder_name" href="javascript:void(0)">$[title]</a></li>',
        var liTpl = '<li class="collapsed current_folder_location"';
        if(option.urlGetDataParams){
            $.each(option.urlGetDataParams, function(index, val) {
                liTpl += ' '+val+'="$['+val+']"';
            });
        }
        liTpl += '><a title="$[title]" name="$[name]" class="folder_name" href="javascript:void(0)">$[title]</a></li>';

        var treeTpl = $("<div class = 'folderlist_content'/>");
        var ulTpl = $('<ul/>');
        var build = function(items){
            var ulTpl = $('<ul/>');
            $.each(items, function(index, val) {
                var liTpl1 = addItem(val);
                if(option.onClick && $.isFunction(option.onClick))
                    liTpl1.find('a.folder_name').bind('click', option.onClick);
                else
                    liTpl1.find('a.folder_name').bind('click', onClick);
                if(val.items || val.hasItems){
                    var objArrow = $(arrowTpl);
                    objArrow.bind('click',loadData);
                    liTpl1.append(objArrow);
                    if(val.items)
                        liTpl1.append(build.call(this, val.items));
                }
                ulTpl.append(liTpl1);
            });
            return ulTpl;
        };
        var addItem = function(item){
            var liTpl1 = liTpl.replace(/\$\[([^\]]+)\]/g, function() {
                return item[arguments[1]];
            });
            $(liTpl1).bind('click', onClick);
            return $(liTpl1);
        };
        var onClick = function(){
            alert($(this).text())
        }
        function genId(){
            idTree++;
            return 'ipTree_id_' + idTree;
        }
        function assignId(items){
            for(var i = 0; i < items.length; i++){
                setTemId(items[i]);
                if(items[i].items){
                    assignId(items[i].items);
                }
            }
        }
        function setTemId(objTem){
            objTem.id = genId();
        }
        function loadData(){
            var obj = this;
            var parrent_id_tree = $(this).parent().attr('id_tree');
            if($(this).parent().hasClass('collapsed')){
                if($(this).parent().find('ul').length > 0){
                    $(this).parent().removeClass('collapsed').addClass('expanded');
                }else{
                    var data = {};
                    if(option.urlGetDataParams){
                        $.each(option.urlGetDataParams, function(index, val) {
                            data[val] = $(obj).parent().attr(val);
                        });
                    }
                    $.ajax({
                        url: option.urlGetData,
                        type: "POST",
                        cache: true,
                        data:data,
                        success: function(string){
                            if(string){
                                var result = jQuery.parseJSON(string);
                                $.each(result, function(index, val) {
                                     val.id = genId();
                                     val.id_tree = parrent_id_tree + '/' + val.id;
                                });
                                var subUlTpl = build.call(this,result);
                                $(obj).parent().append(subUlTpl);
                                $(obj).parent().removeClass('collapsed').addClass('expanded');
                            }
                        }
                    });
                }
            }else{
                 $(this).parent().removeClass('expanded').addClass('collapsed');
            }
        }
        ip_argument = option.items;
        assignId(option.items);
        ulTpl = build.call(this,option.items);
        treeTpl.append(ulTpl);
        this.append(treeTpl);
    }
})(jQuery);