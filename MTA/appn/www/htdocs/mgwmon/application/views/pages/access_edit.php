<!DOCTYPE html>
<html>
<head>
	<title>Edit SMTP ACLs</title>
                <?=HTML::script('media/scripts/jquery-1.4.2.js');?>
                <?=HTML::script('media/scripts/jquery.cokidoo-textarea.js');?>
                <?=HTML::style('media/css/editor_styles.css');?>	

	<script type="text/javascript">
	$().ready(function(){
		$("#id3").autoResize({maxHeight:900});
	});
	</script>

</head>
<body>
<h2>SMTP Gateway ACLs Editor</h2>

	<div class='form' style="width:900px;height:600px;text-align:left;vertical-align:top;margin-top:0%;margin-left:0%">
<textarea id="id3" style="width:900px;height:600px;text-align:left;vertical-align:top;margin-top:0%;margin-left:0%;background-color:#A0C1EA;"><?php foreach($acl_lines as $line):?><?php echo trim($line); echo "\n";?><?php endforeach;?></textarea><br/>		
		<div>
			<input type='submit' class='save' value=' Save ' />
			<input type='submit' class='cancel' value=' Cancel ' />
		</div>
	</div>

<br>
</body>
</html>
