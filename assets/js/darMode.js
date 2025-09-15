const btnDark = document.getElementById("btn_darkmode");
    const root = document.documentElement;

    // Carregar preferência do usuário
    if (localStorage.getItem("theme") === "dark") {
      root.classList.add("dark-mode");
    }

    btnDark.addEventListener("click", () => {
      root.classList.toggle("dark-mode");
      
      // Salvar no localStorage
      if (root.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
      } else {
        localStorage.setItem("theme", "light");
      }
    });