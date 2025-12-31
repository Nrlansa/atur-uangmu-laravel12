window.toggleSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('main');

    if (sidebar) {
        if (sidebar.classList.contains('left-0')) {
            // SEMBUNYIKAN SIDEBAR
            sidebar.classList.replace('left-0', '-left-72');
            // GESER KONTEN UTAMA KE FULL SCREEN
            if (mainContent) {
                mainContent.classList.replace('ml-72', 'ml-0');
            }
        } else {
            // TAMPILKAN KEMBALI SIDEBAR
            sidebar.classList.replace('-left-72', 'left-0');
            // BERI JARAK KEMBALI PADA KONTEN UTAMA
            if (mainContent) {
                mainContent.classList.replace('ml-0', 'ml-72');
            }
        }
    }
}