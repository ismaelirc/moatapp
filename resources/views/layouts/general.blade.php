<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://www.moat.ai/">Moat.ai</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <a class="nav-link" href="{{route('logout').'?token='.JWTAuth::getToken()}}">Sign out</a>
        </li>
    </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('home').'?token='.JWTAuth::getToken()}}">
                            <span data-feather="home"></span>
                            Artist list
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('album').'?token='.JWTAuth::getToken()}}">
                            <span data-feather="file"></span>
                            Albuns
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>