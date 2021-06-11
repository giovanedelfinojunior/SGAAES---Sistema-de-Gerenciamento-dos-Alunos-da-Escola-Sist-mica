<script src = "../../addons/plugins/Chart.js"></script>
<?php
$_SESSION['pagina']='';
$_SESSION['pagina']['titulo']='<h2>Relatório de Motivos</h2>';
/*--Função que gera uma cor aleatória para os motivos--*/
function cor() {
    $hexa = '0123456789ABCDEF';
    $color = '#';
    for($i = 0; $i < 6; $i++) {
        $index = rand(0,15);
        $color .= $hexa[$index];
    }
    return $color;
}
/*-----------FIM FUNÇÃO DE COR-----------------*/

/*--Declarando variávelis e Recebendo dados do formulario para usar no Filtro--*/
$condicao='';
$condicao_data_tabela = '';
$condicao1 = '';
$condicao2 = '';
$condicao3 = '';
$de = '';
$ate = '';
/*-----------FIM DECLARACÃO DE VARIAVEIS DO FILTRO------------------*/


/*--Verificando se usuário enviou formulario de fiotro(Campo de Turma) --*/
if ((isset($_POST['txtde'])) && (isset($_POST['txtate'])) || (isset($_POST['selturma']))){
/*-----------------------*/

/*--Verificando se o campo está vazio e adicionando os sqls do filtro nas variávelis de condiao--*/
  $p_turma = $_POST['selturma'];
  if ($p_turma <> '') {
     $condicao1 = ',alunos_id AS alunos,turmas.id AS turmas';
     $condicao2 = 'INNER JOIN alunos ON (ajustes_de_ponto.alunos_id = alunos.id) INNER JOIN turmas ON (alunos.turmas_id = turmas.id)';
     $condicao3 = 'AND turmas_id ="'.$p_turma.'"';
  }else {
    $condicao1 = '';
    $condicao2 = '';
    $condicao3 = '';
  }

  /*-----------FIM DADOS FILTRO DE TURMA-------------*/


/*--Verificando se usuário enviou formulario de fiotro(Campos de Data) --*/
$p_de = $_POST['txtde'];
$p_ate =  $_POST['txtate'];
echo $p_de;
/*--Verificando se o campo está vazio e adicionando os sqls do filtro nas variávelis de condiao--*/
if (($p_de<>'') && ($p_ate <> '')){

echo $condicao = "AND data_ajuste BETWEEN '$p_de' AND '$p_ate'";
echo $condicao_data_tabela = "WHERE data_ajuste BETWEEN '$p_de' AND '$p_ate'";

$and_where = 'AND';
}else{
$condicao = '';
$and_where = 'WHERE';
}
}else{
  $and_where = 'WHERE';
  $p_turma='';
  $p_de ='';
  $p_ate='';
}
/*------------FIM DADOS FILTRO POR DATA-----------------*/

/*--Declarando Variáveis--*/
$am=0;
$ct =0;
$ft =0;
$sa =0;
$saida_antecipada=0;
$chegada_tardia=0;
$falta=0;
$contador = 0;
$data_count=0;
$validacao_motivos_act = 0;
$validacao_motivos_asa = 0;
$validacao_motivos_aft = 0;
/*-----------FIM DECLARAÇÃO-----------*/

/*Formulario do filtro de busca*/
$sql_sel_turmas = "SELECT * FROM turmas";
$sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);
echo "<fieldset style='width:80%;margin-bottom: 10px;'>
  <form method='post' action='?folder=reports&file=sgaaes_reason_report&ext=php'>
    <table class='ftable'>
      <tr>
        <td>Turma: <select name='selturma'>
                      <option value=''>Todas</option>";
                       while ($sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array()){

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

                        $opc_selecionada = "";
                        if($sql_sel_turmas_dados['id']==$p_turma){
                          $opc_selecionada = "selected";
                        }
                      echo "<option value='".$sql_sel_turmas_dados['id']."' ".$opc_selecionada." > ".$sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo." </option>";
                     }

                    echo" </select>
        </td>
        <td style='text-align:right;'>
            Data:<input type='date' name='txtde' value='".$p_de."'>
        </td>
        <td></td>
          <td>
            <button type='submit'>Filtrar</button>
          </td>
      </tr>
      <tr>
        <td></td>
        <td>
            Até
        </td>
      </tr>
      <tr>
        <td>
        </td >
        <td style='text-align:right;'>
          <input type='date' name='txtate' value='".$p_ate."'>
        </td>
      </tr>
    </table>
  </form>
  <legend>Relatório de Motivos</legend>
";
/*-----------FIM FILTRO DE BUSCA---------------*/
$_SESSION['pagina']['conteudo']="
<table border='1' width='50%'>
<thead>
<tr>
  <th>Motivo</th>
  <th>Chegada Tardia <div style = 'display:-webkit-inline-box; width:10px; height:10px; background-color:rgba(150,150,220,1); '></div></th>
  <th>Saída Antecipada <div style = 'display:-webkit-inline-box; width:10px; height:10px; background-color:rgba(220,150,150,1); '></div></th>
  <th>Faltas <div style = 'display:-webkit-inline-box; width:10px; height:10px; background-color:rgba(150,220,150,1)'></div></th>
</tr>
</thead>
    <tbody>";



/*--Selecionando Dados Do banco da tabela de ajuste de ponto--*/
$sql_sel_ajuste_am = "SELECT motivos.motivo, COUNT(ajustes_de_ponto.id) AS aam $condicao1 FROM ajustes_de_ponto $condicao2 RIGHT JOIN motivos ON (ajustes_de_ponto.motivos_id=motivos.id AND ajustes_de_ponto.tipo='am' AND status_ajuste ='a' $condicao3 $condicao)  GROUP BY motivos.id ";
$sql_sel_ajuste_am_resutado = $conexao->query($sql_sel_ajuste_am);
$sql_sel_ajuste_ct = "SELECT motivos.motivo, COUNT(ajustes_de_ponto.id) AS act $condicao1 FROM ajustes_de_ponto $condicao2 RIGHT JOIN motivos ON (ajustes_de_ponto.motivos_id=motivos.id AND ajustes_de_ponto.tipo='ct' AND status_ajuste ='a' $condicao3 $condicao)  GROUP BY motivos.id ";
$sql_sel_ajuste_ct_resutado = $conexao->query($sql_sel_ajuste_ct);
$sql_sel_ajuste_ft = "SELECT motivos.motivo, COUNT(ajustes_de_ponto.id) AS aft $condicao1 FROM  ajustes_de_ponto $condicao2 RIGHT JOIN motivos ON (ajustes_de_ponto.motivos_id=motivos.id AND ajustes_de_ponto.tipo='ft' AND status_ajuste ='a' $condicao3 $condicao ) GROUP BY motivos.id ";
$sql_sel_ajuste_ft_resultado = $conexao->query($sql_sel_ajuste_ft);
$sql_sel_ajuste_sa = "SELECT motivos.motivo, COUNT(ajustes_de_ponto.id) AS asa $condicao1 FROM  ajustes_de_ponto $condicao2 RIGHT JOIN motivos ON (ajustes_de_ponto.motivos_id=motivos.id AND ajustes_de_ponto.tipo='sa' AND status_ajuste ='a' $condicao3 $condicao) GROUP BY motivos.id ";
$sql_sel_ajuste_sa_resultado = $conexao->query($sql_sel_ajuste_sa);
/*---------FIM SELECTS E QUERYs DE AJUSTE DE PONTO-------------*/



/*--While que vai repetir enquanto ainda tiverem os dados que foram selecionados preenchendo a tabela de acordo com os motivos--*/
 while(
($sql_sel_ajuste_ct_dados = $sql_sel_ajuste_ct_resutado->fetch_array()) AND
($sql_sel_ajuste_ft_dados = $sql_sel_ajuste_ft_resultado->fetch_array()) AND
($sql_sel_ajuste_sa_dados = $sql_sel_ajuste_sa_resultado->fetch_array()) AND
($sql_sel_ajuste_am_dados = $sql_sel_ajuste_am_resutado->fetch_array())) {

//Carregando variávelis Auxiliares utilizadas nos graficos -- Cor e Valores.
  $corgrafico = cor();
  $contador = $contador+1;

  $grafico[$contador] = $corgrafico;

  $sql_sel_ajuste_ct_dados['act'] += $sql_sel_ajuste_am_dados['aam'];
  $sql_sel_ajuste_sa_dados['asa'] += $sql_sel_ajuste_am_dados['aam'];

  $qtd_motivos_act[$contador] = $sql_sel_ajuste_ct_dados['act'];
  $qtd_motivos_asa[$contador] = $sql_sel_ajuste_sa_dados['asa'];
  $qtd_motivos_aft[$contador] = $sql_sel_ajuste_ft_dados['aft'];

  $motivos[$contador] = $sql_sel_ajuste_ct_dados['motivo'];



  if ($qtd_motivos_aft[$contador] != 0){$validacao_motivos_aft +=1; }
  if ($qtd_motivos_asa[$contador] != 0){$validacao_motivos_asa +=1 ;}
  if ($qtd_motivos_act[$contador] != 0){$validacao_motivos_act +=1 ;}

//----------------FIM variávelIS AUXILIARES------------------//

//Preenchendo a tabela com os dados da consulta no banco
    $_SESSION['pagina']['conteudo'].= "
    <tr>
        <td>".htmlentities($sql_sel_ajuste_ct_dados['motivo'], ENT_QUOTES)." <div style = 'display:-webkit-inline-box; width:10px; height:10px; background-color: ".$corgrafico.";'></div></td>
        <td>".$sql_sel_ajuste_ct_dados['act'] ."</td>
        <td>".$sql_sel_ajuste_sa_dados['asa'] ."</td>
        <td>".$sql_sel_ajuste_ft_dados['aft'] ."</td>
    </tr>";
//----------------------------------//

}/*------------Fim do While-------------*/



/*--Select que seleciona os tipos por motivo de acordo com os tipos, para poder gerar o total dos ajustes por tipo--*/
$sql_sel_total_ajustes_de_ponto = "SELECT tipo, count(*) AS qtd $condicao1 FROM ajustes_de_ponto $condicao2 $condicao_data_tabela $and_where status_ajuste ='a' $condicao3 GROUP BY tipo";
$sql_sel_total_ajustes_de_ponto_resutado = $conexao->query($sql_sel_total_ajustes_de_ponto);

while ($sql_sel_total_ajustes_de_ponto_dados = $sql_sel_total_ajustes_de_ponto_resutado->fetch_array()) {
if ($sql_sel_total_ajustes_de_ponto_dados['tipo'] == 'ct'){
$ct = $sql_sel_total_ajustes_de_ponto_dados['qtd'];
  }else if($sql_sel_total_ajustes_de_ponto_dados['tipo'] == 'sa'){
    $sa = $sql_sel_total_ajustes_de_ponto_dados['qtd'];
  }else if($sql_sel_total_ajustes_de_ponto_dados['tipo'] == 'ft') {
    $ft = $sql_sel_total_ajustes_de_ponto_dados['qtd'];
  }else if($sql_sel_total_ajustes_de_ponto_dados['tipo'] == 'am') {
        $am = $sql_sel_total_ajustes_de_ponto_dados['qtd'];
    }else{
    $_SESSION['pagina']['conteudo'].="";
  }
}
$ct +=$am;
$sa +=$am;
/*---------------------FIM CONTEUDO DE TOTAIS----------------------*/

/*Preenche linha com os totais de ajustes*/
    $_SESSION['pagina']['conteudo'].= " <tr>
          <th>TOTAL:</th>
          <td>".$ct."</td>
          <td>".$sa."</td>
          <td>".$ft."</td>
      </tr>
    </tbody>
  </table>";
/*-------------FIM LINHA TOTAIS DE AJUSTE-----------------*/

/*Selects e querys referentes as datas dos ajustes, são utilizados apenas para o grafico de linha */
$sql_sel_ajuste_data_ct = "SELECT MONTH(data_ajuste) AS mes ,COUNT(tipo) AS qtd $condicao1 FROM ajustes_de_ponto $condicao2 WHERE (tipo ='am' AND status_ajuste ='a' $condicao ) $condicao3 GROUP BY MONTH(data_ajuste) UNION SELECT MONTH(data_ajuste) AS mes ,COUNT(tipo) AS qtd $condicao1 FROM ajustes_de_ponto $condicao2 WHERE  (tipo ='ct' AND status_ajuste ='a' $condicao) $condicao3 GROUP BY MONTH(data_ajuste)";
$sql_sel_ajuste_data_ft = "SELECT  MONTH(data_ajuste) AS mes ,COUNT(tipo) AS qtd $condicao1 FROM ajustes_de_ponto $condicao2 WHERE (tipo ='ft' AND status_ajuste ='a' $condicao ) $condicao3  GROUP BY MONTH(data_ajuste) ";
 $sql_sel_ajuste_data_sa = "SELECT MONTH(data_ajuste) AS mes ,COUNT(tipo) AS qtd $condicao1 FROM ajustes_de_ponto $condicao2 WHERE (tipo ='am' AND status_ajuste ='a' $condicao ) $condicao3 GROUP BY MONTH(data_ajuste) UNION SELECT  MONTH(data_ajuste) AS mes ,COUNT(tipo) AS qtd $condicao1 FROM ajustes_de_ponto  $condicao2 WHERE (tipo ='sa' AND status_ajuste ='a' $condicao ) $condicao3 GROUP BY MONTH(data_ajuste)";


$sql_sel_ajuste_data_resultado_ct = $conexao ->query($sql_sel_ajuste_data_ct);
$sql_sel_ajuste_data_resultado_sa = $conexao ->query($sql_sel_ajuste_data_sa);
$sql_sel_ajuste_data_resultado_ft = $conexao ->query($sql_sel_ajuste_data_ft);

/*-----------FIM SELECTS E QUERYS-------------*/


/*--------------IMPLEMENTAR Nos Testes--------------
for($i=1; $i<=12;$i++){
$datasct[$i] = 0;
$datassa[$i] = 0;
}
--------------IMPLEMENTAR Nos Testes--------------*/



/*Adicionando conteudo recebido do banco pelos selects para preencher as variávelis que serão utilizadas no grafico de linhas */
$datasct = array('1' => 0,'2' => 0,'3' => 0,'4' => 0,'5' => 0,'6' => 0,'7' => 0,'8' => 0,'9' => 0,'10' => 0,'11' => 0,'12' => 0 );
while($sql_sel_ajuste_data_dados_ct = $sql_sel_ajuste_data_resultado_ct->fetch_array()) {
$recebedata= $sql_sel_ajuste_data_dados_ct['mes'];
$datasct[$recebedata] = $sql_sel_ajuste_data_dados_ct['qtd'];
}

$datassa = array('1' => 0,'2' => 0,'3' => 0,'4' => 0,'5' => 0,'6' => 0,'7' => 0,'8' => 0,'9' => 0,'10' => 0,'11' => 0,'12' => 0 );
while($sql_sel_ajuste_data_dados_sa = $sql_sel_ajuste_data_resultado_sa->fetch_array()) {
$recebedatasa= $sql_sel_ajuste_data_dados_sa['mes'];
$datassa[$recebedatasa] = $sql_sel_ajuste_data_dados_sa['qtd'];
}

$datasft = array('1' => 0,'2' => 0,'3' => 0,'4' => 0,'5' => 0,'6' => 0,'7' => 0,'8' => 0,'9' => 0,'10' => 0,'11' => 0,'12' => 0 );
while($sql_sel_ajuste_data_dados_ft = $sql_sel_ajuste_data_resultado_ft->fetch_array()) {
$recebedataft= $sql_sel_ajuste_data_dados_ft['mes'];
$datasft[$recebedataft] = $sql_sel_ajuste_data_dados_ft['qtd'];
}



/*------------------FIM DADOS DE GRAFICO DE LINHAS--------------------*/

/*Canvas que vai receber/mostrar os graficos*/
$_SESSION['pagina']['conteudo'].= "<table width='100%'>
  <tr>
    <td>
      <div class='canvas-holder' style='width:400px; height:200px;'>
        <h3>Índice de Frequência</h3>
        <canvas id = 'chart-area_ftg' width='350px' height='150px'/>
      </div>
    </td>";

if($validacao_motivos_act != 0){
$verificar_Grafico_Chegada_Tardia = TRUE;
  $_SESSION['pagina']['conteudo'].=" <td>
          <div class='canvas-holder' style='width:200px;height:200px;'>
              <h3>Chegada Tardia</h3>
              <canvas id='chart-area' width='150' height='150'/>
            </div>

        </td></tr>";
 }else{
   $verificar_Grafico_Chegada_Tardia = FALSE;
   $_SESSION['pagina']['conteudo'].= "<td><h3>Chegada Tardia</h3><h3>Nenhum Registro!</h3></td></tr>";
 }

 if ($validacao_motivos_asa != 0){
      $verificar_Grafico_Saida_Antecipada = TRUE;
   $_SESSION['pagina']['conteudo'].="<tr>
       <td>
         <div class='canvas-holder' style='width:200px;height:200px;'>
           <h3>Saida Antecipada</h3>
           <canvas id='chart-area_sa' width='150' height='150'/>
         </div>
       </td>";


 }else{
   $_SESSION['pagina']['conteudo'].= "<td><h3>Saida Antecipada</h3><h3>Nenhum Registro</h3></td>";
   $verificar_Grafico_Saida_Antecipada = FALSE;
 }

if($validacao_motivos_aft != 0){
  $verificar_Grafico_Falta = TRUE;
  $_SESSION['pagina']['conteudo'].="<td>
    <div class='canvas-holder' style='width:200px;height:200px;'>
      <h3>Falta</h3>
      <canvas id='chart-area_ft' width='150' height='150'/>
    </div>
  </td></tr>";
}else{
  $verificar_Grafico_Falta = FALSE;
   $_SESSION['pagina']['conteudo'].= "<td><h3>Falta</h3><h3>Nenhum Registro!</h3></td>";
}

/*------------------FIM CANVAS-------------------*/

$_SESSION['pagina']['conteudo'].= "</table>
<script>
  var grafico_ct = [
    ";
/*--Preenchendo graficos pizza com a ajuda das variaveis auxiliares--*/
 $contador +=1;
 for($i=1; $i< $contador; $i++ ){

      $_SESSION['pagina']['conteudo'].= " {

        value: '".$qtd_motivos_act[$i]."',
        color:'".$grafico[$i]."',
        highlight: '".$grafico[$i]."',
        label: '".$motivos[$i]."'
      },
      ";
 }

$_SESSION['pagina']['conteudo'].= "  ];
var grafico_sa = [
";
 for($i=1; $i< $contador; $i++ ){
$_SESSION['pagina']['conteudo'].= "
      {
        value: '".$qtd_motivos_asa[$i]."',
        color: '".$grafico[$i]."',
        highlight: '".$grafico[$i]."',
        label: '".$motivos[$i]."'

      },
      ";
    }

$_SESSION['pagina']['conteudo'].= "  ];

  var grafico_ft = [
    ";
   for($i=1; $i< $contador; $i++ ){

    $_SESSION['pagina']['conteudo'].=" {
          value: '".$qtd_motivos_aft[$i]."',
          color:'".$grafico[$i]."',
          highlight: '".$grafico[$i]."',
          label: '". $motivos[$i]."'

        },";
  }

/*-------------FIM Graficos Pizzas------------*/

/*--Preenchendo Grafico de Linhas--*/
$_SESSION['pagina']['conteudo'].="
    ];
    var faltageral = {
    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],

    datasets: [
        {

              label: 'Chegada Tardia',
              fillColor: 'rgba(150,150,220,0.2)',
              strokeColor: 'rgba(150,150,220,1)',
              pointColor: 'rgba(150,150,220,1)',
              pointStrokeColor: '#fff',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(150,150,220,1)',/*?????*/


              data: [ " ; for($i=1; $i<12; $i++){
                            if($i < 12){

                                $_SESSION['pagina']['conteudo'].= $datasct[$i] .",";
                              }
                            } $_SESSION['pagina']['conteudo'].= $datasct[12]."]";




    $_SESSION['pagina']['conteudo'].= "  },

        {
          label: 'Saida Antecipada',
          fillColor: 'rgba(220,150,150,0.2)',
          strokeColor: 'rgba(220,150,150,1)',
          pointColor: 'rgba(220,150,150,1)',
          pointStrokeColor: '#fff',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,150,150,1)',/*?????*/
          data: [";
                  for($i=1; $i<12; $i++){
                    if($i < 12){
                      $_SESSION['pagina']['conteudo'].= $datassa[$i]." ,";
                    }
                  }$_SESSION['pagina']['conteudo'].= $datassa[12]. "]";


      $_SESSION['pagina']['conteudo'].= "   },
        {



            label: 'Falta',
            fillColor: 'rgba(150,220,150,0.2)',
            strokeColor: 'rgba(150,220,150,1)',
            pointColor: 'rgba(150,220,150,1)',
            pointStrokeColor: '#fff',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(150,220,150,1)',/*?????*/
            data: [ ";
                  for($i=1; $i<12; $i++){
                    if($i < 12){
                      $_SESSION['pagina']['conteudo'].= $datasft[$i]. ",";
                    }
                  }$_SESSION['pagina']['conteudo'].= $datasft[12]. "]";

/*---------------------FIM GRAFICOS DE LINHA---------------------*/

/*--Pegando dados preenchidos nos graficos e enviando para serem exibidos no Canvas--*/

//--Transformando Graficos em imagem e gerando legenda para serem enviados para o formulário que serão ultilizados no PDF--//
$_SESSION['pagina']['conteudo'].="        }
    ]
}

  window.onload = function(){
  var ctx_ftg = document.getElementById('chart-area_ftg').getContext('2d');
  window.myLineChart = new Chart(ctx_ftg).Line(faltageral);
  var myLineChart = new Chart(ctx_ftg).Line(faltageral,{ animationEasing: 'easeOutQuart',legendTemplate : '<% for (var i=0; i<datasets.length; i++){%><%if(datasets[i].label){%> <div><span style=\"border:2px solid white; background-color:<%=datasets[i].strokeColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><%=datasets[i].label%></div><%}%><%}%>',
     onAnimationComplete: function(){
        $('#chart-image-faltageral').val(myLineChart.toBase64Image());}});
        $('#legend_ftg').val(myLineChart.generateLegend());

";

  if($verificar_Grafico_Chegada_Tardia){
    $_SESSION['pagina']['conteudo'].= "

      var ctx = document.getElementById('chart-area').getContext('2d');

      var myPieChart = new Chart(ctx).Pie(grafico_ct,{animationEasing: 'easeOutQuart',legendTemplate : '<% for (var i=0; i<segments.length; i++){%><%if(segments[i].label){%><div><span style=\"border:2px solid white;background-color:<%=segments[i].fillColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <%=segments[i].label%> (<%=segments[i].value%>)</div> <%}%><%}%>',
         onAnimationComplete: function(){
            $('#chart-image').val(myPieChart.toBase64Image());}});
            $('#legend_ct').val(myPieChart.generateLegend());

";

  }


  if($verificar_Grafico_Saida_Antecipada){
    $_SESSION['pagina']['conteudo'].= "
    var ctx_sa = document.getElementById('chart-area_sa').getContext('2d');
    window.myPie = new Chart(ctx_sa).Pie(grafico_sa);
    var myPie = new Chart(ctx_sa).Pie(grafico_sa,{animationEasing: 'easeOutQuart',legendTemplate : '<% for (var i=0; i<segments.length; i++){%><%if(segments[i].label){%><div><span style=\"border:2px solid white;background-color:<%=segments[i].fillColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <%=segments[i].label%> (<%=segments[i].value%>)</div> <%}%><%}%>',
       onAnimationComplete: function(){
          $('#chart-image-sa').val(myPie.toBase64Image());}});
          $('#legend_sa').val(myPie.generateLegend());
    ";

  }

  if ($verificar_Grafico_Falta) {
    $_SESSION['pagina']['conteudo'].= "
      var ctx_ft = document.getElementById('chart-area_ft').getContext('2d');

        window.myPies = new Chart(ctx_ft).Pie(grafico_ft);
        var myPies = new Chart(ctx_ft).Pie(grafico_ft,{animationEasing: 'easeOutQuart',legendTemplate : '<% for (var i=0; i<segments.length; i++){%><%if(segments[i].label){%><div><span style=\"border:2px solid white;background-color:<%=segments[i].fillColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <%=segments[i].label%> (<%=segments[i].value%>)</div> <%}%><%}%>',
           onAnimationComplete: function(){
              $('#chart-image-ft').val(myPies.toBase64Image());}});
              $('#legend_ft').val(myPies.generateLegend());
        ";

  }

$_SESSION['pagina']['conteudo'].= "}

</script>
";
/*------------------FIM GRAFICOS------------------------*/
/*--Preenchendo formulario com as imagens do grafico e legendas--*/
echo $_SESSION['pagina']['conteudo'];
 ?>

 <form  action='../../addons/plugins/pdf/sgaaes_construtorpdf_pdf.php' method='post'>

   <input name='hid_ct_img' type='hidden' id='chart-image' value='' />
   <input name='hid_ct_legenda' type='hidden' id='legend_ct' value=''/>

   <input name='hid_sa_img' type='hidden' id='chart-image-sa' value='' />
   <input name='hid_sa_legenda' type='hidden' id='legend_sa' value=''/>

   <input name='hid_ft_img' type='hidden'  id='chart-image-ft' value='' />
   <input name='hid_ft_legenda' type='hidden' id='legend_ft' value=''/>

   <input name='hid_fth_img' type='hidden' id='chart-image-faltageral' value='' />
   <input name='hid_ftg_legenda' type='hidden' id='legend_ftg' value=''/>

  <div style="width: 49px; float: right;font-family: sans-seri"><button type="submit" class ="btnpdf" title='Imprimir'><img src = '../../layout/images/pdf.png' width='40px' height='40px' title='Imprimir'></button> Imprimir<div>
   </form>

<!--FIM FORMULÁRIO---------------->

</fieldset>
</div>
