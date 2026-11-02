<?php
$titulo_pagina = 'Encomendas';
$pagina_ativa = 'encomendas';
include 'includes/cabecalho.php';

// Valores submetidos (vazios na primeira visita)
$v = [];
foreach (['produto', 'quantidade', 'data', 'hora', 'nome', 'telefone', 'email', 'observacoes'] as $campo) {
  $v[$campo] = trim($_POST[$campo] ?? '');
}
if ($v['quantidade'] === '') {
  $v['quantidade'] = '1';
}

$erros = [];
$resumo = null;
$limite_antecedencia = new DateTime('+48 hours');
$data_minima = $limite_antecedencia->format('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Produto e tamanho vêm juntos no formato "id-indice"
  $item = null;
  if (preg_match('/^(\d+)-(\d+)$/', $v['produto'], $m)) {
    foreach ($produtos as $p) {
      if ($p['id'] === (int)$m[1] && isset($p['tamanhos'][(int)$m[2]])) {
        $item = ['produto' => $p, 'tamanho' => $p['tamanhos'][(int)$m[2]]];
      }
    }
  }
  if ($item === null) {
    $erros['produto'] = 'Escolhe um produto e tamanho.';
  }

  if (!ctype_digit($v['quantidade']) || (int)$v['quantidade'] < 1 || (int)$v['quantidade'] > 20) {
    $erros['quantidade'] = 'A quantidade tem de ser entre 1 e 20.';
  }

  $levantamento = DateTime::createFromFormat('Y-m-d H:i', $v['data'] . ' ' . $v['hora']);
  if (!$levantamento || $levantamento->format('Y-m-d H:i') !== $v['data'] . ' ' . $v['hora']) {
    $erros['data'] = 'Indica uma data e uma hora de levantamento válidas.';
  } elseif ($levantamento < $limite_antecedencia) {
    $erros['data'] = 'A encomenda tem de ser feita com pelo menos 48 horas de antecedência.';
  } else {
    // Dom 08h-13h, restantes dias 08h-19h
    $domingo = $levantamento->format('w') === '0';
    $hora_max = $domingo ? '13:00' : '19:00';
    $hora = $levantamento->format('H:i');
    if ($hora < '08:00' || $hora > $hora_max) {
      $erros['data'] = 'Aos ' . ($domingo ? 'domingos' : 'restantes dias') . ' o levantamento é entre as 08h e as ' . ($domingo ? '13h' : '19h') . '.';
    }
  }

  if (mb_strlen($v['nome']) < 3) {
    $erros['nome'] = 'O nome tem de ter pelo menos 3 caracteres.';
  }
  if (!preg_match('/^(\+351 ?)?[29][0-9]{2} ?[0-9]{3} ?[0-9]{3}$/', $v['telefone'])) {
    $erros['telefone'] = 'Indica um telefone com 9 dígitos, por exemplo 912 345 678.';
  }
  if ($v['email'] !== '' && !filter_var($v['email'], FILTER_VALIDATE_EMAIL)) {
    $erros['email'] = 'O email não parece válido.';
  }
  if (mb_strlen($v['observacoes']) > 200) {
    $erros['observacoes'] = 'As observações podem ter no máximo 200 caracteres.';
  }

  if (!$erros) {
    $resumo = [
      'item' => $item,
      'quantidade' => (int)$v['quantidade'],
      'total' => $item['tamanho']['preco'] * (int)$v['quantidade'],
      'levantamento' => $levantamento,
    ];
  }
}

// Mensagem de erro de um campo
function erro_campo($erros, $campo) {
  if (!isset($erros[$campo])) {
    return '';
  }
  return '<p id="erro-' . $campo . '" class="text-sm font-semibold text-erro" role="alert">' . htmlspecialchars($erros[$campo]) . '</p>';
}

// Atributos de acessibilidade para campos com erro
function attr_erro($erros, $campo) {
  return isset($erros[$campo]) ? ' aria-invalid="true" aria-describedby="erro-' . $campo . '"' : '';
}
?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
  <header class="mb-8">
    <h1 class="text-3xl md:text-4xl font-extrabold text-castanho">
      Fazer uma encomenda
    </h1>
    <p class="text-base md:text-lg text-castanho/80 mt-2">
      Levantamento na pastelaria. Encomendas com pelo menos 48 horas de antecedência.
    </p>
  </header>

  <?php if ($resumo): ?>
  <section class="bg-bege p-6 md:p-8 rounded-2xl border border-castanho/10 space-y-4" aria-labelledby="titulo-resumo">
    <h2 id="titulo-resumo" class="text-2xl font-bold text-castanho">Resumo da encomenda</h2>
    <p class="text-castanho/80">Confirma os dados. Ainda não guardámos nada: esta fase só mostra o resumo.</p>
    <dl class="grid grid-cols-1 sm:grid-cols-[auto_1fr] gap-x-6 gap-y-2 text-castanho">
      <dt class="font-semibold">Produto</dt>
      <dd><?= htmlspecialchars($resumo['item']['produto']['nome']) ?> (<?= htmlspecialchars($resumo['item']['tamanho']['nome']) ?>)</dd>
      <dt class="font-semibold">Quantidade</dt>
      <dd><?= $resumo['quantidade'] ?></dd>
      <dt class="font-semibold">Total</dt>
      <dd><?= formatar_preco($resumo['total']) ?></dd>
      <dt class="font-semibold">Levantamento</dt>
      <dd><?= $resumo['levantamento']->format('d/m/Y') ?> às <?= $resumo['levantamento']->format('H:i') ?></dd>
      <dt class="font-semibold">Nome</dt>
      <dd><?= htmlspecialchars($v['nome']) ?></dd>
      <dt class="font-semibold">Telefone</dt>
      <dd><?= htmlspecialchars($v['telefone']) ?></dd>
      <?php if ($v['email'] !== ''): ?>
      <dt class="font-semibold">Email</dt>
      <dd><?= htmlspecialchars($v['email']) ?></dd>
      <?php endif; ?>
      <?php if ($v['observacoes'] !== ''): ?>
      <dt class="font-semibold">Observações</dt>
      <dd><?= nl2br(htmlspecialchars($v['observacoes'])) ?></dd>
      <?php endif; ?>
    </dl>
    <a href="encomendas.php" class="inline-flex items-center min-h-11 px-6 py-2 bg-framboesa text-creme font-semibold rounded-xl hover:bg-framboesa/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">Fazer outra encomenda</a>
  </section>
  <?php else: ?>

  <?php if ($erros): ?>
  <div class="mb-6 p-4 rounded-xl border border-erro bg-creme text-erro" role="alert">
    <p class="font-bold">Há campos por corrigir. Vê as mensagens abaixo.</p>
  </div>
  <?php endif; ?>

  <form novalidate method="post" action="encomendas.php" class="bg-bege p-6 md:p-8 rounded-2xl border border-castanho/10 space-y-8">
    
    <!-- Grupo 1: O teu pedido -->
    <fieldset class="space-y-4">
      <legend class="text-xl font-bold text-castanho pb-2 border-b border-castanho/15 w-full">
        O teu pedido
      </legend>

      <div class="space-y-1">
        <label for="campo-produto" class="block text-sm font-semibold text-castanho">
          Produto e tamanho <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <select name="produto" id="campo-produto" required<?= attr_erro($erros, 'produto') ?> class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
          <option value="">Escolhe um produto...</option>
          <?php foreach ($produtos as $p): ?>
            <optgroup label="<?= htmlspecialchars($p['nome']) ?>">
              <?php foreach ($p['tamanhos'] as $i => $t): ?>
                <?php $valor = $p['id'] . '-' . $i; ?>
                <option value="<?= $valor ?>"<?= $v['produto'] === $valor ? ' selected' : '' ?>><?= htmlspecialchars($t['nome']) ?> · <?= formatar_preco($t['preco']) ?></option>
              <?php endforeach; ?>
            </optgroup>
          <?php endforeach; ?>
        </select>
        <?= erro_campo($erros, 'produto') ?>
      </div>

      <div class="space-y-1">
        <label for="campo-quantidade" class="block text-sm font-semibold text-castanho">
          Quantidade <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <input type="number" name="quantidade" id="campo-quantidade" min="1" max="20" value="<?= htmlspecialchars($v['quantidade']) ?>" required<?= attr_erro($erros, 'quantidade') ?> class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        <?= erro_campo($erros, 'quantidade') ?>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1">
          <label for="campo-data" class="block text-sm font-semibold text-castanho">
            Data de levantamento <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
          </label>
          <input type="date" name="data" id="campo-data" min="<?= $data_minima ?>" value="<?= htmlspecialchars($v['data']) ?>" required<?= attr_erro($erros, 'data') ?> class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        </div>

        <div class="space-y-1">
          <label for="campo-hora" class="block text-sm font-semibold text-castanho">
            Hora <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
          </label>
          <input type="time" name="hora" id="campo-hora" min="08:00" max="18:30" step="1800" value="<?= htmlspecialchars($v['hora']) ?>" required<?= attr_erro($erros, 'data') ?> class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        </div>
      </div>
      <?= erro_campo($erros, 'data') ?>
    </fieldset>

    <!-- Grupo 2: Os teus dados -->
    <fieldset class="space-y-4">
      <legend class="text-xl font-bold text-castanho pb-2 border-b border-castanho/15 w-full">
        Os teus dados
      </legend>

      <div class="space-y-1">
        <label for="campo-nome" class="block text-sm font-semibold text-castanho">
          Nome <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <input type="text" name="nome" id="campo-nome" required minlength="3" autocomplete="name" value="<?= htmlspecialchars($v['nome']) ?>"<?= attr_erro($erros, 'nome') ?> class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        <?= erro_campo($erros, 'nome') ?>
      </div>

      <div class="space-y-1">
        <label for="campo-telefone" class="block text-sm font-semibold text-castanho">
          Telefone <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <input type="tel" name="telefone" id="campo-telefone" required pattern="(\+351 ?)?[29][0-9]{2} ?[0-9]{3} ?[0-9]{3}" title="Telefone com 9 dígitos, por exemplo 912 345 678" autocomplete="tel" value="<?= htmlspecialchars($v['telefone']) ?>"<?= attr_erro($erros, 'telefone') ?> class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        <?= erro_campo($erros, 'telefone') ?>
      </div>

      <div class="space-y-1">
        <label for="campo-email" class="block text-sm font-semibold text-castanho">
          Email <span class="text-xs font-normal text-castanho/70">(opcional)</span>
        </label>
        <input type="email" name="email" id="campo-email" autocomplete="email" value="<?= htmlspecialchars($v['email']) ?>"<?= attr_erro($erros, 'email') ?> class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        <?= erro_campo($erros, 'email') ?>
      </div>

      <div class="space-y-1">
        <label for="campo-observacoes" class="block text-sm font-semibold text-castanho">
          Observações <span class="text-xs font-normal text-castanho/70">(opcional)</span>
        </label>
        <textarea name="observacoes" id="campo-observacoes" maxlength="200" rows="4"<?= attr_erro($erros, 'observacoes') ?> class="w-full p-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2"><?= htmlspecialchars($v['observacoes']) ?></textarea>
        <?= erro_campo($erros, 'observacoes') ?>
      </div>
    </fieldset>

    <div class="pt-2">
      <button type="submit" class="w-full md:w-auto min-h-11 px-8 py-3 bg-framboesa text-creme font-semibold rounded-xl hover:bg-framboesa/90 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">
        Enviar pedido
      </button>
    </div>
  </form>
  <?php endif; ?>
</div>

<?php
include 'includes/rodape.php';
?>
