@extends('e-commerce.layouts-commerce.template-commerce')
@section('content')
<header class="bg-dark">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img src="assets-commerce/image/1.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block text-dark">
                                <h5> <span class="badge bg-danger">Second slide label</span></h5>
                                <p> <span class="badge bg-danger"> Some representative placeholder content for the second slide.</span></p>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="assets-commerce/image/1.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block badge">
                                <h5> <span class="badge bg-danger">Second slide label</span></h5>
                                <p> <span class="badge bg-danger"> Some representative placeholder content for the second slide.</span></p>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="assets-commerce/image/1.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block text-dark">
                              <h5> <span class="badge bg-danger">Second slide label</span></h5>
                                <p> <span class="badge bg-danger"> Some representative placeholder content for the second slide.</span></p>
                            </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
            
        </header>
        <!-- Section-->

        <section class="py-5 bg-dark" id="about">
            <div class="container">
                <h3 class="text-white text-center">ABOUT</h3>
                <div class="border"></div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 mb-5">
                        <div class="">
                          <p class="text-justify text-white">
                            Kami adalah penyedia sparepart resmi Yamaha dengan komitmen menghadirkan produk berkualitas untuk menjaga performa motor Anda tetap optimal. Berpengalaman di dunia otomotif, kami menyediakan berbagai pilihan suku cadang asli mulai dari mesin, kelistrikan, hingga aksesoris pendukung.
                          </p> 
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-5 align-content-center">
                           <img src="assets-commerce/image/1.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-secondary">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <!-- YANG DI PAKEK -->
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <!-- <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." /> -->
                            <img class="card-img-top" src="assets-commerce/image/images.jpeg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Sale Item</h5>
                                    Rp. 25.000
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <!-- <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." /> -->
                            <img class="card-img-top" src="assets-commerce/image/images.jpeg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Sale Item</h5>
                                    <!-- Product price-->
                                    Rp. 25.000
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <!-- BATAS -->
                   
                </div>
            </div>
        </section>
@endsection