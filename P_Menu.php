
<br class="hidden-xs hidden-sm">
<br class="hidden-xs hidden-sm">
<br class="hidden-xs hidden-sm">
<br class="hidden-xs hidden-sm">
<nav class="navbar navbar-default sidebar"  role="navigation" style="z-index: 1;">
  	<div class="container-fluid">
    	<div class="row-fluid">
      		<div class="navbar-header">
  		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
  		        <span class="sr-only">Toggle navigation</span>
  		        <span class="icon-bar"></span>
  		        <span class="icon-bar"></span>
  		        <span class="icon-bar"></span>
  		      </button>      
      		</div>
  		    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
  		      <ul class="nav navbar-nav">
  		       <li class=""><a href="inicio.php">Início<span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-home"></span></a></li>
             <li class=""><a href="actividades.php">Actividades<span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-bookmark"></span></a></li>
    <?php if ($_SESSION['usuarioNivelAcesso'] == 1 || $_SESSION['usuarioNivelAcesso'] == 5) { ?>
            <li class=""><a href="listarUsuarios.php">Usuários<span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-user"></span></a></li>
             <!-- <li class=""><a href="cursos.php">Cursos<span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-list-alt"></span></a></li> -->
    <?php } ?> 
            <li class=""><a href="temas.php">Temas<span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-pencil"></span></a></li>
            <li class=""><a href="proj_tcc.php">Projectos <span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-book"></span></a></li>
            <li class=""><a href="monografia.php">Monografias<span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-list"></span></a></li>
  		             
  		      </ul>
  		    </div>
  		</div>
  	</div>
</nav>