<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Gestion de ACL</title>
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
<tr style="width:700px; border-color:black; border-width:4px; border-style:solid;">  		
<th style="width:140px" colspan="2">Acciones</th>
<th style="width:340px">Aplicacion</th>
<th style="width:100px">Tipo ACL</th>
<th style="width:100px">ACL Net</th>
<th style="width:240px">ACL Froms</th>
</tr>
<?php 
/*function sanitize(&$elem, $c){
	$elem = preg_replace("/[\/|\^|\$]/", "", $elem); 
    $elem = preg_replace("/\s*OK/", "", $elem);  
}
array_walk_recursive($acl_groups, 'sanitize');*/	
?>


<?php $i=1;$alt="";?>
<?php foreach($acl_items as $aclitem):?>
<?php $alt = ($i%2) ? 'class="alt"' : ''; $i++;?>
<tr style="width:700px; border-color:black; border-width:4px; border-style:solid;">
<td <?=$alt?> style="width:70px;"><?= HTML::anchor($aclitem->edit, 'Edit'); ?></td>
<td <?=$alt?> style="width:70px;"><?= HTML::anchor($aclitem->delete, 'Delete'); ?></td>
<td <?=$alt?> style="width:340px;"><?= $aclitem->header ?></td>
<td <?=$alt?> style="width:100px;"><?= $aclitem->type ?></td>
<td <?=$alt?> style="width:100px;"><?= implode('<br/>', $aclitem->pnet); ?></td>
<td <?=$alt?> style="width:240px;"><?= implode('<br/>', $aclitem->psender); ?></td>
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
