$(document).ready(function(){
	get_current_number();

	$(".update_number").click(function(){
		update_callback_number();
	})
	//For message box
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
		$("#"+target).fadeOut();
	})
});

function get_current_number(){
	$.ajax({
		url:"/adminhelper/get_callback_number"
	}).done(function(response, status){
		var phone = response.result.phone;
		$(".fromnumber").val(phone);
	}).fail(function(response, status){

	});
}


//When clicking the "update" to update the call back number
function update_callback_number(){
	var phone = $(".fromnumber").val();
	$.ajax({
		url:"/adminhelper/update_callback_number",
		type:"POST",
		data:{'leads[phone]':phone, 'leads[type]':0}
	}).done(function(response, status){

			$("#msgbox .modal_content").text("Successfully updated.");
			$("#msgbox").fadeIn();			
	}).fail(function(response, status){
			$("#msgbox .modal_content").text("There was an error to send. Please contact the admin or retry later.");
			$("#msgbox").fadeIn();	
	});
}