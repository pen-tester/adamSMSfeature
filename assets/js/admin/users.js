$(document).ready(function(){


	$(window).click(function(e){
	    $(".btn-select").each(function(){
		    // if the target of the click isn't the container nor a descendant of the container
		    if (!$(this).is(e.target) && $(this).has(e.target).length === 0) 
		    {
		        $(this).find("ul").fadeOut();
		    }

	    });
	})	;

	$(window).click(function(e){
	    $(".btn-select").each(function(){
		    // if the target of the click isn't the container nor a descendant of the container
		    if (!$(this).is(e.target) && $(this).has(e.target).length === 0) 
		    {
		        $(this).find("ul").fadeOut();
		    }

	    });
	});

	$("body").on("click",".btn-select",function(){
		$(this).find("ul").toggle();
	});


	//For message box
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
		$("#"+target).fadeOut();
	})

	//delete the usre action
	$("body").on("click",".delete", function(){
		var target = $(this).attr("data-target");
		$.ajax({
			url:"/adminhelper/deleteuser",
			data:{userid:target},
			type:"POST"
		}).done(function(response, status){
			list_users();
		}).fail(function(response,status){

		});				
	});

	refresh_selectbox();
});


function refresh_selectbox(){
	$(".btn-select ul li").removeClass("selected");
	$(".btn-select").each(function(){
		var sel_val = $(this).find("input[type=hidden]").val();
		var parent = this;
		try{

				$(this).find("ul li").each(function(){
					var val = $(this).attr("data-value");
					var text = $(this).text();
					if(val==sel_val) {
						$(this).addClass("selected");
						$(parent).find(".btn-select-value").text(text);
						return false;
					}
				});
		}catch(e){

		}
	})
}

function phone_format(phone){
	return "("+ phone.slice(2,5)+")- "+phone.slice(5,8)+"-"+phone.slice(8);
}

