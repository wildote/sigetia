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

 	$resultado = mysqli_query($conectar,"SELECT * FROM `monografias`  ORDER BY `monografias`.`estado` ASC");



?>     

<div class="container-fluid">
<div class="row-fluid">
<div class="col col-lg-H col-md-H col-sm-H haggy">
    <div class="panel panel-default panel-table">
        <div class="panel-heading" >
            
              <p>
              	
                	<div class="divH"><label>Monografia</label></div>
                	<?php 
				            $num = mysqli_num_rows($resultado);
				            	if ($_SESSION['usuarioNivelAcesso'] == 2 || $_SESSION['usuarioNivelAcesso'] == 5) {
				            		
				    ?>
                	<div class="text-right divH hidden ">
                		<a href="#adicionar_proj_Modal" data-toggle="modal"title="Fazer upload do monografia"><i  data-toggle="tooltip"><button type='button' class='text-right btn btn-sm btn-info'><span class="glyphicon glyphicon-plus"></span> </button></i></a>
                	</div>
                	<?php
				       }
				    ?>
                
              </p> 
        </div>	 
        <div class="panel-body">	
					<!-- <form name="form2" method="post" action="">
						<div class="col-sm-3  form-group" >
							<input type="text" class="input-sm form-control" name="PalavraChave" maxlength="30" size='25' placeholder="Usuario ou tema" required="">
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
					                    <th >Autor</th>
										<th>Tema</th>
										<th>Descrição</th>
										<th>Estado</th>
										<th>Observações</th>
										<th>Supervisor</th>
		<?php if ($_SESSION['usuarioNivelAcesso'] != 3) { ?><th>Avaliado por</th><?php } ?>
										<th>Acções</th>
									  </tr>
									</thead>
									<tbody class="searchable">
										<?php 
										 $user=$_SESSION['usuarioLogin'];
											while($linhas = mysqli_fetch_array($resultado)){

												//Querry para buscar o nome do autor da Monografia
												$idUsuario=$linhas['idUsuario'];
												$rs = mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE `idUsuario`='$idUsuario'");
							                 	$rs = mysqli_fetch_assoc($rs);


												//Mostrar o nome do supervisor da monografia
												$idSupervisor=$linhas['idSupervisor'];
												$resultado2 = mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE `idUsuario`='$idSupervisor'");
							                 	$linhas2 = mysqli_fetch_assoc($resultado2);
							                 ?>
												<tr <?php if (!$linhas['url'] && $_SESSION['usuarioNivelAcesso'] != 3) { ?> style="color: red;" <?php } ?>>
											<?php
							                        echo ( "<td style='background: #;'>".$rs['nome']."</td>");
							                        echo ( "<td>".$linhas['tema']."</td>");
							                        echo ( "<td>".$linhas['descricao']."</td>");
													
													if($linhas['estado']=='0'){?>
													<td class="text-center">
												<?php if ($linhas['url'] && ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5)) {?><a href='#avaliar_Modal' data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" data-whatevertema="<?php echo $linhas['tema'];?>" data-whateverdescricao="<?php echo $linhas['descricao'];?>"><?php } ?><button type='button' name='Activar' class='btn btn-sm btn-warning btn-block' title=""><span class=''>Não avaliado</span> </button></a></td>
													<?php	
													}elseif($linhas['estado']=='1'){?>
													<td class="text-center">
													<?php if ($linhas['url'] && $_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5) {?><a href='#avaliar_Modal' data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" data-whatevertema="<?php echo $linhas['tema'];?>" data-whateverdescricao="<?php echo $linhas['descricao'];?>"><?php } ?><button type='button' name='Activar' class='btn btn-sm btn-primary btn-block' title=""><span class=''>Aprovado</span> </button></a></td>
													<?php	
													}elseif($linhas['estado']=='2'){?>
													<td class="text-center"><a href='#'><button type='button' name='Activar' class='btn btn-sm btn-danger btn-block ' title=""><span class=''>Reprovado</span> </button></a></td>
													<?php	
													}elseif($linhas['estado']=='3'){?>
													<td class="text-center"><a href='#'><button type='button' name='Activar' class='btn btn-sm btn-success btn-block ' title=""><span class=''>Defendido</span> </button></a></td>
													<?php
													}
													echo ( "<td>".$linhas['obs']."</td>");
							                        echo ( "<td>".$linhas2['nome']."</td>");
							                        $idUserAprov=$linhas['idUserAprov'];
													$resultado3 = mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE `idUsuario`='$idUserAprov'");
								                 	$linhas3 = mysqli_fetch_assoc($resultado3);
							                    if ($_SESSION['usuarioNivelAcesso'] != 3) {
    												echo ( "<td>".$linhas3['nome']."</td>"); 
    											}
													?>

													<td>
						                            
						                            <?php if ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5 || $user==$idUsuario) {
						                            	
						                            ?>
						                           <!--  <a href="#editar_proj_modal" class="edit" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" data-whatevertema="<?php echo $linhas['tema'];?>" data-whateverdescricao="<?php echo $linhas['descricao'];?>" data-whateverproj="<?php echo $linhas['url'];?> "><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a> -->
						                    <?php if (($linhas['url'] && ($linhas['estado']==0 || $linhas['estado']==2)) || $_SESSION['usuarioNivelAcesso'] == 5) { ?>
						                           <a href="#delete" class="delete" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" ><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a>
						                            <?php } } ?>

						                    <?php if (!$linhas['url'] && $user==$idUsuario) { ?>
						                           <a href="#carregar_mono_modal" class="edit" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" data-whatevertema="<?php echo $linhas['tema'];?>" data-whateverdescricao="<?php echo $linhas['descricao'];?>" ><i class="fa fa-upload" style="color: #36b9cc;" data-toggle="tooltip" title="carregar arquivo"></i></a>
						                           <?php 
						                    } 

						                           ?>
											<?php if ($linhas['url'] && ($linhas['estado']=='3' || $user==$idUsuario || $_SESSION['usuarioNivelAcesso'] != 3) ) { ?>
 
						                            <a href="<?php echo utf8_encode($linhas['url']) ?>"  class="baixar"  target='blank'><i class="fa fa-download" title="Baixar arquivo"></i></a>
						                    		<?php 
						                    } 

						                           ?>
						                        </td>
													<?php
												echo "</tr>";
											}
									            		
									            	
									            ?>    
									
							  		</tbody>
				  				</table>
						</form>
						
					</div>
					<button type='button' onclick="Voltar()" class='btn btn-info'><span class="glyphicon glyphicon-arrow-left"></span>Voltar</button>
						<p class="clearfix"></p>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>


<!-- /container -->

 				  <div id="adicionar_proj_Modal" class="modal fade">
				    <div class="modal-dialog">
				      <div class="modal-content">
				          <div class="modal-header">            
				            <h4 class="modal-title">Adicionar monografia</h4>
				            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				          </div>
				          <br>
				          <form name="proj_file" method="POST" action="up.php" enctype="multipart/form-data">
				          <div class="text-center"><i class="fa fa-file fa-7x fa-fw" style="color: #1EA4DD;"></i></div>
				          <div class="modal-body">   
				                
				            <div class="form-group">
				              <label>Tema(*)</label>
				              
				              <input type="text" id="tema" name="tema" autofocus="" maxlength="750" class="form-control" placeholder="Digite o tema do seu monografia TCC" required>
				            </div>
				            
				            <div class="form-group">
				              <label>Descricão(*)</label>
				              <textarea  id="descricao" name="descricao" placeholder="Descreva o seu TCC" class="form-control" ></textarea>
				            </div>
				            
				            <div class="form-group">
				              <label>Carregar(*)</label>
				              <input type="file" id="proj_file" name="proj_file" class="form-control"  required>
				            </div>
				            
				                   
				          </div>
				          <div class="modal-footer">
				            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
				            <input type="submit"  class="btn btn-info" name="adicionar_proj_Modal" value="Save">
				          </div>
				        </form>
				      </div>
				    </div>
				  </div>


				  <div id="avaliar_Modal" class="modal fade">
				    <div class="modal-dialog">
				      <div class="modal-content">
				          <div class="modal-header">            
				            <h4 class="modal-title">Avaliar monografia</h4>
				            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				          </div>
				          <br>
				          <form name="aprovar_proj_Modal" method="POST" action="" enctype="multipart/form-data">
				          <div class="text-center"><i class="fa fa-file fa-7x fa-fw" style="color: #1EA4DD;"></i></div>
				          <div class="modal-body">   
				                
				            <div class="form-group">
				              <label>Tema(*)</label>
				              <input type="hidden" id="id" name="id"></input>
				              <input type="text" readonly="" id="tema" name="tema" autofocus="" maxlength="750" class="form-control" placeholder="Digite o tema do seu monografia TCC" required>
				              <label>Descricão(*)</label>
				              <textarea  id="descricao" name="descricao" readonly="" placeholder="Descreva o seu TCC" class="form-control" ></textarea>
				            </div>
				            
				            
				            <div class="form-group">
				              <label>Estado(*)</label>
				              <select required="" name="estado"  class="form-control">
				              		<option>Selecione aqui</option>
				              		<option value="1">Aprovado</option>
				              		<option value="2">Reprovado</option>
				              		<option value="3">Defendido</option>
				              </select>
				            </div>
				            <div class="form-group">
				              <label>Observações</label>
				              <textarea  id="obs"  name="obs" placeholder="Observações acerca do monografia TCC" class="form-control" ></textarea>
				            </div>

				            
				            
				                   
				          </div>
				          <div class="modal-footer">
				            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
				            <input type="submit"  class="btn btn-info" name="aprovar_proj_Modal" value="Save">
				          </div>
				        </form>
				      </div>
				    </div>
				  </div>
  			<script type="text/javascript">
				$('#avaliar_Modal').on('show.bs.modal', function (event) {
				  var button = $(event.relatedTarget) // Button that triggered the modal
				  var id = button.data('whatever') 
				  var tema = button.data('whatevertema') 
				  var descricao = button.data('whateverdescricao') 
				 
				  var modal = $(this)
				  modal.find('#id').val(id)
				  modal.find('#tema').val(tema)
				  modal.find('#descricao').val(descricao)
				  
				  })
			</script>
			<?php 
			if(isset($_POST['aprovar_proj_Modal'] )){
				$id = $_POST["id"];
				$idUsuario = $_SESSION["usuarioLogin"];
			    $sql=mysqli_query($conectar,"SELECT * FROM `monografias` JOIN tabela_usuarios ON monografias.idUsuario=tabela_usuarios.idUsuario WHERE id='$id'");
			    $rs=mysqli_fetch_assoc($sql);
			    $idSupervisor=$rs['idSupervisor'];
			    $estudante=$rs['nome'];
			    $estudante_usuario=$rs['idUsuario'];
				$estado = $_POST["estado"];
				if ($estado==0) {
					$nome_estado="Reprovado";
				}elseif($estado==1){
					$nome_estado="Aprovado";
				}

				$obs = $_POST["obs"];
				$query=mysqli_query($conectar,"UPDATE `monografias` SET `estado`=$estado,`obs`='$obs', idUserAprov='$idUsuario' WHERE id=$id");
				$notificacao=mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_nivel_acesso`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('A sua monografia foi $nome_estado!','A sua monografia foi $nome_estado!','','$idUsuario','$estudante_usuario','1')");
				
				$notificacao=mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_nivel_acesso`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('Monografia','A monografia do estudante $estudante foi $nome_estado','','$idUsuario','$idSupervisor','1')");
				
				if ($query) {
								$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
																		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
																		Avaliado com sucesso!.
																	</div>
															   	";
							}else{
								$_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
																		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
																		
																		Error: ".mysqli_error($conectar)."
																	</div> 
															   	";
								
							}
							header("Location: monografia.php");
			}
			 ?>

  
<!-- Inicio Modal Apagar -->
				<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
				<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				<h4 class="modal-title custom_align" id="Heading">Eliminar Monografia</h4>
				</div>
				<br>
				<div class="text-center"><i class="fa fa-file fa-7x fa-fw" style="color: #1EA4DD;"></i></div>
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

	$query=mysqli_query($conectar,"UPDATE `monografias` SET `url` = null, `estado` = null WHERE `monografias`.`id`='$id'");
	if ($query) 
					/*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, tema,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$tema $apelido', '$senha', 'Activo', '2', NOW())");
					if ($inserir1)*/{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Tema eliminado com sucesso!.
														</div>
												   	";
					//Manda o usuario para a tela de login
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
				}
					header("Location: monografia.php");
}
 ?>

<?php
	include_once("rodape.php");
?>


    
<!-- Inicio Modal Editar -->
 <div id="editar_proj_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
     
      <div class="modal-content">
          <div class="modal-header">            
            <h4 class="modal-title">Editar dados do monografia</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <br>
         <div class="text-center"><i class="fa fa-file fa-7x fa-fw" style="color: #1EA4DD;"></i></div>
          <form name="editarForm" method="POST" action="">
          	<div class="modal-body">  
	
            
            <div class="form-group">
              
              <input type="hidden" id="id" name="id" autofocus="" maxlength="40" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Tema(*)</label>
              <input type="text" id="tema" name="tema" maxlength="200" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Descrição(*)</label>
              <textarea id="descricao" name="descricao" maxlength="400" class="form-control" ></textarea>
            </div>
            
            <div class="form-group">
				<label>Carregar(*)</label>
				<input type="file" id="proj_file" name="proj_file" class="form-control"  required>
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
				$('#editar_proj_modal').on('show.bs.modal', function (event) {
				  var button = $(event.relatedTarget) // Button that triggered the modal
				  var id = button.data('whatever') 
				  var tema = button.data('whatevertema') 
				  var descricao = button.data('whateverdescricao') 
				  var proj_file = button.data('whateverproj') 
				  var modal = $(this)
				  modal.find('#id').val(id)
				  modal.find('#tema').val(tema)
				  modal.find('#descricao').val(descricao)
				  modal.find('#proj_file').val(proj_file)
				  
				  })
</script>
<?php 
if(isset($_POST['Save'] )){
	$id 			= $_POST["id"];
	$tema 				= $_POST["tema"];
	$email 				= $_POST["email"];
	$descricao 			= $_POST["descricao"];	
	$query = mysqli_query($conectar,"UPDATE projecto_tcc set tema ='$tema', descricao = '$descricao' WHERE id='$id'");
	if ($query) 
					/*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, tema,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$tema $apelido', '$senha', 'Activo', '2', NOW())");
					if ($inserir1)*/{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Edição efectuada com sucesso
														</div>
												   	";
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					
				}header("Location: proj_tcc.php");
}




 ?>
 <div id="carregar_mono_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
     
      <div class="modal-content">
          <div class="modal-header">            
            <h4 class="modal-title">Carregar monografia</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <br>
         <div class="text-center"><i class="fa fa-file fa-7x fa-fw" style="color: #1EA4DD;"></i></div>
          <form name="mono_file" method="POST"  action="up2.php" enctype="multipart/form-data">
          	<div class="modal-body">  
	
            
            <div class="form-group">
              
              <input type="hidden" id="id" name="id" autofocus="" maxlength="40" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Tema(*)</label>
              <input type="text" id="tema" readonly="" name="tema" maxlength="200" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <textarea id="descricao" readonly="" name="descricao" maxlength="400" class="form-control" ></textarea>
            </div>
            
            <div class="form-group">
				<label>Carregar(*)</label>
				<input type="file" id="mono_file" name="mono_file" class="form-control"  required>
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
				$('#carregar_mono_modal').on('show.bs.modal', function (event) {
				  var button = $(event.relatedTarget) // Button that triggered the modal
				  var id = button.data('whatever') 
				  var tema = button.data('whatevertema') 
				  var descricao = button.data('whateverdescricao') 
				  var modal = $(this)
				  modal.find('#id').val(id)
				  modal.find('#tema').val(tema)
				  modal.find('#descricao').val(descricao)
				  
				  })
</script>
