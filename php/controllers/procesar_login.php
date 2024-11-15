<?php
include '../helped/db.php';

$tipo_usuario = $_POST['tipo_usuario'];
$contrasena = $tipo_usuario == 'experto' ? $_POST['contrasenaE'] : $_POST['contrasenaU'];

if ($tipo_usuario == 'experto') {
    $stmt = $pdo->prepare("SELECT * FROM experto WHERE ContrasenaAE = :contrasena");
} else {
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE ContrasenaU = :contrasena");
}

$stmt->execute(['contrasena' => $contrasena]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta, vuelve a intentarlo']);
}
?>
