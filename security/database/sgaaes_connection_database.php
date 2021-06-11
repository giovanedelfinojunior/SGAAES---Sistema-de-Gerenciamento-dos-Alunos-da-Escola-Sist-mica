<?php
	include "sgaaes_system_configuration_database.php";
	$conexao = new mysqli ($servidor,$usuario,$senha,$banco);/*faz a conexão com o banco de dados. ("endereço","permissão/usuário","senha","nome do banco de dados")*/

	if ($conexao -> connect_errno > 0){/*connect_errno é um atributo dentro da classe "mysqli",armazena o codigo dos erros.*/
		die("Não foi possivel conectar com o banco de dados".$conexao -> connect_error);/* "die" mata o processo de conexão com o banco de dados se ocorrer um erro.*/
	}																					/*"connect_error" armazena a mensagem dos erros.*/

	$conexao->set_charset('utf8');

?>
