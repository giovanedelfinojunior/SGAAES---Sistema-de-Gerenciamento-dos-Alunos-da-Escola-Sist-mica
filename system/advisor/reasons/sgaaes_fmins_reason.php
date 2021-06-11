<fieldset style="width: 313px; ">
  <legend>Registro de Motivo</legend>
  <form name='frm_ins_reason' method='post' action='?folder=reasons&file=sgaaes_ins_reason&ext=php'>
      <h4>OBS: Os campos que possuem asterisco são obrigatórios!</h4>
      <p>*Motivo: <input name='txtmotivo' placeholder='' maxlength='45' type='text'></p>
      <p>Descrição: <textarea name='txadescricao' cols='40' rows='4'></textarea></p>
      <span id='button'>  <button type='reset'>Limpar</button><button type='submit'>Registrar</button></span>
  </form>
</fieldset>
<?php
  $sql_sel_motivos = "SELECT id,motivo,descricao FROM motivos ";
  $sql_sel_motivos_resultado = $conexao->query($sql_sel_motivos);
 ?>
<fieldset style="width: 350px; margin-top:20px; margin-bottom: 10px">
  <legend>Motivos Registrados</legend>
<table border="1">
  <thead>
    <tr>
      <th>Motivo</th>
      <th>Descrição</th>
      <th>Alterar</th>
      <th>Excluir</th>
    </tr>
  </thead>
<tboddy>
<?php
  if($sql_sel_motivos_resultado->num_rows==0){
    echo "<tr><td colspan='4'>Nenhum registro.</td></tr>";

  } else{
    while($sql_sel_motivos_dados = $sql_sel_motivos_resultado->fetch_array()){
?>
      <tr>
      <td><?php echo htmlentities($sql_sel_motivos_dados['motivo'], ENT_QUOTES); ?></td>
      <td><?php echo htmlentities($sql_sel_motivos_dados['descricao'],ENT_QUOTES);?></td>
      <td><a href='?folder=reasons&file=sgaaes_fmupd_reason&ext=php&id=<?php echo $sql_sel_motivos_dados['id']; ?>'><img src="../../layout/images/edit.png"></a></td>
      <td><a onClick="return deletar('motivo','<?php echo $sql_sel_motivos_dados['motivo'] ?>')" href='?folder=reasons&file=sgaaes_del_reason&ext=php&id=<?php echo $sql_sel_motivos_dados['id']; ?>'><img src="../../layout/images/delete.png"></a></td>
    </tr>
<?php }
}?>
  </tboddy>
</table>
</fieldset>
