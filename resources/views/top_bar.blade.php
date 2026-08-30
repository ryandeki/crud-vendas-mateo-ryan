<div class="container-fluid px-4 py-2 border-bottom mb-4">
    <div class="row align-items-center">
        <div class="col">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Seller logo" style="max-width: 160px">
            </a>
        </div>
        <div class="col text-center">
            Bem-vinda(o) ao <span class="text-primary">Seller</span>!
        </div>
        <div class="col">
            <div class="d-flex justify-content-end align-items-center">
                <span class="me-3">
                    <i
                        class="fa-solid fa-user-circle fa-lg text-secondary me-2"></i>{{ session('user.username') ?? '[username]' }}
                </span>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm px-3">
                    Logout<i class="fa-solid fa-arrow-right-from-bracket ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>