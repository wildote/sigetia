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
 $idUsuario = $_SESSION['usuarioLogin']; 
 if ($_SESSION['usuarioNivelAcesso'] == 3) {
 	$resultado = mysqli_query($conectar,"SELECT * FROM `projecto_tcc` WHERE `idUsuario`='$idUsuario'");
 }else{
 	$resultado = mysqli_query($conectar,"SELECT * FROM `projecto_tcc`");
 }



?>     

<div class="container-fluid">
<div class="row-fluid">
<div class="col col-lg-H col-md-H col-sm-H haggy">
    <div class="panel panel-default panel-table">
        <div class="panel-heading" >
            
              <p>
              	
                	<div class="divH"><label>Projecto TIA</label></div>
                	
                
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
						    
				            <?php 
				            $num = mysqli_num_rows($resultado);
				            	if ($num==0 && $_SESSION['usuarioNivelAcesso'] == 3) {
				            		
				            		?>
				            		<div align="center">
				            			<a href="#adicionar_proj_Modal" data-toggle="modal"><i  data-toggle="tooltip"></i><img src="pics/upload.png" class="img-responsive" style="max-width: 250px;" title="Fazer upload do projecto"></a>
				            			<div class="divH"><i>Fazer upload do projecto</i> </div>
				            			</br>
									</div>
				            		<?php
				            	}else{
				            		?>
				            	<table id="myTable" class="table table-condensed  table-bordered table-list table-hover">
					                  <thead style="background: #eee;">
					                    <tr class="filters">
					                <?php if ($_SESSION['usuarioNivelAcesso'] != 3) { ?>
										<th>Autor</th>
									<?php } ?>
										<th>Tema</th>
										<th>Descrição</th>
										<th>Estado</th>
										<th>Observações</th>
										<th>Supervisor</th>
										<th>Avaliado por</th>
										<th>Data da submissão</th>
										<th>Acções</th>
									  </tr>
									</thead>
									<tbody class="searchable">
										<?php 
										 $user=$_SESSION['usuarioLogin'];
											while($linhas = mysqli_fetch_array($resultado)){
												$idSupervisor=$linhas['idSupervisor'];
												$resultado2 = mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE `idUsuario`='$idSupervisor'");
												$idUsuario=$linhas['idUsuario'];
												$rs = mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE `idUsuario`='$idUsuario'");
							                 	$rs = mysqli_fetch_assoc($rs);
							                 	$linhas2 = mysqli_fetch_assoc($resultado2);
												echo "<tr>";
													if ($_SESSION['usuarioNivelAcesso'] != 3) {
    												echo ( "<td>".$rs['nome']."</td>"); 
    											}
													$NomeEstudante=$rs['nome'];
							                        echo ( "<td>".$linhas['tema']."</td>");
							                        echo ( "<td>".$linhas['descricao']."</td>");
													
													if($linhas['estado']=='0'){?>
													<td class="text-center">
												<?php if ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5) {?><a href='#avaliar_Modal' data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" data-whateveruser="<?=$idUsuario;?>" data-whatevernomeestudante="<?php echo $NomeEstudante;?>" data-whatevertema="<?php echo $linhas['tema'];?>" data-whateverdescricao="<?php echo $linhas['descricao'];?>" data-whateversupervisor="<?php echo $linhas['idSupervisor'];?>"><?php } ?><button type='button' name='Activar' class='btn btn-sm btn-warning btn-block' title=""><span class=''>Não avaliado</span> </button></a></td>
													<?php	
													}elseif($linhas['estado']=='1'){?>
													<td class="text-center"><a href='#'><button type='button' name='Activar' class='btn btn-sm btn-success btn-block' title=""><span class=''>Aprovado</span> </button></a></td>
													<?php	
													}elseif($linhas['estado']=='2'){?>
													<td class="text-center"><a href='#'><button type='button' name='Activar' class='btn btn-sm btn-danger btn-block ' title=""><span class=''>Reprovado</span> </button></a></td>
													<?php
													}
													echo ( "<td>".$linhas['obs']."</td>");
							                        echo ( "<td>".$linhas2['nome']."</td>");
							                        $idUserAprov=$linhas['idUserAprov'];
													$resultado3 = mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE `idUsuario`='$idUserAprov'");
								                 	$linhas3 = mysqli_fetch_assoc($resultado3);
							                        echo ( "<td>".$linhas3['nome']."</td>");
													?>
													<td>
														<?=$linhas['data'] ?>
													</td>
													<td>
													
						                            
						                            <?php if (($_SESSION['usuarioNivelAcesso'] == 5 || $linhas['idUsuario']==$user) && $linhas['estado']!=1) {
						                            	
						                            ?>
						                           <!--  <a href="#editar_proj_modal" class="edit" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" data-whatevertema="<?php echo $linhas['tema'];?>" data-whateverdescricao="<?php echo $linhas['descricao'];?>" data-whateverproj="<?php echo $linhas['url'];?> "><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a> -->
						                            <a href="#delete" class="delete" data-toggle="modal" data-whatever="<?php echo $linhas['id'];?>" ><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a>
						                            <?php } ?>
						                            <a href="<?php echo $linhas['url'] ?>"  class="baixar"  target='blank'><i class="fa fa-download" title="Baixar arquivo"></i></a>
						                        </td>
													<?php
												echo "</tr>";
											}
									            		
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
				            <h4 class="modal-title">Adicionar Projecto</h4>
				            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				          </div>
				          <br>
				          <form name="proj_file" method="POST" action="up.php" enctype="multipart/form-data">
				          <div class="text-center"><i class="fa fa-file fa-7x fa-fw" style="color: #1EA4DD;"></i></div>
				          <div class="modal-body">   
				                
				            <div class="form-group">
				              <label>Tema</label>(*)
				              
				              <input type="text" id="tema" name="tema" autofocus="" maxlength="700" class="form-control" placeholder="Digite o tema do seu projecto TIA" required>
				            </div>
				            
				            <div class="form-group">
				              <label>Descricão</label>(*)
				              <textarea  id="descricao" name="descricao" placeholder="Descreva o seu TCC" class="form-control" required=""></textarea>
				            </div>
				            
				            <div class="form-group">
				              <label>Carregar</label>(*)
				              <input type="file" id="proj_file" name="proj_file" class="input-xs form-control"  required>
				            </div>
				            <div class="form-group">
				              <label>Supervisor</label>
				              <select id="supervisor" name="supervisor" class="form-control" >
				              	<optgroup>
				              		<option value="">Selecione aqui</option>
				              		<?php 
				                      $query=mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE idNivelAcesso='1' OR idNivelAcesso='2'");
				                      while($rs=mysqli_fetch_array($query)){ 

				                         echo "<option value = '".$rs['idUsuario']."'>".$rs['nome']."</option>";
				                      }
				                      
				                    ?>
				              	</optgroup>
				              </select>
				            </div>
				            <br>
				            <div class="alert alert-info" style="width: 100%">
				            	Campos obrigatórios
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
				            <h4 class="modal-title">Avaliar Projecto</h4>
				            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				          </div>
				          <br>
				          <form name="aprovar_proj_Modal" method="POST" action="" enctype="multipart/form-data">
				          <div class="text-center"><i class="fa fa-file fa-7x fa-fw" style="color: #1EA4DD;"></i></div>
				          <div class="modal-body">   
				                
				            <div class="form-group">
				              <label>Tema(*)</label>
				              <input type="hidden" id="id" name="id"></input>
				              <input type="hidden" id="user_dest" name="user_dest"></input>
				              <input type="hidden" id="NomeEstudante" name="NomeEstudante"></input>
				              <input type="text" readonly="" id="tema" name="tema" autofocus="" maxlength="700" class="form-control" placeholder="Digite o tema do seu projecto TIA" required>
				              <label>Descricão(*)</label>
				               <textarea  id="descricao" readonly="" name="descricao" placeholder="Descreva o seu TCC" class="form-control" ></textarea>
				            </div>
				            
				            
				            <div class="form-group">
				              <label>Estado(*)</label>
				              <select name="estado" class="form-control" required="">
				              	<optgroup>
				              		<option value="">Selecione aqui</option>
				              		<option value="1">Aprovado</option>
				              		<option value="2">Reprovado</option>

				              	</optgroup>
				              </select>
				            </div>
				            <div class="form-group">
				              <label>Observações</label>
				              <textarea  id="obs"  name="obs" placeholder="Observações acerca do projecto TIA" class="form-control" ></textarea>
				            </div>

				            <div class="form-group">
				              <label>Supervisor(*)</label>
				              <select id="supervisor" name="supervisor" class="form-control" >
				              	<optgroup>
				              		<option value="">Selecione aqui</option>
				              		<?php 
				                      $query=mysqli_query($conectar,"SELECT * FROM `tabela_usuarios` WHERE idNivelAcesso='1' OR idNivelAcesso='2'");
				                      while($rs=mysqli_fetch_array($query)){ 

				                         echo "<option value = '".$rs['idUsuario']."'>".$rs['nome']."</option>";
				                      }
				                      
				                    ?>
				              	</optgroup>
				              </select>
				            </div>
				            <div class="alert alert-info">
				            	Campos obrigatórios
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
				  var user_dest = button.data('whateveruser')
				  var NomeEstudante = button.data('whatevernomeestudante') 
				  var tema = button.data('whatevertema') 
				  var descricao = button.data('whateverdescricao') 
				  var supervisor = button.data('whateversupervisor') 
				 
				  var modal = $(this)
				  modal.find('#id').val(id)
				  modal.find('#user_dest').val(user_dest)
				  modal.find('#NomeEstudante').val(NomeEstudante)
				  modal.find('#tema').val(tema)
				  modal.find('#descricao').val(descricao)
				  modal.find('#supervisor').val(supervisor)
				  })
			</script>
			<?php 
			if(isset($_POST['aprovar_proj_Modal'] )){
				$id = $_POST["id"];
				$user_dest = $_POST["user_dest"];
				$idUsuario = $_SESSION["usuarioLogin"];
				$NomeEstudante = $_POST["NomeEstudante"];
				$estado = $_POST["estado"];
				if ($estado==0) {
					$nome_estado="Reprovado";
				}elseif($estado==1){
					$nome_estado="Aprovado";
				}
				$obs = $_POST["obs"];
				$idSupervisor = $_POST["supervisor"];
				$query=mysqli_query($conectar,"UPDATE `projecto_tcc` SET `estado`=$estado,`obs`='$obs',`idSupervisor`='$idSupervisor',`data`= NOW(), idUserAprov='$idUsuario' WHERE id=$id");
				$notificacao=mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_nivel_acesso`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('O seu projecto foi $nome_estado!','O seu projecto foi $nome_estado!','','$idUsuario','$user_dest','1')");
				if($estado==1){
				$notificacao=mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_nivel_acesso`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('Projecto','Foi selecionado como o supervisor do estudante $NomeEstudante','','$idUsuario','$idSupervisor','1')");
				}
				if ($estado==1) {
					
				
					$query=mysqli_query($conectar,"INSERT INTO `sigetcc`.`monografias` (`tema`, `descricao`, `idUsuario`, `idSupervisor`, `id_proj`) SELECT `tema`, `descricao`, `idUsuario`, `idSupervisor`,`id` FROM `sigetcc`.`projecto_tcc` WHERE id=$id");
				}
				if ($query) {
								$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
																		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
																		Avaliado com sucesso!.
																	</div>
															   	";
								//Manda o usuario para a tela de login
								header("Location: proj_tcc.php");
							}else{
								$_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
																		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
																		
																		Error: ".mysqli_error($conectar)."
																	</div> 
															   	";
								header("Location: proj_tcc.php");
							}
			}
			 ?>

  
<!-- Inicio Modal Apagar -->
				<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
				<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				<h4 class="modal-title custom_align" id="Heading">Eliminar Tema</h4>
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

	$query=mysqli_query($conectar,"DELETE FROM projecto_tcc WHERE id='$id'");
	if ($query) 
					/*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, tema,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$tema $apelido', '$senha', 'Activo', '2', NOW())");
					if ($inserir1)*/{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															Tema eliminado com sucesso!.
														</div>
												   	";
					//Manda o usuario para a tela de login
					header("Location: proj_tcc.php");
				}else{
					$_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
												   	";
					header("Location: proj_tcc.php");
				}
}
 ?>

<?php
	include_once("rodape.php");
?>

<?php
	if(isset($_POST['Estado'])){
		echo '';
	}
?>
    
<!-- Inicio Modal Editar -->
 <div id="editar_proj_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
     
      <div class="modal-content">
          <div class="modal-header">            
            <h4 class="modal-title">Editar dados do Projecto</h4>
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
              <label>Tema</label>
              <input type="text" id="tema" name="tema" maxlength="200" class="form-control"  required>
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <textarea id="descricao" name="descricao" maxlength="400" class="form-control" ></textarea>
            </div>
            
            <div class="form-group">
				<label>Carregar</label>
				<input type="file" id="proj_file" name="proj_file" class="form-control"  required>
			</div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit"  class="btn btn-info" name="editar_proj_modal" value="Save">
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
if(isset($_POST['editar_proj_modal'] )){
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