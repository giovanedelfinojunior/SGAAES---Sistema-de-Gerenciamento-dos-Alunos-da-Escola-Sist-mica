<?php
	$g_id = $_GET['id'];
 $sql_sel_alunos = "SELECT id FROM alunos WHERE usuarios_id='".$_SESSION['idusuario']."'";
$sql_sel_alunos_resultados = $conexao->query($sql_sel_alunos);
$sql_sel_alunos_dados = $sql_sel_alunos_resultados->fetch_array();

	$sql_sel_ajustes = " SELECT ajustes_de_ponto.*,motivos.motivo FROM ajustes_de_ponto INNER JOIN motivos ON (ajustes_de_ponto.motivos_id = motivos.id)WHERE alunos_id='".$sql_sel_alunos_dados['id']."' AND ajustes_de_ponto.id='".$g_id."' ";
	$sql_sel_ajustes_resultado = $conexao->query($sql_sel_ajustes);
	$sql_sel_ajustes_dados = $sql_sel_ajustes_resultado->fetch_array();

	if($sql_sel_ajustes_dados['tipo']=='ct'){
$sql_sel_ajustes_dados['tipo'] = "Chegada Tardia";
	}else if($sql_sel_ajustes_dados['tipo']=='sa'){
$sql_sel_ajustes_dados['tipo'] = "Saida Antecipada";
				}else if($sql_sel_ajustes_dados['tipo']=='ft'){
$sql_sel_ajustes_dados['tipo'] = "Falta";
				}else if($sql_sel_ajustes_dados['tipo']=='am'){
$sql_sel_ajustes_dados['tipo'] = "Ambos";
				}else{
					$sql_sel_ajustes_dados['tipo'] = "TIPO INVALIDO!";
				}

				$data = explode("-",$sql_sel_ajustes_dados['data_ajuste']);
				$sql_sel_ajustes_dados['data_ajuste'] = $data['2']."/".$data['1']."/".$data['0'];

				if($sql_sel_ajustes_dados['hora_entrada'] == '00:00:00'){
					$hora_entrada = "--:--";
				}else{
					$hora_entrada = substr($sql_sel_ajustes_dados['hora_entrada'],0,5);
				}
				if($sql_sel_ajustes_dados['hora_saida'] == '00:00:00'){
					$hora_saida = "--:--";
				}else{
					$hora_saida = substr($sql_sel_ajustes_dados['hora_entrada'],0,5);
				}
?>
<style>
.span_view{
	font-size:15px;
	margin-left: 3px;
	background-color: white;
	border: 1px solid ;
	border-color: rgba(0, 0, 0, 0.45);
	padding: 2px;
	border-radius: 2px;
	box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.43);
	max-width:200px;


}
.p_view{
font-size: 13px;

}

</style>
<fieldset class ="fieldsetformulario">
	<legend>Visualizar Ajustes</legend>
	<div id="view">

		<p class="p_view">Data:<span class="span_view"><?php echo $sql_sel_ajustes_dados['data_ajuste']?></span></p>
		<p class="p_view">Tipo de Ajuste:<span class="span_view"><?php echo $sql_sel_ajustes_dados['tipo']?></span></p>
		<p class="p_view">Horário de Entrada:<span class="span_view"><?php echo $hora_entrada?></span></p>
		<p class="p_view">Horário de Saída:<span class="span_view"><?php echo $hora_saida?></span></p>
		<p class="p_view ">Observação:<div class="span_view"><?php echo $sql_sel_ajustes_dados['observacao']?></div></p>
		<p class="p_view">Motivo:<span class="span_view"><?php echo $sql_sel_ajustes_dados['motivo']?></span></p>
	</div>
</fieldset>
