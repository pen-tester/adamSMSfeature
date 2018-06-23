window.oncontextmenu = function ()
{
    //showCustomMenu();
    return false;     // cancel default menu
}
var right_clicked_target=null;
$(window).click(function(){
	$(".contextmenu").fadeOut();
});

$(document).ready(function(){
	$(".contextmenu li").click(function(){
		console.log("target",right_clicked_target);
		removechat($(right_clicked_target).find("input[type=hidden]").val());
	})
});

function showCustomMenu(target){

}