/******************************
 * FONCTION envoie de données de formulaire
 */
function envoiFormulaire(form) {
    form.requestSubmit();
}

document.addEventListener('click', function (event) {
    const quantityButton = event.target.closest('[data-quantity-change]');

    if (quantityButton) {
        const stockCard = quantityButton.closest('.stock-card');
        const quantity = stockCard.querySelector('.stock-quantity');
        const currentValue = Number(quantity.textContent);
        const change = Number(quantityButton.dataset.quantityChange);
        const nextValue = Math.max(0, currentValue + change);

        quantity.textContent = String(nextValue);
        stockCard.querySelector('[data-quantity-change="-1"]').disabled = nextValue === 0;
        return;
    }

    const editButton = event.target.closest('[data-edit-miel]');
    if (editButton) {
        document.querySelector('#editMielId').value = editButton.dataset.mielId;
        document.querySelector('#editMielType').value = editButton.dataset.mielType;
        document.querySelector('#editMielPhoto').value = editButton.dataset.mielPhoto;
        document.querySelector('#editMielDialog').showModal();
        return;
    }

    const deleteButton = event.target.closest('[data-delete-miel]');
    if (deleteButton) {
        document.querySelector('#deleteMielId').value = deleteButton.dataset.mielId;
        document.querySelector('#deleteMielName').textContent = deleteButton.dataset.mielType;
        document.querySelector('#deleteMielDialog').showModal();
        return;
    }

    const confirmEditButton = event.target.closest('[data-confirm-edit]');
    if (confirmEditButton) {
        const editForm = document.querySelector('#editMielForm');
        editForm.dataset.confirmed = 'true';
        document.querySelector('#confirmEditDialog').close();
        editForm.requestSubmit();
        return;
    }

    const closeButton = event.target.closest('[data-close-dialog]');
    if (closeButton) {
        closeButton.closest('dialog').close();
    }
});

document.addEventListener('submit', function (event) {
    if (event.target.id !== 'editMielForm' || event.target.dataset.confirmed === 'true') {
        return;
    }

    event.preventDefault();
    document.querySelector('#confirmEditDialog').showModal();
});
