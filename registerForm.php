<?php session_start(); ?>
<html>
<head>
<style type="text/css">
div{width:200px;}
form{text-align:left;}
</style>
</head>
<body>
	<div>
		<form method="POST" action="ReportWithAwql.php">
			<?php
			if(isset($_GET['exception'])){
				$e = $_GET['exception'];				
  				printf("An error has occurred: %s\n", $e->getMessage());
			}
			?>

			<label>Client ID</label><input type="text" name="client_id" size="100"/><br/>
			<label>Client Secret</label><input type="text" name="client_secret" size="100"/><br/>
			<label>Developer Token</label><input type="text" name="developer_token" size="100"/><br/>
			<label>Refresh Token</label><input type="text" name="refresh_token" size="100"/><br/>
			<label>Client Customer ID</label><input type="text" name="client_customer_id" size="100"/><br/>
			<input type="submit" name="new_user" value="ACCESS"/>
		</form>
	</div>
</body>
</html>