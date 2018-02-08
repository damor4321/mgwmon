<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Alert Deactivation Sendings</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
		<?=HTML::script('media/scripts/jquery.min.js');?>
	    <?=HTML::style('media/css/default.css');?>
	      <script type="text/javascript" charset="utf-8">
	  		$(document).ready(function(){
	  			 $('#back').click(function(){
	  				  var root = location.protocol + '//' + location.host;				  
	  				   document.location.href=root +"<?=URL::base()?>index.php/alert/list/";
	  				})
	  		});			
		</script>
	</head>
	<body>

<br/>
Regarding the Alert <?=$alert->name?>, it has been sent to the users:
<br/>
<?php 
foreach($ok as $user) {
	$addr = isset($user['sms_ok']) ? $user['sms'] : $user['email'];
	echo "- {$user['name']} [{$addr}]<br/>";	
}

if(isset($ko[0])) {
	echo "<br/><br/>";
	echo "WARN: The following sendings failed:<br/>";
	foreach($ko as $user) {
		if ($user['sms_ko']) {
			echo "- {$user['name']} [{$user['sms']}] [{$user['sms_ko']}]<br/>";
		}
		else {
			echo "- {$user['name']} [{$user['email']}] [{$user['email_ko']}]<br/>";
		}	
	}

}
?>



<br/><br/>
Alert Deactivation sms message:
<br/>
<?=$alert->text2?>
<br/>
<br/>
Notes on intervention:
<br/>
<?=$alert->note?>
<br/><br/>
Alert current status: <?=$alert->status?>
<br/><br/>
<br/><br/>
<?=Form::input('back' , 'Atrás', array('type' => 'button', 'id' => 'back'));?>

</body>
</html>
