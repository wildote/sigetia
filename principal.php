<?php
if(!isset($_SESSION))
{
   session_start();
}
include_once("seguranca.php");
include_once("conexao.php");
date_default_timezone_set('Africa/Johannesburg');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="SisTCC">
<meta name="author" content="Haggy Manjolo">
<meta name="viewport" content="width=device-width, initial-scale=1">
    

<title>Sistema de Gestão de TIA</title>
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.css">
		<!-- <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet"> -->
		<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
		<link type="text/css" href="bootstrap/css/manjolo.css" rel="stylesheet">
		<link type="text/css" href="bootstrap/css/side.css" rel="stylesheet">
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="bootstrap/js/manjolo.js"></script>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/animate.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript" charset="utf-8" ></script>

		<link id="t-colors" href="bootstrap/skins/default.css" rel="stylesheet" />

		<link href="fonts/css/all.css" rel="stylesheet" />
		<link href="fonts/css/brands.css" rel="stylesheet" />
		<link href="fonts/css/fontawesome.css" rel="stylesheet" />

		<script src="fonts/js/all.js"></script>
		<script src="fonts/js/brands.js"></script>
		<script src="fonts/js/fontawesome.js"></script>
		<script src="fonts/js/regular.js"></script>
		<script src="fonts/js/solid.js"></script>
		<script src="fonts/js/svg-with-js.js"></script>
    



		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
	@media (min-width: 765px) {
		
	
	table.table td a:hover {
		color: #2196F3;
	}
	table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #F44336;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table .avatar {
		border-radius: 50%;
		vertical-align: middle;
		margin-right: 10px;
	}
	.add-new {

       
		border-radius: 50px;
    }
    .modal .modal-dialog {
    max-width: 400px;
  }
  .modal .modal-header, .modal .modal-body, .modal .modal-footer {
    padding: 20px 30px;
  }
  .modal .modal-content {
    border-radius: 3px;
  }
  .modal .modal-footer {
    background: #ecf0f1;
    border-radius: 0 0 3px 3px;
  }
    .modal .modal-title {
        display: inline-block;
    }
  .modal .form-control {
    border-radius: 2px;
    box-shadow: none;
    border-color: #dddddd;
  }
  .modal textarea.form-control {
    resize: vertical;
  }
  .modal .btn {
    border-radius: 2px;
    min-width: 100px;
  } 
  .modal form label {
    font-weight: normal;
  }
}
</style>

<style type="text/css" media="screen">
  body,html{
    height: 100%;
  }

  nav.sidebar, .main{
    -webkit-transition: margin 200ms ease-out;
      -moz-transition: margin 200ms ease-out;
      -o-transition: margin 200ms ease-out;
      transition: margin 200ms ease-out;
  }
  
  .main{
    padding: 10px 10px 0 10px;
  }

 @media (min-width: 765px) {

    .main{
      position: absolute;
      width: calc(100% - 40px); 
      margin-left: 40px;
      float: right;
    }

    nav.sidebar:hover + .main{
      margin-left: 200px;
    }
    nav.sidebar:hover + .co{
      margin-left: -200px;
    }

    nav.sidebar.navbar.sidebar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
      margin-left: 0px;
    }

    nav.sidebar .navbar-brand, nav.sidebar .navbar-header{
      text-align: center;
      width: 100%;
      margin-left: 0px;
    }
    
    nav.sidebar a{
      padding-right: 13px;
    }

    nav.sidebar .navbar-nav > li:first-child{
      border-top: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav > li{
      border-bottom: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav .open .dropdown-menu {
      position: absolute;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: transparent;
      border: 0;
      -webkit-box-shadow: none;
      box-shadow: none;
    }

    nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
      padding: 0 0px 0 0px;
    }

    .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
      color: #777;
    }

    nav.sidebar{
      width: 200px;
      height: 100%;
      margin-left: -160px;
      float: left;
      margin-bottom: 0px;
    }

    nav.sidebar li {
      width: 100%;
    }

    nav.sidebar:hover{
      margin-left: 0px;
    }

    .forAnimate{
      opacity: 0;
    }
    .divH{
      margin-top: -10px; 
      margin-bottom: -10px;
    }
  }
   #owlreporter-preloader {
      background: transparent;
     }
</style>

</head>
<body role="document" onload="preloader()">
<?php 	require_once("menu.php");
        require_once("P_Menu.php");
        
		//include_once("rodape.php");

        if(isset($_SESSION['mensagem'])){
          echo $_SESSION['mensagem'];
          unset($_SESSION['mensagem']);
        }
?>
<div id="preloader"></div>
<script src="bootstrap/js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>

<!-- Preloader -->
    <link href="preloader/preloader.css" rel="stylesheet">
    <script src="preloader/preloader.js"></script>