<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>User Data</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
                <?=HTML::script('media/scripts/jquery.min.js');?>
            	<?=HTML::style('media/css/default.css');?>
		<link type="text/css" href="/media/css/default.css" rel="stylesheet" />	      
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			  $('#delete').click(function(){
				  var root = location.protocol + '//' + location.host;				  
				   document.location.href=root +"<?=Url::base()?>index.php/user/delete/<?=$user->id?>";
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

<table border=0>
<?=Form::open('user/save'); ?>

<tr>
<td class="fv">
<?=Form::label($user->id, 'User: '); ?>
</td>
<td class="fv">
<?=$user->id; ?>
</td>
</tr>

<tr>
<td class="fv">
<?=Form::label($user->name, 'Name: '); ?>
</td>
<td class="fv">
<?=Form::input('name', $user->name); ?>
</td>
</tr>

<tr>
<td class="fv">
<?=Form::label($user->email, 'email: '); ?>
</td>
<td class="fv">
<?=Form::input('email', $user->email); ?>
</td>
</tr>

<tr>
<td class="fv">
<?=Form::label($user->sms, 'sms: '); ?>
</td>
<td class="fv">
<?=Form::input('sms', $user->sms); ?>
</td>
</tr>
</table>
<br/><br/><br/><br/>
<table width="600px">
<tr>
<td>
</td>
<td>
<?=Form::submit(NULL, 'Save');?>
</td>
<td>
<?=Form::input('delete' , 'Delete', array('type' => 'button', 'id' => 'delete'));?>
</td>
</tr>
<?=Form::hidden('id', $user->id);?>
<?=Form::close() ?>
</table>

</body>
</html>
