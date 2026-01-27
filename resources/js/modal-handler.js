// MODAL CONTROL (GLOBAL)
window.openModal = function() {
    const modal = document.getElementById('modalTransaksi');
    if (modal) {
        modal.classList.replace('hidden', 'flex');
        document.body.style.overflow = 'hidden';
    }
};

window.closeModal = function() {
    const modal = document.getElementById('modalTransaksi');
    if (modal) {
        modal.classList.replace('flex', 'hidden');
        document.body.style.overflow = 'auto';
    }
};

// ALPINE DATA
document.addEventListener('alpine:init', () => {
    Alpine.data('transactionForm', () => ({
        open: false,
        rawAmount: '',
        selectedId: '',
        selectedName: '',
        selectedIcon: 'fa-tag',

        get formattedAmount() {
            return this.rawAmount ? new Intl.NumberFormat('id-ID').format(this.rawAmount) : '';
        },

        updateAmount(val) {
            this.rawAmount = val.replace(/\D/g, '');
        },

        selectCategory(id, name, icon) {
            this.selectedId = id;
            this.selectedName = name;
            this.selectedIcon = icon;
            this.open = false;
        }
    }));
});