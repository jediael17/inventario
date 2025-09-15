document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const tbody = document.querySelector('#chamadosTable tbody');
  const modal = document.getElementById('editModal');
  const editForm = document.getElementById('editForm');
  const closeBtn = modal.querySelector('.closeBtn');

  function buscarChamados(q = '') {
    fetch(`buscar_chamados.php?q=${encodeURIComponent(q)}`)
      .then(res => res.json())
      .then(data => {
        tbody.innerHTML = '';
        if (data.error) {
          tbody.innerHTML = `<tr><td colspan="11">Erro: ${data.error}</td></tr>`;
          return;
        }
        if (data.length === 0) {
          tbody.innerHTML = `<tr><td colspan="11">Nenhum chamado encontrado</td></tr>`;
          return;
        }
        data.forEach(row => {
          const tr = document.createElement('tr');
          tr.dataset.id = row.id;
          tr.innerHTML = `
            <td>${row.id}</td>
            <td>${row.chamado}</td>
            <td>${row.patrimonio}</td>
            <td>${row.rq}</td>
            <td>${row.modelo_equipamento}</td>
            <td>${row.nome_colaborador}</td>
            <td>${row.cr}</td>
            <td>${row.data}</td>
            <td>${row.tipo_chamado}</td>
            <td>${row.status}</td>
            <td><button class="editBtn">Editar</button></td>
          `;
          tbody.appendChild(tr);
        });
      })
      .catch(err => {
        console.error('Erro ao buscar chamados:', err);
        tbody.innerHTML = `<tr><td colspan="11">Erro ao buscar chamados</td></tr>`;
      });
  }

  buscarChamados();

  searchInput.addEventListener('input', (e) => {
    buscarChamados(e.target.value.trim());
  });

  tbody.addEventListener('click', (e) => {
    if (e.target.classList.contains('editBtn')) {
      const tr = e.target.closest('tr');
      modal.style.display = 'block';

      document.getElementById('editId').value = tr.dataset.id;
      document.getElementById('editChamado').value = tr.children[1].textContent;
      document.getElementById('editPatrimonio').value = tr.children[2].textContent;
      document.getElementById('editRq').value = tr.children[3].textContent;
      document.getElementById('editModelo').value = tr.children[4].textContent;
      document.getElementById('editColaborador').value = tr.children[5].textContent;
      document.getElementById('editCr').value = tr.children[6].textContent;
      document.getElementById('editData').value = tr.children[7].textContent;
      document.getElementById('editTipo').value = tr.children[8].textContent;
      document.getElementById('editStatus').value = tr.children[9].textContent;
    }
  });

  closeBtn.addEventListener('click', () => modal.style.display = 'none');
  window.addEventListener('click', (e) => {
    if (e.target == modal) modal.style.display = 'none';
  });

  editForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(editForm);

    fetch('editar_chamado.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Chamado atualizado com sucesso!');
        modal.style.display = 'none';
        buscarChamados(searchInput.value.trim());
      } else {
        console.error('Erro ao atualizar chamado:', data.message);
        alert('Erro ao atualizar chamado: ' + data.message);
      }
    })
    .catch(err => {
      console.error('Erro no fetch:', err);
      alert('Erro ao atualizar chamado.');
    });
  });
});
