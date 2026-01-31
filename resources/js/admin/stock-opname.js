document.addEventListener('DOMContentLoaded', () => {

    /* ================== STATE ================== */
    let tempOpname = [];
    let editingOpnameId = null;

    const page = document.getElementById('opnamePage');
    const searchInput = document.getElementById('productSearch');

    const startBtn  = document.getElementById('startOpname');
    const cancelBtn = document.getElementById('cancelOpname');
    const submitBtn = document.getElementById('submitOpname');

    const openModalBtn  = document.getElementById('openModal');
    const closeModalBtn = document.getElementById('closeModal');
    const modal         = document.getElementById('opnameModal');

    const productSelect = document.getElementById('opnameProduct');
    const categoryField = document.getElementById('categoryName');
    const systemStock   = document.getElementById('systemStock');
    const physicalStock = document.getElementById('physicalStock');
    const difference    = document.getElementById('differenceStock');

    const history   = document.getElementById('historyTable');
    const tableBody = document.getElementById('tempOpnameTable');

    const statView  = document.getElementById('statView');
    const statInput = document.getElementById('statInput');

    const viewHeader  = document.getElementById('viewHeader');
    const inputHeader = document.getElementById('inputHeader');

    /* ================== MODE ================== */
    startBtn?.addEventListener('click', () => {
        page.dataset.mode = 'input';
        searchInput.placeholder = 'Search product...';

        statView.classList.add('hidden');
        statInput.classList.remove('hidden');

        startBtn.classList.add('hidden');
        cancelBtn.classList.remove('hidden');
        submitBtn.classList.remove('hidden');
        openModalBtn.classList.remove('hidden');

        history.classList.add('hidden');
        tableBody.classList.remove('hidden');

        viewHeader.classList.add('hidden');
        inputHeader.classList.remove('hidden');
    });

    cancelBtn?.addEventListener('click', () => {
        tempOpname = [];
        editingOpnameId = null;
        renderTable();

        page.dataset.mode = 'view';
        searchInput.placeholder = 'Search opname...';

        statView.classList.remove('hidden');
        statInput.classList.add('hidden');

        startBtn.classList.remove('hidden');
        cancelBtn.classList.add('hidden');
        submitBtn.classList.add('hidden');
        openModalBtn.classList.add('hidden');

        history.classList.remove('hidden');
        tableBody.classList.add('hidden');

        viewHeader.classList.remove('hidden');
        inputHeader.classList.add('hidden');
    });

    /* ================== LOAD EXISTING ================== */
    async function loadOpname(id, isEdit) {
        const res  = await fetch(`/admin/stocks-opname/${id}/json`);
        const data = await res.json();

        startBtn.click();

        tempOpname = data.items.map(i => ({
            product_id: i.product_id,
            product_name: i.product.name,
            category: i.product.category.name,
            system_stock: i.system_stock,
            physical_stock: i.physical_stock,
            difference: i.difference,
            notes: i.notes
        }));

        renderTable();

        if (isEdit) {
            editingOpnameId = id;
        } else {
            openModalBtn.classList.add('hidden');
            submitBtn.classList.add('hidden');
            document.querySelectorAll('.actionCell').forEach(td => {
                td.innerHTML = '<span class="text-gray-400 italic">No Action</span>';
            });
        }
    }

    /* ================== FETCH PRODUCT ================== */
    productSelect?.addEventListener('change', async () => {
        const res  = await fetch(`/admin/opname/products/${productSelect.value}`);
        const data = await res.json();

        systemStock.value = data.stock;
        categoryField.value = data.category || '-';

        physicalStock.value = '';
        difference.value = '';
    });

    physicalStock?.addEventListener('input', () => {
        difference.value = Number(physicalStock.value) - Number(systemStock.value);
    });

    /* ================== ADD / EDIT ITEM ================== */
    document.getElementById('addItemBtn')?.addEventListener('click', () => {
        if (!productSelect.value) {
            Swal.fire('Error','Please select product','error');
            return;
        }

        if (physicalStock.value === '' || physicalStock.value < 0) {
            Swal.fire('Error','Physical stock must be 0 or greater','error');
            return;
        }

        const isExist = tempOpname.some(
            i => i.product_id == productSelect.value
        );

        if (isExist && modal.dataset.editIndex === undefined) {
            Swal.fire({
                icon: 'warning',
                title: 'Product already added',
                text: 'This product is already in the list. Please edit it instead.'
            });
            return;
        }

        Swal.fire({
            title: 'Add this item?',
            icon: 'question',
            showCancelButton: true
        }).then(result => {

            if (!result.isConfirmed) return;

            const index = modal.dataset.editIndex;

            const newItem = {
                product_id: productSelect.value,
                product_name: productSelect.options[productSelect.selectedIndex].text,
                category: categoryField.value,
                system_stock: systemStock.value,
                physical_stock: physicalStock.value,
                difference: Number(difference.value) || 0,
                notes: document.getElementById('itemNotes').value
            };

            if (index !== undefined) {
                tempOpname[index] = newItem;
                delete modal.dataset.editIndex;
            } else {
                tempOpname.push(newItem);
            }

            renderTable();
            closeModal();

            Swal.fire({ icon:'success', title:'Saved', timer:1000, showConfirmButton:false });
        });
    });

    /* ================== TSEARCH DATA ================== */
    function handleSearch() {
        const keyword = searchInput.value.toLowerCase();
        const mode = page.dataset.mode;

        // MODE INPUT (search product + category)
        if (mode === 'input') {
            document.querySelectorAll('#tempOpnameTable tr').forEach(row => {
                const product  = row.children[0].innerText.toLowerCase();
                const category = row.children[1].innerText.toLowerCase();

                row.style.display =
                    product.includes(keyword) || category.includes(keyword)
                        ? ''
                        : 'none';
            });
        } 
        // MODE VIEW (search history opname)
        else {
            document.querySelectorAll('#historyTable tr').forEach(row => {
                const date   = row.children[0].innerText.toLowerCase();
                const status = row.children[3].innerText.toLowerCase();

                row.style.display =
                    date.includes(keyword) || status.includes(keyword)
                        ? ''
                        : 'none';
            });
        }
    }

    searchInput.addEventListener('keyup', handleSearch);

    /* ================== TABLE RENDER ================== */
    function renderTable() {
        tableBody.innerHTML = '';

        tempOpname.forEach((item, index) => {
            tableBody.innerHTML += `
                <tr class="border hover:bg-blue-50">
                    <td class="p-2 font-bold">${item.product_name}</td>
                    <td class="p-2 text-center border">
                        <span class="bg-blue-100 text-blue-700 px-2 rounded text-xs">${item.category}</span>
                    </td>
                    <td class="p-2 text-center border">${item.system_stock}</td>
                    <td class="p-2 text-center border">${item.physical_stock}</td>
                    <td class="p-2 text-center border">
                        ${item.difference == 0
                            ? `<span class="bg-green-100 text-green-700 px-2 rounded">${item.difference}</span>`
                            : `<span class="bg-red-100 text-red-700 px-2 rounded">${item.difference}</span>`
                        }
                    </td>
                    <td class="p-2 text-center border">${item.notes || '-'}</td>
                    <td class="p-2 text-center border actionCell">
                        <div class="flex gap-2 justify-center">
                            <button class="editBtn bg-blue-600 text-white px-3 py-1 rounded" data-index="${index}">Edit</button>
                            <button class="deleteBtn bg-red-600 text-white px-3 py-1 rounded" data-index="${index}">Delete</button>
                        </div>
                    </td>
                </tr>
            `;
        });

        updateInputStats();
    }

    /* ================== ACTIONS ================== */
    document.addEventListener('click', e => {

        if (e.target.classList.contains('deleteBtn')) {
            const index = e.target.dataset.index;

            Swal.fire({
                title: 'Delete this item?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete'
            }).then(result => {
                if (!result.isConfirmed) return;

                tempOpname.splice(index, 1);
                renderTable();

                Swal.fire({
                    icon: 'success',
                    title: 'Item deleted',
                    timer: 1000,
                    showConfirmButton: false
                });
            });
        }

        if (e.target.classList.contains('editBtn')) {
            const i = tempOpname[e.target.dataset.index];

            productSelect.value = i.product_id;
            categoryField.value = i.category;
            systemStock.value = i.system_stock;
            physicalStock.value = i.physical_stock;
            difference.value = i.difference;
            document.getElementById('itemNotes').value = i.notes || '';

            modal.dataset.editIndex = e.target.dataset.index;
            modal.classList.remove('hidden');
        }

        if (e.target.classList.contains('editHistoryBtn')) {
            window.location.href = `/admin/stocks-opname?edit=${e.target.dataset.id}`;
        }

        if (e.target.classList.contains('deleteHistoryBtn')) {
            const id = e.target.dataset.id;
            fetch(`/admin/stocks-opname/${id}`, {
                method:'DELETE',
                headers:{ 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content }
            }).then(()=>location.reload());
        }
    });

    /* ================== STATS ================== */
    function updateInputStats() {
        let diff = 0, equal = 0;

        tempOpname.forEach(i => {
            Number(i.difference) === 0 ? equal++ : diff++;
        });

        document.getElementById('statTotal').innerText = tempOpname.length;
        document.getElementById('statDiff').innerText = diff;
        document.getElementById('statEqual').innerText = equal;
    }

    /* ================== MODAL ================== */
    function closeModal() {
        modal.classList.add('hidden');
        productSelect.value = '';
        categoryField.value = '';
        systemStock.value = '';
        physicalStock.value = '';
        difference.value = '';
        document.getElementById('itemNotes').value = '';
        delete modal.dataset.editIndex;
    }

    openModalBtn?.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModalBtn?.addEventListener('click', closeModal);
    modal.addEventListener('click', e => e.target === modal && closeModal());

    /* ================== SUBMIT ================== */
    submitBtn?.addEventListener('click', async () => {

        if (tempOpname.length === 0) {
            Swal.fire('Warning','No items','warning');
            return;
        }

        Swal.fire({
            title: 'Submit stock opname?',
            text: 'After submit you cannot edit this data.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit',
            cancelButtonText: 'Cancel'
        }).then(async result => {

            if (!result.isConfirmed) return;

            const url = editingOpnameId
                ? `/admin/stocks-opname/${editingOpnameId}`
                : '/admin/stocks-opname/submit';

            const method = editingOpnameId ? 'PUT' : 'POST';

            await fetch(url,{
                method,
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
                },
                body:JSON.stringify({
                    items: tempOpname.map(i=>({
                        product_id:i.product_id,
                        physical_stock:i.physical_stock,
                        notes:i.notes
                    }))
                })
            });

            Swal.fire({
                icon:'success',
                title:'Opname submitted!',
                text:'Waiting for manager review.'
            }).then(()=>window.location.href='/admin/stocks-opname');

        });
    });

    /* ================== URL AUTO LOAD ================== */
    const params = new URLSearchParams(window.location.search);
    if (params.has('view')) loadOpname(params.get('view'), false);
    if (params.has('edit')) loadOpname(params.get('edit'), true);



    

});

// MANAGER ACTIONS
    let selectedOpnameId = null;

    // FILTER
    const filterDate   = document.getElementById('filterDate');
    const filterStaff  = document.getElementById('filterStaff');
    const filterStatus = document.getElementById('filterStatus');

    [filterDate, filterStaff, filterStatus].forEach(el => {
        el?.addEventListener('input', applyManagerFilter);
    });

    function applyManagerFilter() {

        const dateVal   = filterDate.value;
        const staffVal  = filterStaff.value.toLowerCase();
        const statusVal = filterStatus.value;

        document.querySelectorAll('tbody tr').forEach(row => {

            const date   = row.children[0].innerText;
            const staff  = row.children[1].innerText.toLowerCase();
            const status = row.children[2].innerText;

            let visible = true;

            if (dateVal && !date.includes(dateVal)) visible = false;
            if (staffVal && !staff.includes(staffVal)) visible = false;
            if (statusVal && status !== statusVal) visible = false;

            row.style.display = visible ? '' : 'none';
        });
    }

    // Approve / Reject
    document.addEventListener('click', (e) => {

        if (e.target.classList.contains('approveBtn') || e.target.classList.contains('rejectBtn')) {

            const id = e.target.dataset.id;
            const status = e.target.dataset.status;

            Swal.fire({
                title: 'Are you sure?',
                text: `Change status to ${status}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then(async (result) => {

                if (!result.isConfirmed) return;

                await fetch(`/admin/stocks-opname/${id}/change-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Status updated',
                    timer: 1000,
                    showConfirmButton: false
                }).then(() => location.reload());
            });
        }

        // Change status (modal)
        if (e.target.classList.contains('changeStatusBtn')) {
            selectedOpnameId = e.target.dataset.id;
            document.getElementById('changeStatusModal').classList.remove('hidden');
        }

    });

    // Modal buttons
    document.getElementById('modalApprove')?.addEventListener('click', () => {
        submitChangeStatus('APPROVED');
    });

    document.getElementById('modalReject')?.addEventListener('click', () => {
        submitChangeStatus('REJECTED');
    });

    document.getElementById('closeChangeModal')?.addEventListener('click', () => {
        document.getElementById('changeStatusModal').classList.add('hidden');
    });

    // Submit
    async function submitChangeStatus(status) {

        await fetch(`/admin/stocks-opname/${selectedOpnameId}/change-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status })
        });

        Swal.fire({
            icon: 'success',
            title: 'Status updated',
            timer: 1000,
            showConfirmButton: false
        }).then(() => location.reload());
    }


// ================= ADMIN FILTER =================
const adminRows = document.querySelectorAll('#adminOpnameTable tr');

[filterDate, filterStaff, filterManager, filterStatus].forEach(el => {
    el?.addEventListener('change', applyAdminFilter);
});

function applyAdminFilter() {

    let total = 0;
    let approved = 0;
    let rejected = 0;
    let pending = 0;

    adminRows.forEach(row => {

        const date    = row.querySelector('.col-date').innerText;
        const staff   = row.querySelector('.col-staff').innerText;
        const manager = row.querySelector('.col-manager').innerText;
        const status  = row.querySelector('.col-status').innerText;

        let show = true;

        if (filterDate.value && !date.includes(filterDate.value))
            show = false;

        if (filterStaff.value && !staff.includes(filterStaff.options[filterStaff.selectedIndex].text))
            show = false;

        if (filterManager.value && !manager.includes(filterManager.options[filterManager.selectedIndex].text))
            show = false;

        if (filterStatus.value && !status.includes(filterStatus.value))
            show = false;

        row.style.display = show ? '' : 'none';

        if (show) {
            total++;

            if (status.includes('APPROVED')) approved++;
            if (status.includes('REJECTED')) rejected++;
            if (status.includes('UNDER')) pending++;
        }
    });

    // update cards
    document.getElementById('statViewTotal').innerText = total;
    document.getElementById('statViewApproved').innerText = approved;
    document.getElementById('statViewRejected').innerText = rejected;
    document.getElementById('statViewPending').innerText = pending;
}