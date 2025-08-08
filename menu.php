<?php
              $idUsuario = $_SESSION['usuarioLogin'];
              $Nivelacesso=$_SESSION['usuarioNivelAcesso'];
              //Executa consulta
              $result = mysqli_query($conectar,"SELECT * FROM tabela_usuarios WHERE idUsuario = '$idUsuario' LIMIT 1");
              $resultado = mysqli_fetch_assoc($result);
              
              
              
              
?>  


<nav class=" navbar-inverse " onload="" >
  <div class="row-fluid">
      <div class="panel navbar with-nav-tabs navbar-fixed-top" >
        <div class="panel-heading" style="background-color: #274055ff;">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
                                
            </button>
                <a class="navbar-brand" href="inicio.php"><span style="color: #fff; font-size: 25px; "><label>SGM</label></span></span></a>
          </div> 
                  <div id="navbar-collapse" class="collapse navbar-collapse justify-content-start">
            <ul class="nav navbar-nav" >
              
              
              
              <?php 
                 $idNivel_acesso=$_SESSION['usuarioNivelAcesso'];
                 $idUsuario=$_SESSION['usuarioId'];
                  if ($_SESSION['usuarioNivelAcesso']=="1"||$_SESSION['usuarioNivelAcesso']=="5"){
                ?>
                  <li ><a href="mensagens.php"><span class="glyphicon glyphicon-envelope" style="color: #040e17ff; font-size:15px;"> Notificação</span></a></li>
                <?php
                  }else{
                ?>
                  <li ><a href="#msg" data-toggle="modal" data-toggle="tooltip"><span class="glyphicon glyphicon-envelope list-group-item-text"  style="color: #fff; font-size:18px;"> Reportar</span></a></li>
                <?php } ?>
            </ul>
                   <?php 
                      
                      
                      $idUsuario=$_SESSION['usuarioId'];
                      $novasNotificacoes=mysqli_query($conectar,"SELECT * FROM `notificacoes` where (id_nivel_acesso='$idNivel_acesso' OR id_Destinatario='$idUsuario') && Estado='1' ORDER BY Data DESC");
                      $notificacoes=mysqli_query($conectar,"SELECT * FROM `notificacoes` where (id_nivel_acesso='$idNivel_acesso' OR id_Destinatario='$idUsuario') && Estado='0' ORDER BY Data DESC");
                      
                  ?>
            <ul class="nav navbar-nav navbar-right ml-auto">
              <li class="nav-item"><a href="#verNotificacoes" data-toggle="modal" data-toggle="tooltip" style="color: #fff; font-size:18px;" class="nav-link notifications"><i class="fa fa-bell"> </i><span class=""><?php echo ' '.mysqli_num_rows($novasNotificacoes); ?></span></a></li>
              <li class="nav-item hidden"><a href="#" style="color: #fff; font-size:18px" class="nav-link messages"><i class="fa fa-envelope"> </i> <span class="badge"></span></a></li>
              <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" style="color: #fff; font-size:18px; background: transparent;" class="nav-link dropdown-toggle user-action"> <?php echo $_SESSION['usuarioNome']; ?><b class="caret"></b></a>
                <ul class="dropdown-menu" >
                  <li><a href="#usuarioModal" style="color: #000;" class="dropdown-item" data-toggle="modal"><i class="fa fa-user fa-fw" data-toggle="tooltip" title="Usuario"></i> Perfil</a></li>
                  <li><a href="#alterarsenhaModal" style="color: #000;" class="dropdown-item" data-toggle="modal"><i class="fa fa-cog fa-fw" data-toggle="tooltip" title="Alterar senha"></i> Alterar Senha</a></li>
                  <li class="divider dropdown-divider"></li>
                  <li><a href="sair.php" class="dropdown-item" style="color: #000;"><i class="fa fa-sign-out-alt fa-fw"></i> Sair</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
  </div>
</nav>
    


<div class="modal fade" id="verNotificacoes" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header ">
        <button type="submit" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align " ><span class="glyphicon glyphicon-bell"></span> Notificações</h4>
      </div>
      <form name="form" method="POST" action=".php">
        <div class="modal-body">
          <input type="hidden" name="idUsuario" class="form-control" id="id"> 
          <?php if (mysqli_num_rows($novasNotificacoes)>0) {
         $sql=mysqli_query($conectar,"UPDATE `notificacoes` SET `Estado` = '0' WHERE (id_nivel_acesso='$idNivel_acesso' OR id_Destinatario='$idUsuario') && Estado='1'");
          while ($verquery=mysqli_fetch_assoc($novasNotificacoes)) { 
          ?>
          <div class="alert alert-info"><span class="glyphicon glyphicon-bell"></span>
          <button type="submit" name="apagar" data-dismiss="alert" class="close text-center"> <span aria-hidden="true"></span><span class="" style="font-size: 12px;" ></span></button>
          <?php  
              echo $verquery['Texto'];
          ?>
          <hr style="margin: 2px ;">
          </div> <?php } 
          }else{ ?>
          <div class="alert alert-info">Não tens nenhuma notificação!</div>
        <?php 
          }
        ?>
        </div>
        <div class="modal-footer ">
          <button type="button"  data-dismiss="modal" aria-hidden="true" class="btn btn-default" ><span class="glyphicon glyphicon-remove"></span> Fechar</button>
        </div>
      </form>
      </div> 
    </div>
  </div> 
        <!-- Fim Modal -->

<!-- usuario Modal HTML -->
  <div id="usuarioModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        
          <div class="modal-header">            
            <h4 class="modal-title">Dados pessoais</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <form action="" method="POST" name="form3">
          <br>
          <div class="text-center"><i class="fa fa-user fa-7x fa-fw"></i></div>
          <div class="modal-body">   
                
            <div class="form-group">
              <label>Nome Completo(*)</label>
              <input type="text" readonly class="form-control" name="nome" value="<?php  echo $resultado['nome'] ?>" required>
            </div>
            <div class="form-group">
              <label>Usuário(*)</label>
              <input type="text" class="form-control" name="idUsuario" maxlength="" value="<?php  echo $resultado['idUsuario'] ?>" required>
            </div>
            <div class="form-group">
              <label>Curso(*)</label>
              <input type="text" readonly class="form-control" name="curso" value="<?php  echo $resultado['curso'] ?>" required>
            </div>
            
            <div class="form-group">
              <label>Celular(*)</label>
              <input type="text" class="form-control" name="celular"  maxlength="9" value="<?php  echo $resultado['celular'] ?>" required>
            </div>
            <div class="form-group">
              <label>Email(*)</label>
              <input type="email" class="form-control" name="email" maxlength="40" value="<?php  echo $resultado['email'] ?>" required>
            </div>         
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" name="Cancel" value="Cancel">
            <input type="submit" class="btn btn-info" name="usuarioModal" value="Gravar">
          </div>
        </form>
      </div>
    </div>
  </div>

<!-- Reportar um problema Modal HTML -->
  <div id="msg" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        
          <div class="modal-header">            
            <h4 class="modal-title">Reportar um problema</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <form action="" method="POST" name="msgGravar">
          <br>
          <div class="text-center"><i class="glyphicon glyphicon-envelope fa-7x fa-fw"></i></div>
          <div class="modal-body">   
                
            <div class="form-group">
              <label>Assunto(*)</label>
              <input type="text" class="form-control" name="assunto" value="" required>
            </div>
            <div class="form-group">
              <label>Mensagem(*)</label>
              <textarea class="form-control" name="msg" required=""></textarea>
            </div>
                  
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" name="Cancel" value="Cancel">
            <input type="submit" class="btn btn-info" name="msgGravar" value="Gravar">
          </div>
        </form>
      </div>
    </div>
  </div>

<!-- Alterar senha modal Modal HTML -->
  <div id="alterarsenhaModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="POST" name="alterarsenhaModal">
          <div class="modal-header">            
            <h4 class="modal-title">Alterar senha</h4>
            <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <br>
          <div class="text-center"><i class="fa fa-cog fa-7x fa-fw"></i></div>
          <div class="modal-body">    
            <div class="form-group">
              <label>Nome Completo</label>
              <input type="text" readonly="" class="form-control" value="<?php  echo $resultado['nome'] ?>" required>
              <input type="hidden" class="form-control" name="idUsuario" maxlength="" value="<?php  echo $resultado['idUsuario'] ?>" required>
            </div>     
            <div class="form-group">
              <label>Senha actual(*)</label>
              <input type="password" class="input sm form-control" name="senha" placeholder="Senha actual" required>
            </div>
            <div class="form-group">
              <label>Nova senha(*)</label>
              <input type="password" class="input sm form-control" name="nova_senha" placeholder="Nova Senha" required>
            </div>
                     
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <button type="submit" class="btn btn-info" name="alterarsenhaModal">Ok</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php 

  if (isset($_POST['alterarsenhaModal'])) {
      $idUsuario        = $_POST["idUsuario"];
      $senha        = md5($_POST['senha']);
      $nova_senha     = md5(ltrim(rtrim($_POST['nova_senha'])));

      $sql= mysqli_query($conectar,"SELECT * FROM tabela_usuarios WHERE idUsuario='$idUsuario' AND senha='$senha'");
      if(mysqli_fetch_assoc($sql)!=""){

        $query = mysqli_query($conectar,"UPDATE `tabela_usuarios` SET `senha` = '$nova_senha', dataModificacao = NOW() WHERE `tabela_usuarios`.`idUsuario` ='$idUsuario'");
        if ($query) {
          $_SESSION['mensagem'] = "
                                <div class='alert alert-success' role='alert'> 
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  Senha actualizado com sucesso
                                </div>";
        } else {
          $_SESSION['mensagem'] = "
                                <div class='alert alert-danger' role='alert'> 
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  Error:".mysqli_error($conectar)."
                                </div>";
        }
      }else{
          $_SESSION['mensagem'] = "
                                <div class='alert alert-danger' role='alert'> 
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  A senha actual esta incorrecta. Por favor contactar o administrador caso tenha esquecido a sua senha.
                                </div>";
      }header("Refresh: 2");
  }

if(isset($_POST['usuarioModal'] )){
  $idUsuario    = $_SESSION['usuarioLogin'];
  $novoIdUsuario= $_POST["idUsuario"];
  $email        = $_POST["email"];
  $celular      = $_POST["celular"]; 
  $query = mysqli_query($conectar,"UPDATE tabela_usuarios set idUsuario='$novoIdUsuario' ,email ='$email', celular = '$celular', dataModificacao = NOW() WHERE idUsuario='$idUsuario'");
  if ($query) 
          /*$inserir1 = mysqli_query($conectar,"INSERT INTO tabela_usuarios (idUsuario, nome,senha, estado, idNivelAcesso , dataCadastro) VALUES ('$email', '$nome $apelido', '$senha', 'Activo', '2', NOW())");
          if ($inserir1)*/{
          $_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
                              Usuário editado com sucesso
                            </div>
                            ";
        }else{
          $_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert' >
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
                              
                              Error: ".mysqli_error($conectar)."
                            </div> 
                            ";
          
        }header("Refresh: 1");
}

if(isset($_POST['msgGravar'] )){
  $idUsuario    = $_SESSION['usuarioLogin'];
  $assunto= $_POST["assunto"];
  $msg        = $_POST["msg"]; 
  $query = mysqli_query($conectar,"INSERT INTO `mensagens`(`assunto`, `msg`, `idUsuario`) VALUES ('$assunto','$msg','$idUsuario')");
  if ($query){
          $_SESSION['mensagem'] = "<div class='alert  alert-success' role='alert'>
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
                              Mensagem enviada com sucesso
                            </div>
                            ";
        }else{
          $_SESSION['mensagem'] = "<div class='alert  alert-danger' role='alert' >
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
                              
                              Error: ".mysqli_error($conectar)."
                            </div> 
                            ";
          
        }header("Refresh: 1");
}

?>
 <script type="text/javascript">
          /*if (window.history.replaceState) {
            window.history.replaceState(null,null,window.location.href);
          }*/

</script>