<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Monitoring Users</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
                <?=HTML::script('media/scripts/jquery.min.js');?>
           	<?=HTML::style('media/css/default.css');?>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			  $('#add').click(function(){
				  var root = location.protocol + '//' + location.host;				  
				   document.location.href=root +"<?=Url::base()?>index.php/user/edit/";
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
<?=Form::input('users' , 'Usuars', array('type' => 'button', 'id' => 'users'));?>
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
<th style="width:140px" colspan="2">Actions</th>
<th style="width:30px">User</th>
<th style="width:200px">Name</th>
<th style="width:100px">email</th>
<th style="width:100px">sms</th>
</tr>
<?php $i=1;$alt="";?>
<?php foreach($users as $user):?>
<?php $alt = ($i%2) ? 'class="alt"' : ''; $i++;?>
<tr>
<td <?=$alt?> style="width:70px"><?= HTML::anchor($user->edit, 'Edit'); ?></td>
<td <?=$alt?> style="width:70px"><?= HTML::anchor($user->delete, 'Delete'); ?></td>
<td <?=$alt?> style="width:200px"><?= $user->id ?></td>
<td <?=$alt?> style="width:200px"><?= $user->name ?></td>
<td <?=$alt?> style="width:100px"><?= $user->email ?></td>
<td <?=$alt?> style="width:100px"><?= $user->sms ?></td>
</tr>
<?php endforeach;?>
</table>
<br/>
<br/>
<table width="740px">
<tr>
<td>
</td>
<td>
<?=Form::input('add' , 'New User', array('type' => 'button', 'id' => 'add'));?>
</td>
</tr>
</table>
</body>
</html>
