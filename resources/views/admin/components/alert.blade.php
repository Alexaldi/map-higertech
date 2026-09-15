{{-- Success Alert --}}
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif


{{-- Delete Confirmation --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.delete-form').forEach(function (form) {

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus pengguna?',
                    text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });
            });

        });

    });
</script>