document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('stockInputForm');
    if (!form) return;

    const qtyInput = form.querySelector('#qtyInput');
    const typeSelect = form.querySelector('[name="type"]');
    const productSelect = form.querySelector('[name="product_id"]');

    let currentStock = 0;

    function updateStockColor(stock, min) {
        const el = document.getElementById('currentStock');

        el.classList.remove('text-green-600','text-yellow-600','text-red-600');

        if (stock === 0) {
            el.classList.add('text-red-600');
        } else if (stock <= min) {
            el.classList.add('text-yellow-600');
        } else {
            el.classList.add('text-green-600');
        }
    }

    function toggleOutOption(stock) {
        const outOption = typeSelect.querySelector('option[value="OUT"]');
        const msg = document.getElementById('outDisabledMsg');

        if (stock === 0) {
            outOption.disabled = true;
            typeSelect.value = 'IN';
            msg.classList.remove('hidden');
        } else {
            outOption.disabled = false;
            msg.classList.add('hidden');
        }
    }

    productSelect.addEventListener('change', async () => {

        const id = productSelect.value;

        if (!id) {
            document.getElementById('stockInfo').classList.add('hidden');
            return;
        }

        try {
            const res = await fetch(`/admin/products/${id}/stock`);
            const data = await res.json();

            currentStock = parseInt(data.current_stock);

            updateStockColor(currentStock, data.minimum_stock);
            toggleOutOption(currentStock);

            document.getElementById('stockInfo').classList.remove('hidden');
            document.getElementById('currentStock').textContent = currentStock;
            document.getElementById('minStock').textContent = data.minimum_stock;

        } catch (e) {
            console.error(e);
        }

    });

    function validateQty() {
        const type = typeSelect.value;
        const qty = parseInt(qtyInput.value || 0);

        if (type === 'OUT' && qty > currentStock) {
            Swal.fire({
                icon: 'warning',
                title: 'Stock not enough',
                text: `Available stock: ${currentStock}`
            });

            qtyInput.value = currentStock;
        }
    }

    qtyInput.addEventListener('input', validateQty);
    typeSelect.addEventListener('change', validateQty);

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const product = form.querySelector('[name="product_id"]').value;
        const type = typeSelect.value;
        const qty = parseInt(qtyInput.value || 0);

        if (!product || !type || !qty) {
            Swal.fire({
                icon: 'warning',
                title: 'The form is not complete',
                text: 'All fields are required!'
            });
            return;
        }

        if (type === 'OUT' && currentStock === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Stock is empty',
                text: 'You cannot choose OUT because stock is zero'
            });
            return;
        }

        if (type === 'OUT' && qty > currentStock) {
            Swal.fire({
                icon: 'error',
                title: 'Stock not enough',
                text: `Available stock: ${currentStock}`
            });
            return;
        }

        
        Swal.fire({
            title: 'Confirm Stock Request?',
            html: `
                <b>Type:</b> ${type}<br>
                <b>Quantity:</b> ${qty}<br>
                <b>Current Stock Now:</b> ${currentStock}
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#2563eb'
        }).then(result => {
            if (!result.isConfirmed) return;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: new FormData(form)
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw data;
                return data;
            })
            .then(res => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message
                }).then(() => {
                    form.reset();
                    document.getElementById('stockInfo').classList.add('hidden');
                });
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: err.message || 'There is an error'
                });
            });
        });
    });

});
