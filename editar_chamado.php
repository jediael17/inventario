<?php
require("connector.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false, 'message'=>'Método inválido']);
    exit;
}

$id = $_POST['id'] ?? null;
$chamado = trim($_POST['chamado'] ?? '');
$patrimonio = trim($_POST['patrimonio'] ?? '');
$rq = trim($_POST['rq'] ?? '');
$modelo = trim($_POST['modelo_equipamento'] ?? '');
$colaborador = trim($_POST['nome_colaborador'] ?? '');
$cr = trim($_POST['cr'] ?? '');
$data = trim($_POST['data'] ?? '');
$tipo = trim($_POST['tipo_chamado'] ?? '');
$status = trim($_POST['status'] ?? '');

if (!$id) {
    echo json_encode(['success'=>false, 'message'=>'ID inválido']);
    exit;
}

$timestamp = strtotime($data);
if (!$timestamp) {
    echo json_encode(['success'=>false, 'message'=>'Data inválida']);
    exit;
}
$dataFormatada = date('Y-m-d', $timestamp);

try {
    $stmt = $pdo->prepare("UPDATE chamados SET
        chamado = :chamado,
        patrimonio = :patrimonio,
        rq = :rq,
        modelo_equipamento = :modelo,
        nome_colaborador = :colaborador,
        cr = :cr,
        data = :data,
        tipo_chamado = :tipo,
        status = :status
        WHERE id = :id
    ");

    $stmt->execute([
        ':chamado' => $chamado,
        ':patrimonio' => $patrimonio,
        ':rq' => $rq,
        ':modelo' => $modelo,
        ':colaborador' => $colaborador,
        ':cr' => $cr,
        ':data' => $dataFormatada,
        ':tipo' => $tipo,
        ':status' => $status,
        ':id' => $id
    ]);

    echo json_encode(['success'=>true]);
} catch (PDOException $e) {
    echo json_encode(['success'=>false, 'message'=>$e->getMessage()]);
}
