$(document).ready(function(){	
	//initFCM();
	trigger_notification();
	$("#btnchat").click(function(){
		if(inited == false)return;
		$("#current_phone").text($("#phone").val());
		inited=false;
		//Calling the chat history....
		$.ajax({
		      type: 'POST',
		      url: "/api/list_chat",
		      data: {phone:$("#phone").val()}
		  })
		       //dataType: "none"})
		.done(function(data,status) 
		{ 
			console.log("success");
	      	console.log(data);
	      	initchat(data);
	    }
		).fail(function(data,status){
			console.log("fail");
			console.log(data);
			inited = true;
		});		
	});

	$("#btnsendsms").click(function(){
		if(check_phone()==true){
			$("#current_phone").text($("#phone").val());
			//Calling the sned sms api.......
			console.log($("#sms").val());
			$.ajax({
			      type: 'POST',
			      url: "/api/send_singlesms",
			      data: {phone:$("#phone").val(),content:$("#sms").val()}
			  })
			       //dataType: "none"})
			.done(function(data,status) 
			{ 
				console.log("success");
		      	console.log(data);
		      	$("#sms").val("");
		    }
			).fail(function(data,status){
				console.log("fail");
				console.log(data);
				$("#errorcontent").text("Send sms error");
				$("#errorbox").fadeIn();
				$("#sms").val("");
			});	

		}
		else{
			$("#errorcontent").text("Phone number is incorrect or Sms content is empty");
			$("#errorbox").fadeIn();	
		}
	});
	$(".btnclose").click(function(){
		$("#errorbox").fadeOut();
	});

	setTimeout(get_newsms, 1500);

});

function get_newsms(){
	var error=false;
	if(inited == false)  error = true;
	var phone = $("#current_phone").text();
	if(phone == "") error=true;
	var reg = new RegExp("^\\+1[0-9]{10}$");
	if(!reg.test(phone)) error=true;
	if(error==false){
		var sphone = $("#phone").val();
		var id = $("#topid").val();
		
		//Calling the chat history....
		$.ajax({
		      type: 'POST',
		      url: "/api/list_chat_new",
		      data: {phone:sphone,id:id}
		  })
		       //dataType: "none"})
		.done(function(data,status) 
		{ 
			console.log("success");
	      	console.log(data);
	      	addchat(data);
	      	setTimeout(get_newsms, 1500);
	    }
		).fail(function(data,status){
			console.log("fail");
			console.log(data);
			setTimeout(get_newsms, 1500);
		});		
	}	
	else setTimeout(get_newsms, 1500);
}


//Check the current phone number is correct....
function check_phone(){
	var phone = $("#current_phone").text();
	if($("#sms").val()=="") return false;
	if(phone == "") return false;
	var reg = new RegExp("^\\+1[0-9]{10}$");
	if(reg.test(phone)) return true;
	return false;
}

function addchat(data){
	var length = data.length;
	var phone = $("#current_phone").text(); 

	for(var i=0;i<length; i++){
		var item = data[i];
		var htmlitem;
		if(item.FromNum == phone){ //Algign left
			additem(item,0);
		}else{  //Aligin right
			additem(item,1);
		}
	}
	if(length>0){
		$("#topid").val(data[0].No);
	}
}
var inited= true;
function initchat(data){
	var length = data.length;
	var phone = $("#current_phone").text(); 
	$("#msgcontent").html("");

	for(var i=0;i<length; i++){
		var item = data[i];
		var htmlitem;
		if(item.FromNum == phone){ //Algign left
			htmlitem="<div class='row'> \
					   <div class='chatbox  placeleft'>"+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-left'>"
					   +item.RecTime+
					   "</span></div>\
					</div>";
		}else{  //Aligin right
			htmlitem="<div class='row'> \
					   <div class='chatbox  placeright'>"+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-right'>"
					   +item.RecTime+
					   "</span></div>\
					</div>";
		}

		$("#msgcontent").append(htmlitem);
	}
	if(length>0){
		$("#topid").val(data[0].No);
	}
	inited = true;
}

function additem(item,direction=0){
	var htmlitem;
		if(direction== 0){ //Algign left
			htmlitem="<div class='row'> \
					   <div class='chatbox  placeleft'>"+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-left'>"
					   +item.RecTime+
					   "</span></div>\
					</div>";
		}else{  //Aligin right
			htmlitem="<div class='row'> \
					   <div class='chatbox  placeright'>"+
					     item.Content+
					   "</div>\
					   <div><span class='rectime text-right'>"
					   +item.RecTime+
					   "</span></div>\
					</div>";
		}

		$("#msgcontent").prepend(htmlitem);
}

function trigger_notification()
{
    //check if browser supports notification API
    if("Notification" in window)
    {
        if(Notification.permission == "granted")
        {
            var notification = new Notification("Notification", {"body":"You will receive the new sms.", "icon":"http://qnimate.com/wp-content/uploads/2014/07/web-notification-api-300x150.jpg"});
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

function initFCM(){
	  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyAyRANuVEUyoIsY4dIkykFlpFrpy6MNHTY",
    authDomain: "adamsms-c2cd9.firebaseapp.com",
    databaseURL: "https://adamsms-c2cd9.firebaseio.com",
    projectId: "adamsms-c2cd9",
    storageBucket: "adamsms-c2cd9.appspot.com",
    messagingSenderId: "11495849866"
  };
  firebase.initializeApp(config);
  const messaging = firebase.messaging();  
	messaging.onMessage(function(payload) {
	  console.log("Message received. ", payload);
	  // ...
	});  
	messaging.setBackgroundMessageHandler(function(payload) {
	  console.log('[firebase-messaging-sw.js] Received background message ', payload);
	  // Customize notification here
	  const notificationTitle = 'Someone sent you sms';
	  const notificationOptions = {
	    body: 'Please reply.',
	    icon: 'http://qnimate.com/wp-content/uploads/2014/07/web-notification-api-300x150.jpg'
	  };

	  return self.registration.showNotification(notificationTitle,
	      notificationOptions);
	});	
}