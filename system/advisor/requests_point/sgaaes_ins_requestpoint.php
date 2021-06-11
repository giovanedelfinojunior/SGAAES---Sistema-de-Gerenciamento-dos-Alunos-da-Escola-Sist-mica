<?php

	$p_data=$_POST['txtdata'];
	$p_tipoajuste=$_POST['selajuste'];
	$p_horaentrada=$_POST['txthoraentrada'];
	$p_horasaida=$_POST['txthorasaida'];
	$p_motivos=$_POST['selmotivo'];
	$p_observacoes=$_POST['txaobservacoes'];

	$p_idaluno = "";
	if(isset($_POST['selaluno'])){
		$p_idaluno=$_POST['selaluno'];
		$p_idaluno = $p_idaluno['0'];
	}else{
		$p_idaluno=$_POST['hidid'];
	}
	$msg="";
	$imagem="warning.png";

		if($p_idaluno==""){
			$msg="Preencha o campo Nome do Aluno ";
		}elseif($p_data==""){
			$msg="Preencha o campo Data";
			}else{
				if($p_horaentrada == ""){
					$p_horaentrada = "00:00:00";
				}
				if($p_horasaida == ""){
					$p_horasaida = "00:00:00";
				}

				$sql_sel_ajustes="SELECT * FROM  ajustes_de_ponto WHERE status_ajuste='s' AND data_ajuste='".$p_data."' AND alunos_id='".$p_idaluno."' ";
				$sql_sel_ajustes_resultados=$conexao->query($sql_sel_ajustes);


					if($sql_sel_ajustes_resultados->num_rows>0){
						$msg="Já existe uma solicitação para este aluno neste dia";
						}else {

							$tabela="ajustes_de_ponto";
							$dados = array (
							'alunos_id'=>$p_idaluno,
							'motivos_id'=>$p_motivos,
							'data_ajuste'=>$p_data,
							'tipo'=>$p_tipoajuste,
							'hora_entrada'=>$p_horaentrada,
							'hora_saida'=>$p_horasaida,
							'observacao'=>$p_observacoes,
							'data_envio'=>$data_envio,
							'hora_envio'=>$hora_envio,
							'status_ajuste'=>'s'
							);

							$resultado= adicionar($tabela, $dados);

							if($resultado){
								$msg="Ajuste Solicitado com sucesso.";
								$imagem="ok.png";
							}else{
								$msg="Erro ao efetuar a solicitação.".$conexao->error;
						}
					}
			}
?>
 <div id="title"></div>
  <div id="mensagens">
    Aviso
    <img src = "../../layout/images/<?php echo $imagem; ?>">
    <?php echo $msg?>
</div>
  <a class="retornar" href="?folder=requests_point&file=sgaaes_fmins_requestpoint&ext=php">Retornar</a>
