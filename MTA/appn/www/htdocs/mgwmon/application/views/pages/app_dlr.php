<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Desactivation Notice Sendings</title>
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

Regarding the Application: <?=$app->name?> at Queue <?=$app->queue?>, after modification the following Rules are Active:
<br/>
<?php 
foreach($aclrules as $aclrule) {
	echo "- {$aclrule->id} {$aclrule->tp} {$aclrule->target} {$aclrule->action} {$aclrule->status}<br/>";	
}
?>

<br/><br/>
<?=Form::input('back' , 'Back', array('type' => 'button', 'id' => 'back'));?>

</body>
</html>
