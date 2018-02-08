<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Alert Data</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
                <?=HTML::script('media/scripts/jquery.min.js');?>
                <?=HTML::script('media/scripts/jquery.selso.js');?>
                <?=HTML::style('media/css/default.css');?>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			  $('#delete').click(function(){
				  var root = location.protocol + '//' + location.host;				  
				   document.location.href=root +"<?=URL::base()?>index.php/alert/delete/<?=$alert->id?>";
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

			$('#save').click(function(){
			     	 var res="";
			     	 $("select.right option").each(function(){  
			             res += " " + $(this).val(); 
			         }); 
			         $('<input>').attr({type: 'hidden', id: 'users_yes', name: 'users_yes', value: res
			        	}).appendTo('#alertform');

			     	 res="";
			     	 $("select.left option").each(function(){  
			             res += " " + $(this).val(); 
			         }); 
			         $('<input>').attr({type: 'hidden', id: 'users_not', name: 'users_not', value: res
			        	}).appendTo('#alertform');
			         
			         $('#alertform').submit();
			   })
					
		});
		$(function(){
			<?php 
			if ($alert->status == "ACTIVE") {
				echo "$('#send_deac').hide();";
			}
			?>
			
			// sorts all the combo select boxes
			function sortBoxes(){			
				$('select.left, select.right').find('option').selso({
					type: 'alpha', 
					extract: function(o){ return $(o).text(); } 
				});
				
				// clear all highlighted items
				$('select.left, select.right').find('option:selected').removeAttr('selected');
			}
			
			// add/remove buttons for combo select boxes
			$('input.add').click(function(){
				var left = $(this).parent().parent().find('select.left option:selected');
				var right = $(this).parent().parent().find('select.right');
				right.append(left);
				sortBoxes();	
			});
		
			$('input.remove').click(function(){
				var left = $(this).parent().parent().find('select.left');
				var right = $(this).parent().parent().find('select.right option:selected');
				left.append(right);
				sortBoxes();
			});


			$('#sstatus').change(function()
			{
				if ($(this).val() == 'DEACTIVATED'){
					$('#send_deac').show();
				}
				else {
					$('#send_deac').hide();
				}
			});

			//.change();
			
										
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
</tr>
</table>
<br/>
</div>

<? if(isset($error_message) and $error_message) echo '
<div id="kohana_error">
	<h1><span class="type">ERROR:</span> <span class="message">'.$error_message.'.</span></h1>
</div>';
?>


<table border=0>
<?=Form::open('alert/save',array('id'=>'alertform')); ?>

<tr>
<td class="fv">
<?=Form::label($alert->id, 'Alerta: '); ?>
</td>
<td class="fv">
<?=$alert->id; ?>
</td>
</tr>

<tr>
<td class="fv">
<?=Form::label($alert->name, 'Nombre: '); ?>
</td>
<td class="fv">
<?=Form::input('name', $alert->name); ?>
</td>
</tr>

<tr>
<td class="fv">
<?=Form::label($alert->type, 'Tipo: '); ?>
</td>
<td class="fv">
<?=Form::input('type', $alert->type); ?>
</td>
</tr>


<tr>
<td class="fv">
<?=Form::label($alert->target, 'Target: '); ?>
</td>
<td class="fv">
<?=Form::input('target', $alert->target); ?>
</td>
</tr>

<tr>
<td class="fv">
<?=Form::label($alert->trigger, 'Trigger: '); ?>
</td>
<td class="fv">
<?=Form::input('trigger', $alert->trigger); ?>
</td>
</tr>

<tr>
<td class="fv">
<?=Form::label($alert->status, 'Estado: '); ?>
</td>
<td class="fv">
<?php 
//Form::select('status', array('ACTIVE','DEACTIVATED'), $alert->status);
$sel_act=$sel_des="";
if ($alert->status == "ACTIVE") $sel_act = "selected"; else $sel_des = "selected";
?>
<select class="norm" name="status" id="sstatus">
<option value="ACTIVE" <?=$sel_act?>>ACTIVED</option>
<option value="DEACTIVATED" <?=$sel_des?>>DEACTIVATED</option>
</select>
</td>
</tr>
<tr>
<td class="fv">
<?=Form::label($alert->text, 'Alert SMS Text: '); ?>
</td>
<td class="fv">
<?=Form::textarea('text', $alert->text, array('rows' => 3, 'cols' => 50)); ?>
</td>
</tr>
</table>

<div id="send_deac">
<table border=0>
<tr>
<td>
<?=Form::label("", "Send notice<br/> for intervention<br/>to the subscribed users:"); ?>
</td>
<td>
<input type="checkbox" name="send_alert_deact" value="yes" />
</td>
</tr>
<tr>
<td class="fv">
<?=Form::label($alert->text2, 'Text of Intervention Notice: '); ?>
</td>
<td class="fv">
<?=Form::textarea('text2', $alert->text2, array('rows' => 3, 'cols' => 50));?>
</td>
</tr>
</table>
</div>

<table border=0>
<tr>
<td class="fv">
<?=Form::label($alert->note, 'Notes: '); ?>
</td>
<td class="fv">
<?=Form::textarea('note', $alert->note, array('rows' => 11, 'cols' => 50));?>
</td>
</tr>
<tr>
<td>
<?=Form::label('users', "        &nbsp; Subscripted Users:"); ?>
</td>
<td>
			<br/>
			<fieldset id="selusers">
				<select id="selusersleft" name="selusersleft" class="left" multiple="multiple">
				<?php foreach($users_not as $user):?>
					<option id="opt<?=$user->id?>" value="<?=$user->id?>"><?=$user->name?></option>	
				<?php endforeach;?>
				</select>
				<fieldset>
					<input type="button" class="add" value=" &gt; " />
					<input type="button" class="remove" value=" &lt; " />
				</fieldset>
				<select id="selusersright" name="selusersright" class="right" multiple="multiple">
				<?php foreach($users_yes as $user):?>
					<option id="opt<?=$user->id?>" value="<?=$user->id?>"><?=$user->name?></option>	
				<?php endforeach;?>
				</select>
			</fieldset>			
</td>
</tr>
</table>

<table width="850px">
<tr>
<td>
<?=Form::hidden('id', $alert->id);?>
<!--<?=Form::submit(NULL, 'Salvar');?>-->
<?=Form::input('save' , 'Save', array('type' => 'button', 'id' => 'save'));?>

</td>
<td>
<?=Form::input('delete' , 'Delete', array('type' => 'button', 'id' => 'delete'));?>
</td>
</tr>
<?=Form::close() ?>
</table>
</body>
</html>
