<?php

	$sql_sel_tabela="SELECT ajustes_de_ponto.*,
						motivos.*
						FROM ajustes_de_ponto
						INNER JOIN motivos ON(ajustes_de_ponto.motivos_id=motivos.id)";


?>
<div class="tabela" >
<fieldset class = "fieldsettabela">

	<legend>Ajustes Rejeitados</legend>
	<table style ='max-width:300px;' border='1' >

		<thead>
			<tr>
				<th width="50%">Data e Hora De Envio</th>
				<th width="30%">Data do Ajuste</th>
				<th width="10%">Corrigir</th>
			</tr>
		</thead>
		<tbody>
			<?php

	$sql_sel_ajustesrejeitados="SELECT ajustes_de_ponto.*
								FROM ajustes_de_ponto
								INNER JOIN alunos ON(ajustes_de_ponto.alunos_id = alunos.id)
								WHERE alunos.usuarios_id='".$_SESSION['idusuario']."' AND status_ajuste='r'";
	$sql_sel_ajustesrejeitados_resultado=$conexao->query($sql_sel_ajustesrejeitados);
			if($sql_sel_ajustesrejeitados_resultado->num_rows==0){
			?>
			<tr>
				<td colspan="4" align="center">Nenhum Registro. </td>
			</tr>
			<?php
				}else{
					$cont_td = 0;
					while($sql_sel_ajustesrejeitados_dados=$sql_sel_ajustesrejeitados_resultado->fetch_array()){
						$cont_td += 1;
						$class_td = "";
						if($cont_td % 2 ==  0){
							$class_td = "class='cores_td'";
						}
						$data = explode("-",$sql_sel_ajustesrejeitados_dados['data_ajuste']);
						$data_ajuste = $data['2']."/".$data['1']."/".$data['0'];
						$data_envio = explode("-",$sql_sel_ajustesrejeitados_dados['data_envio']);
						$sql_sel_ajustesrejeitados_dados['data_envio'] = $data_envio['2']."/".$data_envio['1']."/".$data_envio['0'];

					?>
			<tr <?php echo $class_td; ?>>
				<td <?php echo $class_td; ?>><?php echo $sql_sel_ajustesrejeitados_dados['data_envio']; ?> - <?php echo substr( $sql_sel_ajustesrejeitados_dados['hora_envio'],0,5); ?></td>
				<td <?php echo $class_td; ?>><?php echo $data_ajuste;?></td>
				<td align="center"><a href="?folder=point_adjustment&file=sgaaes_fmins_pointadjustment&ext=php&id=<?php echo $sql_sel_ajustesrejeitados_dados['id']; ?>"><button class="btncorrigir" type="button">Corrigir</button></a></td>
			</tr>
					<?php }
				}?>
		</tbody>

	</table>
</fieldset >
</div>

<div class="tabela">
<fieldset class = "fieldsettabela">
<legend>Ajustes Solicitados</legend>
	<table style ='max-width:300px;' border='1' >

		<thead>
			<tr>
				<th width="50%">Data e Hora Da Solicitação</th>
				<th width="30%">Data Do Ajuste</th>
				<th width="20%">Enviar</th>
			</tr>
		</thead>
		<tbody>
				<?php
					$sql_sel_ajustessolicitados="SELECT ajustes_de_ponto.*
												FROM ajustes_de_ponto
												INNER JOIN alunos ON(ajustes_de_ponto.alunos_id = alunos.id)
												WHERE alunos.usuarios_id='".$_SESSION['idusuario']."' AND status_ajuste='s'";
					$sql_sel_ajustessolicitados_resultados=$conexao->query($sql_sel_ajustessolicitados);
						if($sql_sel_ajustessolicitados_resultados->num_rows==0){

				?>
			<tr>
				<td colspan="4" align="center">Nenhum Registro.</td>
			</tr>
				<?php
					}else{
						$cont_td = 0;
						while($sql_sel_ajustessolicitados_dados=$sql_sel_ajustessolicitados_resultados->fetch_array()){
							$cont_td += 1;
							$class_td = "";
							if($cont_td % 2 ==  0){
								$class_td = "class='cores_td'";
							}
							$data = explode('-',$sql_sel_ajustessolicitados_dados['data_ajuste']);
							$sql_sel_ajustessolicitados_dados['data_ajuste'] =  $data['2']."/".$data['1']."/".$data['0'];
							$data_envio = explode("-",$sql_sel_ajustessolicitados_dados['data_envio']);
							$sql_sel_ajustessolicitados_dados['data_envio'] = $data_envio['2']."/".$data_envio['1']."/".$data_envio['0'];

				?>
			<tr <?php echo $class_td; ?>>
				<td><?php echo $sql_sel_ajustessolicitados_dados['data_envio']; ?> - <?php echo substr( $sql_sel_ajustessolicitados_dados['hora_envio'],0,5); ?></td>
				<td><?php echo $sql_sel_ajustessolicitados_dados['data_ajuste']; ?></td>
				<td align="center"><a href="?folder=point_adjustment&file=sgaaes_fmins_pointadjustment&ext=	php&id=<?php echo $sql_sel_ajustessolicitados_dados['id']; ?>"><button type="submit" >Enviar</button></a></td>
			</tr>
		</tbody>
				<?php }
				}?>
	</table>
</fieldset>
</div>


<div class="tabela">
<fieldset class = "fieldsettabela">
<legend>Ajustes Pendentes</legend>
	<table border='1' >

		<thead>
			<tr>
				<th width="50">Data e Hora de Envio</th>
					<th width="10">Motivo</th>
				<th width="30">Data Do Ajuste</th>
				<th width="10">Visualizar</th>
			</tr>
		</thead>
		<tbody>
		<?php
				$sql_sel_ajustespendentes="SELECT ajustes_de_ponto.*, motivos.id AS idmotivos,motivos.motivo
										FROM ajustes_de_ponto
										INNER JOIN  motivos ON(ajustes_de_ponto.motivos_id=motivos.id)
										INNER JOIN alunos ON(ajustes_de_ponto.alunos_id = alunos.id)
										WHERE alunos.usuarios_id='".$_SESSION['idusuario']."' AND status_ajuste='p' ORDER BY data_ajuste DESC";
			$sql_sel_ajustespendentes_resultados=$conexao->query($sql_sel_ajustespendentes);
				if($sql_sel_ajustespendentes_resultados->num_rows==0){
		?>
			<tr>
				<td colspan="5" align="center">Nenhum Registro.</td>
			</tr>
			<?php
				}else{
				$cont_td = 0;
				while($sql_sel_ajustespendentes_dados=$sql_sel_ajustespendentes_resultados->fetch_array()){
					$cont_td += 1;
					$class_td = "";
					if($cont_td % 2 ==  0){
						$class_td = "class='cores_td'";
					}
					$data = explode("-",$sql_sel_ajustespendentes_dados['data_ajuste']);
					$data_ajuste = $data['2']."/".$data['1']."/".$data['0'];
					$data_envio = explode("-",$sql_sel_ajustespendentes_dados['data_envio']);
					$sql_sel_ajustespendentes_dados['data_envio'] = $data_envio['2']."/".$data_envio['1']."/".$data_envio['0'];
			?>
			<tr <?php echo $class_td; ?>>
				<td><?php echo $sql_sel_ajustespendentes_dados['data_envio']; ?> - <?php echo substr( $sql_sel_ajustespendentes_dados['hora_envio'],0,5); ?></td>
				<td><?php echo htmlentities($sql_sel_ajustespendentes_dados['motivo'], ENT_QUOTES); ?></td>
				<td><?php echo $data_ajuste ?></td>
				<td align="center"><a href="?folder=point_adjustment&file=sgaaes_view_pointadjustement&ext=php&id=<?php echo $sql_sel_ajustespendentes_dados['id']; ?>"><img style="width:15px;"src="../../layout/images/lupa_icon.png"/></a></td>
			</tr>
		</tbody>
				<?php }
				}?>
	</table>
</fieldset>
</div>

<div class="tabela" >
<fieldset class = "fieldsettabela">
<legend>Ajustes Aceitos</legend>
	<table border = '1'>

		<thead>
			<tr>
				<th width="20">Data</th>
				<th width="20">Motivo</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql_sel_ajustesaceitos="SELECT ajustes_de_ponto.*,
											motivos.*
											FROM ajustes_de_ponto
											INNER JOIN motivos ON(ajustes_de_ponto.motivos_id=motivos.id)
											INNER JOIN alunos ON(ajustes_de_ponto.alunos_id = alunos.id)
											WHERE alunos.usuarios_id='".$_SESSION['idusuario']."' AND status_ajuste='a' ORDER BY data_ajuste";
				$sql_sel_ajustesaceitos_resultados=$conexao->query($sql_sel_ajustesaceitos);
					if($sql_sel_ajustesaceitos_resultados->num_rows==0){
			?>
			<tr>
				<td colspan="4" align="center">Nenhum Registro.</td>
			</tr>
			<?php
					}else{
						$cont_td = 0;
						while($sql_sel_ajustesaceitos_dados=$sql_sel_ajustesaceitos_resultados->fetch_array()){
							$cont_td += 1;
							$class_td = "";
							if($cont_td % 2 ==  0){
								$class_td = "class='cores_td'";
							}
							$data = explode("-",$sql_sel_ajustesaceitos_dados['data_ajuste']);
							$sql_sel_ajustesaceitos_dados['data_ajuste'] = $data['2']."/".$data['1']."/".$data['0'];

			?>
			<tr <?php echo $class_td; ?>>
				<td><?php echo $sql_sel_ajustesaceitos_dados['data_ajuste']; ?></td>
				<td><?php echo htmlentities($sql_sel_ajustesaceitos_dados['motivo'], ENT_QUOTES); ?></td>
			</tr>
		</tbody>
						<?php }
					}?>
	</table>
</fieldset>
</div>
