<?php
include "../../security/database/sgaaes_connection_database.php";
	//se o código for x, quer dizer que a pessoa não escolheu categoria, então avisa no select de produto que a pessoa deve selecionar a categoria
	if(isset($_POST['id_turmaaluno'])){
		$id_turmaaluno=$_POST['id_turmaaluno'];
		if ($id_turmaaluno==""){
			echo "<option value=''>Selecione uma Turma</option>";
			}
		//senão, quer dizer que a pessoa escolheu uma categoria válida, então faz a pesquisa.
		else{
			$sql_sel_alunos = "SELECT * FROM alunos WHERE turmas_id='".$id_turmaaluno."' ORDER BY nome_aluno ASC";
			$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);
			//os echos abaixo são o que é retornado para a function(busca) da página index
			if($sql_sel_alunos_resultado->num_rows == 0){
			echo "<option value=''>Nenhum Aluno Registrado</option>";
			}else{
				echo "<option value=''>Selecione um aluno</option>";
				while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){
						echo "<option value=".$sql_sel_alunos_dados['id'].">".$sql_sel_alunos_dados['nome_aluno']."</option>";
					}
				}
			}
	}else if(isset($_POST['id_turmaequipe'])){
		$id_turmaequipe =$_POST['id_turmaequipe'];
		if ($id_turmaequipe==""){
			echo "<option value=''>Selecione uma Turma</option>";
			}
		//senão, quer dizer que a pessoa escolheu uma categoria válida, então faz a pesquisa.
		else{
			$sql_sel_equipes = "SELECT equipes.*
								FROM equipes
								INNER JOIN alunos ON(alunos.equipes_id = equipes.id)
								WHERE turmas_id='".$id_turmaequipe."' ORDER BY nome_equipe ASC";
			$sql_sel_equipes_resultado = $conexao->query($sql_sel_equipes);
			//os echos abaixo são o que é retornado para a function(busca) da página index
			if($sql_sel_equipes_resultado->num_rows == 0){
				echo "<option value=''>Nenhuma Equipe Registrada</option>";
			}else{
				echo "<option value=''>Selecione uma equipe</option>";
						while($sql_sel_equipes_dados = $sql_sel_equipes_resultado->fetch_array()){
						echo "<option value=".$sql_sel_equipes_dados['id'].">".$sql_sel_equipes_dados['nome_equipe']."</option>";
					}
				}
			}
	}
?>
