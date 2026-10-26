<?php
$titulo_pagina = 'Produtos';
$pagina_ativa = 'produtos';
include 'includes/cabecalho.php';

// Leitura e sanitização dos parâmetros do filtro
$pesquisa = isset($_GET['q']) ? trim($_GET['q']) : '';
$categoria_selecionada = isset($_GET['categoria']) ? trim($_GET['categoria']) : 'Todas';

$categorias_validas = ['Todas', 'Bolos', 'Doces tradicionais', 'Pastelaria'];
if (!in_array($categoria_selecionada, $categorias_validas, true)) {
  $categoria_selecionada = 'Todas';
}

// Filtragem em memória
$produtos_filtrados = [];
foreach ($produtos as $p) {
  $cumpre_categoria = ($categoria_selecionada === 'Todas' || $p['categoria'] === $categoria_selecionada);

  $cumpre_pesquisa = true;
  if ($pesquisa !== '') {
    $no_nome = (mb_stripos($p['nome'], $pesquisa) !== false);
    $na_descricao = (mb_stripos($p['descricao'], $pesquisa) !== false);
    $cumpre_pesquisa = ($no_nome || $na_descricao);
  }

  if ($cumpre_categoria && $cumpre_pesquisa) {
    $produtos_filtrados[] = $p;
  }
}

$total_resultados = count($produtos_filtrados);
if ($total_resultados === 1) {
  $rotulo_resultados = '1 produto';
} elseif ($total_resultados > 1) {
  $rotulo_resultados = $total_resultados . ' produtos';
} else {
  $rotulo_resultados = 'Nenhum produto encontrado';
}
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
  <header class="mb-8">
    <h1 class="text-3xl md:text-4xl font-extrabold text-castanho">
      Os nossos produtos
    </h1>
    <p class="text-base md:text-lg text-castanho/80 mt-2">
      Descobre a nossa seleção de doçaria portuguesa confecionada com receitas tradicionais e ingredientes selecionados.
    </p>
  </header>

  <!-- Formulário de Filtro e Pesquisa -->
  <form method="get" action="produtos.php" class="bg-bege p-4 md:p-6 rounded-2xl border border-castanho/10 mb-8 flex flex-col md:flex-row gap-4 items-stretch md:items-end">
    <div class="flex-grow space-y-1">
      <label for="campo-q" class="block text-sm font-semibold text-castanho">Pesquisar</label>
      <input type="text" id="campo-q" name="q" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Pesquisar produtos..." class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
    </div>

    <div class="w-full md:w-56 space-y-1">
      <label for="campo-categoria" class="block text-sm font-semibold text-castanho">Categoria</label>
      <select id="campo-categoria" name="categoria" class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        <?php
        foreach ($categorias_validas as $cat) {
          $selected = ($categoria_selecionada === $cat) ? ' selected' : '';
          echo '<option value="' . htmlspecialchars($cat) . '"' . $selected . '>' . htmlspecialchars($cat) . '</option>';
        }
        ?>
      </select>
    </div>

    <div>
      <button type="submit" class="w-full md:w-auto min-h-11 px-6 py-2 bg-framboesa text-creme font-semibold rounded-xl hover:bg-framboesa/90 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">
        Filtrar
      </button>
    </div>
  </form>

  <!-- Contador de Resultados -->
  <p class="text-sm font-medium text-castanho/80 mb-6">
    <?= htmlspecialchars($rotulo_resultados) ?>
  </p>

  <!-- Grelha de Produtos: sem botão "Ver", com todos os detalhes e lista de tamanhos -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php
    foreach ($produtos_filtrados as $prod) {
      $img_src = caminho_imagem($prod['imagem']);
      ?>
      <article class="flex flex-col bg-bege rounded-2xl p-5 border border-castanho/10 shadow-sm">
        <img src="<?= htmlspecialchars($img_src) ?>" alt="<?= htmlspecialchars($prod['nome']) ?>" width="400" height="300" loading="lazy" class="w-full h-48 object-cover rounded-xl mb-4 bg-creme">
        <p class="text-xs uppercase tracking-wider font-bold text-framboesa mb-1">
          <?= htmlspecialchars($prod['categoria']) ?>
        </p>
        <h2 class="text-xl font-bold text-castanho">
          <?= htmlspecialchars($prod['nome']) ?>
        </h2>
        <p class="text-sm text-castanho/80 mt-2 mb-4">
          <?= htmlspecialchars($prod['descricao']) ?>
        </p>

        <div class="mt-auto pt-3 border-t border-castanho/15">
          <p class="text-xs font-semibold text-castanho uppercase tracking-wider mb-2">Tamanhos e Preços:</p>
          <ul class="text-sm space-y-1">
            <?php
            foreach ($prod['tamanhos'] as $tam) {
              echo '<li class="flex justify-between text-castanho"><span class="font-medium">' . htmlspecialchars($tam['nome']) . '</span><span>' . htmlspecialchars(formatar_preco($tam['preco'])) . '</span></li>';
            }
            ?>
          </ul>
        </div>
      </article>
      <?php
    }
    ?>
  </div>
</div>

<?php
include 'includes/rodape.php';
?>
