

var last_zillow_result= null;

//show profile when displaying the main window
function show_profile(profile){
	$("#sel_phone").val(profile.phone);

	//Star and selecting grade
	$(".chat_tab .grade").attr("data-target", profile.phone);
	$(".chat_tab .grade").parent().find("input[type=hidden]").val(profile.grade);
	$(".chat_tab .stararea .star").attr("data-target", profile.phone);
	$(".chat_tab .stararea .star").attr("data-value", profile.rate);
	if(profile.rate=='1') $(".chat_tab .stararea .star").addClass("goldstar");

	$(".btn-select .selectbox").attr("data-phone",profile.phone );

	//When this property has been uploaded to the podio
	$(".uploadPodio").removeClass("uploaded");
	if(profile.podioitemid !="" && profile.podioitemid!=null){
		$(".uploadPodio").addClass("uploaded");
		$("#podiopropertyitemid").val(profile.podioitemid);
	}
	$(".uploadRealtor").removeClass("uploaded");
	if(profile.realtor !="" && profile.realtor!=null){
		$(".uploadRealtor").addClass("uploaded");
		$("#realtor").val(profile.realtor);
	}
	if(profile.podiosellerid !="" && profile.podiosellerid!=null){
		$("#podiosellerid").val(profile.podiosellerid);
	}	
	$(".uploadCashbuyer").removeClass("uploaded");
	if(profile.podiocashbuyerid !="" && profile.podiocashbuyerid!=null){
		$(".uploadCashbuyer").addClass("uploaded");
		$("#podiocashbuyerid").val(profile.podioitemid);
	}	

	if(profile !=null){
		$(".property_val").each(function(){
			var target = $(this).attr("data-target");
			if($(this).hasClass("showphone")){
				$(this).text(phone_format(profile.phone));
			}else if($(this).hasClass("showname")){
				var name = profile.firstname;
				name = name + " " + ((profile.lastname!=null && profile.lastname!="")?profile.lastname:"");
				$(this).text(name);
			}else if($(this).hasClass("showaddr")){
				if($(this).attr("type")=="hidden")$(this).val(profile.address+", "+profile.city+", "+profile.state+", "+profile.zip);
				else $(this).text(profile.address+", "+profile.city+", "+profile.state+", "+profile.zip);
			}else if($(this).hasClass("checkbox")){
				if(profile[target] == '0') $(this).prop("checked", false);
				else $(this).prop("checked", true);				
			}else if($(this).hasClass("selectbox")){
				$(this).find(".btn-select-input").val(profile[target]);
			}else{
				
				if($(this).hasClass("showtxt")){
					$(this).text(profile[target]);
				}else{
					$(this).val(profile[target]);
				}
			}

		});		
	}
	else{
		$(".property_val").each(function(){
			var target= $(this).attr("data-target");;
			if($(this).hasClass("showphone")){

			}else if($(this).hasClass("showname")){

			}else if($(this).hasClass("showaddr")){
				
			}else if($(this).hasClass("checkbox")){

			}else if($(this).hasClass("selectbox")){
				
			}else{			
				if($(this).hasClass("showtxt")){
					$(this).text("");
				}else{
					$(this).val("");
				}
			}

		});			
	}


	$(".showmap").attr({"data-addr":profile.address, "data-zip":profile.city+", "+profile.state});
	//Get and zillow link and set zpid for the option 
	//Init the zillow info
	$(".update_from_zillow").attr("data-id","");
	last_zillow_result = null;

			$.ajax({
				url:"/api/api_messenger/get_zillow_propertyurl",
				data:{addr:profile.address, zip:profile.city+", "+profile.state},
				type:"POST"
			}).done(function(response, status){
				console.log("zillow result" ,response);
				if(response.status=="ok" && response.result!=null){
					$(".showmap.zillow").attr("data-url", response.result.links.homedetails);
					$(".update_from_zillow").attr("data-id", response.result.zpid);
					last_zillow_result = response.result
	 			}else{
	 				//$("#errorcontent").text("Zillow doesn't respond.");
	 				//$("#errorbox").fadeIn();
				}

			}).fail(function(response, status){
				console.log("zillow error", response);
			});


	refresh_selectbox();

	$("#profilemsg").fadeIn();	
}
