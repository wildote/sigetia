<?php
require_once '_db.php';
require_once 'conexao.php';
if(!isset($_SESSION))
{
   session_start();
}

$id=$_POST['id'];
$result = mysqli_query($conectar,"SELECT * FROM reservations WHERE id = '$id' LIMIT 1");
$resultado = mysqli_fetch_assoc($result);
if (trim($resultado['status'])!=trim("Confirmada") OR $_SESSION['usuarioNivelAcesso']==1) {
	$stmt = $db->prepare("DELETE FROM reservations WHERE id = :id");
	$stmt->bindParam(':id', $_POST['id']);
	$stmt->execute();

	class Result {}

	$response = new Result();
	$response->result = 'OK';
	$response->message = 'Eliminado com sucesso';
}


header('Content-Type: application/json');
echo json_encode($response);

?>
