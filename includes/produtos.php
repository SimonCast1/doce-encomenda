<?php
// Catálogo de produtos da pastelaria
$produtos = [
  [
    'id' => 1,
    'nome' => 'Bolo de Chocolate',
    'categoria' => 'Bolos',
    'destaque' => true,
    'descricao' => 'Bolo húmido de chocolate, com cobertura de ganache.',
    'imagem' => 'imagens/bolo-chocolate.jpg',
    'tamanhos' => [
      ['nome' => '1 kg', 'preco' => 18],
      ['nome' => '2 kg', 'preco' => 34]
    ]
  ],
  [
    'id' => 2,
    'nome' => 'Pão de Ló',
    'categoria' => 'Bolos',
    'destaque' => false,
    'descricao' => 'Pão de ló tradicional, fofo e ligeiramente húmido no centro.',
    'imagem' => 'imagens/pao-de-lo.jpg',
    'tamanhos' => [
      ['nome' => '800 g', 'preco' => 15]
    ]
  ],
  [
    'id' => 3,
    'nome' => 'Bolo de Bolacha',
    'categoria' => 'Bolos',
    'destaque' => false,
    'descricao' => 'Camadas de bolacha Maria com creme de café e manteiga.',
    'imagem' => 'imagens/bolo-bolacha.jpg',
    'tamanhos' => [
      ['nome' => '1 kg', 'preco' => 16]
    ]
  ],
  [
    'id' => 4,
    'nome' => 'Doce Conventual',
    'categoria' => 'Doces tradicionais',
    'destaque' => true,
    'descricao' => 'Doce de ovos e amêndoa, de inspiração conventual.',
    'imagem' => 'imagens/doce-conventual.jpg',
    'tamanhos' => [
      ['nome' => 'Unidade', 'preco' => 2.5]
    ]
  ],
  [
    'id' => 5,
    'nome' => 'Toucinho do Céu',
    'categoria' => 'Doces tradicionais',
    'destaque' => false,
    'descricao' => 'Bolo de amêndoa e ovos, denso e muito doce.',
    'imagem' => 'imagens/toucinho-do-ceu.jpg',
    'tamanhos' => [
      ['nome' => 'Fatia (120 g)', 'preco' => 3]
    ]
  ],
  [
    'id' => 6,
    'nome' => 'Ovos Moles',
    'categoria' => 'Doces tradicionais',
    'destaque' => false,
    'descricao' => 'Creme de gemas dentro de uma fina massa de hóstia.',
    'imagem' => 'imagens/ovos-moles.jpg',
    'tamanhos' => [
      ['nome' => 'Caixa de 6', 'preco' => 4.5]
    ]
  ],
  [
    'id' => 7,
    'nome' => 'Pastel de Nata',
    'categoria' => 'Pastelaria',
    'destaque' => true,
    'descricao' => 'Massa folhada estaladiça com creme de ovos.',
    'imagem' => 'imagens/pastel-de-nata.jpg',
    'tamanhos' => [
      ['nome' => 'Unidade (60 g)', 'preco' => 1.2]
    ]
  ],
  [
    'id' => 8,
    'nome' => 'Queijada',
    'categoria' => 'Pastelaria',
    'destaque' => false,
    'descricao' => 'Pequena queijada de queijo fresco e canela.',
    'imagem' => 'imagens/queijada.jpg',
    'tamanhos' => [
      ['nome' => 'Unidade (80 g)', 'preco' => 1.5]
    ]
  ],
  [
    'id' => 9,
    'nome' => 'Travesseiro',
    'categoria' => 'Pastelaria',
    'destaque' => false,
    'descricao' => 'Massa folhada recheada com creme de amêndoa.',
    'imagem' => 'imagens/travesseiro.jpg',
    'tamanhos' => [
      ['nome' => 'Unidade (90 g)', 'preco' => 1.8]
    ]
  ]
];

// Formata o valor com vírgula e símbolo colado (ex.: 18€ ou 1,20€)
function formatar_preco($valor) {
  if (fmod((float)$valor, 1.0) == 0.0) {
    return number_format((float)$valor, 0, ',', '') . '€';
  }
  return number_format((float)$valor, 2, ',', '') . '€';
}

// Apresenta "desde X€" quando existem múltiplos tamanhos
function texto_preco($produto) {
  $preco_base = formatar_preco($produto['tamanhos'][0]['preco']);
  if (count($produto['tamanhos']) > 1) {
    return 'desde ' . $preco_base;
  }
  return $preco_base;
}

// Garante uma imagem alternativa se o ficheiro ainda não existir no disco
function caminho_imagem($caminho) {
  if (!empty($caminho) && file_exists($caminho)) {
    return $caminho;
  }
  return 'imagens/placeholder.svg';
}
