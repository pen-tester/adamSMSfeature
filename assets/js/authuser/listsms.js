

var trigger = false;

$(document).ready(function(){
	//For message box
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
		$("#"+target).fadeOut();
	})

	//When clicking the send sms all button.
	$("body").on("click",".btn_sendall" ,function(){
		var target = $(this).attr("data-target");
		if(trigger || $(this).hasClass("disable")) return;
		$(this).addClass("disable");
		trigger = true;
		$.ajax({
			url:"/api/sendsms/"+target+"/"+$("#entry").val()+"/adam"
		}).done(function(response, status){
			trigger = false;
			console.log(response);	
			if(response.status=='error'){
				$("#msgbox .modal_content").text(response.errors);
				$("#msgbox").fadeIn();
			}else{
				$("#msgbox .modal_content").text("Successfully sent sms.");
				$("#msgbox").fadeIn();
			}	
			

		}).fail(function(response, status){
			console.log(response);
			trigger = false;
			$(this).removeClass("disable");
			$("#msgbox .modalcontent").text("There was an error to send. Please contact the admin or retry later.");
			$("#msgbox").fadeIn();				
		})
	});


	list_smstemplates();
})

function list_smstemplates()
{
	sindex =0;
	$.ajax({
		url:"/smscontenthelper/list_smstemplates",
		type:"POST"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			console.log(data.result);
			add_template_tolist(data.result);
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});		
}

function add_template_tolist($users){
	$("#userarea tbody").html("");
	var length = $users.length;
	for(var i=0; i<length; i++){
		$item = $users[i];
		add_item($item);
	}
}

var sindex=0;

function add_item(item, direction=0){  //0:add after last 1:add before the first
	var active ="Inactive";
	if(item.active != '0') 
		active="Active";

   var itemstring=
   "<tr>\
	    <td>"+sindex+"</td>\
	    <td>"+item.msg+`</td>\
	    <td>
	        <span class='btn_sendall btnpadding' data-target='`+sindex+`'><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
	    </td>
	  </tr>`;	
	 if(direction==0){
	 	$("#userarea tbody").append(itemstring);
	 }
	 else{
		$("#userarea tbody").prepend(itemstring);
	 }
	 sindex++;
}