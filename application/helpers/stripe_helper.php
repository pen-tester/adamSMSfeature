<?php

	include_once(APPPATH."libraries/stripelib/vendor/autoload.php");

	function getStripeConfig(){
		$stripe = array(
		  "secret_key"      => "sk_test_lsGYOZTfSKbTn9GALxLAb1pm",
		  "publishable_key" => "pk_test_LP7XHiOeiFCito4XjafMmEJW"
		);
		return $stripe;
	}
?>