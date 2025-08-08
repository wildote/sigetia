<?php
include_once("principal.php");
require_once '_db.php';

date_default_timezone_set('Africa/Johannesburg');

function intercecao($start,$end,$inicio,$fim)
          {
            $Lista=array();
            $Lista2=array();
            $i=0;
            $e=0;
            while (strtotime($start) <= strtotime($end)) {
              $Lista[$i]=$start;
              $start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
              $i++;
            }
            while (strtotime($inicio) <= strtotime($fim)) {
              $Lista2[$e]=$inicio;
              $inicio = date ("Y-m-d", strtotime("+1 day", strtotime($inicio)));
              $e++;
            }
            
            $rs1 = array_intersect($Lista, $Lista2);
            
            return count($rs1);
}    
?>

<?php
	if(isset($_SESSION['mensagem'])){
		echo $_SESSION['mensagem'];
		unset($_SESSION['mensagem']);
	}
?>

<?php 
    if(isset($_POST['filtroMes'])){
       $mes=$_POST['mes']."-00";
       $reservas= mysqli_query($conectar,"SELECT * FROM reservations WHERE month(start)=month('$mes') OR month(end)=month('$mes')");
       $ocupacoes= mysqli_query($conectar,"SELECT * FROM reservations WHERE status='Confirmada' AND ( month(start)=month('$mes') OR month(end)=month('$mes') )");
       $rendimento= mysqli_query($conectar,"SELECT SUM(valor_pago) FROM `reservations` WHERE status='Confirmada' AND ( month(start)=month('$mes') OR month(end)=month('$mes') )");   
       $row = mysqli_fetch_row($rendimento);
       $total= $row[0];
       
    }else if(isset($_POST['filtroDia'])){
       $dia=$_POST['dia'];
       $reservas= mysqli_query($conectar,"SELECT * FROM reservations WHERE date('$dia') BETWEEN date(start) AND date(end)");
       $ocupacoes= mysqli_query($conectar,"SELECT * FROM reservations WHERE status='Confirmada' AND date('$dia') BETWEEN date(start) AND date(end)");
       $rendimento= mysqli_query($conectar,"SELECT SUM(valor_pago/ndias) FROM `reservations` WHERE status='Confirmada' AND date('$dia') BETWEEN date(start) AND date(end) ");   
       $row = mysqli_fetch_row($rendimento);
       $total= $row[0];
       
    }elseif(isset($_POST['filtroData'])){
       $start=$_POST['start'];
       $end=$_POST['end'];
       $reservas= mysqli_query($conectar,"SELECT * FROM reservations WHERE (start BETWEEN '$start' AND '$end') OR (end BETWEEN '$start' AND '$end') OR ('$start' BETWEEN start AND end) OR ('$end' BETWEEN start AND end)");
       $ocupacoes= mysqli_query($conectar,"SELECT * FROM reservations WHERE (status='Confirmada') AND ((start BETWEEN '$start' AND '$end') OR (end BETWEEN '$start' AND '$end') OR ('$start' BETWEEN start AND end) OR ('$end' BETWEEN start AND end))");
       $rendimento= mysqli_query($conectar,"SELECT SUM(valor_pago/ndias) FROM `reservations` WHERE (status='Confirmada') AND ((start BETWEEN '$start' AND '$end') OR (end BETWEEN '$start' AND '$end') OR ('$start' BETWEEN start AND end) OR ('$end' BETWEEN start AND end))");
       
        $valor=0;
        while ($rs=mysqli_fetch_array($ocupacoes)) {
          $startRS = $rs['start'];
          $endRS = $rs['end'];
          $inicio = $start;
          $fim = $end;
          $valor = $valor + ($rs['valor_pago']/$rs['ndias'])*intercecao($startRS,$endRS,$inicio,$fim);
          

        }
          
       $row = mysqli_fetch_row($rendimento);
       $total= $row[0];
       
    }

    
?>

<div class="container-fluid" >
   <p><h1 align="center" class=" alert alert-info col">Seja Bem Vindo</h1><a href='File3.php?start=<?php  echo $start ?>&end=<?php  echo $end ?>&valor=<?php  echo $valor ?>' class="text-right "> <button type='button' class='text-right btn btn-sm btn-success'><span class='glyphicon glyphicon-print'></span> Imprimir Relatorio</button></a></p>
	<div class="row-fluid">
	<div class="col col-lg-H col-md-H col-sm-H haggy">
      <div class="text-right divH">
          
      </div>
			<div class="col-lg-4 col-md-4 col-sm-4">
            <div class="panel panel-danger alert alert-info ">
      				<h1 align="center" class="text-danger">Reservas</h1>
  					  <center>
      				 <strong class="text-danger">Total: <?php echo @mysqli_num_rows($reservas);  ?></strong> <br>
      				</center>
					  </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
               	<div class="panel panel-success alert alert-info">
    				<h1 align="center" class="text-success">Ocupações</h1>
					
    				
					 <center>
    				 <strong class="text-success">Total: <?php echo @mysqli_num_rows($ocupacoes);  ?></strong> <br>
    				 
    				 </center>
					 
 				</div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
               	<div class="panel panel-primary alert alert-info">
    				<h1 align="center" class="text-primary">Rendimento</h1>
					
    				<center>
    				 <strong class="text-primary">Total: <?php echo @number_format($valor,2)." MZN"; ?></strong> <br>
    				 
    				 </center>
					 
 				</div>
      </div>
            <h2 class="text-center"> <b>Filtro</b></h2>
              
              
             <form name="form2" method="POST" class="" style="z-index: 0;" action="">
                <div class="col-lg-4 col-md-4 hidden"></div>
                  <div class="col-lg-4 col-md-4 col-xs-12" style="z-index: 0;">
                    <p class="text-center"><b>Data</b> DD-MM-AAAA até <b>Data</b> DD-MM-AAAA</p>
                    <div class="input-group">

                      <input type="date" class="input-sm form-control" name="start" value="<?php echo $_POST['start'] ?>">
                      <span class="input-group-btn">
                        
                      </span>

                      <input type="date" class="input-sm form-control" name="end" value="<?php echo $_POST['end'] ?>">
                      <span class="input-group-btn">
                        <button name="filtroData" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                      </span>
                    </div>
                  </div>   
              </form>
              
             	<form name="form1" method="POST" class="hidden" action="">
             		  <div class="col-lg-4 col-md-4 col-xs-12">
                    <p><b>MÊS</b></p>
                    <div class="input-group">
                      <input type="month" class="input-sm form-control" name="mes" value="<?php echo $_POST['mes'] ?>">
                      <span class="input-group-btn">
                        <button name="filtroMes" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                      </span>
                    </div>
                  </div>   
              </form>
      <div class="col col-xs-12 col-md-12 col-sm-12 col-lg-12">
        <p></p>
                  <p>
                 <?php
                 date_default_timezone_set('Africa/Johannesburg');
                 $agora=DATE('Y-m-d H:m:s');
                    $query= mysqli_query($conectar,"SELECT * FROM reservations WHERE status='Confirmada' AND '$agora' BETWEEN start AND end");
                  ?>   
                <label for="texto">Número de Ocupações agora: <?php  $num = mysqli_num_rows($query);  echo "$num"; ?> </label>
                <a href='File2.php'> <button type='button' class='text-right btn btn-sm btn-info'><span class='glyphicon glyphicon-print'></span> Imprimir</button></a>
                  </p> 
            <div class="row-fluid">
            <div class="table-responsive">
        
      <form name="form1" method="post" action="">
         
                <table id="myTable" class="table table-bordered table-striped  table-responsive table-hover">
                  <thead class="btn-primary"> 
                    <th>Cómodo</th>
                    <th>Empresa</th>      
                    <th>Nome</th>
                    <th>Contacto</th>
                    <th>Adultos</th>
                    <th>Crianças</th>
                  </thead>
                <tbody class="searchable">
        
                    <?php
                      
                      while($linhas = mysqli_fetch_array($query)){
                        $room_id=$linhas['room_id'];
                        $stmt = $db->prepare('SELECT * FROM rooms WHERE id = :room_id');
                        $stmt->bindParam(':room_id', $room_id);
                        $stmt->execute();
                        $room = $stmt->fetch();
                        echo "<tr>";
                          echo "<td>".$room['name']."</td>";
                          echo "<td>".$linhas['empresa']."</td>";
                          echo "<td>".$linhas['name']."</td>";
                          echo "<td>".$linhas['Celular']."</td>";
                          echo "<td>".$linhas['N_Adultos']."</td>";
                          echo "<td>".$linhas['N_Criancas']."</td>"; 
                          ?>
                          <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $linhas['idUsuario'];?>">
                          <?php
                        echo "</tr>";
                      }
                    ?>
                    
                  </tbody>
    </table>
    </form>
  
</div>
</div>        
    </div>
	</div>
</div>
<br>
<br>
              
           
<?php
	include_once("rodape.php");
?>


