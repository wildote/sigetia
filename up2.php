<?PHP
include_once("principal.php");
$idUsuario = $_SESSION['usuarioLogin'];
$nome= $_SESSION['usuarioNome']; 
  if(isset($_FILES['mono_file'] )){
    $tema=$_POST['tema'];
    $id=$_POST['id'];
    $sql=mysqli_query($conectar,"SELECT * FROM `monografias` JOIN tabela_usuarios ON monografias.idUsuario=tabela_usuarios.idUsuario WHERE id='$id'");
    $rs=mysqli_fetch_assoc($sql);
    $idSupervisor=$rs['idSupervisor'];
    $estudante=$rs['nome'];
    $estudante_usuario=$rs['idUsuario'];
    $descricao=$_POST['descricao'];
    $path = "uploads/monografias/";
    $file_name=explode('.', basename( $_FILES['mono_file']['name']));
    $file_name=array_pop($file_name);
    $path = $path .$nome.'_'. md5($_SESSION['usuarioLogin']) .'.'. $file_name;
    if(move_uploaded_file($_FILES['mono_file']['tmp_name'], $path)) {
      mysqli_query($conectar,"UPDATE `monografias` SET `url`= '$path' WHERE id ='$id'");
      mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_nivel_acesso`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('Nova Monografia foi adicionada!','Nova Monografia foi adicionada!','1','$idUsuario','','1')");
      mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('Monografia carregada!','A monografica do supervisionando, $estudante foi carregada!','$idUsuario','$idSupervisor','1')");
      $_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															O ficheiro foi carregado com sucesso!
														</div>
												   	";
    } else{
        $_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															". mysqli_error($conectar)."
														</div>
												   	";
    }
    header("Location: monografia.php");
  }
?>