<?php
require("connector.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $chamado = $_POST['chamado'] ?? '';
    $patrimonio = $_POST['patrimonio'] ?? '';
    $rq = $_POST['rq'] ?? '';
    $modelo = $_POST['modelo_equipamento'] ?? '';
    $colaborador = $_POST['nome_colaborador'] ?? '';
    $cr = $_POST['cr'] ?? '';
    $data = $_POST['data'] ?? '';
    $tipo = $_POST['tipo_chamado'] ?? '';
    $status = $_POST['status'] ?? '';

    try {
        $stmt = $pdo->prepare("INSERT INTO chamados 
            (chamado, patrimonio, rq, modelo_equipamento, nome_colaborador, cr, data, tipo_chamado, status) 
            VALUES (:chamado, :patrimonio, :rq, :modelo, :colaborador, :cr, :data, :tipo, :status)");
        
        $stmt->execute([
            ':chamado' => $chamado,
            ':patrimonio' => $patrimonio,
            ':rq' => $rq,
            ':modelo' => $modelo,
            ':colaborador' => $colaborador,
            ':cr' => $cr,
            ':data' => $data,
            ':tipo' => $tipo,
            ':status' => $status
        ]);

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
