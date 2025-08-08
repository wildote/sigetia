<?php
require_once '_db.php';
require_once 'conexao.php';

if(!isset($_SESSION))
{
   session_start();
}

$stmt = $db->prepare("INSERT INTO reservations (name, start, end, room_id, status, paid, `empresa`, `modo_pagamento`, `valor_pago`, `Celular`, `email`, `N_Adultos`, `N_Criancas`, `DataReserva`, `usuarioReserva`, `usuarioAtualizacao`) VALUES (:name, :start, :end, :room, 'Nova reserva', 0,:empresa, :modo_pagamento, :valor_pago,  :Celular, :email, :Adultos, :Criancas, NOW(), :usuarioReserva, :usuarioAtualizacao)");
if($_POST['valor_pago']=="" or $_POST['valor_pago']==null){
    $valor_pago=0;
}
if (isset($_POST['reservaOnline'])) {
	$id = $_POST["id"];
	$query=mysqli_query($conectar,"SELECT * FROM reservas WHERE id='$id'");
	$linhas = mysqli_fetch_assoc($query);
    $modo_pagamento="Presencial";
	$stmt->bindParam(':start', $linhas['CheckIn']);
	$stmt->bindParam(':end', $linhas['CheckOut']);
	$stmt->bindParam(':name', $linhas['Nome']);
	$stmt->bindParam(':room', $_POST['room']);
	$stmt->bindParam(':Celular', $linhas['Celular']);
	$stmt->bindParam(':empresa', $linhas['empresa']);
	$stmt->bindParam(':modo_pagamento', $modo_pagamento);
	$stmt->bindParam(':valor_pago', $valor_pago);
	$stmt->bindParam(':email', $linhas['email']);
	$stmt->bindParam(':Adultos', $linhas['N_Adultos']);
	$stmt->bindParam(':Criancas', $linhas['N_Criancas']);
	$stmt->bindParam(':usuarioReserva',$_SESSION['usuarioId']);
	$stmt->bindParam(':usuarioAtualizacao',$_SESSION['usuarioId']);
	$room_id=$_POST['room'];
	$CheckIn=$linhas['CheckIn'];
	$CheckOut=$linhas['CheckOut'];
	$sql=mysqli_query($conectar,"SELECT * FROM reservations WHERE room_id='$room_id' AND end BETWEEN '$CheckIn' AND end");
	$sql1=mysqli_query($conectar,"SELECT * FROM reservations WHERE room_id='$room_id' AND start BETWEEN start AND '$CheckOut'");
	if (mysqli_num_rows($sql)>0 && mysqli_num_rows($sql1)>0) {
		class Result {}
		$response = new Result();
		$response->result = 'O cómodo ja esta reservado para estes dias, escolha um outro cómodo por favor!';
		$_SESSION['mensagem'] = "
													
														<div class='alert alert-danger' role='alert'>
															<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
															O cómodo ja esta reservado para estes dias, escolha um outro cómodo por favor.
														</div>
												   	";
					//Manda o usuario para a tela de login
					header("Location: Reservas.php");		
	}else {
		$stmt->execute();
		class Result {}
		$response = new Result();
		$response->result = 'OK';
		$response->message = 'Criado com o id: '.$db->lastInsertId();
		$response->id = $db->lastInsertId();
		
		$stmt = $db->prepare("DELETE FROM reservas WHERE id = :id");
		$stmt->bindParam(':id', $_POST['id']);
		$stmt->execute();
			header("Location: index2.php");		
	}

}else {
	
	$stmt->bindParam(':start', $_POST['start']);
	$stmt->bindParam(':end', $_POST['end']);
	$stmt->bindParam(':name', $_POST['name']);
	$stmt->bindParam(':room', $_POST['room']);
	$stmt->bindParam(':Celular', $_POST['Celular']);
	$stmt->bindParam(':empresa', $_POST['empresa']);
	$stmt->bindParam(':modo_pagamento', $_POST['modo_pagamento']);
	$stmt->bindParam(':valor_pago', $valor_pago);
	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':Adultos', $_POST['Adultos']);
	$stmt->bindParam(':Criancas', $_POST['Criancas']);
	$stmt->bindParam(':usuarioReserva',$_SESSION['usuarioId']);
	$stmt->bindParam(':usuarioAtualizacao',$_SESSION['usuarioId']);
	$stmt->execute();
		class Result {}

		$response = new Result();
		$response->result = 'OK';
		$response->message = 'Criado com o id: '.$db->lastInsertId();
		$response->id = $db->lastInsertId();
}
	
	

header('Content-Type: application/json');
echo json_encode($response);

?>
