<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Inicio · Centro Ibero Meneses
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilo_menu.css') }}">
</head>

<body>
<div class="bg-shape">
</div>
<header>
    <img src="{{ asset('assets/logo.png') }}" alt="Centro Ibero Meneses">
    <div class="header-right">
        <div class="user-chip">
            <div class="avatar">
                {{ $otros->initNombre }}{{ $otros->initApPat }}
            </div>
            <span>
                    {{ $persona->nombre }} {{ $persona->ap_pat }}
                </span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Cerrar sesión" aria-label="Cerrar sesión">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <path d="M16 17l5-5-5-5" />
                    <path d="M21 12H9" />
                </svg>
            </button>
        </form>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <path d="M16 17l5-5-5-5" />
            <path d="M21 12H9" />
        </svg>
    </div>
</header>
<main>
    <p class="eyebrow">
        Centro Ibero Meneses
    </p>
    <h1>
        Accesos
    </h1>
    <a href="{{ route('personas-centro.index') }}" class="primary-action">
        <div class="icon-frame">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1.5" />
                <rect x="14" y="3" width="7" height="7" rx="1.5" />
                <rect x="3" y="14" width="7" height="7" rx="1.5" />
                <rect x="14" y="14" width="7" height="7" rx="1.5" />
            </svg>
        </div>
        <div class="txt">
            <strong>
                Sistema
            </strong>
            <p>
                Registro digital de centro meneses
            </p>
        </div>
        <svg class="arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14" />
            <path d="M13 6l6 6-6 6" />
        </svg>
    </a>
    <a href="{{ route('personas-centro.index') }}" class="primary-action">
        <div class="icon-frame">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1.5" />
                <rect x="14" y="3" width="7" height="7" rx="1.5" />
                <rect x="3" y="14" width="7" height="7" rx="1.5" />
                <rect x="14" y="14" width="7" height="7" rx="1.5" />
            </svg>
        </div>
        <div class="txt">
            <strong>
                Estadísticas
            </strong>
            <p>
                Estadísticas del registro digital
            </p>
        </div>
        <svg class="arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14" />
            <path d="M13 6l6 6-6 6" />
        </svg>
    </a>
</main>
</body>

</html>
