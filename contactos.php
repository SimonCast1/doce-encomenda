<?php
$titulo_pagina = 'Contactos';
$pagina_ativa = 'contactos';
include 'includes/cabecalho.php';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
  <header class="mb-8">
    <h1 class="text-3xl md:text-4xl font-extrabold text-castanho">
      Contactos
    </h1>
  </header>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
    <!-- Dados da Loja -->
    <div class="bg-bege p-6 md:p-8 rounded-2xl border border-castanho/10 space-y-6">
      <div>
        <h2 class="text-xl font-bold text-castanho mb-2">Visita-nos</h2>
        <address class="not-italic text-base text-castanho/90">Rua dos Doces, 12, Lisboa</address>
      </div>

      <div>
        <h2 class="text-xl font-bold text-castanho mb-2">Contactos diretos</h2>
        <p class="text-base text-castanho/90">
          Telefone: <a href="tel:+351210000000" class="font-medium text-framboesa hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa rounded">+351 210 000 000</a>
        </p>
        <p class="text-base text-castanho/90 mt-1">
          Email: <a href="mailto:geral@doceencomenda.pt" class="font-medium text-framboesa hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa rounded">geral@doceencomenda.pt</a>
        </p>
      </div>

      <div>
        <h2 class="text-xl font-bold text-castanho mb-2">Horário de funcionamento</h2>
        <p class="text-base text-castanho/90">Segunda a Sábado: 08h às 19h</p>
        <p class="text-base text-castanho/90">Domingo: 08h às 13h</p>
      </div>

      <div>
        <h2 class="text-xl font-bold text-castanho mb-2">Redes sociais</h2>
        <p class="text-base text-castanho/90">
          <a href="#" class="font-medium text-framboesa hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa rounded">Instagram</a> | 
          <a href="#" class="font-medium text-framboesa hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa rounded">Facebook</a>
        </p>
      </div>
    </div>

    <!-- Mapa OpenStreetMap -->
    <div class="space-y-2">
      <div class="rounded-2xl overflow-hidden border border-castanho/10 shadow-sm">
        <iframe title="Mapa da zona da pastelaria" src="https://www.openstreetmap.org/export/embed.html?bbox=-9.1500%2C38.7050%2C-9.1250%2C38.7220&amp;layer=mapnik&amp;marker=38.7139%2C-9.1394" loading="lazy" class="w-full h-80 lg:h-[420px] border-0"></iframe>
      </div>
      <p class="text-xs text-castanho/70 italic text-center">
        Morada fictícia: o mapa mostra apenas a zona do Rossio, em Lisboa
      </p>
    </div>
  </div>
</div>

<?php
include 'includes/rodape.php';
?>
