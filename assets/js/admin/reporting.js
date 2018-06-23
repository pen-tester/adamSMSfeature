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

	$("body").on("click",".btn-select",function(){
		$(this).find("ul").toggle();
	});
    
    $('#daterange').daterangepicker({
        "startDate": "01/20/2018",
        "endDate": "01/26/2018"
    }, function(start, end, label) {
        setting_daterange(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });   
    
    $(".filter_grade input[type=checkbox]").change(function(){
        var grades=[];
        $(".filter_grade input[type=checkbox]").each(function(){
            if($(this).prop("checked")){
                grades.push($(this).val());
            }
        });
        setting_grades(grades);
    })
})

function setting_daterange(start, end){
    angular.element($('#reportingController')).scope().setting_daterange(start, end);   
    angular.element($('#reportingController')).scope().$apply(); 
}

function setting_grades(grades){
    angular.element($('#reportingController')).scope().setting_grades(grades);   
    angular.element($('#reportingController')).scope().$apply(); 
}