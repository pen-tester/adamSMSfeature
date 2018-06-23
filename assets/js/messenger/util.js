
function formatDate(datestring,format) {
	var date = new Date(datestring);
	format=format+"";
	var result="";
	var i_format=0;
	var c="";
	var token="";
	var y=date.getYear()+"";
	var M=date.getMonth()+1;
	var d=date.getDate();
	var E=date.getDay();
	var H=date.getHours();
	var m=date.getMinutes();
	var s=date.getSeconds();
	var yyyy,yy,MMM,MM,dd,hh,h,mm,ss,ampm,HH,H,KK,K,kk,k;
	// Convert real date parts into formatted versions
	var value=new Object();
	if (y.length < 4) {y=""+(y-0+1900);}
	value["y"]=""+y;
	value["yyyy"]=y;
	value["yy"]=y.substring(2,4);
	value["M"]=M;
	value["MM"]=LZ(M);
	value["MMM"]=MONTH_NAMES[M-1];
	value["NNN"]=MONTH_NAMES[M+11];
	value["d"]=d;
	value["dd"]=LZ(d);
	value["E"]=DAY_NAMES[E+7];
	value["EE"]=DAY_NAMES[E];
	value["H"]=H;
	value["HH"]=LZ(H);
	if (H==0){value["h"]=12;}
	else if (H>12){value["h"]=H-12;}
	else {value["h"]=H;}
	value["hh"]=LZ(value["h"]);
	if (H>11){value["K"]=H-12;} else {value["K"]=H;}
	value["k"]=H+1;
	value["KK"]=LZ(value["K"]);
	value["kk"]=LZ(value["k"]);
	if (H > 11) { value["a"]="PM"; }
	else { value["a"]="AM"; }
	value["m"]=m;
	value["mm"]=LZ(m);
	value["s"]=s;
	value["ss"]=LZ(s);
	while (i_format < format.length) {
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		if (value[token] != null) { result=result + value[token]; }
		else { result=result + token; }
		}
	return result;
}
var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
var DAY_NAMES=new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
function LZ(x) {return(x<0||x>9?"":"0")+x}

$(document).ready(function(){
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

})

function refresh_selectbox(){
	$(".btn-select ul li").removeClass("selected");
	$(".btn-select").each(function(){
		var sel_val = $(this).find("input[type=hidden]").val();
		var parent = this;
		try{

				$(this).find("ul li").each(function(){
					var val = $(this).attr("data-value");
					var text = $(this).text();
					if(val.toLowerCase()==sel_val.toLowerCase()) {
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

function date_format(datestring){
   var timeparts = datestring.split(/\s+/);
   var dateparts = timeparts[0].split("-");
   var times = timeparts[1].split(":");
   var am="AM";
   var time=times[0];
   if(+times[0] > 12){
	am="PM";
	time = (+times[0] - 12);
   } 
   return dateparts[1]+"/"+dateparts[2]+"/"+dateparts[0]+" "+time+":"+times[1]+ " "+am;
}
