// Lógica das páginas (substitui o PHP): destaques, filtro de produtos e formulário de encomendas

function formatarPreco(valor) {
  const txt = Number.isInteger(valor) ? String(valor) : valor.toFixed(2).replace('.', ',');
  return txt + '€';
}

function textoPreco(p) {
  const base = formatarPreco(p.tamanhos[0].preco);
  return p.tamanhos.length > 1 ? 'desde ' + base : base;
}

function esc(t) {
  return String(t).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
}

// ---------- Início: produtos em destaque ----------
const caixaDestaques = document.getElementById('destaques');
if (caixaDestaques) {
  caixaDestaques.innerHTML = [1, 7, 4].map(id => produtos.find(p => p.id === id)).filter(Boolean).map(p => `
    <article class="flex flex-col bg-bege rounded-2xl p-5 border border-castanho/10 shadow-sm">
      <img src="${esc(p.imagem)}" alt="${esc(p.nome)}" width="400" height="300" loading="lazy" class="w-full h-48 object-cover rounded-xl mb-4 bg-creme">
      <h3 class="text-xl font-bold text-castanho">${esc(p.nome)}</h3>
      <p class="text-sm font-semibold text-framboesa mt-1 mb-4">${esc(textoPreco(p))}</p>
      <div class="mt-auto pt-2">
        <a href="produtos.html" class="inline-flex items-center justify-center w-full min-h-11 px-4 py-2 border border-castanho/30 bg-creme text-castanho font-medium rounded-xl hover:bg-castanho hover:text-creme focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-framboesa focus-visible:ring-offset-2 transition motion-reduce:transition-none">Ver</a>
      </div>
    </article>`).join('');
}

// ---------- Produtos: pesquisa e filtro em tempo real ----------
const listaProdutos = document.getElementById('lista-produtos');
if (listaProdutos) {
  const campoQ = document.getElementById('campo-q');
  const campoCat = document.getElementById('campo-categoria');
  const contador = document.getElementById('contador');
  const formFiltro = document.getElementById('form-filtro');

  const params = new URLSearchParams(location.search);
  campoQ.value = params.get('q') || '';
  if ([...campoCat.options].some(o => o.value === params.get('categoria'))) campoCat.value = params.get('categoria');

  function desenhar() {
    const q = campoQ.value.trim().toLowerCase();
    const cat = campoCat.value;
    const lista = produtos.filter(p =>
      (cat === 'Todas' || p.categoria === cat) &&
      (q === '' || p.nome.toLowerCase().includes(q) || p.descricao.toLowerCase().includes(q)));

    contador.textContent = lista.length === 0 ? 'Nenhum produto encontrado'
      : lista.length === 1 ? '1 produto' : lista.length + ' produtos';

    listaProdutos.innerHTML = lista.map(p => `
      <article class="flex flex-col bg-bege rounded-2xl p-5 border border-castanho/10 shadow-sm">
        <img src="${esc(p.imagem)}" alt="${esc(p.nome)}" width="400" height="300" loading="lazy" class="w-full h-48 object-cover rounded-xl mb-4 bg-creme">
        <p class="text-xs uppercase tracking-wider font-bold text-framboesa mb-1">${esc(p.categoria)}</p>
        <h2 class="text-xl font-bold text-castanho">${esc(p.nome)}</h2>
        <p class="text-sm text-castanho/80 mt-2 mb-4">${esc(p.descricao)}</p>
        <div class="mt-auto pt-3 border-t border-castanho/15">
          <p class="text-xs font-semibold text-castanho uppercase tracking-wider mb-2">Tamanhos e Preços:</p>
          <ul class="text-sm space-y-1">
            ${p.tamanhos.map(t => `<li class="flex justify-between text-castanho"><span class="font-medium">${esc(t.nome)}</span><span>${esc(formatarPreco(t.preco))}</span></li>`).join('')}
          </ul>
        </div>
      </article>`).join('');
  }

  formFiltro.addEventListener('submit', e => { e.preventDefault(); desenhar(); });
  campoQ.addEventListener('input', desenhar);
  campoCat.addEventListener('change', desenhar);
  desenhar();
}

// ---------- Encomendas: validação e resumo ----------
const formEnc = document.getElementById('form-encomenda');
if (formEnc) {
  const $ = id => document.getElementById(id);
  const selProduto = $('campo-produto');

  selProduto.innerHTML = '<option value="">Escolhe um produto...</option>' + produtos.map(p =>
    `<optgroup label="${esc(p.nome)}">` + p.tamanhos.map((t, i) =>
      `<option value="${p.id}-${i}">${esc(t.nome)} · ${esc(formatarPreco(t.preco))}</option>`).join('') + '</optgroup>').join('');

  const pad = n => String(n).padStart(2, '0');
  const limite = new Date(Date.now() + 48 * 3600 * 1000);
  $('campo-data').min = `${limite.getFullYear()}-${pad(limite.getMonth() + 1)}-${pad(limite.getDate())}`;

  function mostrarErros(erros) {
    ['produto', 'quantidade', 'data', 'nome', 'telefone', 'email', 'observacoes'].forEach(c => {
      const p = $('erro-' + c);
      p.textContent = erros[c] || '';
      p.classList.toggle('hidden', !erros[c]);
    });
    $('aviso-erros').classList.toggle('hidden', Object.keys(erros).length === 0);
  }

  formEnc.addEventListener('submit', e => {
    e.preventDefault();
    const v = {};
    ['produto', 'quantidade', 'data', 'hora', 'nome', 'telefone', 'email', 'observacoes'].forEach(c => v[c] = $('campo-' + c).value.trim());
    const erros = {};

    let item = null;
    const m = v.produto.match(/^(\d+)-(\d+)$/);
    if (m) {
      const p = produtos.find(x => x.id === Number(m[1]));
      if (p && p.tamanhos[Number(m[2])]) item = { produto: p, tamanho: p.tamanhos[Number(m[2])] };
    }
    if (!item) erros.produto = 'Escolhe um produto e tamanho.';

    const qtd = Number(v.quantidade);
    if (!/^\d+$/.test(v.quantidade) || qtd < 1 || qtd > 20) erros.quantidade = 'A quantidade tem de ser entre 1 e 20.';

    let levantamento = null;
    if (/^\d{4}-\d{2}-\d{2}$/.test(v.data) && /^\d{2}:\d{2}$/.test(v.hora)) {
      levantamento = new Date(v.data + 'T' + v.hora + ':00');
    }
    if (!levantamento || isNaN(levantamento)) {
      erros.data = 'Indica uma data e uma hora de levantamento válidas.';
    } else if (levantamento < new Date(Date.now() + 48 * 3600 * 1000)) {
      erros.data = 'A encomenda tem de ser feita com pelo menos 48 horas de antecedência.';
    } else {
      const domingo = levantamento.getDay() === 0;
      const horaMax = domingo ? '13:00' : '19:00';
      if (v.hora < '08:00' || v.hora > horaMax) {
        erros.data = 'Aos ' + (domingo ? 'domingos' : 'restantes dias') + ' o levantamento é entre as 08h e as ' + (domingo ? '13h' : '19h') + '.';
      }
    }

    if (v.nome.length < 3) erros.nome = 'O nome tem de ter pelo menos 3 caracteres.';
    if (!/^(\+351 ?)?[29][0-9]{2} ?[0-9]{3} ?[0-9]{3}$/.test(v.telefone)) erros.telefone = 'Indica um telefone com 9 dígitos, por exemplo 912 345 678.';
    if (v.email !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.email)) erros.email = 'O email não parece válido.';
    if (v.observacoes.length > 200) erros.observacoes = 'As observações podem ter no máximo 200 caracteres.';

    mostrarErros(erros);
    if (Object.keys(erros).length) return;

    const linhas = [
      ['Produto', `${item.produto.nome} (${item.tamanho.nome})`],
      ['Quantidade', qtd],
      ['Total', formatarPreco(item.tamanho.preco * qtd)],
      ['Levantamento', `${pad(levantamento.getDate())}/${pad(levantamento.getMonth() + 1)}/${levantamento.getFullYear()} às ${v.hora}`],
      ['Nome', v.nome],
      ['Telefone', v.telefone]
    ];
    if (v.email) linhas.push(['Email', v.email]);
    if (v.observacoes) linhas.push(['Observações', v.observacoes]);
    $('resumo-dados').innerHTML = linhas.map(([k, val]) => `<dt class="font-semibold">${k}</dt><dd>${esc(val)}</dd>`).join('');
    formEnc.classList.add('hidden');
    $('resumo').classList.remove('hidden');
    $('resumo').scrollIntoView();
  });

  $('nova-encomenda').addEventListener('click', () => {
    formEnc.reset();
    mostrarErros({});
    $('resumo').classList.add('hidden');
    formEnc.classList.remove('hidden');
  });
}
