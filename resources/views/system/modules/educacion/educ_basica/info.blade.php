@extends('system.app')

@section('title', 'José Castillo Gaitan · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('educ_basica.index') }}" data-url="{{ route('educ_basica.index') }}" class="return-index">
    Educación básica
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    José Castillo Gaitan
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      José Castillo Gaitan
    </h1>
    <p>
      Ficha académica
    </p>
  </div>
  <div class="header-actions">
    <button class="btn-outline">
      <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                     >
        <path d="M12 20h9" />
        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
      </svg>
      Editar
    </button>
    <button class="btn-danger">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 6h18" />
        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
        <path
                           d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"
                        />
        <path d="M10 11v6" />
        <path d="M14 11v6" />
      </svg>
      Borrar
    </button>
  </div>
</div>
<div class="info-card" style="margin-bottom: 24px;">
  <h3>
    Información general
  </h3>
  <div class="info-grid">
    <div class="info-field">
      <label>
        RFE
      </label>
      <div class="value">
        123456789
      </div>
    </div>
    <div class="info-field">
      <label>
        Edad
      </label>
      <div class="value">
        13 años
      </div>
    </div>
    <div class="info-field">
      <label>
        CURP
      </label>
      <div class="value">
        CURPEJEMPLO123344
      </div>
    </div>
    <div class="info-field">
      <label>
        Sexo
      </label>
      <div class="value">
        Masculino
      </div>
    </div>
    <div class="info-field">
      <label>
        Colonia
      </label>
      <div class="value">
        Colonia 1
      </div>
    </div>
    <div class="info-field">
      <label>
        Teléfono
      </label>
      <div class="value">
        555-1234
      </div>
    </div>
  </div>
</div>
<div class="section-header">
  <h3>
    Cursos
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nueva inscripción
  </button>
</div>

<div class="progress-card">
  <div class="progress-top">
    <h3>
      Secundaria
    </h3>
    <span class="meta-badge">
      Activo
    </span>
    <button class="btn-danger btn-small">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 6h18"/>
        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        <path d="M10 11v6"/>
        <path d="M14 11v6"/>
      </svg>
      Eliminar
    </button>
  </div>
  <p class="progress-meta">
    Ingreso: 12 de diciembre, 2025
  </p>
  <div class="progress-summary">
    <span class="count">
      4 de 9 materias
    </span>
    <div class="progress-bar-track">
      <div class="progress-bar-fill" style="width: 44.44%;">
      </div>
    </div>
  </div>
  <div class="materias-grid">
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        LyC III
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        LyC VI
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        PM III
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        PM IV
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        PM V
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        VC II
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        VC III
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        DIV I
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        DIV II
      </span>
    </div>
  </div>
</div>

<div class="progress-card">
  <div class="progress-top">
    <h3>
      Primaria (12-14)
    </h3>
    <span class="meta-badge on">
      Completo
    </span>
    <button class="btn-danger btn-small">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 6h18"/>
        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        <path d="M10 11v6"/>
        <path d="M14 11v6"/>
      </svg>
      Eliminar
    </button>
  </div>
  <p class="progress-meta">
    Ingreso: 12 de diciembre, 2025
  </p>
  <div class="progress-summary">
    <span class="count">
      9 de 9 materias
    </span>
    <div class="progress-bar-track">
      <div class="progress-bar-fill" style="width: 100%;">
      </div>
    </div>
  </div>
  <div class="materias-grid">
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        LP
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        PE
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        MPE
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        LyC I
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        LyC II
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        PM I
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        PM II
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        VC I
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        DIV I
      </span>
    </div>
  </div>
</div>

<script>
  function toggleMateria(box) {
    box.classList.toggle('done');
    const check = box.querySelector('.check-circle');
    check.innerHTML = box.classList.contains('done')
      ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>'
      : '';
  }
</script>

@endsection