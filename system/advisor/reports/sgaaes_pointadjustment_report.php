<fieldset style="width:95%;margin-bottom: 10px;">
	<legend>Relatório De Ajustes De Ponto</legend>
<?php

	$_SESSION['pagina']="";
	$_SESSION['pagina']['titulo']='<h2>Relatório De Ajustes De Ponto</h2>';

	$sql_sel_turmas="SELECT turmas.* FROM turmas";
	$sql_sel_turmas_resultado=$conexao->query($sql_sel_turmas);

	$sql_sel_tipo="SELECT ajustes_de_ponto.* FROM ajustes_de_ponto";
	$sql_sel_tipo_resultado=$conexao->query($sql_sel_tipo);

		$condicao="";
		if((isset($_POST['txtnome']))&&(isset($_POST['txtdata1'])) && (isset ($_POST['txtdata2']))&&(isset($_POST['seltipo']))&&(isset($_POST['selturma']))){
				$p_nome=$_POST['txtnome'];
				$p_data1=$_POST['txtdata1'];
				$p_data2=$_POST['txtdata2'];
				$p_tipo=$_POST['seltipo'];
				$p_turma=$_POST['selturma'];
				$p_status=$_POST['selstatus'];
				$condicao = "";
				$posicao_where = 0;

				if($p_nome <> ""){
				}else if(($p_data1  <> "")&&($p_data2  <> "")){
							$posicao_where = 1;
						}else if($p_tipo <> ""){
								$posicao_where = 2;
							}else if($p_turma <> ""){
												$posicao_where = 3;
											}else if($p_status <> ""){
												$posicao_where = 4;
											}

				if($p_nome<> ''){
					$condicao = "WHERE nome_aluno LIKE '%".addslashes($p_nome)."%'";
				}
				if(($p_data1  <> "")&&($p_data2  <> "")){
					if($posicao_where == 1){
						$condicao = "WHERE ";
					}else{
						$condicao .= "AND ";
					}
					$condicao .= "data_ajuste BETWEEN '".$p_data1."' AND '".$p_data2."'";
				}
				if($p_tipo <> ""){
					if($posicao_where == 2){
						$condicao = "WHERE ";
					}else{
						$condicao .= "AND ";
					}
					$condicao .= "tipo='".$p_tipo."'";
				}
				if($p_turma <> ""){
					if($posicao_where == 3){
						$condicao = "WHERE ";
					}else{
						$condicao .= "AND ";
					}
					$condicao .= "turmas_id='".$p_turma."'";
				}
				if($p_status <> ""){
					if($posicao_where == 4){
						$condicao = "WHERE ";
					}else{
						$condicao .= "AND ";
					}
					$condicao .= "status_ajuste='".$p_status."'";
				}
			}else{
				$p_nome="";
				$p_data1="";
				$p_data2="";
				$p_tipo="";
				$p_turma="";
				$p_classificacao="";
			}

	$nomeepiteto = "";

	$tipo="";
	$tipo_status="";
	$tipo_ajuste="";
	$sql_sel_tabela="SELECT ajustes_de_ponto.*,
						alunos.*,
						motivos.*,
						turmas.*
						FROM ajustes_de_ponto
						INNER JOIN alunos ON(ajustes_de_ponto.alunos_id=alunos.id)
						INNER JOIN motivos ON (ajustes_de_ponto.motivos_id=motivos.id)
						INNER JOIN turmas ON (alunos.turmas_id=turmas.id)
						".$condicao."
						ORDER BY data_ajuste DESC";

	$sql_sel_tabela_resultados=$conexao->query($sql_sel_tabela);

	$sql_sel_alunos = "SELECT nome_aluno,epiteto FROM alunos ORDER BY nome_aluno ASC";
	$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);

	while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){
		$nomeepiteto .= "'".$sql_sel_alunos_dados['nome_aluno']."', '".$sql_sel_alunos_dados['epiteto']."', ";
	}

	$nomeepiteto = substr($nomeepiteto, 0, -2);

?>
		<form name="frmfiltro" method="post" action="?folder=reports&file=sgaaes_pointadjustment_report&ext=php">
				Nome:
					<input type="text" id="alunoepiteto" name="txtnome" placeholder="Nome ou Epíteto " maxlength="40" />
				De<input type="date" name="txtdata1" placeholder="DD/MM/AAAA" onfocus="this.value='';" value="<?php echo $p_data1 ?>">
				Até<input type="date" name="txtdata2" placeholder="DD/MM/AAAA" onfocus="this.value='';" value="<?php echo $p_data2 ?>">
				Tipo:
					<select name="seltipo">
						<option value="">Todos</option>
							<?php
									$selected1 = "";
									$selected2 = "";
									$selected3 = "";
									$selected4 = "";
									if($p_tipo == "ft"){
										$selected1 ="selected";
										}else if($p_tipo == "ct"){
											$selected2 ="selected";
											}else if($p_tipo == "sa"){
												$selected3 ="selected";
												}else if($p_tipo == "am"){
													$selected4 ="selected";
													}
							?>
						<option value="ft" <?php echo $selected1 ?>>Falta</option>
						<option value="ct" <?php echo $selected2 ?>>Chegada Tardia</option>
						<option value="sa" <?php echo $selected3 ?>>Saída Antecipada</option>
						<option value="am" <?php echo $selected4 ?>>Ambos</option>
					</select>
					Status:<select name="selstatus">
									<option value="">Todos</option>
										<?php
												$selected1 = "";
												$selected2 = "";
												$selected3 = "";
												$selected4 = "";
												if($p_status == "r"){
													$selected1 ="selected";
												}else if($p_status == "s"){
														$selected2 ="selected";
													}else if($p_status == "p"){
															$selected3 ="selected";
														}else if($p_status == "a"){
																$selected4 ="selected";
																}
										?>
									<option value="r" <?php echo $selected1 ?>>Rejeitado</option>
									<option value="s" <?php echo $selected2 ?>>Solicitado</option>
									<option value="p" <?php echo $selected3 ?>>Pendente</option>
									<option value="a" <?php echo $selected4 ?>>Aceito</option>
								</select><p>
					Turma
					<select name="selturma">
					<option value="">Todas </option>
					<?php
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

		$_SESSION['pagina']['conteudo'] ='

			<table width="98%" border="1">
				<thead>
					<tr>
						<th width="15%">Nome</th>
						<th width="10%">Epíteto</th>
						<th width="10%">Data</th>
						<th width="10%">Tipo</th>
						<th width="5%">Horário De Entrada</th>
						<th width="5%">Horário De Saída</th>
						<th width="10%">Motivo</th>
						<th width="30%">Observação</th>
						<th width="10%">Status</th>
					</tr>
				</thead>
				<tbody>';

						if($sql_sel_tabela_resultados->num_rows==0){
					$_SESSION['pagina']['conteudo'].='
					<tr>
						<td colspan="9" align="center">Nenhum Registro</td>
					</tr>';

						}else {
							while($sql_sel_tabela_dados=$sql_sel_tabela_resultados->fetch_array()){

								$data = explode("-",$sql_sel_tabela_dados['data_ajuste']);
								$data = $data[2]."/".$data[1]."/".$data[0];

								if($sql_sel_tabela_dados['status_ajuste']=='r'){
									$tipo_status="Rejeitado";
									}else if($sql_sel_tabela_dados['status_ajuste']=='p'){
											$tipo_status="Pendente";
										}else if($sql_sel_tabela_dados['status_ajuste']=='a'){
												$tipo_status="Aceito";
											}else if($sql_sel_tabela_dados['status_ajuste']=='s'){
													$tipo_status="Solicitado";
												}

												 if($sql_sel_tabela_dados['tipo']=='ft'){
														$tipo_ajuste="Falta";
													}else if($sql_sel_tabela_dados['tipo']=='sa'){
															$tipo_ajuste="Saída Antecipada";
														}else if($sql_sel_tabela_dados['tipo']=='ct'){
																$tipo_ajuste="Chegada Tardia";
															}else if($sql_sel_tabela_dados['tipo']=='am'){
																$tipo_ajuste="Ambos";
															}
													if($sql_sel_tabela_dados['hora_entrada'] == '00:00:00'){
														$hora_entrada = " - ";
													}else{
														$hora_entrada = substr($sql_sel_tabela_dados['hora_entrada'],0,5);
													}
													if($sql_sel_tabela_dados['hora_saida'] == '00:00:00'){
														$hora_saida = " - ";
													}else{
														$hora_saida = substr($sql_sel_tabela_dados['hora_entrada'],0,5);
													}
					$_SESSION['pagina']['conteudo'].='
					<tr>
						<td align="center">'.$sql_sel_tabela_dados['nome_aluno'].'</td>
						<td align="center">'.$sql_sel_tabela_dados['epiteto'].'</td>
						<td align="center">'.$data.'</td>
						<td align="center">'.$tipo_ajuste.'</td>
						<td align="center">'.$hora_entrada.'</td>
						<td align="center">'.$hora_saida.'</td>
						<td align="center">'.htmlentities($sql_sel_tabela_dados['motivo'], ENT_QUOTES).'</td>
						<td align="center">'.htmlentities($sql_sel_tabela_dados['observacao'], ENT_QUOTES).'</td>
						<td align="center">'.$tipo_status.'</td>
					</tr>
				</tbody>';

							}
						}

					$_SESSION['pagina']['conteudo'].='
			</table>';

		echo $_SESSION['pagina']['conteudo'];


		?>
		<a style="float:right;" href="../../addons/plugins/pdf/sgaaes_construtorpdf_pdf.php"><button type="button" class ="btnpdf" title='Imprimir'><img width="40px" height="40px"  src="../../layout/images/pdf.png"></button><br/><p style="float:right; text-decoration:none; color:black; margin-top:0px;">Imprimir</p></a>
</fieldset>
