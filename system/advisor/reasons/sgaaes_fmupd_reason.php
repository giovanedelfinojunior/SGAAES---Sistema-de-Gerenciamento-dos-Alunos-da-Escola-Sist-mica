<?php
/*Recebendo o ID do motivo via GET*/
$g_id = $_GET['id'];
/*-----*/
/*Transformando os dados recebidos do banco em array para preencher o formulário com os dados que estão cadastrados no banco de dados.*/
$sql_sel_motivos = "SELECT motivo,descricao FROM motivos where id = $g_id";
$sql_sel_motivos_resultado = $conexao->query($sql_sel_motivos);
$sql_sel_motivos_dados = $sql_sel_motivos_resultado->fetch_array();
/*-----*/
?>
<fieldset style="width: 313px; ">
  <legend>Alteração de Motivo</legend>
  <form name='frm_upd_reason' method='post' action='?folder=reasons&file=sgaaes_upd_reason&ext=php'>
<!--Preenchendo um input hidden com o id do motivo que será enviado via POST para a página de Update -->
      <input type="hidden" name="hidid" value="<?php echo $g_id;?>">
<!------->
      <h4>OBS: Os campos que possuem asterisco são obrigatórios!</h4>

      <p>*Motivo: <input name='txtmotivo' value = '<?php echo $sql_sel_motivos_dados['motivo']; ?>' placeholder='' maxlength='45' type='text'></p>
      <p>Descrição: <textarea name='txadescricao' cols='40' rows='4'><?php echo $sql_sel_motivos_dados['descricao'];?></textarea></p>
<!------->
      <span id='button'>
        <a href="?folder=reasons&file=sgaaes_fmins_reason&ext=php"><button type='button'>Retornar</button></a></button>
        <button type='submit'>Alterar</button>
      </span>
  </form>
</fieldset>
