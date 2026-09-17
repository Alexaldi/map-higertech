{{-- Success Alert --}}
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonColor: '#0ea5e9',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                });
            }
        });
    </script>
@endif

{{-- Error Alert --}}
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Tutup'
                });
            }
        });
    </script>
@endif

{{-- Generic Delete Confirmation --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const title = form.dataset.title || 'Konfirmasi Hapus';
                const text = form.dataset.message ||
                    'Data yang sudah dihapus tidak dapat dikembalikan.';

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fe fe-trash-2 me-1"></i> Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else if (confirm(text)) {
                    form.submit();
                }
            });
        });
    });
</script>
