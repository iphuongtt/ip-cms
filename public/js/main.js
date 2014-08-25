$('.menu-collapse').click(function(){
	$('.sidebar-extent').hide();
	$('.sidebar-collapse').show();
	$('.container-content').css('margin-left','50px');
});
$('.menu-extent').click(function(){
	$('.sidebar-collapse').hide();
	$('.sidebar-extent').show();
	$('.container-content').css('margin-left','172px');
});

$('.tip').tooltip();