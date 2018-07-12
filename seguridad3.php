<?php
session_start();
if($_SESSION["autentica"] != "YEP"){
	/*header("Location: http://beneficios.umce.cl/becacolaboracion/");*/
	header("Location: http://localhost/becasinternas/becainterna");
	exit();
}
?>