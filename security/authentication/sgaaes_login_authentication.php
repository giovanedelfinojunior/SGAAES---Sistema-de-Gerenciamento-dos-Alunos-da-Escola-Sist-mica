<?php
  $msg = "";
  $p_usuario = $_POST['txtusuario'];
  $p_senha = $_POST['pwdsenha'];

  $hash_senha = md5($salt.$p_senha);

  $msg = "";

  if($p_usuario==""){
    $msg = "O campo usuário não foi preenchido!";
  }else if($p_senha ==""){
    $msg = "O campo senha não foi preenchido!";
  }else{
    $sql_sel_usuarios = "SELECT id,login,senha,permissao FROM usuarios where login='".addslashes($p_usuario)."' AND senha='".$hash_senha."'";
    $sql_sel_usuarios_resultado = $conexao->query($sql_sel_usuarios);
    if ($sql_sel_usuarios_resultado->num_rows >0){
      /* ~~ Transforma o resultado em arrays ~~ */
      $sql_sel_usuarios_dados = $sql_sel_usuarios_resultado->fetch_array();
      /* ~~ Inicia uma Sessão ~~ */
      session_start();
      $_SESSION['idusuario'] = $sql_sel_usuarios_dados['id'];
      //armazenando o usuário para sabermos quem está autenticado
      $_SESSION['usuarios'] = $sql_sel_usuarios_dados['login'];
      //armazenando a permissao para sabermos o que ele pode acessa
      $_SESSION['permissao'] = $sql_sel_usuarios_dados['permissao'];
      //armazenando o id da sessão para futura implementação de segurança
      $_SESSION['idSessao'] = session_id();
      if($_SESSION['permissao']==0){
        header("Location: system/advisor/back_end_advisor.php");
      }else if($_SESSION['permissao']==1){
        header("Location: system/student/back_end_student.php");
      }else{
        $msg = "Permissão de usuário inválida.";
      }
    }else{
        $msg = "Dados incorretos";
      }
  }
 ?>

<div id="mensagens">
  Aviso
  <img src="layout/images/warning.png">
  <p><?php echo $msg;  ?></p>
</div>
<a href="?" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
