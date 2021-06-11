<script type="text/javascript">
	//aviso de solicitar ajuste, quando o orientadores não tiver a permissão para enviar para o aluno;
	function solicitar(){

		alert('Para solicitar o ajuste é necessário ter a permissão da mesma turma!')

	}
	//fim aviso de solicitar ajuste
	//INICIO MODAL
	$(document).ready(function() {

		$('a[name=modal]').click(function(e) {
			e.preventDefault();

			var id = $(this).attr('href');
			//id = .estrutura
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();

			$('.telafundo').css({'width':maskWidth,'height':maskHeight});
			//efeitos modal;
			$('.telafundo').fadeIn(120);
			$('.telafundo').fadeTo("slow",0.8);
			//fim efeitos modal;

			var winH = $(window).height();
			var winW = $(window).width();

			$(id).css('top',  winH/2-$(id).height()/2);
			$(id).css('left', winW/2-$(id).width()/2);

			$(id).fadeIn(300);

		});
		//fechamento da modal;
		$('.janela .fecharcaixaimg').click(function (e) {
			e.preventDefault();

			$('.telafundo').hide();
			$('.janela').hide();
		});
		//fim fechamento da modal;

		$('.telafundo').click(function () {
			$(this).hide();
			$('.janela').hide();
		});

	});
	//FIM MODAL
</script>
<fieldset style="min-width: 80%;margin-bottom: 10px;"><!--especificando tamanho do fieldset-->
<legend>Gestão de Turma</legend>
<?php
	$condicao = "";

	if((isset($_POST["selturma"]))&&(isset($_POST["txtnomeepi"]))){//se o formulário de filtro foi enviado;
		//recebendo dados
		$p_idturma = $_POST['selturma'];
		$p_nomeepi = $_POST['txtnomeepi'];
		if(($p_idturma <> "")||($p_nomeepi <> "")){//se um dos dados não estiver vazio;
			if(($p_idturma <> "")&&($p_nomeepi == "")){//se a turma foi selecionada e o campo nome ficou vazio;
				$condicao .= "WHERE turmas_id='".$p_idturma."'";
			}else if(($p_nomeepi <> "")&&($p_idturma == "")){//se o campo nome foi  preenchido e nenhua turma foi selecionada;

				$condicao .= "WHERE nome_aluno LIKE '%".addslashes($p_nomeepi)."%' OR epiteto LIKE '%".addslashes($p_nomeepi)."%'";

			}else{//se todos os campos foram selecionados

				$condicao .= "WHERE turmas_id='".$p_idturma."' AND (nome_aluno LIKE '%".addslashes($p_nomeepi)."%' OR epiteto LIKE '%".addslashes($p_nomeepi)."%')";

			}
		}
	}else{//se o formulário nã foi enviado!
		$p_idturma = "";
		$p_nomeepi = "";
	}

	$sql_sel_turmas = "SELECT * FROM turmas ORDER BY nome_turma ASC";
	$sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);

	if($sql_sel_turmas_resultado->num_rows == 0){//se nenhuma turma está registrada
?>
		<center><h4>Nenhuma turma registrada!</h4></center>
<?php
	}else{//senao
?>		<center>
		<div class="telafundo"></div> <!-- MASK PARA MODAL -->
		<form name="frmfiltro" method="POST" action="?folder=managements&file=sgaaes_class_management&ext=php" style="margin-top: 10px">
		Turma:<select name="selturma">
			<option value="">Todas</option>
			<?php
				while($sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array()){//enquanto receber dados;
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

		            //manter a turma que foi filtrada selecionada;
					$opc_selecionada = "";

					if($sql_sel_turmas_dados['id'] == $p_idturma){

						$opc_selecionada = "selected";

					}
			?>
					<option value="<?php echo $sql_sel_turmas_dados['id'] ?>" <?php echo $opc_selecionada; ?>><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo ?></option>
			<?php

				}

			 ?>
		  </select>
		Nome ou Epiteto:<input type="text" name="txtnomeepi" id="alunoepiteto" placeHolder = "Nome ou Epiteto" maxlength="45" value="<?php echo $p_nomeepi; ?>"></input>
		<button type="submit" value="enviar">Filtrar</button>
		</form>
		<p>
		</center>
		<table border="1" width="95%">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Epíteto</th>
					<th>E-mail</th>
					<th>Outras Informações</th>
					<th>Ajuste de Ponto</th>
					<th>Alterar</th>
					<th>Excluir</th>
				</tr>
			</thead>
			<tbody>
				<?php

					$sql_sel_alunos = "SELECT * FROM alunos ".$condicao." ORDER BY nome_aluno ASC";
					$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);

					if($sql_sel_alunos_resultado->num_rows == 0){

				?>
				<tr>
					<td colspan="10">Nenhum aluno registrado!</td>
				</tr>
				<?php

					}else{
						while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){
							$display_img = "";
							$lupafoto='<a href=".estrutura'.$sql_sel_alunos_dados['id'].'" name="modal"><img src="../../layout/images/lupa_icon.png"></a>';
							if(!file_exists('../../layout/images/upload_images/'.$sql_sel_alunos_dados['foto'])){//se o aluno tiver uma foto;

								$display_img = "style='display: none;'";//faz com que a foto não apareça;
								$foto='perfilIcon.png';

							}else{//senão;

								$foto='upload_images/'.$sql_sel_alunos_dados["foto"].'';

							}

				?>
				<tr>
					<td width="30%" align="left"><?php echo $sql_sel_alunos_dados['nome_aluno']; ?></td>
					<td width="10%" align="left"><?php echo $sql_sel_alunos_dados['epiteto']; ?></td>
					<td width="30%" align="left"><?php echo $sql_sel_alunos_dados['email']; ?></td>
						<?php

							$sql_sel_anotacoes ="SELECT anotacoes.id,
													anotacoes.classificacao,
													alunos.id
										FROM alunos
										INNER JOIN alunos_has_anotacoes ON(alunos.id=alunos_has_anotacoes.alunos_id)
										INNER JOIN anotacoes ON(alunos_has_anotacoes.anotacoes_id = anotacoes.id)
										WHERE alunos_id = '".$sql_sel_alunos_dados['id']."'
										ORDER BY anotacoes.data_anotacao ASC";
							$sql_sel_anotacoes_resultado = $conexao->query ($sql_sel_anotacoes);

							if($sql_sel_anotacoes_resultado->num_rows == 0){//Se não há nenhuma anotação;

								$anotacoes = "Nenhuma Anotação";

							}else{//senão;

								$positivas = 0;
								$negativas = 0;
								$neutras = 0;

								while($sql_sel_anotacoes_dados = $sql_sel_anotacoes_resultado->fetch_array()){
									if($sql_sel_anotacoes_dados['classificacao'] == "pos"){

										$positivas = $positivas + 1;

									}else if($sql_sel_anotacoes_dados['classificacao'] == "neg"){

										$negativas = $negativas + 1;

											}else{

												$neutras = $neutras + 1;

											}

								}

								$total = $positivas + $negativas + $neutras;

								$anotacoes = "
												ANOTAÇÕES<br />
												Positivas:  	".$positivas."<br />
												Negativas:   ".$negativas."<br />
												Neutras:   ".$neutras."<br />
												Total:  ".$total."
											";

							}
						?>
								<td><?php echo $lupafoto; ?></td>
								<!-- INICIO MODAL -->
								<div class="caixaimg">
									<div class="estrutura<?php echo $sql_sel_alunos_dados['id']; ?> janela"  style="color: #FFFFFF;">
										<a href="#" class="fecharcaixaimg">Fechar [X]</a>
										<img <?php echo $display_img; ?> width="100%" height="80%" border="2px solid black" src="../../layout/images/<?php echo $foto; ?>">
										<br />
										<center>
											<h3><?php echo $anotacoes; ?></h3>
										</center>
									</div>
								</div>
								<!-- FIM MODAL -->
					<?php


					$sql_sel_orientadores = "SELECT id
												FROM orientadores
												INNER JOIN orientadores_has_turmas ON(orientadores_has_turmas.orientadores_id = orientadores.id)
												WHERE orientadores.usuarios_id='".$_SESSION['idusuario']."' AND turmas_id='".$sql_sel_alunos_dados['turmas_id']."'";
						$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);

						if($sql_sel_orientadores_resultado->num_rows > 0){//se o orientador é da mesma turma que o aluno;

							$caminho = "href='?folder=requests_point&file=sgaaes_fmins_requestpoint&ext=php&id=".$sql_sel_alunos_dados['id']."'";
							$onclick = "";

						}else{//senao;

							$caminho = "";
							$onclick = "onClick='return solicitar()'";//aviso de que não tem permissão para enviar o ajuste para esse aluno;

						}
					?>
					<td width="10%"><a <?php echo $caminho; ?> <?php echo $onclick; ?>><button>Solicitar</button></a></td>
					<td width="10%"><a href="?folder=students&file=sgaaes_fmupd_student&ext=php&id=<?php echo $sql_sel_alunos_dados['id']; ?>"title="Alterar registro"><img src="../../layout/images/edit.png"></a></td>
					<td width="10%"><a onClick="return deletar('aluno','<?php echo $sql_sel_alunos_dados['nome_aluno'] ?>')" href="?folder=students&file=sgaaes_del_student&ext=php&id=<?php echo $sql_sel_alunos_dados['id']; ?>" title="Excluir registro"><img src="../../layout/images/delete.png"></a></td>
				</tr>
				<?php

						}
					}

				?>
			</tbody>
			</table>
	<?php
		}
	?>
</fieldset>
