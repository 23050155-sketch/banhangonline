/* =========================
 * admin.js
 * ========================= */

(() => {
  'use strict';

  // ---- Helpers ----
  const $ = (sel, root = document) => root.querySelector(sel);

  const focusFirstInput = (root) => {
    const el = $('input, select, textarea', root);
    el?.focus();
  };

  // =========================
  // Modal
  // =========================
  const Modal = {
    get el() { return $('#productModal'); },
    get titleEl() { return $('#modalTitle'); },
    get contentEl() { return $('#modalContent'); },

    isOpen() {
      return this.el?.classList.contains('show');
    },

    open(url, title = '') {
      const modal = this.el;
      const titleEl = this.titleEl;
      const contentEl = this.contentEl;
      if (!modal || !titleEl || !contentEl) return;

      titleEl.innerText = title;
      modal.classList.add('show');
      document.body.classList.add('modal-open');
      contentEl.innerHTML = 'Loading...';

      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then((res) => {
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          return res.text();
        })
        .then((html) => {
          contentEl.innerHTML = html;
          focusFirstInput(contentEl);
        })
        .catch((err) => {
          console.error('openModal fetch error:', err);
          contentEl.innerHTML = `
            <div class="alert error">
              Không tải được nội dung. Vui lòng thử lại.
            </div>
          `;
        });
    },

    close() {
      const modal = this.el;
      const contentEl = this.contentEl;
      if (!modal || !contentEl) return;

      modal.classList.remove('show');
      document.body.classList.remove('modal-open');
      contentEl.innerHTML = '';
    },
  };

  // expose cho onclick="openModal(...)"
  window.openModal = (url, title) => Modal.open(url, title);
  window.closeModal = () => Modal.close();

  // Close when click backdrop
  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-backdrop')) {
      Modal.close();
    }
  });

  // ESC to close
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && Modal.isOpen()) {
      Modal.close();
    }
  });

  // Block scroll background when modal open
  document.addEventListener(
    'wheel',
    (e) => {
      if (!Modal.isOpen()) return;

      const box = Modal.el?.querySelector('.modal-box');
      if (box && !box.contains(e.target)) {
        e.preventDefault();
      }
    },
    { passive: false }
  );

  // =========================
  // Sidebar / Menu
  // =========================
  const UI = {
    initSidebar() {
      const sidebarBtn = $('#sidebarBtn');
      const sidebar = $('#sidebar');
      sidebarBtn?.addEventListener('click', () => sidebar?.classList.toggle('open'));
    },

    initManageMenu() {
      const toggle = $('#manageToggle');
      const menu = $('#manageMenu');
      if (!toggle || !menu) return;

      // Nếu không có item active thì mặc định collapse
      const hasActive = menu.querySelector('.active');
      if (!hasActive) menu.style.display = 'none';

      toggle.addEventListener('click', () => {
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
      });
    },
  };

  // =========================
  // Boot
  // =========================
  document.addEventListener('DOMContentLoaded', () => {
    UI.initSidebar();
    UI.initManageMenu();

    console.log('ADMIN.JS END ✅', typeof window.openModal);
  });
})();
