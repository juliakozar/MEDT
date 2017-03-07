<? if(isset($_GET['showSource'])) {
	show_source(__FILE__);
	die();
} ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php 

$host = 'localhost';
$dbname = 'medt3';
$user = 'htluser';
$pwd = 'htluser';

#try {
$db = new PDO ("mysql:host=$host;dbname=$dbname", $user, $pwd);
$res = $db->query("SELECT * from project");
$tmp = $res->fetchAll(PDO::FETCH_ASSOC);
#}
#catch {
	
#}
$p_id = "";
if(isset($_GET['edit']))
{	
	$p_id = $_GET['edit'];
	$position = $db->query("SELECT * from project where p_id=$_GET[edit]")->fetchAll(PDO::FETCH_ASSOC);
	echo '<form action="index.php" method="post">';
	echo '<span>Name: <input type="text" value="'.$position[0]['p_name'].'" name="Name"></span>';
	echo '<span>Description: <input type="text" value="'.$position[0]['p_description'].'" name="Description"></span>';
	echo '<span>Datum: <input type="text" value="'.$position[0]['p_createDate'].'" name="Datum"></span>';
	echo '<span>UserID: <input type="text" value="'.$position[0]['p_u_id'].'" name="UserID"></span>';
	echo '<input type="submit" value="Speichern">';
	echo '</form>';
	
	if(isset($_POST['Name']) && isset($_POST['Description']) && isset($_POST['Datum']) && isset($_POST['UserID']))
{
	$res = $db->query("UPDATE project SET p_name=\"$_POST[Name]\",´p_description=\"$_POST[Description]\", p_createDate=$_POST[Datum], p_u_id=$_POST[Name] where p_id=$p_id");	
}
}


if(isset($_GET['delete']))
{
	$res = $db->query("DELETE from project where p_id=$_GET[delete]");
	if ($res->rowCount())
	{
		echo "<div class=\"alert alert-success\">Datensatz vorhanden</div>";
	}
	else
	{
		echo "<div class=\"alert alert-warning\">Datensatz ist nicht vorhanden</div>";	
	}
}	


echo "<table border=1px class=\"table table-striped\">";
echo "<tr><th>Name</th><th>Beschreibung</th><th>Datum</th><th>ID</th><th>Issues</th><th>Operationen</th></tr>";
foreach($tmp as $row)
{
	echo"<tr><td>$row[p_name]</td><td>$row[p_description]</td><td>$row[p_createDate]</td><td>$row[p_u_id]</td><td></td><td><a href=\"$_SERVER[PHP_SELF]?edit=$row[p_id]\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></a></span><a href=\"$_SERVER[PHP_SELF]?delete=$row[p_id]\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></a></td></tr>";
}
echo "</table>";

?>


</body>
</html>