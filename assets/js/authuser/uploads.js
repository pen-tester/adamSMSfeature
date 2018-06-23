$(document).ready(function(){
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
    target_pagination_id = "#pagination";

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

    reload_phones();
});

var entries = 50;

function get_total_number_of_phones(){
    $.ajax({
        url:"/api/api_authuser/get_total_number_of_phones"          
    }).done(function(response, status){
        if(response.status=='ok'){
            total_pages =parseInt( (parseInt(response.result.total)+entries -1 )/entries);
            init_pagination();
        }
    }).fail(function(resp, status){

    });        
}

function reload_phones(){
    get_total_number_of_phones();

    current_page=0;

    get_phones_page();  
}

function get_phones_page(){
    $.ajax({
        url:"/api/api_authuser/list_phones/"+current_page+"/"+entries          
    }).done(function(response, status){
        if(response.status=='ok'){
            show_phones(response.result);
        }
    }).fail(function(resp, status){

    }); 
}

function show_phones(items){
    $("tbody").html("");
    var keys=["sent", "date_added",  "date_sent", "address", "city", "state", "firstname", "lastname", "owner_address", "owner_city", "owner_state", "phone0", "phone1", "phone2", "phone3", "phone4", "phone5", "phone6", "phone7", "phone8", "phone9", "leadtype"];
    var len = items.length;
    var keylen = keys.length;
    for(var i=0;i<len ;i++){
        var item = items[i];
        var itemstring ='';
        for(var ki=0 ; ki<keylen; ki++){
                itemstring = itemstring + `<td>`+item[keys[ki]]+`</td>`
        }
        $("tbody").append("<tr>"+itemstring+"</tr>");
    }
}

/*For pagination click event */
function nextpage(){
    console.log("next");
    if((+current_page)<(+total_pages-1)){
        current_page++;
        get_phones_page();
    }
}

function prevpage(){
    console.log("prev");
    if((+current_page)>0){
        current_page--;
        get_phones_page();
    }    
}

function pageaction(){
    console.log("page");
    var target = $(this).attr("data-target");
    current_page = target;
    get_phones_page();
}
/** */