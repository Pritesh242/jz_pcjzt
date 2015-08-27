<?php
header("Content-type: text/html; charset = utf-8");
if($_POST) {
	require("db.php");
	$db = new DB();
	$db->add($_POST['name'], $_POST['longnum'], $_POST['shortnum'], $_POST['department'], $_POST['content']);
	echo "ok", ",", count($db->all());
} else {
	echo "无法逃避的是自我，而无法挽回的是过去。";
}
?>