<fieldset style="width: 95%;margin-bottom: 10px;">
	<legend>Gestão de Ajuste de Ponto</legend>
<script style="text/javascript">
	function rejeitar(id){

var motivo_rejeicao=prompt("Motivo da rejeição:");
		if(motivo_rejeicao) {
			document.getElementById('hidmotivorejeicao'+id).value = motivo_rejeicao;
	   }else {
	    return false;
	  }



	}

</script>
<?php


	$alert = "";
	$add_motivo="";
	$p_motivorejeicao="";
	if(isset($_GET['id'])&&(isset($_GET['status_ajuste']))){
		$g_id=$_GET['id'];
		$g_status=$_GET['status_ajuste'];
		$semzeros_id = (int)$g_id;
		if(isset($_POST['hidmotivorejeicao'.$semzeros_id])){
			$p_motivorejeicao = $_POST['hidmotivorejeicao'.$semzeros_id];
		};
		$tabela="ajustes_de_ponto";
		$condicao="id = '".$g_id."'";
		$dados=array(
			'status_ajuste'=>$g_status,
			'motivo_rejeicao'=>$p_motivorejeicao,
			'data_envio'=>$data_envio,
			'hora_envio'=>$hora_envio
		);


		$resultado= atualizar($tabela,$dados,$condicao);

		if($resultado){
			if($g_status == "a"){
				$alert = "<img width='12px' height='10px' src='../../layout/images/ok.png'/>Ajuste aceito com sucesso!";
			}else if($g_status == 'r'){
				$alert = "<img width='12px' height='10px' src='../../layout/images/ok.png'/>Ajuste rejeitado com sucesso!";
			}
		}else{
			$alert = "<img width='12px' height='10px' src='../../layout/images/warning.png'>Erro ao aceitar/rejeitar ajuste!".$conexao->error;
		}
	}
	?>
	<center><?php echo $alert ?></center>
	<?php
	$tipo="";
	 $sql_sel_tabela="SELECT ajustes_de_ponto.*,
													ajustes_de_ponto.id AS ajustes_id,
                      		motivos.*,
													turmas.*,
                        	usuarios.id,
													alunos.*
									FROM ajustes_de_ponto
									INNER JOIN motivos ON (ajustes_de_ponto.motivos_id=motivos.id)
									INNER JOIN alunos	ON(ajustes_de_ponto.alunos_id=alunos.id)
									INNER JOIN turmas ON (alunos.turmas_id=turmas.id)
									INNER JOIN orientadores_has_turmas ON(orientadores_has_turmas.turmas_id = alunos.turmas_id)
									INNER JOIN orientadores ON (orientadores.id = orientadores_has_turmas.orientadores_id)
          				INNER JOIN usuarios ON (orientadores.usuarios_id = usuarios.id)
									WHERE status_ajuste='p' AND usuarios.id = '".$_SESSION['idusuario']."'
									ORDER BY data_ajuste DESC";

				$sql_sel_tabela_resultados=$conexao->query($sql_sel_tabela);



				?>
	<table border="1" width="98%">
		<thead>
			<tr>
				<th width="20%">Turma</th>
				<th width="10%">Nome</th>
				<th width="10%">Epíteto</th>
				<th width="10%">Data</th>
				<th width="10%">Tipo</th>
				<th width="10%">Horário Entrada</th>
				<th width="10%">Horário Saída</th>
				<th width="10%">Motivo</th>
				<th width="20%">Observação</th>
				<th width="20%">Enviado</th>
				<th width="5%">Aceitar</th>
				<th width="5%">Rejeitar</th>
				</div>
			</tr>
		</thead>
		<tbody>
<?php
			if($sql_sel_tabela_resultados->num_rows==0){

				echo '
			<tr>
				<td colspan="13" align="center">Nenhum Registro</td>
			</tr>';

			}else{
				$semzeros_id = "";
				while($sql_sel_tabela_dados=$sql_sel_tabela_resultados->fetch_array()){
					$data = explode("-",$sql_sel_tabela_dados['data_ajuste']);
					$data = $data[2]."/".$data[1]."/".$data[0];
					$data_envio = explode("-",$sql_sel_tabela_dados['data_envio']);
					$sql_sel_tabela_dados['data_envio'] = $data_envio['2']."/".$data_envio['1']."/".$data_envio['0'];

					$semzeros_id = (int)$sql_sel_tabela_dados['ajustes_id'];//retirando zeros a esquerda porque depois será utilizado no nome e id do campo motivo rejeição, e o javascript elimina os zeros a esquerda
					if($sql_sel_tabela_dados['tipo']=='ft'){
						$tipo="Falta";
						}else if($sql_sel_tabela_dados['tipo']=='am'){
							$tipo="Ambos";
							}else if($sql_sel_tabela_dados['tipo']=='ct'){
								$tipo="Chegada Tardia";
								}else if($sql_sel_tabela_dados['tipo']=='sa'){
									$tipo="Saída Antecipada";
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
									if($sql_sel_tabela_dados['modalidade'] == "t"){

												$modalidade = "Técnico";

										}else{

											$modalidade = "Superior";

										}

							if($sql_sel_tabela_dados['periodo'] == "mat"){

											$periodo = "Matutino";

									}else if($sql_sel_tabela_dados['periodo'] == "ves"){

													$periodo = "Vespertino";

												}else if($sql_sel_tabela_dados['periodo'] == "not"){

															$periodo = "Noturno";

														}
?>

			<tr>
				<td><?php echo $sql_sel_tabela_dados['nome_turma']."-".$modalidade."-".$periodo; ?> </td>
				<td><?php echo $sql_sel_tabela_dados['nome_aluno']; ?></td>
				<td><?php echo $sql_sel_tabela_dados['epiteto']; ?></td>
				<td><?php echo $data; ?></td>
				<td><?php echo $tipo; ?></td>
				<td><?php echo $hora_entrada; ?></td>
				<td><?php echo $hora_saida; ?></td>
				<td><?php echo htmlentities($sql_sel_tabela_dados['motivo'], ENT_QUOTES); ?></td>
				<td><?php echo htmlentities($sql_sel_tabela_dados['observacao'], ENT_QUOTES); ?></td>
				<td><?php echo $sql_sel_tabela_dados['data_envio']." - ".substr($sql_sel_tabela_dados['hora_envio'],0,5) ; ?> </td>

				<div id="retirarbotoespdf" style="display: block;">
					<td align="center"><a href="?folder=managements&file=sgaaes_pointadjustment_management&ext=php&id=<?php echo $sql_sel_tabela_dados['ajustes_id']?>
					&status_ajuste=a"><img style="width:25px; "src="../../layout/images/ok.png"/></td>
					<form name="frmmotivorejeicao" method="POST" action="?folder=managements&file=sgaaes_pointadjustment_management&ext=php&ext=php&id=<?php echo $sql_sel_tabela_dados['ajustes_id'] ?>
						&status_ajuste=r">
						<input type="hidden" id="hidmotivorejeicao" value=" <?php echo $semzeros_id; ?>" name="hidmotivorejeicao'.$semzeros_id.'" value="">
						<td align="center"><a onClick="return rejeitar('<?php echo $semzeros_id; ?>')"><button style="text-decoration: none; background-color: rgba(0,0,0,0); border: none;" type="submit"><img style="width:25px;" src="../../layout/images/reject.png"/></button></a></td>
					</form>
				</div>
			</tr>
		</tbody>
<?php
				 }
			}
?>
	</table>

</fieldset>
