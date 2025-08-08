<?php
	include_once("principal.php");
	
?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript" charset="utf-8" ></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myTable').DataTable( {
		"language": {
		"lengthMenu": "Mostrando _MENU_ registros por pagina",
		"zeroRecords": "Nada encontrado ",
		"info": "Visualisando _PAGE_ de _PAGES_",
		"infoEmpty": "Sem registros disponiveis",
		"infoFiltered": "(Filtrado de _MAX_ registros totais)"
		}
		} );
		} );
		
</script>
<?php

if(isset($_SESSION['mensagem'])){
		echo $_SESSION['mensagem'];
		unset($_SESSION['mensagem']);
}
 
$resultado = mysqli_query($conectar,"SELECT * FROM `mensagens` JOIN tabela_usuarios ON mensagens.idUsuario = tabela_usuarios.idUsuario ORDER BY 'data' DESC");


?>     

<div class="container-fluid">
<div class="row-fluid">
<div class="col col-lg-H col-md-H col-sm-H haggy">
    <div class="panel panel-default panel-table">
        <div class="panel-heading" >
            
              <p>
              	
                	<div class="divH"><label>Notificação </label></div>
                	<!-- <div class="text-right divH">
                	<?php if ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5) { ?>
                		 <a href="#adicionarActividadeModal" data-toggle="modal"><button type="button" class="btn btn-info add-new"><i class="fa fa-plus" data-toggle="tooltip"></i> Adicionar nova</button></a>
                	<?php } ?>
                	</div> -->
                
              </p> 
        </div>	 
        <div class="panel-body">	
					<!-- <form name="form2" method="post" action="">
						<div class="col-sm-3  form-group" >
							<input type="text" class="input-sm form-control" name="PalavraChave" maxlength="30" size='25' placeholder="Usuario ou nome" required="">
				    	</div>
				   		<div class="col-sm-1 col-md-1">
							<button class='btn btn-sm btn-success' name='buscar'><span class="glyphicon glyphicon-search"></span> Pesquisar</button>
				    	</div>
					</form> -->
                

              <div class="col col-xs-12 col-md-12 col-sm-12 col-lg-12">
              		
            <div class="row-fluid">
            <div class="table-responsive">
			<form name="form1" method="post" action="">
			    
                <table id="myTable" class="table table-condensed  table-bordered table-list table-hover">
	                  <thead style="background: #eee;">
	                    <tr class="filters">
						<th>#</th>
						<th>Assunto</th>
						<th>Mensagem</th>
						<th>Remetente</th>
						<th>data</th>
						 <?php if ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5) { ?>
						<th>Ações</th>
						<?php } ?>
					  </tr>
					</thead>
					<tbody class="searchable">
				<?php 
				 	$i=1;
					while($linhas = mysqli_fetch_array($resultado)){
	                 	
	                
						echo "<tr>";
	                        echo "<td>".$i."</td>";
	                        echo "<td>".$linhas['assunto']."</td>";
	                        echo "<td>".$linhas['msg']."</td>";
	                        echo "<td>".$linhas['nome']."</td>";
	                        echo "<td>".$linhas['data']."</td>";
	                        
							
		 if ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5) {  ?>

							<td>
                            
                           <!--  <a href="#edit" class="" data-toggle="modal" data-whatever="<?php echo $linhas['idActividade'];?>" data-whatevertitulo="<?php echo $linhas['titulo'];?>" data-whateverdata_inicio="<?php echo $linhas['data_inicio'];?>" data-whateverdata_final="<?php echo $linhas['data_final'];?>" data-whateverlocal="<?php echo $linhas['local'];?>" data-whateverdescricao="<?php echo $linhas['descricao'];?>"><i class="fa fa-edit" data-toggle="tooltip" title="Editar"></i></a>
 -->
                            <a href="#responder" class="" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" data-whatevernome="<?php echo $linhas['nome'];?>" data-whateveridusuario="<?php echo $linhas['idUsuario'];?>"><i class="fa fa-check " data-toggle="tooltip" title="Responder"></i></a>

                            <a href="#delete" class="delete" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>"><i class="fa fa-trash " data-toggle="tooltip" title="Apagar"></i></a>
                        </td>
							<?php 
						}
						echo "</tr>";
					}
				?>
			</tbody>
		  </table>
	  </div>
	  </form>
	<button type='button' onclick="Voltar()" class='btn btn-info'><span class="glyphicon glyphicon-arrow-left"></span>Voltar</button>
	<p class="clearfix"></p>

</div>
</div>
</div>
</div>


<!-- /container -->


<!-- Inicio Modal Apagar -->
				<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
				<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				<h4 class="modal-title custom_align" id="Heading">Eliminar usuário</h4>
				</div>
				<form name="form" method="POST" action="">
				<div class="modal-body">
				
				
				<input type="hidden" name="id" class="form-control" id="id">
				<div class="alert alert-danger"><span class=""></span> Tens a certeza que desejas Eliminar?</div>
				</div>
				<div class="modal-footer ">
				<button type="submit" class="btn btn-success" name="Eliminar"><span class="glyphicon glyphicon-ok-sign"></span> Sim</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Não</button>
				 </div></div> </div></div> </form>
				<!-- Fim Modal -->


				<script type="text/javascript">
					$('#delete').on('show.bs.modal', function (event) {
					  var button = $(event.relatedTarget) // Button that triggered the modal
					  var recipient = button.data('whatever') 
					  var modal = $(this)
					  //modal.find('.modal-title').text('Editar Usuario - ID: ' + recipient)
					  modal.find('#id').val(recipient)
					
					  })
				</script>
<?php 
if(isset($_POST['Eliminar'] )){
	$id = $_POST["id"];

	$query=mysqli_query($conectar,"DELETE FROM mensagens WHERE id='$id'");
	if ($query) 
					/*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, nome,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$nome $apelido', '$senha', 'Activo', '2', NOW())");
					if ($inserir1)*/{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Mensagem eliminada com sucesso!.
														</div>
												   	";
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					
				}header("Location: mensagens.php");
}



	include_once("rodape.php");
?>



<!-- Reportar um problema Modal HTML -->
  <div id="responder" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        
          <div class="modal-header">            
            <h4 class="modal-title">Notificar</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <form action="" method="POST" name="responder">
          <br>
          <div class="text-center"><i class="glyphicon glyphicon-envelope fa-7x fa-fw"></i></div>
          <div class="modal-body">   
            <input type="" hidden="" id="id" name="id"> 
            <input type="" hidden="" id="nome" name="nome">   
            <input type="" hidden="" id="idUsuario" name="idUsuario">   
            <div class="form-group">
              <textarea class="form-control" name="msg" required=""></textarea>
            </div>
                  
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" name="Cancel" value="Cancel">
            <input type="submit" class="btn btn-info" name="responder" value="Gravar">
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
					$('#responder').on('show.bs.modal', function (event) {
					  var button = $(event.relatedTarget) // Button that triggered the modal
					  var recipient = button.data('whatever')
					  var nome = button.data('whatevernome') 
					  var idUsuario = button.data('whateveridusuario') 
					  var modal = $(this)
					  //modal.find('.modal-title').text('Editar Usuario - ID: ' + recipient)
					  modal.find('#id').val(recipient)
					  modal.find('#nome').val(nome)
					  modal.find('#idUsuario').val(idUsuario)
					
					  })
				</script>
<?php 
if(isset($_POST['responder'] )){
	$id = $_POST["id"];
	$nome = $_POST["nome"];
	$idUsuario = $_POST["idUsuario"];
	$msg = $_POST["msg"];
	$remetente = $_SESSION['usuarioLogin'];

	 $notificacao=mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('Resposta!','$msg','$remetente','$idUsuario','1')");
	if ($notificacao) 
					/*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, nome,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$nome $apelido', '$senha', 'Activo', '2', NOW())");
					if ($inserir1)*/{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Mensagem respondida com sucesso!.
														</div>
												   	";
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					
				}header("Location: mensagens.php");
}