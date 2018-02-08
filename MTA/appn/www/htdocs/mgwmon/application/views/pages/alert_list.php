<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Alerts</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
		<?=HTML::script('media/scripts/jquery.min.js');?>
		<?=HTML::style('media/css/default.css');?>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			  $('#add').click(function(){
				  var root = location.protocol + '//' + location.host;				  
				   document.location.href=root +"<?=URL::base()?>index.php/alert/edit/";
				})
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

<table>
<tr>  		
<th style="width:210px" colspan="3">Actions</th>
<th style="width:30px">Alerts</th>
<th style="width:200px">Name</th>
<th style="width:200px">Target</th>
<th style="width:30px">Condition</th>
<th style="width:100px">Status</th>
<th style="width:30px">Type</th>
</tr>
<?php $i=1;$alt="";?>
<?php foreach($alerts as $alert):?>
<?php $alt = ($i%2) ? 'class="alt"' : ''; $i++;?>
<tr>
<td <?=$alt?> style="width:70px"><?= HTML::anchor($alert->edit, 'Edit'); ?></td>
<td <?=$alt?> style="width:70px"><?= HTML::anchor($alert->display, 'View'); ?></td>
<td <?=$alt?> style="width:70px"><?= HTML::anchor($alert->delete, 'Delete'); ?></td>
<td <?=$alt?> style="width:30px"><?= $alert->id ?></td>
<td <?=$alt?> style="width:200px"><?= $alert->name ?></td>
<td <?=$alt?> style="width:200px"><?= $alert->target ?></td>
<td <?=$alt?> style="width:30px"><?= $alert->trigger ?></td>
<td <?=$alt?> style="width:100px"><?= $alert->status ?></td>
<td <?=$alt?> style="width:100px"><?= $alert->type ?></td>
</tr>
<?php endforeach;?>
</table>
<br/>
<br/>
<table width="770px">
<tr>
<td>
</td>
<td>
<?=Form::input('add' , 'New Alert', array('type' => 'button', 'id' => 'add'));?>
</td>
</tr>
</table>
</body>
</html>
