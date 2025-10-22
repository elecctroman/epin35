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

document.querySelectorAll('[data-search-fill]').forEach(button => {
  button.addEventListener('click', () => {
    const form = button.closest('form');
    const input = form ? form.querySelector('input[type="search"]') : document.querySelector('.search-box input[type="search"]');
    if (!input) { return; }
    input.value = button.dataset.searchFill;
    input.focus();
  });
});

const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileMenu = document.querySelector('[data-mobile-menu]');
if (menuToggle && mobileMenu) {
  menuToggle.addEventListener('click', () => {
    const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!expanded));
    mobileMenu.classList.toggle('is-open', !expanded);
  });
}

document.querySelectorAll('[data-scroll-target]').forEach(button => {
  button.addEventListener('click', () => {
    const target = document.getElementById(button.dataset.scrollTarget);
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' });
    }
  });
});

document.querySelectorAll('[data-accordion]').forEach(group => {
  group.querySelectorAll('[data-accordion-toggle]').forEach(trigger => {
    trigger.addEventListener('click', () => {
      const panel = document.getElementById(trigger.getAttribute('aria-controls'));
      if (!panel) { return; }
      const isOpen = !panel.hasAttribute('hidden');
      panel.toggleAttribute('hidden', isOpen);
      trigger.classList.toggle('is-open', !isOpen);
    });
  });
});

document.querySelectorAll('[data-copy]').forEach(button => {
  button.addEventListener('click', async () => {
    const value = button.dataset.copy;
    try {
      if (navigator.clipboard && navigator.clipboard.writeText) {
        await navigator.clipboard.writeText(value);
      } else {
        const temp = document.createElement('textarea');
        temp.value = value;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
      }
      button.classList.add('copied');
      setTimeout(() => button.classList.remove('copied'), 1500);
    } catch (err) {
      console.warn('Copy failed', err);
    }
  });
});
