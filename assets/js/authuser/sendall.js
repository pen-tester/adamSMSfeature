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
    
    $(".btnclose").click(function(){
        var target = $(this).attr("data-target");
        $("#"+target).fadeOut();
        console.log("close", target);
    })

	$("body").on("click",".btn-select",function(){
		$(this).find("ul").toggle();
	});

    $(".btn_archive").click(function(){
        window.open("/authuser/archive","_blank");        
    });

   //Clicking the upload csv button
   $(".btnupload").click(function(){
        var formData= new FormData($("#frm_upcsv")[0]);
        $.ajax({
            url:"/api/api_authuser/upload_csv",
            data:formData,
            type:"POST",
            processData: false,
            contentType: false            
        }).done(function(response, status){
            if(response.status=='ok'){
                reload_phones();
            }
        }).fail(function(resp, status){

        });
    });

    $(".btndeleteall").click(function(){
        $.ajax({
            url:"/api/api_authuser/delete_allphones"         
        }).done(function(response, status){
            if(response.status=='ok'){
                reload_phones();
            }
        }).fail(function(resp, status){

        });       
    })


});

function reload_phones(){
    angular.element($('#sendallController')).scope().reload_uploaded_phone();   
    angular.element($('#sendallController')).scope().$apply(); 
}