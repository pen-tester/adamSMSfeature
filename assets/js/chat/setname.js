$(document).ready(function(){
	get_variable("%sendername");
	$("#btnset").click(function(){
		set_variable("%sendername", $("#valreplace").val());
	});

	$(".btnclose").click(function(){
		var target=$(this).attr("data-target");
		$("#"+target).fadeOut();
	});
});

function get_variable(varname){
	$.ajax({
		url:"/api/api_messenger/get_var",
		type:"POST",
		data:{varname:varname}
	}).done(function(response ,status){
		console.log(response);
		if(response.result!=null){
			$("#valreplace").val(response.result);
		}
	}).fail(function(response,status){
		$("#msgbox").text("Server gives an error. Please contact with administrator.");
		$("#msgbox").fadeIn();
		console.log("error", "server gives an error");
	});

}

function set_variable(varname,varreplace){
	$.ajax({
		url:"/api/api_messenger/insert_var",
		type:"POST",
		data:{varname:varname,varval:varreplace}
	}).done(function(response ,status){
		console.log(response);
		$("#msgbox .modal_content").text("Successfully updated");
		$("#msgbox").fadeIn();		

	}).fail(function(response,status){
		$("#msgbox .modal_content").text("Server gives an error. Please contact with administrator.");
		$("#msgbox").fadeIn();
		console.log("error", "server gives an error");
	});

}