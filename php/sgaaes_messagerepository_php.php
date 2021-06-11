<?php
/*Ínicio mensagens de operações*/
	function mensagens($id,$operacao,$o_que){
		$mensagem = "Nenhuma mensagem encontrada para essa ação...";

		switch($id){
			case 1 : {//realizado com sucesso;
				$mensagem = $operacao." de ".$o_que." realizado(a) com sucesso!";
			}
			break;
			case 2 : {//erro ao cadastrar
				global $conexao;
				$mensagem = "Erro ao realizar o/a ".$operacao." de ".$o_que."!<br>".$conexao->error;
			}
			break;
		}
		return $mensagem;
	}
/*Fim de mensagens de operações*/
/*Ínicio mensagem de campos*/
	function mensagenscampos($id, $campo){
		$mensagem = "Nenhuma mensagem encontrada para essa ação...";
		
		switch($id){
			case 1 : {//campo vazio
				$mensagem = "O campo ".$campo." deve ser preenchido!";
			}
			break;
			case 2 : {//campos não correspondem;
				$mensagem = "Os campos ".$campo." não correspondem!";
			}
			break;
			case 3 : {//Quando se adiciona mais campo no formulário e algum ficou vazio;
				$mensagem = "Algum campo de ".$campo." não foi preenchido/selecionado!";
			}
			break;
			case 4 : {//já está cadastrado(a);
				$mensagem = "Esse(a) ".$campo." já está cadastrado(a)";
			}
			break;
			case 5 : {//já está em uso;
				$mensagem = "Esse(a) ".$campo." já está em uso!";
			}
			break;
		}
		return $mensagem;
	}
/*Fim mensagens de campos*/
?>
