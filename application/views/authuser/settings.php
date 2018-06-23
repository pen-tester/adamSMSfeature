<link href="/assets/styles/authuser/settings.css?1" rel="stylesheet"/>
<div class="container">
	<div class="row">
		<div class="form-group">
			<label>Setting the backward phone number that receives calling</label>
			<input type="text" id="callnumber" />
			<button class="btn btn-primary btn_update_callnumber">Update</button>
		</div>
	</div>	
	<div class="row">
		<div class="form-group">
			<label>Setting the phone number that sends sms</label>
			<input type="text" readonly="readonly" id="phonenumber" />
			<button class="btn btn-primary btn_update_smsnumber">Update</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-lg-6">
			<label> List the phones in system </label>
			<ul id="system_numbers" class="number_list">

			</ul>
			<button class="btn btn-primary btn_list_system_numbers">List the System Number</button>
		</div>
		<div class="col-md-6 col-lg-6">
			<label> List the phones in twilio </label>
			<ul id="twilio_numbers" class="number_list">

			</ul>
			<button class="btn btn-primary btn_list_twilio_numbers">List the Twilio Number</button>
		</div>	
	</div>

</div>
<script defer="defer" type="text/javascript" src="/assets/js/authuser/settings.js?4"></script>