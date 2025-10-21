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

function bindRemoveButtons(scope) {
  scope.querySelectorAll('[data-remove-variation]').forEach(button => {
    button.addEventListener('click', () => {
      const item = button.closest('[data-variation]');
      const list = button.closest('[data-variation-list]');
      if (list && item && list.children.length > 1) {
        item.remove();
      }
    });
  });
}

document.querySelectorAll('[data-add-variation]').forEach(button => {
  const form = button.closest('form');
  if (!form) { return; }
  const list = form.querySelector('[data-variation-list]');
  if (!list) { return; }
  bindRemoveButtons(list);
  button.addEventListener('click', () => {
    const prototype = list.querySelector('[data-variation]');
    if (!prototype) { return; }
    const clone = prototype.cloneNode(true);
    clone.querySelectorAll('input, textarea').forEach(input => {
      if (input.name === 'variation_id[]') {
        input.remove();
        return;
      }
      if (input.type === 'checkbox') {
        input.checked = false;
        return;
      }
      input.value = '';
    });
    list.appendChild(clone);
    bindRemoveButtons(clone);
  });
});

function renderChart(element) {
  const raw = element.dataset.chart;
  if (!raw) { return; }
  let points = [];
  try {
    const data = JSON.parse(raw);
    points = Object.entries(data);
  } catch (err) {
    return;
  }
  if (!points.length) { return; }
  const width = element.clientWidth || 400;
  const height = element.clientHeight || 200;
  const values = points.map(([, value]) => Number(value) || 0);
  const max = Math.max(...values, 1);
  const step = width / Math.max(points.length - 1, 1);
  const coords = points.map(([label, value], index) => {
    const x = index * step;
    const y = height - (Number(value) / max) * (height - 10);
    return `${x},${y}`;
  }).join(' ');
  const svg = `<svg viewBox="0 0 ${width} ${height}" preserveAspectRatio="none">
    <polyline fill="none" stroke="var(--primary)" stroke-width="3" points="${coords}" stroke-linecap="round" />
    <polyline fill="rgba(59,130,246,0.18)" stroke="none" points="0,${height} ${coords} ${width},${height}" />
  </svg>`;
  element.innerHTML = svg;
}

document.querySelectorAll('.chart[data-chart]').forEach(renderChart);
