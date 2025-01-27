  // sidebar  hide and show 
  const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');

      toggleSidebarBtn.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-hidden');
        mainContent.classList.toggle('main-content-full');
        toggleSidebarBtn.classList.toggle('hidden');
        toggleSidebarBtn.innerHTML = sidebar.classList.contains('sidebar-hidden') 
          ? '<i class="fas fa-angle-right"></i>' 
          : '<i class="fas fa-angle-left"></i>';
      });