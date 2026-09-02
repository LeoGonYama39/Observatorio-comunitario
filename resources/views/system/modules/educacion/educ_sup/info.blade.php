@extends('system.app')

@section('title', 'Leonel Lora Vázquez · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('educ_sup.index') }}" data-url="{{ route('educ_sup.index') }}" class="return-index">
    Educación media-superior
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Leonel Lora Vázquez
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      Leonel Lora Vázquez
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
        CURP
      </label>
      <div class="value">
        CURPEJEMPLO12345
      </div>
    </div>
    <div class="info-field">
      <label>
        Edad
      </label>
      <div class="value">
        30 años
      </div>
    </div>
    <div class="info-field">
      <label>
        Matrícula
      </label>
      <div class="value">
        658545
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
      Rumbo a la uni
    </h3>
    <span class="meta-badge on">
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
    Ingreso: 8 de agosto, 2026
  </p>
  <div class="progress-summary">
    <span class="count">
      1 de 12 materias
    </span>
    <div class="progress-bar-track">
      <div class="progress-bar-fill" style="width: 8.3%;">
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
        Historia de México
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Matemáticas 
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Física
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Química
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Geografía
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Biología
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Ciencias de la salud
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Educación física
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Inglés
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Matemáticas avanzadas
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Literatura unviersal
      </span>
    </div>
    <div class="materia-box" onclick="toggleMateria(this)">
      <div class="check-circle">
      </div>
      <span>
        Programación
      </span>
    </div>
  </div>
</div>
<div class="progress-card">
  <div class="progress-top">
    <h3>
      Prepa abierta
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
    Ingreso: 1 de febrero, 2026
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
        Literatura
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Matemáticas
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Física
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Química
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Geografía
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Biología
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Ciencias de la salud
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Educación física
      </span>
    </div>
    <div class="materia-box done" onclick="toggleMateria(this)">
      <div class="check-circle">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </div>
      <span>
        Historia II
      </span>
    </div>
  </div>
</div>
<script>
  function toggleMateria(box) {
    box.classList.toggle('done');
    const check = box.querySelector('.check-circle');
    check.innerHTML = box.classList.contains('done')
      ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>': '';
  }
</script>
@endsection