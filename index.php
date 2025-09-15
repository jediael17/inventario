<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Inventario ES1</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/cabecalho.css">
  <link rel="stylesheet" href="./assets/css/navBar.css">
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=wb_sunny&icon_names=dark_mode" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>

  <header class="cabecalho">
    <img src="./assets/img/AeC.png" alt="">
    <div class="google-search"> <!-- ou use .search-container se preferir -->
      <input type="text" id="searchInput" placeholder="Pesquisar no inventário...">
      <span id="searchBtn" class="material-symbols-outlined">search</span>
      <ul id="searchHistory" class="search-history"></ul>
    </div>    
    <button id="btn_darkmode" class="mode">
      <span class="material-symbols-outlined">dark_mode</span>
      <span class="material-symbols-outlined">wb_sunny</span>
    </button>
  </header>

  <nav class="navBar">
    <form action="salvar_chamado.php" method="POST" class="formulario">
      <h2>Cadastro de Produtos:</h2>
      <br>
      <section class="formulario_dadosch">
        <div class="input-container">
          <input type="text" name="chamado" required>
          <label>Chamado:</label>
        </div>

        <div class="input-container">
          <input type="text" name="patrimonio" required>
          <label>Patrimônio:</label>
        </div>

        <div class="input-container">
          <input type="text" name="rq" required>
          <label>RQ:</label>
        </div>

        <div class="input-container">
          <input type="text" name="modelo_equipamento" required>
          <label>Modelo:</label>
        </div>

        <div class="input-container">
          <input type="date" name="data" required>
          <label>Data:</label>
        </div>
  
        <div class="input-container">
          <select name="status" required>
            <option value="Aberto">Aberto</option>
            <option value="Em andamento">Em andamento</option>
            <option value="Fechado">Fechado</option>
          </select>
          <label>Status:</label>
        </div>
        
      </section>

      <section class="formulario_dados">
        <div class="input-container">
          <input type="text" name="nome_colaborador" required>
          <label>Nome do Colaborador:</label>
        </div>

        <div class="input-container">
          <input type="text" name="cr" required>
          <label>CR:</label>
        </div>

        <div class="input-container">
          <select name="tipo_chamado" class="" required>
            <option value="Notebook">Solicitação Notebook</option>
            <option value="Desktop">Solicitação Desktop</option>
            <option value="Memoria Ram DDR4 8GB">Solicitação Memoria Ram DDR4 8GB</option>
            <option value="Instalação">Solicitação Memoria SSD Sata</option>
          </select>
          <label>Tipo de Chamado:</label>
        </div>
        
      </section>      
  
      <div class="button">
        <input type="reset" class="button-reset">
        <button type="submit" class="button-salvar">Salvar</button>
      </div>
    </form>
  </nav>

  <main>
    <h2>Chamados Cadastrados</h2>
    <table id="chamadosTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Chamado</th>
          <th>Patrimônio</th>
          <th>RQ</th>
          <th>Modelo</th>
          <th>Colaborador</th>
          <th>CR</th>
          <th>Data</th>
          <th>Tipo</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
          require("connector.php");
  
          try {
            $stmt = $pdo->query("SELECT * FROM chamados ORDER BY id DESC");
            while ($row = $stmt->fetch()) {
              echo "<tr data-id='{$row['id']}'>";
              echo "<td>{$row['id']}</td>";
              echo "<td>{$row['chamado']}</td>";
              echo "<td>{$row['patrimonio']}</td>";
              echo "<td>{$row['rq']}</td>";
              echo "<td>{$row['modelo_equipamento']}</td>";
              echo "<td>{$row['nome_colaborador']}</td>";
              echo "<td>{$row['cr']}</td>";
              echo "<td>{$row['data']}</td>";
              echo "<td>{$row['tipo_chamado']}</td>";
              echo "<td>{$row['status']}</td>";
              echo "<td><button class='editBtn'>Editar</button></td>";
              echo "</tr>";
            }
          } catch (PDOException $e) {
            echo "<tr><td colspan='11'>Erro ao buscar dados: {$e->getMessage()}</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </main>
  

  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="closeBtn">&times;</span>
      <h3>Editar Chamado</h3>
      <form id="editForm">
        <input type="hidden" name="id" id="editId">
        <label>Chamado: <input type="text" name="chamado" id="editChamado" required></label>
        <label>Patrimônio: <input type="text" name="patrimonio" id="editPatrimonio" required></label>
        <label>RQ: <input type="text" name="rq" id="editRq" required></label>
        <label>Modelo: <input type="text" name="modelo_equipamento" id="editModelo" required></label>
        <label>Colaborador: <input type="text" name="nome_colaborador" id="editColaborador" required></label>
        <label>CR: <input type="text" name="cr" id="editCr" required></label>
        <label>Data: <input type="date" name="data" id="editData" required></label>
        <label>Tipo: 
          <select name="tipo_chamado" id="editTipo" required>
            <option value="Notebook">Notebook</option>
            <option value="Desktop">Desktop</option>
            <option value="Memoria Ram DDR4 8GB">Memoria Ram DDR4 8GB</option>
            <option value="Instalação">Instalação</option>
          </select>
        </label>
        <label>Status: 
          <select name="status" id="editStatus" required>
            <option value="Aberto">Aberto</option>
            <option value="Em andamento">Em andamento</option>
            <option value="Fechado">Fechado</option>
          </select>
        </label>
        <button type="submit">Salvar Alterações</button>
      </form>
    </div>
  </div>

  
  <script src="./assets/js/seache.js"></script>
  <script src="./assets/js/darMode.js"></script>
</body>
</html>
