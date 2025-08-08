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
		"zeroRecords": "Nada encontrado",
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
 
$resultado = mysqli_query($conectar,"SELECT * FROM temas ORDER BY 'data_criacao' DESC");


?>     

<div class="container-fluid">
<div class="row-fluid">
<div class="col col-lg-H col-md-H col-sm-H haggy">
    <div class="panel panel-default panel-table">
        <div class="panel-heading" >
            
              <p>
              	
                	<div class="divH"><label>Sugestões de temas para Projectos para TIA</label></div>
                	<div class="text-right divH">
                	<?php if ($_SESSION['usuarioNivelAcesso'] != 3) { ?>
                		 <a href="#adicionarActividadeModal" data-toggle="modal"><button type="button" class="btn btn-info add-new"><i class="fa fa-plus" data-toggle="tooltip"></i> Adicionar novo</button></a>
                	<?php } ?>
                	</div>
                
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
						<th>Título</th>
						<th>Descrição</th>
						<!-- <th>Estado</th> -->
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
	                        echo "<td readonly>".$i."</td>";
	                        echo "<td>".$linhas['titulo']."</td>";
	                        echo "<td>".$linhas['descricao']."</td>";
	                        /*echo "<td>".$linhas['estado']."</td>";*/
							
		 if ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5) {  ?>

							<td>
                            
                            <a href="#delete" class="delete" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a>
                        </td>
							<?php 
						}
						echo "</tr>";
						$i++;
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

 <div id="adicionarActividadeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">            
            <h4 class="modal-title">Adicionar tema</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <br>
          <form name="addActividade" method="POST" action="">
          <div class="text-center"><i class="glyphicon glyphicon-bookmark" style="font-size: 40pt"></i></div>
          <div class="modal-body">   
                
            <div class="form-group">
              <label>Título</label>
              
              <input type="text" id="titulo" name="titulo" autofocus="" maxlength="700" class="form-control"  required>
            </div>
            
            
            <div class="form-group">
              <label>Descrição</label>
              <textarea type="text" id="descricao" name="descricao" class="form-control" ></textarea>
            </div> 
            
                   
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit"  class="btn btn-info" name="adicionarActividadeModal" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php 

  if(isset($_POST['adicionarActividadeModal'] )){
	$titulo 				= $_POST["titulo"];
	$data 				= $_POST["data"];
	$local 			= $_POST["local"];
	$descricao 				= $_POST["descricao"];	
$query = mysqli_query($conectar,"INSERT INTO temas (`titulo`, `descricao`) VALUES ('$titulo', '$descricao')");
	if ($query) {
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Tema agendada com sucesso
														</div>
												   	";
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					
				}header("Location: temas.php");
}
 ?>

  
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
				<div class="alert alert-danger"><span class=""></span> Tens a certeza que desejas Eliminar o usuário?</div>
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

	$query=mysqli_query($conectar,"DELETE FROM temas WHERE id='$id'");
	if ($query) 
					/*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, nome,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$nome $apelido', '$senha', 'Activo', '2', NOW())");
					if ($inserir1)*/{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Tema eliminada com sucesso!.
														</div>
												   	";
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					
				}header("Location: temas.php");
}
	include_once("rodape.php");
?>
    
<!-- Inicio Modal Editar -->
 <div id="editarsuarioModal" class="modal fade">
    <div class="modal-dialog">
     
      <div class="modal-content">
          <div class="modal-header">            
            <h4 class="modal-title">Editar dados do usuário</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <br>
          <div class="text-center"><i class="fa fa-user fa-7x fa-fw"></i></div>
          <form name="editarForm" method="POST" action="">
          	<div class="modal-body">  
	
            
            <div class="form-group">
              <label>Nome Completo</label>
              
              <input type="text" id="nome" name="nome" autofocus="" maxlength="40" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Usuário</label>
              <input readonly type="text" id="idUsuario" name="idUsuario" maxlength="20" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Curso</label>
              <input type="text" id="curso" name="curso" maxlength="15" class="form-control" >
            </div>
            
            <div class="form-group">
              <label>Celular</label>
              <input type="text" id="celular" name="celular" maxlength="9" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" id="email" name="email" maxlength="40" class="form-control"  required>
            </div> 
            <div class="form-group">
              <label>Nivel de Acesso</label>
              <select class="input sm form-control" id="nivel_de_acesso"  name="nivel_de_acesso" required="">
				<option ></option>
				  	<?php 
                      $query=mysqli_query($conectar,"SELECT * FROM `tabela_nivel_acesso`");
                      while($rs=mysqli_fetch_array($query)){ 

                         echo "<option value = '".$rs['idNivelAcesso']."'>".$rs['nomeNivelAcesso']."</option>";
                      }
                      
                    ?>
				</select> 
            </div>
                   
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit"  class="btn btn-info" name="Save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript">
				$('#editarsuarioModal').on('show.bs.modal', function (event) {
				  var button = $(event.relatedTarget) // Button that triggered the modal
				  var idUsuario = button.data('whatever') 
				  var nome = button.data('whatevernome') 
				  var celular = button.data('whatevercelular') 
				  var email = button.data('whateveremail') 
				  var curso = button.data('whatevercurso')
				  var nomenivel = button.data('whatevernomenivel')
				  var idNivelAcesso = button.data('whateveridNivelAcesso') 
				  var modal = $(this)
				  modal.find('.modal-title').text('Editar Usuario: ' + nome)
				  modal.find('#idUsuario').val(idUsuario)
				  modal.find('#nome').val(nome)
				  modal.find('#celular').val(celular)
				  modal.find('#email').val(email)
				  modal.find('#curso').val(curso)
				  modal.find('#nomenivel').val(nomenivel)
				  modal.find('#nivel_de_acesso').val(idNivelAcesso)
				  modal.find('#nivel_de_acesso').val(idNivelAcesso)
				  })
</script>
<?php 
if(isset($_POST['Save'] )){
	$idUsuario 			= $_POST["idUsuario"];
	$nome 				= $_POST["nome"];
	$email 				= $_POST["email"];
	$celular 			= $_POST["celular"];
	$curso 				= $_POST["curso"];
	$nivel_de_acesso 	= $_POST["nivel_de_acesso"];	
	$query = mysqli_query($conectar,"UPDATE tabela_usuarios set nome ='$nome', email ='$email', celular = '$celular', curso = '$curso', idNivelAcesso = '$nivel_de_acesso', dataModificacao = NOW() WHERE idUsuario='$idUsuario'");
	if ($query) 
					/*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, nome,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$nome $apelido', '$senha', 'Activo', '2', NOW())");
					if ($inserir1)*/{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Usuário <strong> $nome</strong> editado com sucesso
														</div>
												   	";
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					
				}header("Location: listarUsuarios.php");
}



if(isset($_POST['adicionarUsuarioModal'] )){
	$nome 				= $_POST["nome"];
	$email 				= $_POST["email"];
	$celular 			= $_POST["celular"];
	$curso 				= $_POST["curso"];
	$nivel_de_acesso 	= $_POST["nivel_de_acesso"];
	$senha				= md5("1234");	
$query = mysqli_query($conectar,"INSERT INTO tabela_usuarios (`idUsuario`, `nome`, `celular`, `email`, `senha`, `estado`, `curso`, `idNivelAcesso`, `dataCadastro`) VALUES ('$email', '$nome', '$celular', '$email', '$senha','Activo', '$curso', '$nivel_de_acesso', NOW())");
	if ($query) {
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Usuário <strong> $nome</strong> cadastrado com sucesso
														</div>
												   	";
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					
				}header("Location: listarUsuarios.php");
}
 ?>