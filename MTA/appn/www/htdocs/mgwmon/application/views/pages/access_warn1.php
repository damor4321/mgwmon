<!DOCTYPE html>
<html>
<head>
	<title>ERROR</title>
                <?=HTML::script('media/scripts/jquery-1.4.2.js');?>
                <?=HTML::script('media/scripts/jquery.cokidoo-textarea.js');?>
                <?=HTML::style('media/css/editor_styles.css');?>	


</head>
<body>
<h3>ERROR: Found Inconsistences between las ACLs per SENDER and ACLs per IP Applications</h3>
Please, mail the admin.<br/>



<?php if(count($diff1)>1) { ?>
	<div class='form' style="width:900px;height:100px;text-align:left;vertical-align:top;margin-top:0%;margin-left:0%">
<textarea id="id3" style="width:900px;height:100px;text-align:left;vertical-align:top;margin-top:0%;margin-left:0%;background-color:#d9a4a4;"><?php foreach($diff1 as $line):?><?php echo trim($line); echo "\n";?><?php endforeach;?></textarea><br/>		
	</div>
<br>

<?php } ?>

<?php if(count($diff2)>1) { ?>
	<div class='form' style="width:900px;height:100px;text-align:left;vertical-align:top;margin-top:0%;margin-left:0%">
<textarea id="id3" style="width:900px;height:100px;text-align:left;vertical-align:top;margin-top:0%;margin-left:0%;background-color:#d9a4a4;"><?php foreach($diff2 as $line):?><?php echo trim($line); echo "\n";?><?php endforeach;?></textarea><br/>		
	</div>

<br>

<?php } ?>

</body>
</html>
