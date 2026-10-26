<?php
$titulo_pagina = 'Sobre nós';
$pagina_ativa = 'sobre';
include 'includes/cabecalho.php';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-12">
  <header>
    <h1 class="text-3xl md:text-4xl font-extrabold text-castanho">
      Sobre nós
    </h1>
  </header>

  <!-- TEXTO FICTÍCIO: rever antes de entregar -->
  <section class="space-y-4 max-w-3xl">
    <h2 class="text-2xl font-bold text-castanho">A nossa história</h2>
    <p class="text-base text-castanho/90 leading-relaxed">
      A Doce Encomenda nasceu no coração de um dos bairros mais carismáticos de Lisboa, com a missão simples de devolver o tempo e o carinho às receitas tradicionais portuguesas. O que começou como uma paixão de domingo em família depressa se transformou numa referência para quem procura sabores autênticos.
    </p>
    <p class="text-base text-castanho/90 leading-relaxed">
      Trabalhamos diariamente com matérias-primas de produtores locais: ovos frescos da região, amêndoa do Algarve e farinhas selecionadas. Recusamos processos industriais acelerados, permitindo que cada massa descanse o tempo necessário e que cada calda de açúcar atinja o ponto perfeito.
    </p>
    <p class="text-base text-castanho/90 leading-relaxed">
      Hoje, a nossa equipa continua a confecionar diariamente bolos de aniversário por encomenda, sobremesas conventuais e os clássicos pastéis que acompanham as manhãs do bairro, mantendo sempre o rigor, a simpatia e o aroma a canela que nos caracteriza.
    </p>
  </section>

  <!-- TEXTO FICTÍCIO: rever antes de entregar -->
  <section class="space-y-6">
    <h2 class="text-2xl font-bold text-castanho">Quem está por trás da pastelaria</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <article class="flex flex-col sm:flex-row items-center gap-4 bg-bege p-5 rounded-2xl border border-castanho/10">
        <img src="<?= htmlspecialchars(caminho_imagem('imagens/equipa-1.jpg')) ?>" alt="Retrato da pasteleira principal" width="160" height="160" loading="lazy" class="w-32 h-32 object-cover rounded-xl bg-creme">
        <div>
          <h3 class="text-lg font-bold text-castanho">Maria Inês Ramos</h3>
          <p class="text-sm font-semibold text-framboesa mb-1">Mestre Pasteleira</p>
          <p class="text-sm text-castanho/80">Responsável pela confeção dos bolos de celebração e pela pesquisa das antigas receitas conventuais de ovos.</p>
        </div>
      </article>

      <article class="flex flex-col sm:flex-row items-center gap-4 bg-bege p-5 rounded-2xl border border-castanho/10">
        <img src="<?= htmlspecialchars(caminho_imagem('imagens/equipa-2.jpg')) ?>" alt="Retrato do responsável de balcão e atendimento" width="160" height="160" loading="lazy" class="w-32 h-32 object-cover rounded-xl bg-creme">
        <div>
          <h3 class="text-lg font-bold text-castanho">António Duarte</h3>
          <p class="text-sm font-semibold text-framboesa mb-1">Responsável de Balcão e Encomendas</p>
          <p class="text-sm text-castanho/80">Garante que cada cliente recebe aconselhamento personalizado e que todas as encomendas saem a tempo.</p>
        </div>
      </article>
    </div>
  </section>

  <!-- Galeria de Fotos Quadradas -->
  <section class="space-y-6">
    <h2 class="text-2xl font-bold text-castanho">Galeria</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
      <?php
      for ($i = 1; $i <= 6; $i++) {
        $caminho_galeria = caminho_imagem("imagens/galeria-{$i}.jpg");
        ?>
        <figure class="bg-bege rounded-2xl overflow-hidden border border-castanho/10 shadow-sm">
          <img src="<?= htmlspecialchars($caminho_galeria) ?>" alt="Fotografia <?= $i ?> do espaço e produtos da Doce Encomenda" width="400" height="400" loading="lazy" class="w-full aspect-square object-cover">
        </figure>
        <?php
      }
      ?>
    </div>
  </section>
</div>

<?php
include 'includes/rodape.php';
?>
