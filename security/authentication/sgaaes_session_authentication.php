<?php
	session_start();
	if(!isset($_SESSION['idSessao'])){
	header("Location: ../../security/authentication/sgaaes_logout_authentication.php");
	exit;//para a execução da página, executa somente o header
	} else if($_SESSION['idSessao']!=session_id()) {
		header("Location: ../../security/authentication/sgaaes_logout_authentication.php");
		exit;//para a execução da página, executa somente o header
	}
?>
