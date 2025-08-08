<?php
include_once("principal.php");
	$idUsuario = $_GET['idUsuario'];
	$Estado = $_GET['Estado'];
	
	
	if($Estado==='Activo'){
		$sql = mysqli_query($conectar,"UPDATE tabela_usuarios SET estado = 'Desativado' WHERE tabela_usuarios.idUsuario = '$idUsuario'");
	}else{
		$sql = mysqli_query($conectar,"UPDATE tabela_usuarios SET estado = 'Activo' WHERE tabela_usuarios.idUsuario = '$idUsuario'");
	}
	if ($sql){
		$_SESSION['mensagem'] ="
													<div class='col-md-9 col-md-offset-0'>
														<div class='alert alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
															Usuario foi activado com sucesso!
														</div>
												   	</div>
											   	";
			header("Location: listarUsuarios.php");
            
	}else{
		$_SESSION['mensagem'] ="
													<div class='alert alert-danger' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															
															Error: ".mysqli_error($conectar)."
														</div> 
											   	";
			header("Location: listarUsuarios.php");
	}
?>