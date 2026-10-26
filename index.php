<?php
$titulo_pagina = 'Início';
$pagina_ativa = 'inicio';
include 'includes/cabecalho.php';
?>

<!-- Secção Hero -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-8 md:py-16">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-bege/40 rounded-3xl p-6 md:p-12 border border-castanho/10">
    <div>
      <img src="<?= htmlspecialchars(caminho_imagem('imagens/hero.jpg')) ?>" alt="Montra com bolos e doçaria tradicional da Doce Encomenda" width="600" height="400" class="w-full h-64 md:h-80 object-cover rounded-2xl shadow-sm">
    </div>
    <div class="space-y-4">
      <h1 class="text-3xl md:text-5xl font-extrabold leading-tight text-castanho">
        Bolos por encomenda
      </h1>
      <p class="text-base md:text-lg text-castanho/80">
        Criamos bolos artesanais e doces tradicionais portugueses para os teus momentos especiais, preparados diariamente na nossa pastelaria em Lisboa.
      </p>
      <div class="pt-2">
        <a href="encomendas.php" class="inline-flex items-center justify-center min-h-11 px-6 py-3 bg-framboesa text-creme font-semibold rounded-xl hover:bg-framboesa/90 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">
          Fazer encomenda
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Secção de Destaques -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
  <h2 class="text-2xl md:text-3xl font-bold mb-6 text-castanho">
    Produtos em destaque
  </h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php
    // IDs ordenados conforme pedido no enunciado: Bolo de Chocolate, Pastel de Nata, Doce Conventual
    $ids_destaque = [1, 7, 4];
    $produtos_por_id = [];
    foreach ($produtos as $p) {
      $produtos_por_id[$p['id']] = $p;
    }

    foreach ($ids_destaque as $id) {
      if (isset($produtos_por_id[$id])) {
        $prod = $produtos_por_id[$id];
        $img_src = caminho_imagem($prod['imagem']);
        $preco_rotulo = texto_preco($prod);
        ?>
        <article class="flex flex-col bg-bege rounded-2xl p-5 border border-castanho/10 shadow-sm">
          <img src="<?= htmlspecialchars($img_src) ?>" alt="<?= htmlspecialchars($prod['nome']) ?>" width="400" height="300" loading="lazy" class="w-full h-48 object-cover rounded-xl mb-4 bg-creme">
          <h3 class="text-xl font-bold text-castanho">
            <?= htmlspecialchars($prod['nome']) ?>
          </h3>
          <p class="text-sm font-semibold text-framboesa mt-1 mb-4">
            <?= htmlspecialchars($preco_rotulo) ?>
          </p>
          <div class="mt-auto pt-2">
            <a href="produtos.php" class="inline-flex items-center justify-center w-full min-h-11 px-4 py-2 border border-castanho/30 bg-creme text-castanho font-medium rounded-xl hover:bg-castanho hover:text-creme focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">
              Ver
            </a>
          </div>
        </article>
        <?php
      }
    }
    ?>
  </div>
</section>

<!-- Secção Horário de Funcionamento -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
  <div class="bg-bege rounded-2xl p-6 md:p-8 text-center border border-castanho/10">
    <h2 class="text-xl md:text-2xl font-bold text-castanho mb-3">
      Horário de funcionamento
    </h2>
    <p class="text-base text-castanho font-medium">Seg-Sáb 08h-19h</p>
    <p class="text-base text-castanho font-medium">Dom 08h-13h</p>
  </div>
</section>

<?php
include 'includes/rodape.php';
?>
