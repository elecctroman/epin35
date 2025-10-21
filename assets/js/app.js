document.querySelectorAll('[data-tab-target]').forEach(button => {
  button.addEventListener('click', () => {
    const target = button.dataset.tabTarget;
    document.querySelectorAll('[data-tab-group="' + button.dataset.tabGroup + '"]').forEach(tab => {
      tab.classList.toggle('active', tab.dataset.tabTarget === target);
    });
    document.querySelectorAll('[data-tab-panel="' + button.dataset.tabGroup + '"]').forEach(panel => {
      panel.hidden = panel.id !== target;
    });
  });
});

const lazyImages = document.querySelectorAll('img[data-lazy]');
if ('IntersectionObserver' in window) {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.lazy;
        img.removeAttribute('data-lazy');
        observer.unobserve(img);
      }
    });
  }, { rootMargin: '200px' });
  lazyImages.forEach(img => observer.observe(img));
}
