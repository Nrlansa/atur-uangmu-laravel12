
window.openEditModal = function(id, categoryId, amount) {
    const modal = document.getElementById('editBudgetModal');
    const form = document.getElementById('editBudgetForm');
    
    form.action = `/budget/${id}`;
    document.getElementById('edit_category_id').value = categoryId;
    document.getElementById('edit_amount').value = amount;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex', 'items-center', 'justify-center'); 
    
    document.body.style.overflow = 'hidden';
}

window.closeEditModal = function() {
    const modal = document.getElementById('editBudgetModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

window.addEventListener('click', function(event) {
    const modal = document.getElementById('editBudgetModal');
    if (event.target == modal) {
        window.closeEditModal();
    }
});