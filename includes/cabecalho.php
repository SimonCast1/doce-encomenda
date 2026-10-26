<?php
// Garante acesso aos produtos e funções auxiliares em todas as páginas
require_once __DIR__ . '/produtos.php';
?>
<!DOCTYPE html>
<html lang="pt-PT">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Doce Encomenda: pastelaria tradicional e bolos por encomenda em Lisboa.">
    <title><?= htmlspecialchars($titulo_pagina) ?> | Doce Encomenda</title>

    <!-- Tailwind CSS por CDN com paleta do projeto -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              creme: '#FFF7EF',
              bege: '#F3E4D3',
              castanho: '#3E2723',
              framboesa: '#B5485D',
              erro: '#9B1C1C'
            }
          }
        }
      };
    </script>

    <!-- Ícone do separador do browser -->
    <link rel="icon" type="image/svg+xml" href="imagens/favicon.svg">
    <!-- Regras complementares que o Tailwind não cobre -->
    <link rel="stylesheet" href="css/estilo.css">
  </head>
  <body class="bg-creme text-castanho min-h-screen flex flex-col antialiased">
    <!-- Ligação acessível para saltar navegação -->
    <a href="#conteudo-principal" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 focus:p-3 focus:bg-framboesa focus:text-creme focus:rounded-md focus:outline-none">
      Saltar para o conteúdo
    </a>

    <header class="bg-creme border-b border-castanho/15 sticky top-0 z-40">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
        <a href="index.php" class="flex items-center min-h-11 text-xl font-bold tracking-tight text-castanho hover:text-framboesa focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">
          Doce Encomenda
        </a>

        <!-- Botão hambúrguer para ecrãs pequenos -->
        <button type="button" id="botao-menu" aria-controls="menu-principal" aria-expanded="false" aria-label="Abrir menu de navegação" class="md:hidden flex items-center justify-center w-11 h-11 rounded-lg border border-castanho/20 text-castanho hover:bg-bege focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>

        <!-- Navegação principal -->
        <nav id="menu-principal" aria-label="Menu principal" class="hidden md:flex absolute md:static top-full left-0 right-0 bg-creme md:bg-transparent border-b md:border-b-0 border-castanho/15 md:p-0 px-4 py-4 shadow-md md:shadow-none">
          <ul class="flex flex-col md:flex-row md:items-center gap-1 md:gap-6 w-full md:w-auto">
            <?php
            $itens_menu = [
              'inicio' => ['label' => 'Início', 'url' => 'index.php'],
              'sobre' => ['label' => 'Sobre nós', 'url' => 'sobre.php'],
              'produtos' => ['label' => 'Produtos', 'url' => 'produtos.php'],
              'encomendas' => ['label' => 'Encomendas', 'url' => 'encomendas.php'],
              'contactos' => ['label' => 'Contactos', 'url' => 'contactos.php']
            ];

            foreach ($itens_menu as $chave => $item) {
              $ativo = ($pagina_ativa === $chave);
              $classes_link = 'flex items-center min-h-11 px-3 py-2 text-base font-medium rounded-md transition motion-reduce:transition-none hover:text-framboesa focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2';
              if ($ativo) {
                $classes_link .= ' text-framboesa border-b-2 border-framboesa font-semibold';
              } else {
                $classes_link .= ' text-castanho';
              }
              $aria_current = $ativo ? ' aria-current="page"' : '';

              echo '<li><a href="' . htmlspecialchars($item['url']) . '" class="' . $classes_link . '"' . $aria_current . '>' . htmlspecialchars($item['label']) . '</a></li>';
            }
            ?>
          </ul>
        </nav>
      </div>
    </header>

    <main id="conteudo-principal" class="flex-grow">
