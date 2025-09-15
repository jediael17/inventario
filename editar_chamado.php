<?php
require("connector.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'] ?? null;
    $chamado = $_POST['chamado'] ?? '';
    $patrimonio = $_POST['patrimonio'] ?? '';
    $rq = $_POST['rq'] ?? '';
    $modelo = $_POST['modelo_equipamento'] ?? '';
    $colaborador = $_POST['nome_colaborador'] ?? '';
    $cr = $_POST['cr'] ?? '';
    $data = $_POST['data'] ?? '';
    $tipo = $_POST['tipo_chamado'] ?? '';
    $status = $_POST['status'] ?? '';

    if($id){
        try{
            $stmt = $pdo->prepare("UPDATE chamados SET
                chamado=:chamado,
                patrimonio=:patrimonio,
                rq=:rq,
                modelo_equipamento=:modelo,
                nome_colaborador=:colaborador,
                cr=:cr,
                data=:data,
                tipo_chamado=:tipo,
                status=:status
                WHERE id=:id
            ");
            $stmt->execute([
                ':chamado'=>$chamado,
                ':patrimonio'=>$patrimonio,
                ':rq'=>$rq,
                ':modelo'=>$modelo,
                ':colaborador'=>$colaborador,
                ':cr'=>$cr,
                ':data'=>$data,
                ':tipo'=>$tipo,
                ':status'=>$status,
                ':id'=>$id
            ]);
            echo json_encode(['success'=>true]);
        } catch(PDOException $e){
            echo json_encode(['success'=>false, 'message'=>$e->getMessage()]);
        }
    } else {
        echo json_encode(['success'=>false, 'message'=>'ID inválido']);
    }
} else {
    echo json_encode(['success'=>false, 'message'=>'Método inválido']);
}
