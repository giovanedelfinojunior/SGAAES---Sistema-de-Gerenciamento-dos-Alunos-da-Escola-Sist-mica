<?php
	
	$g_id = $_GET['id'];
	
	$msg = "";
	$imagem = "warning.png"; 
		
		$tabela = "orientadores_has_turmas";
		
		$condicao = "turmas_id = '".$g_id."'";
		
		$resultado = deletar($tabela, $condicao);

		if($resultado){

			$sql_sel_alunos = "SELECT id,usuarios_id FROM alunos WHERE turmas_id = '".$g_id."'";
			$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);
			
			if($sql_sel_alunos_resultado->num_rows > 0){
				while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){
				
					$tabela = "alunos_has_anotacoes";

					$condicao = "alunos_id = '".$sql_sel_alunos_dados['id']."'";

					$resultado = deletar($tabela, $condicao);
					
					
					if($resultado){

						$tabela = "ajustes_de_ponto";
						
						$condicao = "alunos_id = '".$sql_sel_alunos_dados['id']."'";
							
						$resultado = deletar($tabela, $condicao);	
											
						if($resultado){

							$tabela = "alunos";
							
							$condicao = "turmas_id = '".$g_id."'";
							
							$resultado = deletar($tabela, $condicao);
						
							if($resultado){

								$tabela = "usuarios";

								$condicao = "id = '".$sql_sel_alunos_dados['usuarios_id']."'";

								$resultado = deletar($tabela, $condicao);
							}else{

							$msg = mensagens(2, "Exclusão","turma");
						
							}
						}else{
						
							$msg = mensagens(2, "Exclusão","turma");
							
						}
					}else{
					
						$msg = mensagens(2, "Exclusão","turma");
						
					}
				}
			}

			if($resultado){
				
				$tabela = "turmas";
			
				$condicao = "id = '".$g_id."'";
			
				$resultado = deletar($tabela, $condicao);

				if($resultado){
				
					$msg = mensagens(1, "Exclusão","turma");
					$imagem = "ok.png";

				}else{
	
					$msg = mensagens(2, "Exclusão","turma");
		
				}
	 		}else{
				$msg = mensagens(2, "Exclusão","turma");
		
			}

		}else{
	
			$msg = mensagens(2, "Exclusão","turma");
		
		}	
	
?>
							
<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=classes&file=sgaaes_fmins_class&ext=php" class="retornar">Retornar</a>
<?php	
$conexao->close(); 
?>