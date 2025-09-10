<?php
require("connector.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura dos campos do formulário
    $chamado           = $_POST['chamado'] ?? null;
    $patrimonio        = $_POST['patrimonio'] ?? null;
    $rq                = $_POST['rq'] ?? null;
    $modelo            = $_POST['modelo_equipamento'] ?? null;
    $nomeColaborador   = $_POST['nome_colaborador'] ?? null;
    $cr                = $_POST['cr'] ?? null;
    $data              = $_POST['data'] ?? null;
    $tipoChamado       = $_POST['tipo_chamado'] ?? null;
    $status            = $_POST['status'] ?? null;

    // Validação simples
    if ($chamado && $patrimonio && $rq && $modelo && $nomeColaborador && $cr && $data && $tipoChamado && $status) {
        try {
            // Query preparada
            $query = "INSERT INTO chamados 
                (chamado, patrimonio, rq, modelo_equipamento, nome_colaborador, cr, data, tipo_chamado, status) 
                VALUES 
                (:chamado, :patrimonio, :rq, :modelo, :nomeColaborador, :cr, :data, :tipoChamado, :status)";

            $stmt = $pdo->prepare($query);

            // Executa com os valores
            $stmt->execute([
                ':chamado'         => $chamado,
                ':patrimonio'      => $patrimonio,
                ':rq'              => $rq,
                ':modelo'          => $modelo,
                ':nomeColaborador' => $nomeColaborador,
                ':cr'              => $cr,
                ':data'            => $data,
                ':tipoChamado'     => $tipoChamado,
                ':status'          => $status
            ]);

            // Redireciona com sucesso
            header("Location: index.php?criado=sucesso");
            exit;

        } catch (PDOException $e) {
            echo "❌ Erro ao salvar chamado: " . $e->getMessage();
        }
    } else {
        echo "⚠️ Todos os campos são obrigatórios!";
    }
}
