$(document).ready(function(){
    refresh_selectbox();

    //Selecting the star icon
    $(".stararea .star").click(function(){
        var cur_val =  $(this).parent().find("input[type=hidden]").val();
        cur_val = 1- cur_val;
        if(cur_val == 0) $(this).removeClass("goldstar");
        else $(this).addClass("goldstar");
        $(this).parent().find("input[type=hidden]").val(cur_val);
    });

    $(".btnclose").click(function(){
        $("#"+$(this).attr("data-target")).fadeOut();
    })

    $(".btncloseredirect").click(function(){
        window.location.href = "/messenger/index";
    })
    //Upload realtor....
	//when clicking the address, display the zillow property and google
	//option:0 => zillow property displaying from backend (search api)
	//option:1 => google map search api
	$(".showmap").click(function(){
		var addr = $("#fulladdr").val();
		var option= $(this).attr("data-option");
		if(option=='0'){
			var win = window.open($(this).attr("data-url"), '_blank');					
		}else{
			var url= "https://www.google.com/maps/search/?api=1&query="+addr+", "+zip;
			var win = window.open(url, '_blank');
		}

    });
    
    $(".btnaddlead").click(function(){
        $(".required").each(function(){
            if($(this).val()==""){
                $("#errorcontent").text("Plese Fill Name and Phone, Address");
                $("#errorbox").fadeIn();
                return false;
            }
        });
            //Setting value alter value
            $(".altervalue").each(function(){
                var val = $(this).val();
                $(this).parent().find(".addaltervalue").val(val);
            });
            
        $.ajax({
            url:"/api/api_messenger/add_archive",
            data:$("#discovery_form").serialize(),
            type:"POST"
        }).done(function(resp, status){
            if(resp.status=='ok'){
                $("#successbox .modal-body").text("Successfully added!");
                $("#successbox").fadeIn();
            }
        }).fail(function(resp, status){

        });
    });

    //When name changing
    $("#fullname").change(function(){
        var fullname = $(this).val();
        var items = fullname.split(" ");
        console.log(items);
        if(items.length ==2){
            $("#name_success").val("success");
            $("#firstname").val(items[0]);
            $("#lastname").val(items[1]);
        }else{
            $("#name_success").val("");
        }
    });

    //When changing the full address to addr, city, state, zip
    $("#fulladdr").change(function(){
        var fulladdr = $(this).val();
        var items = fulladdr.split(", ");
        if(items.length != 4){
            $("#errorcontent").text("The address format has to be like 'address, city, state, zipcode'");
            $("#errorbox").fadeIn();
            $("#address_success").val('');
        }else{
            console.log(items[0]);
            $("#laddress").val(items[0]);
            $("#lcity").val(items[1]);
            $("#lstate").val(items[2]);
            $("#lzip").val(items[3]);
            $("#address_success").val('1');

            $(".update_from_zillow").attr("data-id","");
            last_zillow_result = null;          
			$.ajax({
				url:"/api/api_messenger/get_zillow_propertyurl",
				data:{addr:$("#laddress").val(), zip:$("#lcity").val()+", "+$("#lstate").val()},
				type:"POST"
			}).done(function(response, status){
				console.log("zillow result" ,response);
				if(response.status=="ok" && response.result!=null){
                    try{
                        $(".showmap.zillow").attr("data-url", response.result.links.homedetails);
                        $(".update_from_zillow").attr("data-id", response.result.zpid);
                        last_zillow_result = response.result
                    }
                    catch(ex){

                    }
	 			}else{
	 				//$("#errorcontent").text("Zillow doesn't respond.");
	 				//$("#errorbox").fadeIn();
				}

			}).fail(function(response, status){
				console.log("zillow error", response);
			});              
        }
    })





	//When clicking the zillow icon, update the profile window
	$(".update_from_zillow").attr("data-id","");
	$(".update_from_zillow").click(function(){
		var target = $(this).attr("data-id");
		if(target==""){
			$("#msgbox .modal_content").text("Please retry later .. now checking for the zillow status");
			$("#msgbox").fadeIn();			
			return;
		}
		$.ajax({
			url:"/api/api_messenger/get_zillow_detailresult",
			type:"POST",
			data:{zpid:target}
		}).done(function(response, status){
			//console.log(response.result);
			var result = response.result;
			process_zillow_info(result);
		}).fail(function(response, status){

		});
	});

	//Upload discovery form to podio
	$(".uploadPodio").click(function(){
		if($(this).hasClass("uploaded")){
			window.open("https://podio.com/monacopropertygroupcom/bay-capital-holdings/apps/properties","_blank");
			return;
		}


		if(trigger) return;
		trigger=true;
		$.ajax({
			url:"/api/api_messenger/upload_podio",
			type:"POST",
			data:$("#discovery_form").serialize()
		}).done(function(response, status){
			console.log("podio result:",response.result);
			try{
				if(response.result.item_id !=null && response.result.item_id!=""){
					$("#podiopropertyitemid").val(response.result.item_id);
					//Success to upload to the podio
					$.ajax({
						url:"/api/api_messenger/upload_seller_podio",
						type:"POST",
						data:{
							'leads[seller-name]':$("#pname").text(),
							'leads[email]':$("#pemail").val(),
							'leads[seller-phone-cell]':[{'type':'mobile','value':$("#sel_phone").val()}],
							'leads[property]':response.result.item_id
						}
					}).done(function(resp, status){	
						$("#msgbox .modal_content").text("Successfully uploaded to podio");
						$("#msgbox").fadeIn();		
						$("#podiosellerid").val(resp.result.item_id);
						//Updating the tb_archive
						var target = $("#sel_phone").val(); 
						$.ajax({
							url:"/api/api_messenger/update_member_info",
							data:{phone:target,field:'podiosellerid', value:resp.result.item_id},
							type:"POST"
						}).done(function(response, status){
							console.log("Update Status",response.result);
				
						}).fail(function(response,status){
				
						});											
						console.log("Podio Seller", response);
					}).fail(function(response, status){
						$("#msgbox .modal_content").text("Please check your internet connection or contact with admin. Only property uploaded.");
						$("#msgbox").fadeIn();
					});			

					//Updating the tb_archive
					var target = $("#sel_phone").val(); 
					$.ajax({
						url:"/api/api_messenger/update_member_info",
						data:{phone:target,field:'podioitemid', value:response.result.item_id},
						type:"POST"
					}).done(function(response, status){
						console.log("Update Status",response.result);
			
					}).fail(function(response,status){
			
					});		
					$(".uploadPodio").addClass("uploaded");				
				}
			}catch(ex){
				$("#msgbox .modal_content").text("Please check your internet connection or contact with admin."+ex);
				$("#msgbox").fadeIn();
			}
			trigger=false;
			
		}).fail(function(response, status){
			$("#msgbox .modal_content").text("Please check your internet connection or contact with admin.");
			$("#msgbox").fadeIn();
			trigger=false;
		});
	});

	//Upload cash buyer to podio
	$(".uploadCashbuyer").click(function(){
		if($(this).hasClass("uploaded")){
			window.open("https://podio.com/monacopropertygroupcom/bay-capital-holdings/apps/properties","_blank");
			return;
		}
		
		$.ajax({
			url:"/api/api_messenger/upload_cashbuyer_podio",
			type:"POST",
			data:{
				'leads[buyer-name]':$("#fullname").text(),
				'leads[email]':$("#pemail").val(),
				'leads[direct-number]':$("#sel_phone").val(),
				'leads[status2]':12
			}
		}).done(function(response, status){	
			$("#msgbox .modal_content").text("Successfully uploaded to podio");
			$("#msgbox").fadeIn();		
			$("#podiocashbuyerid").val(response.result.item_id);
			//Updating the tb_archive
			var target = $("#sel_phone").val(); 
			$.ajax({
				url:"/api/api_messenger/update_member_info",
				data:{phone:target,field:'podiocashbuyerid', value:response.result.item_id},
				type:"POST"
			}).done(function(response, status){
				console.log("Update Status",response.result);
				$(".uploadCashbuyer").addClass("uploaded");
			}).fail(function(response,status){
	
			});											
			console.log("Podio Seller", response);
		}).fail(function(response, status){
			$("#msgbox .modal_content").text("Please check your internet connection or contact with admin. Only property uploaded.");
			$("#msgbox").fadeIn();
		});			

	});
	//Seller update to the realtor
	$(".uploadRealtor").click(function(){
		if($(this).hasClass("uploaded")){
			window.open("https://podio.com/monacopropertygroupcom/bay-capital-holdings/apps/properties","_blank");
			return;
		}
		
		if($("#podiosellerid").val()==""){
			$("#msgbox .modal_content").text("There is not seller for this property yet.");
			$("#msgbox").fadeIn();				
			return;
		}

		$.ajax({
			url:"/api/api_messenger/update_seller_podio",
			type:"POST",
			data:{
				'leads[id]':$("#podiosellerid").val(),
				'leads[next-action]':19
			}
		}).done(function(response, status){	
			$("#msgbox .modal_content").text("Successfully updated to podio");
			$("#msgbox").fadeIn();		
			if(response.status=='ok'){
				//Updating the tb_archive
				var target = $("#sel_phone").val(); 
				$.ajax({
					url:"/api/api_messenger/update_member",
					data:{'leads[phone]':target,'leads[realtor]':response.result.item_id},
					type:"POST"
				}).done(function(response, status){
					console.log("Update Status",response.result);
				}).fail(function(response,status){
		
				});	
				
				$(".uploadRealtor").addClass("uploaded");
			}

			console.log("Podio Seller", response);
		}).fail(function(response, status){
			$("#msgbox .modal_content").text("Please check your internet connection or contact with admin. Only property uploaded.");
			$("#msgbox").fadeIn();
		});				
	})    
})

/*
	Update profile info from the zillow

*/

function process_zillow_info(result){
	console.log("zillow info",result , last_zillow_result);
	if(last_zillow_result != null){
		$(".zillowval_search").val(currency_format(last_zillow_result[$(".zillowval_search").attr("data-zillow")]["amount"]));
		$(".zilloworigin").each(function(){
			var prop = $(this).attr("data-zillow");
			$(this).val(last_zillow_result[prop]);
		});

		$(".zillowval_search").trigger("change");
		$(".zilloworigin").trigger("change");
	}

	if(result.message.code !='0'){
		$("#msgbox .modal_content").text("Zillow response: "+result.message.text);
		$("#msgbox").fadeIn();		
		return;
	}
	var response = result.response;

	//For getting and updating the zillow info from "editedFacts"

	$(".zillowval").each(function(){
		var prop = $(this).attr("data-zillow");
		$(this).val(response.editedFacts[prop]);
	});
	$(".zillowval").trigger("change");

}

function currency_format(val){
	if(typeof val != 'string') return '$0';
	return "$"+val.split("").reverse().reduce(function(acc, num, i, orig) {
        return  num=="-" ? acc : num + (i && !(i % 3) ? "," : "") + acc;
    }, "");
}