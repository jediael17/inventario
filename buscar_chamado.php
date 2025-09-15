<?php
require("connector.php");
header('Content-Type: application/json');

$q = $_GET['q'] ?? '';

try {
    if($q){
        $stmt = $pdo->prepare("SELECT * FROM chamados 
            WHERE chamado LIKE :q 
               OR rq LIKE :q 
               OR nome_colaborador LIKE :q 
            ORDER BY id DESC");
        $stmt->execute([':q'=>"%$q%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM chamados ORDER BY id DESC");
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch(PDOException $e){
    echo json_encode(['error'=>$e->getMessage()]);
}
