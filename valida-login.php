<?php
session_start();
$usuariot = $_POST['usuario'];
$senhat = $_POST['senha'];

date_default_timezone_set('Africa/Johannesburg');
$hoje=DATE('Y-m-d H:m:s');
require_once 'conexao.php';

$senhat = md5($_POST['senha']);
$result = mysqli_query($conectar,"SELECT * FROM tabela_usuarios WHERE idUsuario='$usuariot' AND senha='$senhat' AND estado='Activo' LIMIT 1");
$resultado = mysqli_fetch_assoc($result);
//echo "Usuario: ".$resultado['nome'];
if($resultado==""){
	//Mensagem de Erro
	$_SESSION['loginErro'] = "<br>
								
								Usuário ou Senha Inválido
										
							  <br>";
	
	//Manda o usuario para a tela de login
	header("Location: index.php");
}else{
	//Define os valores atribuidos na sessao do usuario
	$usuario= $resultado['idUsuario'];
	if ($_POST['usuario']!="sombra") {
		$insert=mysqli_query($conectar,"INSERT INTO `login`(`usuario`, `data`) VALUES ('$usuario','$hoje')");
	}
	
	$_SESSION['usuarioId'] 			= $resultado['idUsuario'];
	$_SESSION['usuarioNome'] 		= $resultado['nome'];
	
	$_SESSION['usuarioSenha'] 		= $resultado['senha'];
	 
	$_SESSION['usuarioLogin'] 		= $resultado['idUsuario'];
	$_SESSION['usuarioNivelAcesso'] = $resultado['idNivelAcesso'];
	if($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 2  || $_SESSION['usuarioNivelAcesso'] == 3  || $_SESSION['usuarioNivelAcesso'] == 5){
        header("Location: inicio.php");
	}//*else{
		//*header("Location: portal.php");
	//}
}
?>