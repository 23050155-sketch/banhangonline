document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('sidebarToggle');
  const sidebar = document.querySelector('.admin-sidebar');
  if(!btn || !sidebar) return;

  btn.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });
});
