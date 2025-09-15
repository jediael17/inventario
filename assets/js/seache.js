document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('searchInput');
  const btn = document.getElementById('searchBtn');
  const historyEl = document.getElementById('searchHistory');
  const container = document.querySelector('.google-search') || document.querySelector('.search-container');

  const STORAGE_KEY = 'search_history_v1';
  const MAX_HISTORY = 10;   // quantos itens guardar
  const SHOW_MAX = 5;       // quantos mostrar no dropdown

  let history = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

  function saveHistory() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
  }

  function renderHistory(filter = '') {
    historyEl.innerHTML = '';

    // lista com mais recentes primeiro
    let list = history.slice().reverse();

    if (filter) {
      const f = filter.toLowerCase();
      list = list.filter(item => item.toLowerCase().includes(f));
    }

    if (list.length === 0) {
      historyEl.style.display = 'none';
      return;
    }

    historyEl.style.display = 'block';

    list.slice(0, SHOW_MAX).forEach((item, idx) => {
      const li = document.createElement('li');
      li.className = 'history-item';

      const text = document.createElement('span');
      text.className = 'history-text';
      text.textContent = item;
      text.title = item;
      text.addEventListener('click', (e) => {
        e.stopPropagation();
        input.value = item;
        hideHistory();
        doSearch(item);
      });

      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.className = 'remove-btn';
      removeBtn.innerHTML = '✕';
      removeBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // não aciona o clique do li
        // calcular índice real no array original (já que renderizamos reverse)
        const realIndex = history.length - 1 - idx;
        history.splice(realIndex, 1);
        saveHistory();
        renderHistory(input.value.trim());
      });

      li.appendChild(text);
      li.appendChild(removeBtn);
      historyEl.appendChild(li);
    });
  }

  function hideHistory() {
    historyEl.style.display = 'none';
  }

  function showHistory() {
    renderHistory(input.value.trim());
  }

  function addToHistory(q) {
    q = q.trim();
    if (!q) return;
    // remove duplicatas (case-insensitive)
    history = history.filter(h => h.toLowerCase() !== q.toLowerCase());
    history.push(q); // keep newest at the end
    if (history.length > MAX_HISTORY) {
      history = history.slice(history.length - MAX_HISTORY);
    }
    saveHistory();
  }

  function doSearch(q) {
    if (typeof q === 'undefined') q = input.value.trim();
    if (!q) return;
    addToHistory(q);
    renderHistory('');
    // Ação de busca - troque por sua lógica real:
    // ex: window.location.href = `/buscar.php?q=${encodeURIComponent(q)}`;
    console.log('Pesquisar por:', q);
    alert('Pesquisar por: ' + q);
  }

  // eventos
  if (btn) {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      doSearch();
    });
  }

  input.addEventListener('input', () => {
    renderHistory(input.value.trim());
  });

  input.addEventListener('focus', () => {
    renderHistory(input.value.trim());
  });

  // Enter no input
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      doSearch();
    }
  });

  // clicar fora fecha
  document.addEventListener('click', (e) => {
    if (!container || !container.contains(e.target)) {
      hideHistory();
    }
  });

  // render inicial (se desejar que apareça sem foco, comente)
  // renderHistory();

});