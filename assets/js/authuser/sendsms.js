

var trigger = false;

$(document).ready(function(){
	$("#phonenumber").keyup(function(e){
		if(e.which == 8 || e.which ==46) return false;
		var phone=$(this).val();
		phone = phone.replace(/[^0-9\+]/gi,"");
		if(phone.substr(0,2) != "+1"){
			phone = "+1" + phone;
		}

		if(phone.length<6){
			phone = phone.slice(0,2)+"(" + phone.slice(2,5);
		}else if(phone.length<8){
			phone = phone.slice(0,2)+"(" + phone.slice(2,5)+") "+phone.slice(5,8);
		}else{
			phone = phone.slice(0,2)+"(" + phone.slice(2,5)+") "+phone.slice(5,8)+"-"+phone.slice(8,12);
		}
		$(this).val(phone);
	})
});