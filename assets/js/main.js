document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('editModal');
    const closeBtn = modal.querySelector('.closeBtn');
    const editForm = document.getElementById('editForm');
  
    document.querySelectorAll('.editBtn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const tr = e.target.closest('tr');
        modal.style.display = 'block';
        // preencher campos
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
      });
    });
  
    closeBtn.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', (e) => { if(e.target==modal) modal.style.display='none'; });
  
    // salvar alterações via AJAX
    editForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(editForm);
      fetch('editar_chamado.php', {
        method: 'POST',
        body: formData
      }).then(res => res.json())
        .then(data => {
          if(data.success) {
            alert('Chamado atualizado com sucesso!');
            location.reload(); // recarrega tabela
          } else {
            alert('Erro: ' + data.message);
          }
        }).catch(err => alert('Erro ao atualizar chamado.'));
    });
  });  