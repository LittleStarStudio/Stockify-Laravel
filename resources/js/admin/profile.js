document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('profileForm');
    const btnSave = document.getElementById('btnSave');

    // SESUAI DENGAN BLADE BARU
    const avatarInput = document.getElementById('edit-avatar');
    const avatarPreview = document.getElementById('logoPreview');
    const filenameText = document.getElementById('edit-avatar-filename');

    const toggle = document.getElementById('togglePassword');
    const input = document.getElementById('passwordInput');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    // ================= PREVIEW AVATAR =================
    if (avatarInput) {
        avatarInput.addEventListener('change', () => {
            if (avatarInput.files[0]) {
                avatarPreview.src = URL.createObjectURL(avatarInput.files[0]);
                avatarPreview.classList.add('scale-105');

                // tampilkan nama file
                filenameText.innerText = avatarInput.files[0].name;
            }
        });
    }

    // ================= TOGGLE PASSWORD =================
    if (toggle) {
        toggle.addEventListener('click', () => {
            const hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';

            eyeOpen.classList.toggle('hidden', !hidden);
            eyeClosed.classList.toggle('hidden', hidden);
        });
    }

    // ================= SUBMIT WITH SWEETALERT =================
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        Swal.fire({
            title: 'Save changes?',
            text: 'Your profile will be updated',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save'
        }).then((res) => {

            if (!res.isConfirmed) return;

            btnSave.innerHTML = 'Saving...';
            btnSave.disabled = true;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':
                        document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(async r => {

                if (r.ok) {
                    Swal.fire('Success','Profile updated','success')
                        .then(() => location.reload());
                    return;
                }

                if (r.status === 422) {
                    const data = await r.json();
                    Swal.fire('Validation Error',
                        Object.values(data.errors)
                              .map(e => e[0])
                              .join('<br>'),
                        'error');
                } else {
                    Swal.fire('Error','Something went wrong','error');
                }

                btnSave.innerHTML = 'Update Profile';
                btnSave.disabled = false;
            });
        });
    });

});
