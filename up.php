
<?PHP
include_once("principal.php");
$idUsuario = $_SESSION['usuarioLogin'];
$nome= $_SESSION['usuarioNome']; 
  if(isset($_FILES['proj_file'] )){
    $tema=$_POST['tema'];
    $supervisor=$_POST['supervisor'];
    $descricao=$_POST['descricao'];
    $path = "uploads/projectos/";
    $file_name=explode('.', basename( $_FILES['proj_file']['name']));
    $file_name=array_pop($file_name);
    $path = $path .$nome.'_'. md5($_SESSION['usuarioLogin']) .'.'. $file_name;
    $file=0;
    try {
      if (move_uploaded_file($_FILES['proj_file']['tmp_name'], $path)) {
        $sql=mysqli_query($conectar,"INSERT INTO `projecto_tcc` (`tema`, `descricao`, `idSupervisor`, `url`, `idUsuario`) VALUES ('$tema', '$descricao', '$supervisor', '$path', '$idUsuario')");
      $notificacao=mysqli_query($conectar,"INSERT INTO `notificacoes`(`Titulo`, `Texto`, `id_nivel_acesso`, `id_Usuario`, `id_Destinatario`, `Estado`) VALUES ('Novo projecto de TCC foi adicionado!','Novo projecto de TCC foi adicionado!',1,'$idUsuario','','1')");
      };
      if ($sql) {
        $_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
                              Projecto submetido com sucesso!
                            </div>
                            ";
      }else{
        $_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
                              ". mysqli_error($conectar)."
                            </div>
                            ";
      }

    } catch (Exception $e) {
      $_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert'>
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
                              ".$e."
                            </div>
                            ";
    }
    header("Location: proj_tcc.php");
  }
?>
