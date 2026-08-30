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
                <a href="{{ route('items') }}" class="link-offset-2 link-primary link-underline-opacity-0">Meus itens</a>
                <a href="{{ route('categories') }}" class="link-offset-2 link-secondary link-underline-opacity-0 ms-2">Minhas categorias</a>
                <span class="me-3">
                    <i class="fa-solid fa-user-circle fa-lg text-secondary me-2"></i>{{ session('user.username') ?? '[username]' }}
                </span>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm px-3">
                    Logout<i class="bi bi-box-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>