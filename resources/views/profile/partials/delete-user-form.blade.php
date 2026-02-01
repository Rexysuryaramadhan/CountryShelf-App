<div class="card shadow-sm border-danger">
    <div class="card-body">
        <h5 class="card-title text-danger mb-4">
            <i class="fas fa-trash-alt me-2"></i>Hapus Akun
        </h5>
        <p class="text-muted mb-4">Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi yang ingin Anda simpan.</p>

        <button type="button" class="btn btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class="fas fa-trash me-2"></i>Hapus Akun
        </button>
    </div>
</div>

<!-- Modal for Delete Account Confirmation -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan dan semua data Anda akan dihapus secara permanen.</p>
                <p class="text-danger fw-bold">Silakan masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun:</p>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-0 m-0">
                    @csrf
                    @method('delete')

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="password" placeholder="Masukkan kata sandi Anda">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
