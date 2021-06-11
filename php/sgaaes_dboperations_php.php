<?php

function adicionar($pr_tabela, $pr_dados){

	$campos = array_keys($pr_dados);
/*array_keys: transforma as possições de um array e transforma em valores para outro array*/
	$n_campos = count ($campos);
/*count: retorna o numero de elementos/posições de um array*/
	$sintaxe = "INSERT INTO ".$pr_tabela."(";

	for($aux=0;$aux < $n_campos; $aux++){
		$sintaxe .= $campos[$aux]. ", ";
	}


	//estrutura até aqui:
		//INSERT INTO usuarios (login, senha, permissao,
	$sintaxe = substr($sintaxe, 0, -2);
	$sintaxe.=") VALUES (";


		//estrutura até aqui:
			//INSERT INTO usuarios (login, senha, permissao) VALUES (

	for($aux=0;$aux < $n_campos; $aux++){
		
		if($pr_dados[$campos[$aux]]==""){
			$sintaxe .= "NULL, ";
		}else{
			$sintaxe .= "'".addslashes($pr_dados[$campos[$aux]])."', ";
		}
		
	}
		//estrutura até aqui:
			//INSERT INTO usuários (usuario,senha,permissao) VALUES ('adm', '123', '0',
	$sintaxe = substr($sintaxe, 0, -2);
	$sintaxe .= ")";
	
	global $conexao;
	/*Chama uma variavel de escopo global para o escopo da função.*/

	$resultado = $conexao -> query($sintaxe);

	return $resultado;
	}
//DELETAR
	function deletar($pr_tabela, $pr_condicao){
		$sintaxe = "DELETE FROM ".$pr_tabela." WHERE ".$pr_condicao;
		//Estrutura:
		global $conexao;

		$resultado = $conexao ->query($sintaxe);

	return $resultado;
	}
//ATUALIZAR
	function atualizar ($pr_tabela,$pr_dados,$pr_condicao){

		$campos = array_keys($pr_dados);

		$n_campos = count ($campos);

		$sintaxe = "UPDATE ".$pr_tabela." SET ";
		//estrutura até aqui:
		//UPDATE usuarios SET

		for($aux=0; $aux < $n_campos; $aux++){
			$sintaxe.=$campos[$aux]." = '".addslashes($pr_dados[$campos[$aux]])."', ";
		}
		//estrutura até aqui:
		//UPDATE usuarios SET login = 'admin', senha = '123'
		$sintaxe = substr($sintaxe, 0, -2);
		$sintaxe .= " WHERE ". $pr_condicao;
		//estrutura até aqui:
		//UPDATE usuarios SET login = 'admin', senha = '123' WHERE id='1'
	global $conexao;

		$resultado = $conexao ->query($sintaxe);

	return $resultado;
	}
?>
