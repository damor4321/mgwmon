<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>SMTP Platform ACLs</title>
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

				$('#services').click(function(){
					var root = location.protocol + '//' + location.host;				  
					document.location.href=root +"<?=Url::base()?>queues_mon/sc.php";
				})	

				
		});
	    </script>
	</head>
	<body>
<div id="app_menu">
<table width="770px">
<tr>
<td>
<?=Form::input('alerts' , 'Alertas', array('type' => 'button', 'id' => 'alerts'));?>
</td>
<td>
<?=Form::input('users' , 'Usuarios', array('type' => 'button', 'id' => 'users'));?>
</td>
<td>
<?=Form::input('queues' , 'Colas', array('type' => 'button', 'id' => 'queues'));?>
</td>
<td>
<?=Form::input('services' , 'Servicios', array('type' => 'button', 'id' => 'services'));?>
</td>
</tr>
</table>
<br/>
</div>

<table>
<tr>  		
<th style="width:140px" colspan="2">Actions</th>
<th style="width:200px">Role</th>
<th style="width:100px">Queue</th>
<th style="width:100px">Type</th>
</tr>
<?php $i=1;$alt="";?>
<?php foreach($acls as $acl):?>
<?php $alt = ($i%2) ? 'class="alt"' : ''; $i++;?>
<tr>
<td <?=$alt?> style="width:70px"><?= HTML::anchor($acl->edit, 'Edit'); ?></td>
<td <?=$alt?> style="width:70px"><?= HTML::anchor($acl->display, 'View'); ?></td>
<td <?=$alt?> style="width:240px"><?= $acl->title ?></td>
<td <?=$alt?> style="width:240px"><?= $acl->queue ?></td>
<td <?=$alt?> style="width:140px"><?= $acl->type ?></td>
</tr>
<?php endforeach;?>
</table>
<br/>
<br/>
<table width="770px">
<tr>
<td>
</td>
</tr>
</table>
</body>
</html>
