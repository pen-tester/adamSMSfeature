$(document).ready(function(){

	//Custom select box
	$("body").on("click",".btn-select",function(){
		$(this).find("ul").toggle();
	});
	$("body").on("click",".btn-select ul li",function(){
		$(this).parent().find(".selected").removeClass("selected");
		$(this).addClass("selected");
		var current = $(this).parent().find("li.selected").attr("data-value");
		var text = $(this).parent().find("li.selected").text();
		$(this).parent().parent().find("input[type=hidden]").val(current);
		$(this).parent().parent().find(".btn-select-value").text(text);		

	});
	$(".btn-select").each(function(){
		var current = $(this).find("ul li.selected").attr("data-value");
		var text = $(this).find("ul li.selected").text();
		if(current!=null){
			console.log(current);
			$(this).find("input[type=hidden]").val(current);
			$(this).find(".btn-select-value").text(text);			
		}
	});	


	$(window).click(function(e){
	    $(".btn-select").each(function(){
		    // if the target of the click isn't the container nor a descendant of the container
		    if (!$(this).is(e.target) && $(this).has(e.target).length === 0) 
		    {
		        $(this).find("ul").fadeOut();
		    }

	    });
	})	

	//Action for edit sms permission
	$("body").on("click",".editcontent", function(){
		var target = $(this).attr("data-target");

		console.log("target", target);
		$.ajax({
			url:"/smscontenthelper/get_sms_info",
			data:{id:target},
			type:"POST"
		}).done(function(response, status){
			console.log("Sms content",response.result);
			show_Editsms(response.result);
		}).fail(function(response,status){

		});		
	})


	//For message box
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
		$("#"+target).fadeOut();
	})


	//Update the sms 
	$(".btnupdate").click(function(){
		var id = $("#lid").val();
		var sms = $("#lmsg").val();
		$.ajax({
			url:"/smscontenthelper/updatesms",
			data:{'leads[id]':id,'leads[msg]':sms},
			type:"POST"
		}).done(function(response, status){
			list_smstemplates();
		}).fail(function(response,status){

		});			
		$("#editbox").fadeOut();
		list_smstemplates();
	});


	list_smstemplates();

});

function show_Editsms(data){
	for(var key in data){
		$("#l"+key).val(data[key]);
	}
	$("#editbox").fadeIn();
}


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
	refresh_selectbox();
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
	        <a class='editcontent btnpadding' data-target='`+item.id+`'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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

function refresh_selectbox(){
	$(".btn-select").each(function(){
		var sel_val = $(this).find("input[type=hidden]").val();
		var parent = this;
		try{
			if(parseInt(sel_val)!=-1){

				$(this).find("ul li").each(function(){
					var val = $(this).attr("data-value");
					var text = $(this).text();
					if(val==sel_val) {
						$(this).addClass("selected");

						$(parent).find(".btn-select-value").text(text);
						return false;
					}
				});
			}
		}catch(e){

		}
	})
}
