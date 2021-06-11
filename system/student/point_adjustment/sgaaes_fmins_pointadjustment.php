<fieldset class ="fieldsetformulario">
	<legend>Registro de Ajuste de Ponto</legend>
	<h4>OBS: Todos os campos com asterisco são obrigatórios!</h4>
<?php
	$motivo_rejeicao="";
	$data="";
	$data_ajuste="";
	$tipo="";
	$horaentrada="";
	$horasaida="";
	$motivos="";
	$observacoes="";
	$read_onlyr="";
	$read_onlys="";
$verificar = "";
	if(isset($_GET['id'])){
		$g_id=$_GET['id'];
		$sql_sel_ajustesponto="SELECT * FROM ajustes_de_ponto WHERE id='".$g_id."'";
		$sql_sel_ajustesponto_resultados=$conexao->query($sql_sel_ajustesponto);
		$sql_sel_ajustesponto_dados=$sql_sel_ajustesponto_resultados->fetch_array();

		if($sql_sel_ajustesponto_dados['status_ajuste'] == "r"){
			$motivo_rejeicao="Motivo da rejeição: ".$sql_sel_ajustesponto_dados['motivo_rejeicao'];
			$data=$sql_sel_ajustesponto_dados['data_ajuste'];
			$tipo=$sql_sel_ajustesponto_dados['tipo'];
			$horaentrada=$sql_sel_ajustesponto_dados['hora_entrada'];
			$horasaida=$sql_sel_ajustesponto_dados['hora_saida'];
			$motivos=$sql_sel_ajustesponto_dados['motivos_id'];
			$observacoes=$sql_sel_ajustesponto_dados['observacao'];
			$read_onlyr="readonly='readonly'";
			$verificar = "r";
		}else if($sql_sel_ajustesponto_dados['status_ajuste'] == "s"){
			$data=$sql_sel_ajustesponto_dados['data_ajuste'];
			$tipo=$sql_sel_ajustesponto_dados['tipo'];
			$horaentrada=$sql_sel_ajustesponto_dados['hora_entrada'];
			$horasaida=$sql_sel_ajustesponto_dados['hora_saida'];
			$read_onlys="readonly='readonly'";
			$motivos=$sql_sel_ajustesponto_dados['motivos_id'];
			$observacoes=$sql_sel_ajustesponto_dados['observacao'];
			$verificar = "s";

		}
		$data_ajuste = explode("-",$data);
		$data_ajuste = $data_ajuste['2']."/".$data_ajuste['1']."/".$data_ajuste['0'];

	}


?>

	<?php echo $motivo_rejeicao; ?>

		<form name="frmregisterpoint" method="post" action="?folder=point_adjustment&file=sgaaes_ins_pointadjustment&ext=php">
				<input type="hidden" name="hidid" value="<?php if(isset($_GET['id'])){ echo $g_id;}?>">

					<p>*Data: <input <?php if(($data_ajuste <> "")AND($verificar=="s")){echo " name='txtdata' value= '".$data_ajuste."' readonly='readonly'";}else{ ?> name="txtdata" value= "<?php echo $data?>"  placeholder="DD/MM/AAAA" type="date" <?php }?>></p>


<?php if (($verificar <> "s")||($tipo=="")){ ?>
					<p>*Tipo de Ajuste:
						<select name='seltipos'>
							<option  value="">--Escolha--</option>
							<option <?php if($tipo == "ft"){echo "selected";} ?> value="ft">Falta</option>
							<option <?php if($tipo == "ct"){echo "selected";} ?> value="ct">Chegada Tardia</option>
							<option <?php if($tipo == "sa"){echo "selected";} ?> value="sa">Saída Antecipada</option>
							<option <?php if($tipo == "am"){echo "selected";} ?> value="am">Ambos</option>
						</select></p>
<?php
}else if($tipo=='ft'){
	echo"<p>*Tipo de Ajuste: <select name='seltipos'><option value='ft' selected>Falta</option></select></p>";
}else if($tipo=='ct'){
	echo"<p>*Tipo de Ajuste: <select name='seltipos'><option value='ct' selected>Chegada Tardia</option></select></p>";
}else if($tipo=='sa'){
	echo"<p>*Tipo de Ajuste: <select name='seltipos'><option value='sa' selected>Saída Antecipada</option></select></p>";
}else if($tipo=='am'){
	echo"<p>*Tipo de Ajuste: <select name='seltipos'><option value='am' selected>Ambos</option></select></p>";
}
 ?>


					<p>*Horário de Entrada: <input <?php if(isset($horaentrada)){echo $read_onlys."value='".$horaentrada."'"; }?>  type="time" name="txthoraentrada" maxlength="6"></p>


					<p>*Horário de Saída:	<input <?php if(isset($horasaida) ){echo $read_onlys."value='".$horasaida."'"; }?> type="time" name="txthorasaida" maxlength="6"></p>

<?php if (($verificar <> "s")||($sql_sel_ajustesponto_dados['motivos_id'] == "")){?>
					<p>*Motivo:<select name="selmotivos">
						<option value="">--Escolha--</option>
												<?php
												echo 		$sql_sel_motivos="SELECT id,motivo FROM motivos ORDER BY motivo ASC";
														$sql_sel_motivos_resultados=$conexao->query($sql_sel_motivos);
														while($sql_sel_motivos_dados=$sql_sel_motivos_resultados->fetch_array()){
												?>
										<option <?php if($sql_sel_motivos_dados['id'] == $motivos ){echo "selected";}?> value="<?php echo $sql_sel_motivos_dados['id']?>"><?php echo htmlentities($sql_sel_motivos_dados['motivo'], ENT_QUOTES); ?></option>

													<?php
														}
													?>
									</select></p>

<?php } else{
	$sql_sel_motivos="SELECT id,motivo FROM motivos WHERE id = '".$sql_sel_ajustesponto_dados['motivos_id']."'";
	$sql_sel_motivos_resultados=$conexao->query($sql_sel_motivos);
	$sql_sel_motivos_dados=$sql_sel_motivos_resultados->fetch_array();

	echo "<p>*Motivos:<select name='selmotivos' ><option value='".$sql_sel_motivos_dados['id']."'>".$sql_sel_motivos_dados['motivo']."</option></select>"; }?>

					<p>Observações:</p><textarea <?php if($observacoes <> ""){echo $read_onlys; }?> name="txaobservacoes" ><?php echo $observacoes; ?></textarea>


					<p align="center"><button type="reset">Limpar</button><button type="submit">Enviar</button><p/>


		</form>
</fieldset>
