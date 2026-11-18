// Modul reusable tabel otomatis dengan fetch dan debounce
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('tabelSearch');
    const container = document.getElementById('tabelContainer');

    if (!searchInput || !container) return;

    let debounceTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchTableData(this.value);
        }, 300);
    });

    function fetchTableData(keyword) {
        const url = new URL(window.location.href);
        url.searchParams.set('search', keyword);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContainer = doc.getElementById('tabelContainer');
            if (newContainer) {
                container.innerHTML = newContainer.innerHTML;
            }
        })
        .catch(err => console.error('Gagal memuat data:', err));
    }
});
