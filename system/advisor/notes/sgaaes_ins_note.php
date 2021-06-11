<?php
/*Declarando as variaveis.*/
	$p_aluno = $_POST['selaluno'];
	$p_equipe = $_POST['selequipe'];
	$p_classificacao = $_POST['selclassificacao'];
	$p_data = $_POST['txtdata'];
	$p_anotacao = $_POST['txaanotacao'];

	$p_aluno = array_unique($p_aluno);
	$p_equipe = array_unique($p_equipe);

	$td_aluno = count($p_aluno);
	$p_aluno_validacao = true;
	$td_equipe = count($p_equipe);
	$p_equipe_validacao = true;


	for($i=0; $i<$td_aluno; $i++){
		if($p_aluno[$i]==""){
			$p_aluno_validacao =  false;
			break;
		}
	}
	for($i=0; $i<$td_equipe; $i++){
		if($p_equipe[$i]==""){
			$p_equipe_validacao =  false;
			break;
		}
	}

	$msg = "";
	$imagem = "warning.png";

	/*Validação dos dados!*/

	if((!$p_aluno_validacao)&&(!$p_equipe_validacao)){
		 $msg = mensagenscampos(3,'aluno ou equipe');//Recebe mensagem pedindo para preencher um dos campos (ou os dois)!
	}else if ($p_classificacao == ""){ //Se o campo de classificação estiver vazio...
		$msg= mensagenscampos(1,'classificação'); //Recebe mensagem pendindo para selecionar uma classificação!
	}else if ($p_data == ""){ //Se o campo data estiver vazio...
		$msg= mensagenscampos(1,'data'); //Recebe uma mensagem pedindo para preencher o campo data!
	}else if (str_replace(' ', '', $p_anotacao) == ""){ //Se o campo anotação estiver vazio....
		$msg= mensagenscampos(1,'anotação'); //Recebe uma mensagem pedindo para preencher o campo anotação!
	}else{

		$sql_sel_orientadores = "SELECT id,nome_orientador FROM orientadores WHERE usuarios_id  = '".$_SESSION['idusuario']."'";/*Selecionando os dados da tabela orientadores onde usuarios_id é igual a $_SESSION['idusuario']*/
		$sql_sel_orientadores_resultado = $conexao->query ($sql_sel_orientadores); //Executando a sintaxe!
		$sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array();

			$tabela = "anotacoes";
			$dados = array (
				'orientadores_id' => $sql_sel_orientadores_dados['id'],
				'classificacao' => $p_classificacao,
				'data_anotacao' => $p_data,
				'anotacao' => $p_anotacao
			);
			$resultado = adicionar ($tabela,$dados);
			if($resultado){
				/* Realizando a inserção de ALUNOS E EQUIPES*/
				$id_anotacao = $conexao->insert_id;

				for($i=0; $i<$td_aluno; $i++){

						if($p_aluno[$i]==""){
							$p_aluno_validacao =  false;
						}
						if($p_aluno_validacao){

									/*Realizando a inserção dos ALUNOS*/
							if($p_aluno <> ""){
								$tabela = "alunos_has_anotacoes";
								$dados = array(
									'alunos_id' => $p_aluno[$i],
									'anotacoes_id' => $id_anotacao
								);
								$resultado = adicionar($tabela,$dados);
								if(!$resultado){
									$msg = mensagens(2,"Cadastro","anotação");
								}
							}
						}
					}
					/* Realizando a inserção de EQUIPES*/
				if($p_equipe <> ""){

					for($i=0; $i<$td_equipe; $i++){

						if($p_equipe[$i]==""){
							$p_equipe_validacao =  false;
						}
						if($p_equipe_validacao){

								$tabela = "equipes_has_anotacoes";
								$dados = array (
									'equipes_id' => $p_equipe[$i],
									'anotacoes_id' => $id_anotacao
								);
								$resultado = adicionar($tabela,$dados);
								if(!$resultado){
									$msg = mensagens(2,"Cadastro","anotação");
								}
						}
					}
				}
				if($resultado){
					$msg = mensagens(1,'Cadastro','anotação');;
					$imagem = "ok.png";
				}else{

					$msg = mensagens(2,"Cadastro","anotação");

				}
			}else{
				$msg = mensagens(2,"Cadastro","anotação");
			}
		}
?>
<div id="mensagens">
Aviso
<img src="../../layout/images/<?php echo $imagem; ?>">
<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=notes&file=sgaaes_fmins_note&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
