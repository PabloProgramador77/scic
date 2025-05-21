<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CalzaSuite</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4"> 
                <div class="container-fluid"> 
                    <img src="{{ asset('/media/logo-calzasuite-removebg-preview.png') }}" width="250px" height="auto" alt="Logo CalzaSuite">
                    <div class="collapse navbar-collapse" id="navbarCollapse"> 
                        <ul class="navbar-nav me-auto mb-2 mb-md-0 px-5"> 
                            <li class="nav-item px-5"> 
                                <a class="nav-link active" aria-current="page" href="#">¿Qué es?</a> 
                            </li>
                            @if (Route::has('login'))
                                @auth
                                    <li class="nav-item"> 
                                        <a class="nav-link" href="{{ route('home') }}">Continuar</a> 
                                    </li>
                                @else
                                    <li class="nav-item"> 
                                        <a class="nav-link" href="{{ route('login') }}">Entrar</a> 
                                    </li>
                                @endauth

                            @endif
                            
                        </ul>
                    </div> 
                </div> 
            </nav>
            <div class="container-fluid px-4 py-5"> 
                <div class="row flex-lg-row-reverse align-items-center g-5 py-5"> 
                    <div class="col-10 col-sm-8 col-lg-6"> 
                        <img src="{{ asset('media/banner01.jpg') }}" class="d-block mx-lg-auto img-fluid rounded shadow" alt="Fabricante de calzado" width="680" height="500" loading="lazy"> 
                    </div> 
                    <div class="col-lg-6 p-5"> 
                        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Transforma tu fabrica de calzado con CalzaSuite</h1> 
                        <p class="lead">"Desde la configuración del modelo hasta el control de materiales, todo en una sola plataforma."</p> 
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-5">
                            @if (Route::has('register'))
                                <a href="{{route('register')}}" role="button" class="btn btn-outline-primary btn-lg px-4 me-md-2"><b>Registrarme</b></a>     
                            @endif 
                            
                            <a href="" role="button" class="btn btn-outline-secondary btn-lg px-4"><b>Conocer más</b></a> 
                        </div> 
                    </div> 
                </div> 
            </div>
            <div class="p-5 mb-4 bg-body-tertiary rounded-3"> 
                <div class="container-fluid py-5"> 
                    <h1 class="d-block display-5 fw-bold text-center">CalzaSuite</h1> 
                    <p class="d-block col-md-12 fs-4 text-center">Es la primer y única platatforma web para empresas de calzado que quieren transformar su productividad, estandárizar procesos y llevar el control de sus operaciones. Podrán realizar desde la configuración de modelos de calzado hasta la creación de documentos de producción.</p> 
                </div> 
            </div>
            <div class="row align-items-md-stretch"> 
                <div class="col-md-6"> 
                    <div class="h-100 p-5 text-bg-dark rounded-3"> 
                        <h2 class="fw-bold py-2">Configuración de modelos</h2> 
                        <p>Podrás dar de alta modelos de calzado, agregar piezas, costos, gastos, consumibles, suelas, numeraciones/tallas, etc.</p>
                    </div> 
                </div> 
                <div class="col-md-6"> 
                    <div class="h-100 p-5 bg-body-tertiary border rounded-3"> 
                        <h2 class="fw-bold py-2">Cotizaciones personalizadas</h2> 
                        <p>Realiza cotizaciones personalizadas de modelos configurados para tus clientes en menos de 5 minutos.</p>
                    </div> 
                </div> 
            </div>
            <div class="row align-items-md-stretch"> 
                <div class="col-md-6"> 
                    <div class="h-100 p-5 bg-body-tertiary border rounded-3"> 
                        <h2 class="fw-bold py-2">Generación de notas</h2> 
                        <p>Genera la nota de venta del cliente facilmente con todos los modelos cotizados.</p>
                    </div> 
                </div> 
                <div class="col-md-6"> 
                    <div class="h-100 p-5 text-bg-dark rounded-3"> 
                        <h2 class="fw-bold py-2">Documentos de producción</h2> 
                        <p>Generación automáticamente con un solo click de hojas de producción, solicitud de materiales, cálculo de consumos y otros más.</p>
                    </div> 
                </div> 
            </div>
        </div>
        <div class="container-fluid"> 
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top"> 
                <div class="col-md-4 d-flex align-items-center"> 
                    <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" aria-label="Bootstrap"> 
                        <svg class="bi" width="30" height="24" aria-hidden="true"><use xlink:href="#bootstrap"></use></svg> 
                    </a> 
                    <span class="mb-3 mb-md-0 text-body-secondary">© 2025 CalzaSuite</span> 
                </div> 
                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex"> 
                    <li class="ms-3">
                        Servicio diseñado y creador por 
                    </li> 
                    <li class="ms-3">
                        <a class="text-body-secondary" href="https://pabloprogramador.com.mx" target="_blank">
                            PabloProgramador
                        </a>
                    </li> 
                </ul> 
            </footer> 
        </div>
    </body>
</html>
