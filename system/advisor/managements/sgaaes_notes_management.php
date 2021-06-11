<fieldset style="width: 95%;margin-bottom: 10px;">
	<legend>Gestão de Anotações</legend>
	<?php

		$sql_sel_orientadores = "SELECT id,nome_orientador FROM orientadores";
		$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);

		$sql_sel_turmas = "SELECT * FROM turmas";
		$sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);

		$condicao = "";
		$condicaoturma = "";
		$condicaoturmaequipe = "";
		$condicaoturmaaluno = "";
		$condicaonomealuno = "";
		$condicaonomeequipe = "";
		$condicaodata = "";
		$condicaoorientador = "";
		$condicaoanotacao = "";
		$data = "";
		if(isset($_POST["selturma"])){//verificando se o formulário foi enviado, porque então o isset retorna verdadeiro mesmo que o campo esteja vazio;
			$p_idturma = $_POST['selturma'];
			$p_nome = $_POST['txtnome'];
			$p_data = $_POST['txtdata'];
			$p_orientador = $_POST['selorientador'];

				if($p_idturma <> ""){
					$condicaoturmaequipe = "
						INNER JOIN alunos ON(alunos.equipes_id= alunos.id)
						INNER JOIN turmas ON(alunos.turmas_id = turmas.id)";

					$condicaoturmaaluno = "
						INNER JOIN turmas ON(alunos.turmas_id= turmas.id)";

					$condicaoturma = "AND alunos.turmas_id='".$p_idturma."'";
				}
				if($p_nome <> ""){

					$condicaonomealuno = "AND nome_aluno LIKE '%".addslashes($p_nome)."%'";
					$condicaonomeequipe = "AND nome_equipe LIKE '%".addslashes($p_nome)."%'";

				}
				if(($p_data <> "")&&($p_orientador == "")){

					$condicaodata = "WHERE data_anotacao='".$p_data."'";

				}else if(($p_orientador <> "")&&($p_data == "")){

							$condicaoorientador = "WHERE orientadores_id='".$p_orientador."'";

						}else if(($p_data <> "")&&($p_orientador <> "")){

							$condicaoanotacao = "WHERE data_anotacao='".$p_data."' AND orientadores_id='".$p_orientador."'";
						}

		}else{
			$p_idturma = "";
			$p_nome = "";
			$p_data = "";
			$p_orientador = "";
		}

	 ?>
	<form name="frmfiltroanotacoes" method="POST" action="?folder=managements&file=sgaaes_notes_management&ext=php">
			Turma
			<select name="selturma">
				<option value="">Todas</option>
				<?php
					while($sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array()){
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

						}

				 ?>
						<option value="<?php echo $sql_sel_turmas_dados['id'] ?>" <?php echo $opc_selecionada; ?>><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo; ?></option>
						<?php
					}
				 ?>
			</select>
		Nome:<input type="text" name="txtnome" placeHolder="Aluno ou Equipe" value="<?php echo $p_nome; ?>">
		Data:<input type="date" name="txtdata" placeholder="DD/MM/AAAA" onfocus="this.value='';" value="<?php echo $p_data ?>">
		Orientador:
		<select name="selorientador">
			<option value="">Todos</option>
			<?php

				while($sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array()){
					$opc_selecionada = "";
					if($sql_sel_orientadores_dados['id'] == $p_orientador){

						$opc_selecionada = "selected";

					}
			?>
				<option value="<?php echo $sql_sel_orientadores_dados['id'] ?>" <?php echo $opc_selecionada; ?>><?php echo $sql_sel_orientadores_dados['nome_orientador'] ?></option>
			<?php
				}
			?>
		</select>
		<button type="submit">Filtrar</button>
	</form>
	<p></p>
	<table border="1" width="98%">
		<thead>
			<tr>
				<th width="15%">Alunos</th>
				<th width="15%">Equipes</th>
				<th width="10%">Data</th>
				<th width="20%">Anotações</th>
				<th width="10%">Tipo</th>
				<th width="12%">Orientador</th>
				<th width="5%">Editar</th>
				<th width="5%">Excluir</th>
			</tr>
		</thead>
		<tbody>
			<?php

				$sql_sel_anotacoes = "SELECT * FROM anotacoes ".$condicaodata." ".$condicaoorientador." ".$condicaoanotacao." ORDER BY data_anotacao DESC";
				$sql_sel_anotacoes_resultado = $conexao->query($sql_sel_anotacoes);

				if($sql_sel_anotacoes_resultado->num_rows == 0){

			?>
			<tr>
					<td colspan="8">Nenhuma Anotação registrada!</td>
			</tr>
			<?php

				}else{

					$quant = 0;
					while($sql_sel_anotacoes_dados = $sql_sel_anotacoes_resultado->fetch_array()){
						$sql_sel_alunos = "SELECT nome_aluno
						FROM alunos
						INNER JOIN alunos_has_anotacoes ON(alunos_has_anotacoes.alunos_id = alunos.id)
						".$condicaoturmaaluno."
						WHERE alunos_has_anotacoes.anotacoes_id='".$sql_sel_anotacoes_dados['id']."' ".$condicaoturma." ".$condicaonomealuno."
						ORDER BY nome_aluno ASC";
						$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);

						$sql_sel_equipes = "SELECT nome_equipe
												FROM equipes
												INNER JOIN equipes_has_anotacoes ON(equipes_has_anotacoes.equipes_id = equipes.id)
												".$condicaoturmaequipe."
												WHERE equipes_has_anotacoes.anotacoes_id='".$sql_sel_anotacoes_dados['id']."' ".$condicaoturma." ".$condicaonomeequipe."
												ORDER BY nome_equipe ASC";
						$sql_sel_equipes_resultado = $conexao->query($sql_sel_equipes);

						if(($sql_sel_alunos_resultado->num_rows <> 0)||($sql_sel_equipes_resultado->num_rows <> 0)){
							$quant = 1;
							?>
							<tr>
							<?php
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
							 ?>
										<td>

							<?php
										$alunos = "";
										while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){

											$alunos .= $sql_sel_alunos_dados['nome_aluno'].", ";

										}
										$alunos = substr($alunos, 0, -2);
           								 echo $alunos;
							?>
								</td>
								<td>
							<?php
										$equipes = "";
										while($sql_sel_equipes_dados = $sql_sel_equipes_resultado->fetch_array()){

											$equipes .= $sql_sel_equipes_dados['nome_equipe'].", ";

										}
										$equipes = substr($equipes, 0, -2);
           								 echo $equipes;

							?>
							</td>
												<td><?php echo $data; ?></td>
												<td><?php echo $sql_sel_anotacoes_dados['anotacao'] ?></td>
												<td><?php echo $classificacao ?></td>
												<td><?php echo $sql_sel_orientadores_dados['nome_orientador'] ?></td>
												<td><a href="?folder=notes&file=sgaaes_fmupd_note&ext=php&id=<?php echo $sql_sel_anotacoes_dados['id'];?>" title="Editar anotação"><img src="../../layout/images/edit.png"></a></td>
												<td><a onclick="return deletar('anotação','<?php echo $sql_sel_anotacoes_dados['anotacao'] ?>')" href="?folder=notes&file=sgaaes_del_note&ext=php&id=<?php echo $sql_sel_anotacoes_dados['id']; ?>"><img src="../../layout/images/delete.png"></a></td>
											</tr>
							<?php
						}
					}
					if($quant == 0){
						?>
							<tr>
								<td colspan="8">Nenhum aluno ou equipe com esse nome!</td>
							</tr>
						<?php

					}
				}
			?>
		</tbody>
	</table>
</fieldset>
