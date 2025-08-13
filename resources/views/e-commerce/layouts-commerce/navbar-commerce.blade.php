 <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">
                    <img src="assets-commerce/image/logo-yamaha.png" alt="" class="" width="100" height="24">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                                <a class="btn btn-outline-light" href="/cart">
                                    <i class="bi-cart-fill me-1"></i>
                                    Cart
                                    <span id="cart-count" class="badge bg-dark text-white ms-1 rounded-pill">{{ $cartCount ?? 0 }}</span>
                                </a>
                        </li>
                    </ul>
                    
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    @if(!$user)
                        <a href="/login" class="btn btn-outline-info">Login</a>
                    @endif
                    @if($user)
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">Logout</button>
                        </form>
                    @endif

                </div>
            </div>
        </nav>
        <!-- Header-->