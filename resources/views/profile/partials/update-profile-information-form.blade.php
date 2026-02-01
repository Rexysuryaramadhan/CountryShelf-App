<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title text-primary mb-4">
            <i class="fas fa-user-circle me-2"></i>Informasi Profil
        </h5>
        <p class="text-muted mb-4">Perbarui informasi profil dan alamat email akun Anda.</p>

        <form method="post" action="{{ route('profile.update') }}" class="mt-4">
            @csrf
            @method('patch')

            <div class="mb-3 row">
                <label for="name" class="col-md-3 col-form-label text-md-end">Nama</label>
                <div class="col-md-7">
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-md-3 col-form-label text-md-end">Email</label>
                <div class="col-md-7">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-gray-800">
                                Alamat email Anda belum terverifikasi.

                                <button form="send-verification" class="btn btn-link p-0 text-sm text-primary">
                                    Klik di sini untuk mengirim ulang email verifikasi.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 fw-medium text-sm text-success">
                                    Tautan verifikasi baru telah dikirim ke alamat email Anda.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="offset-md-3 col-md-7">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-success ms-3">
                            Tersimpan!
                        </span>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
