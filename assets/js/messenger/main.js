var trigger=false;
$(document).ready(function(){
	trigger_notification();	
/*	$(window).click(function(e){
		var container = $(".profile");
		    // if the target of the click isn't the container nor a descendant of the container
		    if (!container.is(e.target) && container.has(e.target).length === 0) 
		    {
		        $(".profile").fadeOut();
		    }
	});
*/
	/*** Load the user list when role is admin
	 * 	 Load the lead types
	 */
	$.ajax({
		url:"/api/api_messenger/list_leadtypes"
	}).done(function(resp, status){
		list_leadtypes(resp.result);
	}).fail(function(resp, status){

	});

	$.ajax({
		url:"/adminhelper/list_all_users"
	}).done(function(resp, status){
		listusers(resp.result);
	}).fail(function(resp, status){

	});	

	$("body").on("click", ".dropusers ul li", function(){
		list_newsmslist();
	});

	$("body").on("click", ".dropleadtype ul li", function(){
		list_newsmslist();
	});
	
	/** */

	$(".btn_add_new_lead").click(function(){
		window.open("/messenger/addnewlead","_blank");
	})


	$("body").on("click", ".sentpodio", function(){
		window.open("https://podio.com/monacopropertygroupcom/bay-capital-holdings/apps/properties","_blank");
	})

	$("body").on("click",".selentry.btn-select ul li",function(){
		$(this).parent().find(".selected").removeClass("selected");
		$(this).addClass("selected");
		var current = $(this).parent().find("li.selected").attr("data-value");
		var text = $(this).parent().find("li.selected").text();
		$(this).parent().parent().find("input[type=hidden]").val(current);
		$(this).parent().parent().find(".btn-select-value").text(text);		

		reload_newsmslist();
	});

	$("body").on("click", ".btninfo", function(){
		$(".btninfo").removeClass("active");
		$(this).addClass("active");
		var target = $(this).attr("data-target");
		$("#sel_phone").val(target);

		console.log("show profile", target);

		$.ajax({
			url:"/api/api_messenger/get_member_info",
			data:{phone:target},
			type:"POST"
		}).done(function(response, status){
			console.log("Info",response.result);
			show_profile(response.result);

		}).fail(function(response,status){

		});
	});

	$("body").on("click","ul.grade li", function(){
		var target = $(this).parent().attr("data-target");
		var grade = $(this).attr("data-value");
		console.log("target", target);
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{phone:target,field:'grade', value:grade},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});		
	})

	$("body").on("click","ul.update_attr.selectbox li", function(){
		var target = $(this).parent().attr("data-phone");
		var field = $(this).parent().attr("data-target");
		var value = $(this).attr("data-value");
		console.log("target", target);
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{phone:target,field:field, value:value},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});		
	});	

	//When clicking the rating (star)
	$("body").on("click", "td .star", function(){
		var target = $(this).attr("data-target");
		var object = $(this);
		var value = 1- parseInt($(this).attr("data-value"));
		console.log("Rate for phone "+ target);
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{phone:target,field:'rate', value:value},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);
			object.attr("data-value",value);
			if(value==1){
				object.addClass("goldstar");
			}else{
				object.removeClass("goldstar");
			}
		}).fail(function(response,status){

		});			
	});

	//Change event in the profile event in info window
	$(".property_val").change(function(){
		var field = $(this).attr("data-target");
		var target = $("#sel_phone").val();
		var value = $(this).val();
		if($(this).hasClass("checkbox")){
			value = (this.checked)?1:0;
		}
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{phone:target, field:field, value:value },
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});				
	});

	$(".property_val.selectbox ul li").click(function(){
		var target = $("#sel_phone").val();
		var field = $(this).parent().parent().attr("data-target");
		var value = $(this).attr("data-value");

		console.log("target", target);
		$.ajax({
			url:"/api/api_messenger/update_member_info",
			data:{phone:target,field:field,value:value},
			type:"POST"
		}).done(function(response, status){
			console.log("Update Status",response.result);

		}).fail(function(response,status){

		});	

	});
	//Info change

	/*For adding pagination to the recent chat and incoming text */
	$(".btnclose").click(function(){
		var target = $(this).attr("data-target");
		$(".btninfo").removeClass("active");
		$("#"+target).fadeOut();
	})
	$("#pagination").on("click","li.page", function(){
		var target = $(this).attr("data-value");
		var new_page = parseInt(target);
		if(new_page!= current_page){
			current_page = new_page
			init_smsarea();
		}
	});
	$("#pagination").on("click","li.next", function(){
		if(current_page<total_page-1){
			current_page++;
			init_smsarea();
		}		
	});	
	$("#pagination").on("click","li.prev", function(){
		if(current_page>0){
			current_page--;
			init_smsarea();
		}		
	});	
	$("#pagination").on("click","li.first", function(){
			current_page=0;
			init_smsarea();
	});	
	$("#pagination").on("click","li.last", function(){
			current_page=total_page - 1;
			init_smsarea();
	});	

	//For filtering
	$("body").on("change",".filter_grade input",function(){
		var target = $(this).attr("data-value");
		list_newsmslist();
	});
	$("body").on("click",".filter_star li",function(){
		var target = $(this).attr("data-value");
		list_newsmslist();
	});


	//
	$("body").on("click", ".chat", function(){
		var target = $(this).attr("data-target");
		var sms_id = $(this).attr("data-id");
		$.ajax({
			url:"/api/api_messenger/update_message_readstatus",
			data:{id:sms_id, phone:target},
			type:"POST"
		})
		.done(function(){
			//init_recent_userarea();
			reload_pageinfo();
		})
		.fail(function(){

		});
		init_chatwindow(target);
	});

	$("#smsarea").on("click",".delete", function(){
		var target = $(this).attr("data-target");
		removeMessage(target);	
	})

	$("body").on("click",".loadmore", function(){
		$(".profile").fadeOut();
		var target = $(this).attr("data-target");
		var cur_id = $(this).attr("data-id");
		$("#target_phone").val(target);
		$("#moreid").val(target);
		console.log("show more for "+ target);

		$.ajax({
			url:"/api/api_messenger/load_message",
			data:{phone:target,id:cur_id},
			type:"POST"
		}).done(function(response,status){
			//console.log(response);
			add_moremessage(response.result.msg);
			$("#moremessages").fadeIn();
		}).fail(function(response,status){

		});


	});

	$(".btn-search").click(function(){
		list_newsmslist();
	});

	$(".search-query").keyup(function(e){
		if(e.which==13){
			console.log("enter key pressed in the search function");
			list_newsmslist();
		}
	})

	//when clicking the address, display the zillow property and google
	//option:0 => zillow property displaying from backend (search api)
	//option:1 => google map search api
	$(".showmap").click(function(){
		var addr = $(this).attr("data-addr");
		var zip=$(this).attr("data-zip");
		var option= $(this).attr("data-option");
		if(option=='0'){
			var win = window.open($(this).attr("data-url"), '_blank');					
		}else{
			var url= "https://www.google.com/maps/search/?api=1&query="+addr+", "+zip;
			var win = window.open(url, '_blank');
		}

	});

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
			window.open("https://podio.com/monacopropertygroupcom/bay-capital-holdings/apps/cash-buyers","_blank");
			return;
		}
		
		$.ajax({
			url:"/api/api_messenger/upload_cashbuyer_podio",
			type:"POST",
			data:{
				'leads[buyer-name]':$("#pname").text(),
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
				$.ajax({
					url:"/api/api_messenger/update_member_info",
					data:{phone:target,field:'leadtype', value:'Cash Buyer'},
					type:"POST"
				}).done(function(response, status){
				}).fail(function(response,status){
				});					
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


	reload_newsmslist();  //List the new sms first time;;;

	//reload_users_numberinfo();
	//get_listrecentsms();
	/*setTimeout(function(){
		location.reload();
	}, 60000);
	*/
});

var total_page=0;
var current_page=0;
var entries_page = 0;

function add_moremessage(rows){
	var length=rows.length;
	$("#moremessages tbody").html("");
	if(length==0) return ;
	for(var i=0;i<length; i++){
		add_onemessage_in_moredlg(rows[i]);
	}
	$("#moreid").val(rows[length-1].No);
}

function add_onemessage_in_moredlg(row){

	var itemstring = `<tr>
		<td>`+row.RecTime+`</td>
		<td>`+row.Content+`</td>
		</tr>`;
	$("#moremessages tbody").append(itemstring);
}


function removeMessage(target){
	$.ajax({
		url:"/api/api_messenger/remove_message",
		data:{id:target},
		type:"POST"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			reload_pageinfo();				
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modal_content").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});		
}

function reload_newsmslist()
{
	console.log("reload newsms");
	$(".profile").fadeOut();
	var old = parseInt($("#number_entries_perpage").val());
	if(entries_page!= old){
		entries_page=old;
		console.log("entries_page:", entries_page);	
		$("#current_no").val("-1");
		reload_pageinfo();		
	}

}

function reload_pageinfo(){
	$.ajax({
		url:"/api/api_messenger/get_numbers_newsms"
	})
	.done(function(data,status){
		//console.log(data);
		if(data.status=="ok"){
			try{
				total_page = parseInt((parseInt(data.result["total"])+entries_page-1)/entries_page);
			}catch(e){
				total_page=1;
			}			
			console.log("total pages:", total_page);
			if(total_page<=current_page){
				current_page = Math.max(0, total_page -1);
			}
			init_smsarea();
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});	
}


function init_smsarea(){
		init_page_area();
		list_newsmslist();	
}

function list_newsmslist()
{
	var searchstring = $(".search-query").val();
	var grades=[];
	var star = $(".filter_star input[type=hidden]").val();
	//if($(".filter_grade input[type=hidden]").val()!="-1"){
		$(".filter_grade input").each(function(){
			if($(this).prop("checked")==true) grades.push($(this).attr("data-value"));
		})

	var userid = $("#dropusers").val();
	var leadtype= $("#dropleadtype").val();
	//}

	$.ajax({
		url:"/api/api_messenger/get_list_newsms/"+current_page+"/"+entries_page,
		data:{search:searchstring, grades:grades, star:star, userid:userid, leadtype:leadtype},
		type:"POST"
	})
	.done(function(data,status){
		//console.log(data);
		if(data.status=="ok"){
			console.log(data.result);
			add_data_smsarea(data.result);
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});		
}

function add_data_smsarea(data){
	$("#smsarea tbody").html("");
	var length = data.length;
	for(var i=0; i<length ;i++){
		var item = data[i];
		add_item(item);  //add item after last
	}
	if(length>0){
		$("#current_no").val(Math.max(parseInt(data[0].No),parseInt($("#current_no").val())));
	}else{
		//$("#current_no").val("0");
	}
	refresh_selectbox();
}

function add_item(item, direction=0){  //0:add after last 1:add before the first
	var fromuser="";
	if(item.firstname==null || item.firstname==""){
		fromuser=item.FromNum;
	}else{
		fromuser=item.firstname+" "+((item.lastname==null || item.lastname=="")?"":item.lastname);
	}
	var readstatus = "";
	if(item.readstatus=='0'){
		readstatus = "<span class='newmsg'>&#9679;</span>";
			//console.log(item,"ss", item.readstatus);
	}
	//Check grade
	var grade=0;
	if(item.grade == null){
		grade=-1;
	}else{
		grade =item.grade;
	}

	var strclass="";
	if(item.rate !='0') strclass=" goldstar";


	var starstring =`<span class='star`+strclass+`' data-target='`+item.FromNum+`' data-value='`+item.rate+`'>&#9733;</span>`;

	var leadtype =""
	try{
		leadtype = item.leadtype.replace(/Ow/, '');
	} catch(e){

	}
//formatDate(item.RecTime, "MM/dd/yy hh:mm a")
	var podio = (item.podioitemid !="" || item.podiosellerid !="" || item.podiocashbuyerid!="" || item.realtor=='1' )?`<a class='sentpodio'><img style='width:25px;height:25px' src='/assets/images/podio.png'></img></a>`:"";
//`<span class='loadmore' data-target='`+item.FromNum+`' data-id='`+item.No+`'>&#x25BE;</span>
   var itemstring=
   "<tr data-target='"+item.FromNum+"'>\
	    <td>"+starstring+readstatus+date_format(item.RecTime) + "</td>\
	    <td>"+fromuser+"</td>\
	    <td class='loadcontent'>"+item.Content+`<span class='loadmore' data-target='`+item.FromNum+`' data-id='`+item.No+`'>&#x25BE;</span></td>
	    <td>`+leadtype+`</td>
	    <td>
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' name='' value='`+grade+`' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='grade' data-target='`+item.FromNum+`'>
	                <li data-value='Low'>Low</li>
	                <li data-value='Medium'>Medium</li>
	                <li data-value='High'>High</li>
	                <li data-value='Nurture'>Nurture</li>
	            </ul>
	        </a>
		</td>	
		<td>`+item.send_username+`</td>	
	    <td>
	        <a class='btninfo btnpadding' data-target='`+item.FromNum+`'><i class="fa fa-info-circle" aria-hidden="true"></i></a>
	        <a class='chat btnpadding' data-target='`+item.FromNum+`' data-id='`+item.No+`'><i class='fa fa-weixin' aria-hidden='true'></i></a>
	        <a class='delete btnpadding' data-target='`+item.No+`'><i class="fa fa-trash" aria-hidden="true"></i></a>`+podio+`
	    </td>
	  </tr>`;	
	 if(direction==0){
	 	$("#smsarea tbody").append(itemstring);
	 }
	 else{
		$("#smsarea tbody").prepend(itemstring);
	 }

	 //Get more messages to display 2-3 messages for the one user

		$.ajax({
			url:"/api/api_messenger/load_message",
			data:{phone:item.FromNum,id:item.No},
			type:"POST"
		}).done(function(response,status){
			//console.log(response);
			add_moremessagearea(response.result);
			
		}).fail(function(response,status){

		});	 
}

function add_moremessagearea(result){
	var phone = result.phone;
	var msgs = result.msg;
	$("tr").each(function(){
		var target = $(this).attr("data-target");
		if(target == phone){ //For the corresponding the number
			var length = msgs.length;
			for(var i=0; i<Math.min(length,2); i++){
				//console.log(msgs[i]);
				var itemstring = `<div class='moremsgcontent'>`+msgs[i]["Content"]+`</div>`;
				$(this).find(".loadcontent").append(itemstring);
			}

			return false;
		}
	})
}


function get_listrecentsms(){
	//$curno='0',$page='0',$entries='10'
	var current_no = $("#current_no").val();
	$.ajax({
		url:"/api/api_messenger/get_list_recentnewsms",
		type:"POST",
		data:{
			curno:current_no,
			page:current_page,
			entry:entries_page
		}
	})
	.done(function(data,status){
		add_newdata_smsarea(data.result);		
		if(data.result.length>0)list_newsmslist();
		//console.log("success", data);
		setTimeout(get_listrecentsms,1500);
		
	})
	.fail(function(data,status){
		console.log("fail", data);
		setTimeout(get_listrecentsms,1500);
		
	});
}

function add_newdata_smsarea(data){
	var length = data.length;
	/*for(var i=0; i<length ;i++){
		var item = data[i];
		add_item(item,1);  //add item after last
		var count_elements = $('#smsarea tbody tr').length;
		if(count_elements>entries_page)$("#smsarea tbody tr").last().remove();
		trigger_notification(item);
	}*/
	if(length>0){
		$("#current_no").val(data[0].No);
		//init_recent_userarea();
	}else{
		
	}	
}

function trigger_notification(item=null)
{
    //check if browser supports notification API
    if("Notification" in window)
    {
        if(Notification.permission == "granted" && item!=null)
        {
            var notification = new Notification("You've received the sms from "+item.FromNum, {"body":item.Content, "icon":"https://sms.probateproject.com/assets/images.jpg"});
            /* Remove the notification from Notification Center when clicked.*/
			notification.onclick = function () {
					//window.open(url); 
				console.log("clicked");
			};

			/* Callback function when the notification is closed. */
			notification.onclose = function () {
				console.log('Notification closed');
			};
 			setTimeout(notification.close.bind(notification), 3000);
        }
        else
        {
            Notification.requestPermission(function (permission) {
                if (permission === "granted") 
                {
                    var notification = new Notification("Notification", {"body":"You will receive the new sms.", "icon":"http://qnimate.com/wp-content/uploads/2014/07/web-notification-api-300x150.jpg"});
					notification.onclick = function () {
							//window.open(url); 
						console.log("clicked");
					};

					/* Callback function when the notification is closed. */
					notification.onclose = function () {
						console.log('Notification closed');
					};                    
					setTimeout(notification.close.bind(notification), 3000);
                }

            });
        }
    }   
    else
    {
        alert("Your browser doesn't support notfication API");
    }       
}

function init_chatwindow(target)
{
	$("#chatbox .title").text("Chat with "+target);

	//$("#chatbox").fadeIn();
	window.open("/messenger/chat/"+encodeURI(target),"_blank");
}

/*

function init_recent_userarea()
{
	$("#recentchatuser tbody").html("");
	$.ajax({
		url:"/api/api_messenger/get_recent_chatusers/"+current_userpage
	}).done(function(data,status){
		var length = data.result.length;
		console.log(data.result);
		for(var i=0;i<length;i++){
			var item = data.result[i];
			add_useritem(item);
		}
		refresh_selectbox();
	}).fail(function(data,status){

	});
}

function add_useritem(item,direction=0){
	var fromuser="";
	if(item.firstname==null || item.firstname==""){
		fromuser=item.FromNum;
	}else{
		fromuser=item.firstname+" "+((item.lastname==null || item.lastname=="")?"":item.lastname);
	}
	//Check grade
	var grade=0;
	if(item.grade == null){
		grade=-1;
	}else{
		grade =item.grade;
	}
   var itemstring=
   "<tr>\
	    <td>"+item.ChatTime+"</td>\
	    <td>"+fromuser+`</td>
	    <td>`+item.Content+`</td>
	    <td>`+item.leadtype+`</td>
	    <td>
	        <a class='btn btn-default btn-select'>
	            <input type='hidden' class='btn-select-input' name='' value='`+grade+`' />
	            <span class='btn-select-value'>Select an Item</span>
	            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
	            <ul class='grade' data-target='`+item.FromNum+`'>
	                <li data-value='0'>Low</li>
	                <li data-value='1'>Medium</li>
	                <li data-value='2'>High</li>
	            </ul>
	        </a>
	    </td>
	    <td>
	        <a class='btninfo btnpadding' data-target='`+item.FromNum+`'><i class="fa fa-info-circle" aria-hidden="true"></i></a>
	        <a class='chat btnpadding' data-target='`+item.FromNum+`' data-id='`+item.No+`'><i class='fa fa-weixin' aria-hidden='true'></i></a>
	        <a class='delete btnpadding' data-target='`+item.No+`'><i class="fa fa-trash" aria-hidden="true"></i></a>
	    </td>
	  </tr>`;	
	 if(direction==0){
	 	$("#recentchatuser tbody").append(itemstring);
	 }
	 else{
		$("#recentchatuser tbody").prepend(itemstring);
	 }	
}

var total_userpage=1;
var entry_users_perpage=5;
var current_userpage=0;

function reload_users_numberinfo(){
	$.ajax({
		url:"/api/api_messenger/get_numbers_users"
	})
	.done(function(data,status){
		console.log(data);
		if(data.status=="ok"){
			try{
				total_userpage = parseInt((parseInt(data.result["total"])+entry_users_perpage-1)/entry_users_perpage);
			}catch(e){
				total_userpage=1;
			}			
			console.log("total pages:", total_page);
			total_userpage = Math.min(10,total_userpage);
			init_userarea();
		}else{
			console.log("error::", data);
		}
	})
	.fail(function(data,status){
		$("#msgbox .modalcontent").text("Please check your internet connection.");
		$("#msgbox").fadeIn();
	});	
}

function init_userarea(){
	init_recent_userarea();
	init_userpage_area();
}

*/
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

/**
 * New feature for search
 */

 function list_leadtypes(items)
 {
	 var length = items.length;
	 var itemstring =`<li data-value="-1">All</li>`;
	 $(".dropleadtype ul").html("");
	 $(".dropleadtype ul").append(itemstring);
	 for( var i=0;i <length;i++){
		 var item = items[i];
		 var itemstring=`<li data-value="`+item["leadtype"]+`">`+item["leadtype"]+`</li>`;
		 $(".dropleadtype ul").append(itemstring);
	 }
	 refresh_selectbox();
 }

 function listusers(items){
	var length = items.length;
	var itemstring =`<li data-value="-1">All</li>`;
	$(".dropusers ul").html("");
	$(".dropusers ul").append(itemstring);
	for( var i=0;i <length;i++){
		var item = items[i];
		var itemstring=`<li data-value="`+item["No"]+`">`+item["Name"]+`</li>`;
		$(".dropusers ul").append(itemstring);
	}
	refresh_selectbox();
 }