<?php
// Configurações de conexão
$usuario = 'admin_inventario';
$senha   = 'webserver';
$dbname  = 'inventario';
$host    = '192.168.121.33';
$port    = "3306";

try {
    // Conexão PDO com charset
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorno padrão em array associativo
            PDO::ATTR_EMULATE_PREPARES => false // Usa prepared statements nativos
        ]
    );

    echo "✅ Conexão realizada com sucesso!";

} catch (PDOException $e) {
    // Mensagem amigável para o usuário final
    echo "⚠️ Erro ao conectar ao banco de dados. Contate o administrador.";

    // Registro do erro em log para debug
    $logFile = __DIR__ . "/pdo_errors.log";
    $mensagem = "[" . date("Y-m-d H:i:s") . "] " . $e->getMessage() . PHP_EOL;
    file_put_contents($logFile, $mensagem, FILE_APPEND);

}
