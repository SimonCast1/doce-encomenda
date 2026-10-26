# Doce Encomenda

Site de uma pastelaria de bairro em Lisboa (bolos por encomenda e doçaria tradicional). Trabalho da unidade curricular Aplicações Web (ISCAC), por Simão Castelhano e Hugo Rua.

Os dados da loja (morada, telefone, nomes da equipa) são fictícios.

## Estado

Entrega 2: estrutura e formatação em HTML e CSS, em PHP com cabeçalho e rodapé partilhados.

- O formulário de encomendas ainda não envia nada. O campo Tamanho só vai ser preenchido quando houver JavaScript (Alpine.js), na fase seguinte.
- Sem base de dados por agora. Os produtos estão num array em `includes/produtos.php`.

## Como correr

É preciso PHP 8 (por exemplo, o do XAMPP). Na pasta do projeto:

```
php -S localhost:8000
```

No XAMPP em Windows: `C:\xampp\php\php.exe -S localhost:8000`. Depois abrir http://localhost:8000.

## Estrutura

```
index.php          página inicial (destaques e horário)
produtos.php       catálogo com pesquisa (?q=) e filtro por categoria (?categoria=)
sobre.php          história, equipa e galeria
encomendas.php     formulário de encomenda (validação HTML5)
contactos.php      morada, telefone, email, horário e mapa
includes/
  cabecalho.php    <head>, cabeçalho e menu (usa $titulo_pagina e $pagina_ativa)
  rodape.php       rodapé e fecho do documento
  produtos.php     lista de produtos e funções de preço e imagem
css/estilo.css     estilos extra, além do Tailwind
js/menu.js         abrir e fechar o menu em mobile
imagens/           fotografias dos produtos, equipa e galeria
```

## Tecnologias

- PHP, com includes partilhados
- Tailwind CSS (via CDN), com as cores da marca definidas em `includes/cabecalho.php`
- HTML semântico e responsivo (testado a 360 e 1280 px)

## Imagens

As fotografias foram geradas com IA (Google AI Studio) e comprimidas para JPG de largura máxima 800 px (1000 px no hero). Quando uma imagem não existe, o site mostra `imagens/placeholder.svg`.
