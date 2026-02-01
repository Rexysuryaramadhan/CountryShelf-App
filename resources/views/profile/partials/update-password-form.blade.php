<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title text-primary mb-4">
            <i class="fas fa-key me-2"></i>Ubah Kata Sandi
        </h5>
        <p class="text-muted mb-4">Pastikan akun Anda menggunakan kata sandi yang kuat untuk menjaga keamanan.</p>

        <form method="post" action="{{ route('password.update') }}" class="mt-4">
            @csrf
            @method('put')

            <div class="mb-3 row">
                <label for="current_password" class="col-md-3 col-form-label text-md-end">Kata Sandi Saat Ini</label>
                <div class="col-md-7">
                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                        autocomplete="current-password"
                    >
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="password" class="col-md-3 col-form-label text-md-end">Kata Sandi Baru</label>
                <div class="col-md-7">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                        autocomplete="new-password"
                    >
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="password_confirmation" class="col-md-3 col-form-label text-md-end">Konfirmasi Kata Sandi</label>
                <div class="col-md-7">
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="form-control"
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <div class="row">
                <div class="offset-md-3 col-md-7">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>

                    @if (session('status') === 'password-updated')
                        <span class="text-success ms-3">
                            Tersimpan!
                        </span>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
