$(document).ready(function(){

    init();

    //List the system numbers
    $(".btn_list_system_numbers").click(function(){
        $.ajax({
            url:"/api/api_authuser/list_system_numbers"
        }).done(function(res, status){
            if(res.status=='ok'){
                show_system_numbers(res.result);
            }
        }).fail(function(res, status){

        });
    });

    //List the twilio numbers
    $(".btn_list_twilio_numbers").click(function(){
        $.ajax({
            url:"/api/api_authuser/list_twilio_numbers"
        }).done(function(res, status){
            if(res.status=='ok'){
                show_twilio_numbers(res.result);
            }
        }).fail(function(res, status){

        });
    });  
    
    
    //When clicking the system number;
    $("body").on("click", ".sysnumber" ,function(){
        var phone  = $(this).attr("data-phone");
        var sid = $(this).attr("data-sid");
        $("#phonenumber").val(phone);
        $("#phonenumber").attr("data-sid", sid);
    });

    //When clicking the system number;
    $("body").on("click", ".twinumber" ,function(){
        var phone  = $(this).attr("data-phone");
        $("#phonenumber").val(phone);
        $("#phonenumber").attr("data-sid", "");
    });    

    //Update the sms twilio number;
    $(".btn_update_smsnumber").click(function(){
        var phone = $("#phonenumber").val();
        var sid = $("#phonenumber").attr("data-sid");
        $.ajax({
            url:"/api/api_authuser/update_userinfo",
            data:{'leads[twiliophone]':phone, 'leads[twilionumbersid]':sid},
            type:"POST"
        }).done(function(res,status){

        }).fail(function(res, status){

        });
    });
    $(".btn_update_callnumber").click(function(){
        var phone = $("#callnumber").val();

        $.ajax({
            url:"/api/api_authuser/update_user",
            data:{'leads[backwardnumber]':phone},
            type:"POST"
        }).done(function(res,status){

        }).fail(function(res, status){

        });
    });    
});

function init(){
    $.ajax({
        url:"/api/api_authuser/get_current_number"
    }).done(function(res, status){
        if(res.status=='ok'){
            $("#phonenumber").val(res.result["phone"]);
            $("#phonenumber").attr("data-sid",res.result["sid"] )
        }
    }).fail(function(res, status){

    });   
    $.ajax({
        url:"/api/api_authuser/get_current_callnumber"
    }).done(function(res, status){
        if(res.status=='ok'){
            $("#callnumber").val(res.result["phone"]);

        }
    }).fail(function(res, status){

    });      
}

function show_system_numbers(items){
    $("#system_numbers").html("");
    var length = items.length;
    for(var i=0; i<length; i++){
        var item = items[i];
        var itemstring = `<li class="sysnumber" data-sid="`+item.sid+`" data-phone="`+item.phone+`">`+item.phone+`</li>`;
        $("#system_numbers").append(itemstring);
    }

}


function show_twilio_numbers(items){
    $("#twilio_numbers").html("");
    var length = items.length;
    for(var i=0; i<length; i++){
        var item = items[i];
        var itemstring = `<li class="twinumber" data-phone="`+item.phone+`">`+item.phone+`</li>`;
        $("#twilio_numbers").append(itemstring);
    }

}
