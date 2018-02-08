<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>ACL rules</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
		<?=HTML::script('media/scripts/jquery.min.js');?>
		<?=HTML::style('media/css/default.css');?>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			  $('#add').click(function(){
				  var root = location.protocol + '//' + location.host;				  
				   document.location.href=root +"<?=URL::base()?>index.php/acl/edit/";
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
			 	$('#acls').click(function(){
				  var root = location.protocol + '//' + location.host;				  
				   document.location.href=root +"<?=URL::base()?>index.php/acl/list/";
				})
			 	$('#delete').click(function(){
			 			var answer = confirm('Delete application?');
			 			return answer;
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
<td>
<?=Form::input('acls' , 'ACLs', array('type' => 'button', 'id' => 'acls'));?>
</td>
</tr>
</table>
<br/>
</div>


<table>
<tr>  		
<th style="width:120px" colspan="3">Actions</th>
<th style="width:30px">Application ID</th>
<th style="width:30px">Customer Id</th>
<th style="width:200px">Name</th>
<th style="width:420px">Description</th>
<th style="width:140px">Queue</th>
<th style="width:30px">Volume</th>
</tr>
<?php $i=1;$alt="";?>
<?php foreach($apps as $app):?>
<?php $alt = ($i%2) ? 'class="alt"' : ''; $i++;?>
<tr>
<td <?=$alt?> style="width:40px"><?= HTML::anchor($app->edit, 'Edit'); ?></td>
<td <?=$alt?> style="width:40px"><?= HTML::anchor($app->display, 'View'); ?></td>
<td <?=$alt?> style="width:40px"><?= HTML::anchor($app->delete, 'Delete', array('id' => 'delete', 'href' => $app->delete )); ?></td>
<td <?=$alt?> style="width:30px"><?= $app->id ?></td>
<td <?=$alt?> style="width:30px"><?= $app->client_id ?></td>
<td <?=$alt?> style="width:200px"><?= $app->name ?></td>
<td <?=$alt?> style="width:420px"><?= $app->description ?></td>
<td <?=$alt?> style="width:140px"><?= $app->queue ?></td>
<td <?=$alt?> style="width:30px"><?= $app->volume ?></td>
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
<?=Form::input('add' , 'New Aplication', array('type' => 'button', 'id' => 'add'));?>
</td>
<td>
<?=Form::input('add' , 'Rules File', array('type' => 'button', 'id' => 'genfile'));?>
</td>
</tr>
</table>
<div>
<br>
<?=$page_links?>
</div>
</body>
</html>
