<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Alert Data</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
                <?=HTML::script('media/scripts/easyui/jquery.min.js');?>
                <?=HTML::script('media/scripts/easyui/jquery.easyui.min.js');?>
                <?=HTML::script('media/scripts/easyui/jquery.edatagrid.js');?>
                <?=HTML::style('media/css/default2.css');?>
                <?=HTML::style('media/css/easyui/themes/default/easyui.css');?>
                <?=HTML::style('media/css/easyui/themes/icon.css');?>
                <?=HTML::style('media/css/easyui/demo.css');?>
                
		<script type="text/javascript" charset="utf-8">
		
		$(document).ready(function(){
			var root = location.protocol + '//' + location.host;
			$('#delete').click(function(){
				var answer = confirm('Delete application?');
				if(answer) {
					var root = location.protocol + '//' + location.host;				  
					document.location.href=root +"<?=URL::base()?>index.php/acl/delete/<?=$app->id?>";
				}
				return answer;
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
			$('#save').click(function(){
				var res="";						         
				$('#aclform').submit();
			})

			$('#dg').edatagrid({
                url: root +"<?=URL::base()?>/index.php/acl/crud/?appid=<?=$app->id?>&op=show",
                saveUrl: root +"<?=URL::base()?>/index.php/acl/crud/?appid=<?=$app->id?>&op=save",
                updateUrl: root +"<?=URL::base()?>/index.php/acl/crud/?appid=<?=$app->id?>&op=update",
                destroyUrl: root +"<?=URL::base()?>/index.php/acl/crud/?appid=<?=$app->id?>&op=delete"
        	});				

		});			
	    </script>

	</head>
	<body>

<div id="app_menu">
<table width="770px" border="0">
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

<? if(isset($error_message) and $error_message) echo '
<div id="kohana_error">
	<h1><span class="type">ERROR:</span> <span class="message">'.$error_message.'.</span></h1>
</div>';
?>

<table border="0">

<tr>
<td class="ii">
<?=Form::label($app->id, 'Application ID: '); ?>
</td>
<td class="iii">
<?=$app->id; ?>
</td>
<td></td>
</tr>

<tr>
<td class="ii">
<?=Form::label($app->client_id, 'Customer ID: '); ?>
</td>
<td class="iii">
<?=$app->client_id; ?>
</td>
<td></td>
</tr>


<tr>
<td class="ii">
<?=Form::label($app->name, 'Name: '); ?>
</td>
<td class="iii">
<?=$app->name; ?>
</td>
<td></td>
</tr>

<tr>
<td class="ii">
<?=Form::label($app->description, 'Descripction: '); ?>
</td>
<td class="iii">
<?=$app->description; ?>
</td>
<td></td>
</tr>

<tr>
<td class="ii">
<?=Form::label($app->volume, 'Volume: '); ?>
</td>
<td class="iii">
<?=$app->volume; ?>
</td>
<td></td>
</tr>

<tr>
<td class="ii">
<?=Form::label($app->queue, 'Queue: '); ?>
</td>
<td class="iii">
<?=$app->queue; ?>
</td>
<td></td>
</tr>

<tr>
<td class="ii" colspan="3">
<br/>
<br/>
<br/>
<div>
<table title="ACL Rules" style="width:1200px;">
<tr>  		
<th style="width:100px">AclRule ID</th>
<th style="width:30px">Type</th>
<th style="width:300px">Target</th>
<th style="width:30px">Action</th>
<th style="width:60px">Status</th>
</tr>
<?php $i=1;$alt="";?>
<?php foreach($aclrules as $aclrule):?>
<?php $alt = ($i%2) ? 'class="alt"' : ''; $i++;?>
<tr>
<td <?=$alt?> style="width:100px"><?= $aclrule->id ?></td>
<td <?=$alt?> style="width:30px"><?= $aclrule->tp ?></td>
<td <?=$alt?> style="width:300px"><?= $aclrule->target ?></td>
<td <?=$alt?> style="width:30px"><?= $aclrule->action ?></td>
<td <?=$alt?> style="width:60px"><?= $aclrule->status ?></td>
</tr>
<?php endforeach;?>
</table>

</body>
</html>
