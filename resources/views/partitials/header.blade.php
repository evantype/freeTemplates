<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ url('/') }}" class="nav-link px-2 text-white">Главная</a></li>
                <li><a href="{{ route('siteTemplates') }}" class="nav-link px-2 text-white">Шаблоны сайтов</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Поиск..."
                       aria-label="Search">
            </form>

            <div class="text-end">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Войти</a>
                    <a href="{{ route('register') }}" class="btn btn-warning">Зарегистрироваться</a>
                @else
                    <a href="{{ route('logout') }}" class="btn btn-warning">Выйти</a>
                @endguest
            </div>
        </div>
    </div>
</header>
