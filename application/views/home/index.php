<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Twilio API</title>
	<link href="<?php echo base_url(); ?>dist/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>dist/assets/css/styles.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo base_url(); ?>dist/assets/js/jquery.min.js"></script>
</head>
<body>
<div class="container">
	<form>
		<div class="form-group">
			<label for="phone">Phone Number:</label>
			<input type="text" class="form-control" id="phone">
		</div>
		<div class="form-group">
			<label for="message">Message:</label>
			<textarea class="form-control" id="message"></textarea>
		</div>
		<button type="submit" class="btn btn-default pull-right phone_send">Send</button>
		<div class="email_form">
			<div class="form-group">
				<label for="email">Your Email:</label>
				<input type="email" class="form-control" id="email">
			</div>
			<button type="submit" class="btn btn-default pull-right email_send">Authenticate</button>
		</div>
		<div class="ticket_form">
			<div class="form-group">
				<label for="ticket">Your Ticket:</label>
				<textarea class="form-control" id="ticket"></textarea>
			</div>
			<button type="submit" class="btn btn-default pull-right ticket_send">Submit</button>
		</div>
	</form>
</div>
<?php
	include_once("index_js.php");
?>
</body>
</html>