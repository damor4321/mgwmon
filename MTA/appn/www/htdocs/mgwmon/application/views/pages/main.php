<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>MTA Monitoring</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="title" content="'.$title.'" />
                 <?=HTML::script('media/scripts/jquery.min.js');?>
           	 <?=HTML::style('media/css/default.css');?>
		<script type="text/javascript" charset="utf-8">
	    </script>
	</head>
	<body>
<br/>

<center>
<h2>MTA Monitoring</h2>
<table>
<tr>
<td><?= HTML::anchor('user/list/0', 'Users'); ?></td>
</tr>
<tr>
<td><?= HTML::anchor('alert/list/0', 'Alert'); ?></td>
</tr>
<tr>
<td><?= HTML::anchor('http://adminmta.internaldomain:8001/mgwmon/queues_mon/qc.php', 'Colas'); ?></td>
</tr>
<tr>
<td><?= HTML::anchor('http://adminmta.internaldomain:8001/mgwmon/queues_mon/sc.php', 'Monitores'); ?></td>
</tr>
<tr>
<td><?= HTML::anchor('access/list/0', 'ACLs Envios'); ?></td>
</tr>
</tr>
</table>
</center>
</body>
</html>
