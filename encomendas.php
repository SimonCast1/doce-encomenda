<?php
$titulo_pagina = 'Encomendas';
$pagina_ativa = 'encomendas';
include 'includes/cabecalho.php';
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

  <!-- Formulário sem processamento backend nesta fase -->
  <form method="post" action="encomendas.php" class="bg-bege p-6 md:p-8 rounded-2xl border border-castanho/10 space-y-8">
    
    <!-- Grupo 1: O teu pedido -->
    <fieldset class="space-y-4">
      <legend class="text-xl font-bold text-castanho pb-2 border-b border-castanho/15 w-full">
        O teu pedido
      </legend>

      <div class="space-y-1">
        <label for="campo-produto" class="block text-sm font-semibold text-castanho">
          Produto <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <select name="produto" id="campo-produto" required class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
          <option value="">Escolhe um produto...</option>
          <?php
          foreach ($produtos as $p) {
            echo '<option value="' . (int)$p['id'] . '">' . htmlspecialchars($p['nome']) . '</option>';
          }
          ?>
        </select>
      </div>

      <div class="space-y-1">
        <label for="campo-tamanho" class="block text-sm font-semibold text-castanho">
          Tamanho <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <!-- Será preenchido em JavaScript numa fase posterior -->
        <select name="tamanho" id="campo-tamanho" required class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
          <option value="">Escolhe o produto primeiro</option>
        </select>
      </div>

      <div class="space-y-1">
        <label for="campo-quantidade" class="block text-sm font-semibold text-castanho">
          Quantidade <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <input type="number" name="quantidade" id="campo-quantidade" min="1" max="20" value="1" required class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1">
          <label for="campo-data" class="block text-sm font-semibold text-castanho">
            Data de levantamento <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
          </label>
          <input type="date" name="data" id="campo-data" required class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        </div>

        <div class="space-y-1">
          <label for="campo-hora" class="block text-sm font-semibold text-castanho">
            Hora <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
          </label>
          <input type="time" name="hora" id="campo-hora" min="08:00" max="18:30" step="1800" required class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
        </div>
      </div>
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
        <input type="text" name="nome" id="campo-nome" required minlength="3" autocomplete="name" class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
      </div>

      <div class="space-y-1">
        <label for="campo-telefone" class="block text-sm font-semibold text-castanho">
          Telefone <span class="text-xs font-normal text-castanho/70">(obrigatório)</span>
        </label>
        <input type="tel" name="telefone" id="campo-telefone" required pattern="(\+351 ?)?[29][0-9]{2} ?[0-9]{3} ?[0-9]{3}" title="Telefone com 9 dígitos, por exemplo 912 345 678" autocomplete="tel" class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
      </div>

      <div class="space-y-1">
        <label for="campo-email" class="block text-sm font-semibold text-castanho">
          Email <span class="text-xs font-normal text-castanho/70">(opcional)</span>
        </label>
        <input type="email" name="email" id="campo-email" autocomplete="email" class="w-full min-h-11 px-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2">
      </div>

      <div class="space-y-1">
        <label for="campo-observacoes" class="block text-sm font-semibold text-castanho">
          Observações <span class="text-xs font-normal text-castanho/70">(opcional)</span>
        </label>
        <textarea name="observacoes" id="campo-observacoes" maxlength="200" rows="4" class="w-full p-4 bg-creme text-castanho border border-castanho/20 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2"></textarea>
      </div>
    </fieldset>

    <div class="pt-2">
      <button type="submit" class="w-full md:w-auto min-h-11 px-8 py-3 bg-framboesa text-creme font-semibold rounded-xl hover:bg-framboesa/90 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">
        Enviar pedido
      </button>
    </div>
  </form>
</div>

<?php
include 'includes/rodape.php';
?>
