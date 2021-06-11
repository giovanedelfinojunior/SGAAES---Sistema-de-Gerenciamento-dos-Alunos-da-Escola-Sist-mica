<script type="text/javascript">
		turmaAntigo = new Array();
  		turmaAntigo[0] = "";
    //função criada para receber os valores dos campos existentes, usados posteriormente para descobrirmos se o valor do campo foi alterado ou não
  function valoresAntigos (){
    //recebe todas as posições do campo selcategoria[] e salva na variável categorias
    var turmas = document.getElementsByName('selturma[]');
    //da posição 0 até a posição final do array...
    for (var i=0;i<turmas.length;i++){
      //...captura e salva o valor atual do campo selcategoria no array criado no carregamento da página para os valores antigos
      turmaAntigo[i] = turmas[i].value;
    }
  }
	//função que mostra a lista de produtos ao lado da categoria CORRETA
	  function mostraalunos(){

		//recebe todas as posições do campo selproduto[] e salva na variável produtoMudar
		var alunoMudar = document.getElementsByName('selaluno[]');
		//recebe todas as posições do campo selcategoria[] e salva na variável categoriaAtual
		var turmaAtual = document.getElementsByName('selturma[]');
		//verifica da posição 0 até a posição final do array...
		for (var j=0;j<alunoMudar.length;j++){
		  //...se o valor antigo da categoria for diferente do valor atual da categoria.
		  if (turmaAntigo[j] != turmaAtual[j].value){
			//se sim, é porque essa foi a posição alterada, portanto repassa a posição atual para a variável 'atual'
			atual=j;
		  }
		}
		    //passa o valor novo do selcategoria que foi alterado para a variável cod
		id_turmaaluno = turmaAtual[atual].value;
		//mostra o Aguarde no campo
		$(alunoMudar[atual]).html("<option>Aguarde</option>");
		//envia o código por post para a página buscadinamica.php, que pesquisa dinamicamente pelo código quais os produtos correspondentes àquela categoria
		$.post("../../addons/php/sgaaes_dynamicsearch.php", {id_turmaaluno:id_turmaaluno},
		//inicia a função busca
		function(busca){
		  //repassa o que foi encontrado na busca ao select de produtos correspondente ao de categorias qe foi modificado os produtos encontrados
		  $(alunoMudar[atual]).html(busca);
		  //chama a função valoresAntigos para guardar os valores atuais das categorias como antigos
		  valoresAntigos();
		  //fecha a função busca e o processo do post
		});
		//fecha a função mostraprodutos
	  }
	//função de validação dos campos do mestre detalhe
	  function validaDetalhe(){
		//recebe os valores das categorias preenchidas
		var turmasValidar = document.getElementsByName('selturma[]');
		//recebe os valores dos produtos preenchidos
		var alunosValidar = document.getElementsByName('selaluno[]');
		//estrutura para-faça para repetir a validação enquanto i for menor que o tamanho do array, sendo que i começa de 0 e tem incremento 1
		for (var i = 0;i < turmasValidar.length; i++){
		  //cria a variável linha com valor de "i mais um" para a mensagem avisar corretamente qual campo não foi preenchido
		  var linha = i+1;
		  //se a posição atual dos arrays de categoria e/ou produto estiverem vazios,
		  if ((turmasValidar[i].value=="")||(alunosValidar[i].value=="")){
			alert ("A linha "+linha+" não foi completamente preenchida.");
			return false;
		  }
		}

	  }
</script>
<?php

	$sql_sel_requestpoint="SELECT motivos.* FROM motivos";
	$sql_sel_requestpoint_resultados=$conexao->query($sql_sel_requestpoint);


?>

<fieldset>
	<legend>Solicitação de Ajuste de Ponto</legend>
	<form name="frmrequestpoint" method="post" action="?folder=requests_point&file=sgaaes_ins_requestpoint&ext=php">
			<h4>Os campos que possuem asterisco são obrigatórios</h4>
		<?php
				if(isset($_GET['id'])){
					$sql_sel_alunos = "SELECT id, nome_aluno FROM alunos WHERE id='".$_GET['id']."'";
					$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);
					$sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array();
				 echo $sql_sel_alunos_dados['nome_aluno'];
				 ?>
				 <input type="hidden" name="hidid" value="<?php echo $sql_sel_alunos_dados['id'] ?>">
				 <?php
				}else{
				?>
			Turma:<select name="selturma[]" id="selturma[]" onChange="mostraalunos()">
			<option value="">Escolha</option>
			<?php
				$sql_sel_turmas = "SELECT * FROM turmas ORDER BY nome_turma ASC";
				$sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);
				$nome_turma = "Todas as Turmas";
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

			?>
					<option value="<?php echo $sql_sel_turmas_dados['id'] ?>"><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo ?></option>
			<?php

				}

			 ?>
		  </select>
			<p>*Aluno:<select name="selaluno[]" id="selaluno[]">
						<option value="">Selecione uma turma</option>
				</select>
			</p>
			<?php } ?>
			<p>*Data:<input type="date"  name="txtdata" placeholder="DD/MM/AAAA" onfocus="this.value='';"></p>
			<p>*Tipo De Ajuste:
					<select name="selajuste">
					<option value="">--Escolha--</option>
					<option value="ft">Falta</option>
					<option value="ct">Chegada Tardia</option>
					<option value="sa">Saída Antecipada</option>
					<option value="am">Ambos</option>
					</select></p>
			<p>Horário De Entrada:<input type="time" name="txthoraentrada" placeholder=""  maxlength="8"   ></p>
			<p>Horário De Saída:<input type="time" name="txthorasaida" placeholder="" maxlength="8" ></p>
			Motivo:
				<select name="selmotivo" width="30">
					<option value="">--Escolha--</option>
					<?php
						while($sql_sel_requestpoint_dados=$sql_sel_requestpoint_resultados->fetch_array()){
					?>
					<option value="<?php echo $sql_sel_requestpoint_dados['id'];?>"><?php echo $sql_sel_requestpoint_dados['motivo'];?></option>
					<?php } ?>
				</select></p>
			<p>Observações:
				<textarea name="txaobservacoes" ></textarea></p>
				<p align="center"><button type="reset">Limpar</button><button type="submit">Enviar</button></p>
	</form>
	<?php
	$tipo_status="";
		$sql_sel_ajustes="SELECT ajustes_de_ponto.*,
								ajustes_de_ponto.id AS ajustes_id,
							alunos.*
							FROM ajustes_de_ponto
							INNER JOIN alunos ON(ajustes_de_ponto.alunos_id=alunos.id)
							WHERE status_ajuste='s'";

		$sql_sel_ajustes_resultados=$conexao->query($sql_sel_ajustes);
	?>
</fieldset>
<fieldset style="min-width: 450px; margin-top: 20px;margin-bottom: 10px;">
	<legend>Solicitações de Ajustes de Ponto Registrados(as)</legend>
	<table border="1" align="center">
		<thead>
			<tr>
				<th width="10%">Aluno</th>
				<th width="10%">Data</th>
				<th width="10%">Cancelar Solicitação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($sql_sel_ajustes_resultados->num_rows== 0){
			?>
			<tr>
				<td colspan="4" align="center">Nenhum Registro</td>
			</tr>
			<?php
				}else{
					while($sql_sel_ajustes_dados=$sql_sel_ajustes_resultados->fetch_array()){

					$data = explode("-",$sql_sel_ajustes_dados['data_ajuste']);
					$data = $data[2]."/".$data[1]."/".$data[0];
			?>
			<tr>
				<td align="center"><?php echo $sql_sel_ajustes_dados['nome_aluno'] ;?></td>
				<td align="center"><?php echo $data;?></td>
				<td align="center"><a onclick="return deletar('ajustes_de_ponto','<?php echo $sql_sel_ajustes_dados['ajustes_id']; ?>')" href="?folder=requests_point&file=sgaaes_del_requestpoint&ext=php&id=<?php echo $sql_sel_ajustes_dados['ajustes_id']; ?>" ><img width="25" src="../../layout/images/del.png"></a></td>
			</tr>
		</tbody>
				<?php }
				}
			?>
	</table>
</fieldset>
