const tabs = document.querySelectorAll('[data-tab]');
const tabPanels = document.querySelectorAll('[data-tab-panel]');

if (tabs.length) {
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;

            tabs.forEach(item => item.classList.toggle('is-active', item === tab));
            tabPanels.forEach(panel => panel.hidden = panel.dataset.tabPanel !== target);
        });
    });
}
