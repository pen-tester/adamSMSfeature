var total_pages=1;
var current_page = 0;
var target_pagination_id="";

$(document).ready(function(){
    $(".pagination").on("click", ".prevpage", function(){
        prevpage();
        $(".singlepage").removeClass("active");
        $(target_pagination_id+" .pcontent span[data-target="+current_page+"]").addClass("active");        
    });
    $(".pagination").on("click", ".nextpage", function(){
        nextpage();
        $(".singlepage").removeClass("active");
        $(target_pagination_id+" .pcontent span[data-target="+current_page+"]").addClass("active");        
    });
    $(".pagination").on("click", ".singlepage", function(){
        pageaction();
        $(".singlepage").removeClass("active");
        $(target_pagination_id+" .pcontent span[data-target="+current_page+"]").addClass("active");
    });        
});

function init_pagination(){
    $(target_pagination_id+" .pcontent").html("");
    for(var i=0; i<total_pages ;i++){
        var pclass='';
        var pagestring = `<span data-target='`+i+`' class="singlepage">`+(i+1)+`</span>`;
        $(target_pagination_id+" .pcontent").append(pagestring);
    }

    $(target_pagination_id+" .pcontent span[data-target="+current_page+"]").addClass("active");
}