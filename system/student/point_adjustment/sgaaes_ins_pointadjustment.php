<?php

	$p_data=$_POST["txtdata"];
	$p_tipos_ajustes=$_POST["seltipos"];
	$p_horario_entrada=$_POST["txthoraentrada"];
	$p_horario_saida=$_POST["txthorasaida"];
	$p_motivos=$_POST["selmotivos"];
	$p_observacoes=$_POST["txaobservacoes"];
$p_id = $_POST['hidid'];

if ($p_id =='') {
	$url_retorno = "?folder=point_adjustment&file=sgaaes_fmins_pointadjustment&ext=php";
	$p_id = "";
}else{
$p_id = $_POST['hidid'];
$url_retorno = "?folder=point_adjustment&file=sgaaes_fmins_pointadjustment&ext=php&id=".$p_id;
}
	$sql_sel_alunos="SELECT id FROM alunos WHERE usuarios_id='".$_SESSION['idusuario']."' ";
	$sql_sel_alunos_resultados=$conexao->query($sql_sel_alunos);
	$sql_sel_alunos_dados=$sql_sel_alunos_resultados->fetch_array();

	$msg ="";
	$imagem ="warning.png";

	if($p_data == ""){
		$msg= mensagenscampos(1, "data");

	}else if($p_tipos_ajustes == ""){
			$msg= mensagenscampos(1, "tipo do ajuste");

		}else if(($p_horario_entrada == "")&&(($p_tipos_ajustes == "ct")||($p_tipos_ajustes == "am"))){
				$msg= mensagenscampos(1, "hora de entrada");
			}else if(($p_horario_saida == "")&&(($p_tipos_ajustes == "sa")||($p_tipos_ajustes == "am"))){
					$msg= mensagenscampos(1, "hora de saída");
				}else if($p_motivos == ""){
						$msg= mensagenscampos(1, "motivo");
					}else{

									if($p_horario_entrada == ""){
										$p_horario_entrada = "00:00:00";
									}
									if($p_horario_saida == ""){
										$p_horario_saida = "00:00:00";
									}
									if($p_id > 0){
									$tabela="ajustes_de_ponto";
									$dados=array(
										'alunos_id'=>$sql_sel_alunos_dados['id'],
										'motivos_id'=>$p_motivos,
										'data_ajuste'=>$p_data,
										'tipo'=>$p_tipos_ajustes,
										'hora_entrada'=>$p_horario_entrada,
										'hora_saida'=>$p_horario_saida,
										'status_ajuste'=>"p",
										'observacao'=>$p_observacoes,
										'data_envio'=>$data_envio,
										'hora_envio'=>$hora_envio
									);
								$condicao = "id = '".$p_id."'";
								$resultado = atualizar($tabela, $dados,$condicao);
								if($resultado){
									$msg="Concluído";
									$imagem="ok.png";
									$url_retorno = "?folder=consultation&file=sgaaes_view_consultation&ext=php";
									}else{

										$msg="Erro ao adicionar".$conexao->error;
								}
							}else{
/*INSERT------------------------------------------------------------------------*/
$sql_sel_tabelas="SELECT id,data_ajuste  FROM ajustes_de_ponto WHERE data_ajuste='".$p_data."'AND alunos_id='".$sql_sel_alunos_dados['id']."'";
	$sql_sel_tabelas_resultados=$conexao->query($sql_sel_tabelas);
	$sql_sel_tabelas_dados=$sql_sel_tabelas_resultados->fetch_array();
	if($sql_sel_tabelas_resultados->num_rows>0){
		$msg="Já existe um ajuste de ponto para este dia!";
		$url_retorno = "?folder=point_adjustment&file=sgaaes_fmins_pointadjustment&ext=php";
	}else{
							$tabela="ajustes_de_ponto";
							$dados=array(
								'alunos_id'=>$sql_sel_alunos_dados['id'],
								'motivos_id'=>$p_motivos,
								'data_ajuste'=>$p_data,
								'tipo'=>$p_tipos_ajustes,
								'hora_entrada'=>$p_horario_entrada,
								'hora_saida'=>$p_horario_saida,
								'status_ajuste'=>"p",
								'observacao'=>$p_observacoes,
								'data_envio'=>$data_envio,
								'hora_envio'=>$hora_envio
							);

						$resultado = adicionar($tabela, $dados);
						if($resultado){
							$msg=mensagens(1, "Cadasto", "ajuste de ponto");
							$imagem="ok.png";
							$url_retorno = "?folder=consultation&file=sgaaes_view_consultation&ext=php";
						}else{
								$msg=mensagens(2, "Cadasto", "ajuste de ponto");
						}
					}
}
}
?>
<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="<?php echo $url_retorno ?>" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
