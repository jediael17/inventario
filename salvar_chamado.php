<?php
// Configuração do banco
$host = "192.168.121.33";
$port = "3306";
$user = "adm_inventario";
$pass = "webserver";
$dbname = "inventario";

// Conexão
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Gerar ID aleatório
$id = uniqid("ch_");

// Receber dados do formulário
$chamado = $_POST['chamado'];
$patrimonio = $_POST['patrimonio'];
$rq = $_POST['rq'];
$modelo_equipamento = $_POST['modelo_equipamento'];
$nome_colaborador = $_POST['nome_colaborador'];
$cr = $_POST['cr'];
$data = $_POST['data'];
$tipo_chamado = $_POST['tipo_chamado'];
$status = $_POST['status'];

// Inserir no banco
$sql = "INSERT INTO chamados (id, chamado, patrimonio, rq, modelo_equipamento, nome_colaborador, cr, data, tipo_chamado, status)
        VALUES ('$id', '$chamado', '$patrimonio', '$rq', '$modelo_equipamento', '$nome_colaborador', '$cr', '$data', '$tipo_chamado', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "Chamado registrado com sucesso! <a href='form_chamado.html'>Voltar</a>";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>
