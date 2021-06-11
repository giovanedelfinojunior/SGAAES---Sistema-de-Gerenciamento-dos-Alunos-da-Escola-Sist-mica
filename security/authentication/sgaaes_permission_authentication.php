<?php

if($permissao != $_SESSION['permissao']){
	if($_SESSION['permissao']==0){
		header("Location: ../../system/advisor/back_end_advisor.php?msg=Você não tem permissão para acessar esta página!");
		exit;//para a execução da página, executa somente o header
	} else if ($_SESSION['permissao']== 1){
			header("Location: ../../system/student/back_end_student.php?msg=Você não tem permissão para acessar esta página!");
			exit;//para a execução da página, executa somente o header
		} else {
			header ("Location: ../../security/authentication/sgaaes_logout_authentication.php");
			exit;//para a execução da página, executa somente o header
		}
}

?>
