<fieldset style="width: 95%;margin-bottom: 10px;">
	<?php
	$_SESSION['pagina'] = "";
	$_SESSION['pagina'] ['titulo'] = '<legend>Relatório de Anotações</legend>';

		$condicaonomealuno = "";
		$condicaonomeequipe = "";
		$condicaodata = "";
		$condicaoclassificacao = "";
		$condicaoanotacao = "";
		$condicaoturma = "";

		if(isset($_POST["txtnome"])){
			$p_nome = $_POST['txtnome'];
			$p_data1 = $_POST['txtdata1'];
			$p_data2 = $_POST['txtdata2'];
			$p_classificacao = $_POST['selclassificacao'];
			$p_turma = $_POST['selturma'];

			if($p_nome <> ""){

				$condicaonomealuno = "AND nome_aluno LIKE '%".addslashes($p_nome)."%'";
				$condicaonomeequipe = "AND nome_equipe LIKE '%".addslashes($p_nome)."%'";

			}

			if($p_turma <> ""){
				$condicaoturma = "AND turmas_id = '".$p_turma."'";
			}

			if(($p_data1 <> "")&&($p_data2 <>"")&&($p_classificacao == "")){

				$condicaodata = "WHERE data_anotacao BETWEEN '".$p_data1."' AND '".$p_data2."'";

			}else if(($p_data1 == "")&&($p_data2 == "")&&($p_classificacao <> "")){

				$condicaoclassificacao = "WHERE classificacao='".$p_classificacao."'";

			}else if(($p_data1 <> "")&&($p_data2 <> "")&&($p_classificacao <> "")){

				$condicaoanotacao = "WHERE data_anotacao BETWEEN '".$p_data1."' AND '".$p_data2."' AND classificacao='".$p_classificacao."'";

			}

		}else{
			$p_nome = "";
			$p_data1 = "";
			$p_data2 = "";
			$p_classificacao = "";
		}

	 ?>
	<form name="frmfiltroanotacoes" method="POST" action="?folder=reports&file=sgaaes_notes_report&ext=php">
		Nome:<input type="text" name="txtnome" id="alunoequipe" placeHolder="Aluno ou Equipe" value="<?php echo $p_nome; ?>">
		De<input type="date" name="txtdata1" placeholder="DD/MM/AAAA" onfocus="this.value='';" value="<?php echo $p_data1 ?>">
		Até<input type="date" name="txtdata2" placeholder="DD/MM/AAAA" onfocus="this.value='';" value="<?php echo $p_data2 ?>">
		Tipo:
		<select name="selclassificacao">
			<?php

				$selecionada1 = "";
				$selecionada2 = "";
				$selecionada3 = "";
				if($p_classificacao == "pos"){

					$selecionada1 = "selected";

				}else if($p_classificacao == "neg"){

							$selecionada2 = "selected";

						}else if($p_classificacao == "neu"){

							$selecionada3 = "selected";

						}

			?>
			<option value="">Todos</option>
			<option value="pos" <?php echo $selecionada1;  ?>>Positiva</option>
			<option value="neg" <?php echo $selecionada2; ?>>Negativa</option>
			<option value="neu" <?php echo $selecionada3; ?>>Neutra</option>
		</select>
		<p>
		Turma
			<select name="selturma">
			<option value="">Todas </option>
			<?php
				$sql_sel_turmas="SELECT turmas.* FROM turmas";
				$sql_sel_turmas_resultado=$conexao->query($sql_sel_turmas);

				while($sql_sel_turmas_dados=$sql_sel_turmas_resultado->fetch_array()){

					$modalidade = "";
					$periodo = "";
							if($sql_sel_turmas_dados['modalidade'] == "t"){

										$modalidade = "Técnico";

								}else{

									$modalidade = "Superior";

								}

					if($sql_sel_turmas_dados['periodo'] == "mat"){

									$periodo = "Matutino";

							}else if($sql_sel_turmas_dados['periodo'] == "ves"){

											$periodo = "Vespertino";

											}else if($sql_sel_turmas_dados['periodo'] == "not"){

													$periodo = "Noturno";

												}
												$opc_selecionada = "";

												if($sql_sel_turmas_dados['id'] == $p_idturma){

													$opc_selecionada = "selected";
													$nome_turma = "Turma ".$sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo;

												}
											?>
												<option value="<?php echo $sql_sel_turmas_dados['id'] ?>" <?php echo $opc_selecionada; ?>><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo ?></option>
											<?php

											}

											?>
			</select>
		<button type="submit">Filtrar</button>
	</form>
	<?php
	$_SESSION['pagina']['conteudo'] = '
	<p></p>
	<table border="1" width="98%">
		<thead>
			<tr>
				<th width="12%">Aluno</th>
				<th width="12%">Equipe</th>
				<th width="10%">Data</th>
				<th width="25%">Anotações</th>
				<th width="10%">Tipo</th>
				<th width="12%">Orientador</th>
			</tr>
		</thead>
		<tbody>
		';

				$sql_sel_anotacoes = "SELECT * FROM anotacoes ".$condicaodata." ".$condicaoclassificacao." ".$condicaoanotacao." ORDER BY data_anotacao DESC";
				$sql_sel_anotacoes_resultado = $conexao->query($sql_sel_anotacoes);

				if($sql_sel_anotacoes_resultado->num_rows == 0){

			$_SESSION['pagina']['conteudo'].='
			<tr>
					<td colspan="8">Nenhuma Anotação registrada ou dados incorretos no filtro!</td>
			</tr>
			';

				}else{

					$quant = 0;

					while($sql_sel_anotacoes_dados = $sql_sel_anotacoes_resultado->fetch_array()){
						$sql_sel_alunos = "SELECT nome_aluno
						FROM alunos
						INNER JOIN alunos_has_anotacoes ON(alunos_has_anotacoes.alunos_id = alunos.id)
						INNER JOIN turmas ON(alunos.turmas_id = turmas.id)
						WHERE alunos_has_anotacoes.anotacoes_id='".$sql_sel_anotacoes_dados['id']."' ".$condicaonomealuno." ".$condicaoturma."
						ORDER BY nome_aluno ASC";
						$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);

						$sql_sel_equipes = "SELECT nome_equipe
												FROM equipes
												INNER JOIN equipes_has_anotacoes ON(equipes_has_anotacoes.equipes_id = equipes.id)
												WHERE equipes_has_anotacoes.anotacoes_id='".$sql_sel_anotacoes_dados['id']."' ".$condicaonomeequipe."
												ORDER BY nome_equipe ASC";
						$sql_sel_equipes_resultado = $conexao->query($sql_sel_equipes);

						if(($sql_sel_alunos_resultado->num_rows <> 0)||($sql_sel_equipes_resultado->num_rows <> 0)){
							$quant = 1;
							$_SESSION['pagina']['conteudo'].='
							<tr>
							';

										$data = explode("-",$sql_sel_anotacoes_dados['data_anotacao']);
										$data = $data[2]."/".$data[1]."/".$data[0];

										$sql_sel_orientadores = "SELECT nome_orientador FROM orientadores WHERE id='".$sql_sel_anotacoes_dados['orientadores_id']."'";
										$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);
										$sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array();


										if($sql_sel_anotacoes_dados['classificacao'] == "pos"){

											$classificacao = "Positiva";

										}else if($sql_sel_anotacoes_dados['classificacao'] == "neg"){

											$classificacao = "Negativa";

										}else{

											$classificacao = "Neutra";

										}
									$_SESSION['pagina']['conteudo'].='
										<td>
										';

										$nome_aluno = "";
										while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){

											$nome_aluno .= $sql_sel_alunos_dados['nome_aluno']." ";

										}
										$_SESSION['pagina']['conteudo'].= '
										'.$nome_aluno.'
										';
								$_SESSION['pagina']['conteudo'].='
								</td>
								<td>
								';
										$equipes = "";
										while($sql_sel_equipes_dados = $sql_sel_equipes_resultado->fetch_array()){

											$equipes .= $sql_sel_equipes_dados['nome_equipe'].", ";


										}
										$equipes = substr($equipes, 0, -2);
										$_SESSION['pagina']['conteudo'].='
										'.$equipes.'
										';
									$_SESSION['pagina']['conteudo'].='
										</td>
											<td>'.$data.'</td>
											<td>'.$sql_sel_anotacoes_dados['anotacao'].'</td>
											<td>'.$classificacao.'</td>
											<td>'.$sql_sel_orientadores_dados['nome_orientador'].'</td>
										</tr>
									';
						}
					}
					if($quant == 0){

					$_SESSION['pagina']['conteudo'].='
						<tr>
							<td colspan="6">Nenhum aluno ou equipe com esse nome!</td>
						</tr>
						';
					}
				}
		$_SESSION['pagina']['conteudo'].='
		</tbody>
	</table>
	';
	echo $_SESSION['pagina']['titulo'];
	echo $_SESSION['pagina']['conteudo'];
	?>
	<a style="float:right;" href="../../addons/plugins/pdf/sgaaes_construtorpdf_pdf.php"><button type="button" class ="btnpdf" title='Imprimir'><img width="40px" height="40px"  src="../../layout/images/pdf.png"></button><br/><p style="float:right; text-decoration:none; color:black; margin-top:0px;">Imprimir</p></a>
</fieldset>
