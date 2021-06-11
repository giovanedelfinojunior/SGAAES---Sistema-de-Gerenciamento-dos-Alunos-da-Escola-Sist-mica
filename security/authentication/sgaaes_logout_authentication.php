<?php
/*~~Inicia a Sessão~~*/
session_start();
//Destrói a variável de sessão.
session_unset();
//Destrói a sessão.
session_destroy();
//Redirecionamento
header("location: ../../index.php");

?>
