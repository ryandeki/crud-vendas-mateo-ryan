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
                <div class="btn btn-outline-danger btn-md border border-danger rounded p-1 me-4">
                    <a href="{{ route('trash.items') }}" class="link-offset-2 link-danger link-light-hover link-underline-opacity-0"><i class="bi bi-trash3"></i></a>
                </div>
                <a href="{{ route('items') }}" class="link-offset-2 link-primary link-underline-opacity-0 ms-2">Meus itens</a>
                <a href="{{ route('categories') }}" class="link-offset-2 link-secondary link-underline-opacity-0 ms-2">Minhas categorias</a>
                <div class="col">
                    <a href="{{ route('user.page') }}" class="link-offset-2 link-dark link-underline-opacity-0">
                        <i class="bi bi-person-circle col-auto fs-3 ms-2"></i>
                        <span class="me-4">
                            <i class="fa-solid fa-user-circle fa-lg text-secondary"></i>{{ session('user.username') ?? '[username]' }}
                        </span>
                    </a>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm px-3">
                    Logout<i class="bi bi-box-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>