$(document).ready(function(){
	console.log("layout ready");
	setInterval(makeanimate , 2000);

	//For checkbox
	$("#HasCustomMessage").change(function(){
        if($(this).is(":checked")) {
           $("#CustomMessage").show();
        }
        else{
			$("#CustomMessage").hide();
        }
	});

	 //For order
	 $("#submitorder").click(function(){

	 	if(validation()){
			var form = $("form");
			 
			    // No pressing the buy now button more than once
			form.find('button').prop('disabled', true);
		   stripe.createToken(card).then(function(result) {
		    if (result.error) {
		      // Inform the user if there was an error
		      var errorElement = document.getElementById('card-errors');
		      errorElement.textContent = result.error.message;
		      form.find('button').prop('disabled', false);
		    } else {
		      // Send the token to your server
		      stripeTokenHandler(result.token);
		    }
		  });

	 	}

	 });
});


function validation(){
	$("#recipients").find("p").remove();
	$(".groupname").find("p").remove();
	if($("#recipient").val() == ""){
		$("#recipient").parent().after("<p>This is required field</p>");
		return false;
	}
	var phonenumber = new RegExp('^[0-9]{8,11}$');
	if(!phonenumber.test($("#recipient").val())){
		$("#recipient").parent().after("<p>phone number format error</p>");
		return false;		
	}
	if($("#Customer").val() == ""){
		$("#Customer").parent().after("<p>This is required field</p>");
		return false;
	}
	return true;
}

var index=0;


function makeanimate(){
	if(index<8){
		index++;
		$(".text-message").animate({top:"-=250px"}, 500);
	} 
	else{
		index = 0;
		var off= 8*250;
		$(".text-message").animate({top:"+="+off+"px"}, 500);
	}
}

function stripeTokenHandler(token) {
    var form = $('form');
 
       // Otherwise, we're good to go! Submit the form.
 
        // Insert the unique token into the form
        $('<input>', {
            'type': 'hidden',
            'name': 'stripeToken',
            'value': token.id
        }).appendTo(form);
 
        // Call the native submit method on the form
        // to keep the submission from being canceled
        form.submit();
}

// Create a Stripe client
var stripe = Stripe('pk_test_LP7XHiOeiFCito4XjafMmEJW');

// Create an instance of Elements
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '24px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();


});