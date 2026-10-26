// Gestão da abertura e fecho do menu em ecrãs móveis
const botaoMenu = document.getElementById('botao-menu');
const navegacao = document.getElementById('menu-principal');

if (botaoMenu && navegacao) {
  botaoMenu.addEventListener('click', function () {
    const estaAberto = botaoMenu.getAttribute('aria-expanded') === 'true';
    botaoMenu.setAttribute('aria-expanded', String(!estaAberto));
    navegacao.classList.toggle('hidden');
  });
}
