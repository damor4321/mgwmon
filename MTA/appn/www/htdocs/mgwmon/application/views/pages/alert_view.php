<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Alert Configuration</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
		<?=HTML::script('media/scripts/jquery.min.js');?>
	    <?=HTML::style('media/css/default.css');?>
	      <script type="text/javascript" charset="utf-8">
	  		$(document).ready(function(){
				
				 $('#users').click(function(){
					  var root = location.protocol + '//' + location.host;				  
					   document.location.href=root +"<?=URL::base()?>index.php/user/list/";
					})				
				$('#alerts').click(function(){
					var root = location.protocol + '//' + location.host;				  
					document.location.href=root +"<?=URL::base()?>index.php/alert/list/";
				})				
				$('#queues').click(function(){
					var root = location.protocol + '//' + location.host;				  
					document.location.href=root +"<?=Url::base()?>queues_mon/qc.php";
				})				  		
			});			
		</script>
	</head>
	<body>

<div id="app_menu">
<table width="770px">
<tr>
<td>
<?=Form::input('alerts' , 'Alerts', array('type' => 'button', 'id' => 'alerts'));?>
</td>
<td>
<?=Form::input('users' , 'Users', array('type' => 'button', 'id' => 'users'));?>
</td>
<td>
<?=Form::input('queues' , 'Queues', array('type' => 'button', 'id' => 'queues'));?>
</td>
</tr>
</table>
<br/>
</div>

<table border=0>
<tr>
<td class="fv">
Alerta:
</td>
<td class="fv">
<?=$alert->id?>
</td>
</tr>

<tr>
<td class="fv">
Nombre:
</td>
<td class="fv">
<?=$alert->name?>
</td>
</tr>

<tr>
<td class="fv">
Tipo:
</td>
<td class="fv">
<?=$alert->type?>
</td>
</tr>

<tr>
<td class="fv">
Target:
</td>
<td class="fv">
<?=$alert->target?>
</td>
</tr>

<tr>
<td class="fv">
Trigger:
</td>
<td class="fv">
<?=$alert->trigger?>
</td>
</tr>

<tr>
<td class="fv">
Estado:
</td>
<td class="fv">
<?=$alert->status?>
</td>
</tr>


<tr>
<td class="fv">
SMS Alert Text:
</td>
<td class="fv">
<?=$alert->text?>
</td>
</tr>

<tr>
<td class="fv">
Intervention Notice Text:
</td>
<td class="fv">
<?=$alert->text2?>
</td>
</tr>

<tr>
<td class="fv">
Notes on Intervention:
</td>
<td class="fv">
<?=$alert->note?>
</td>
</tr>

<tr>
<td class="fv">
Subscribed Users:
</td>
<td class="fv">
<br/>
<?php foreach($users_yes as $user):?>
<li><?=$user->name?>	
<?php endforeach;?>
<br/><br/><br/>
</td>
</tr>
</table>

</body>
</html>
