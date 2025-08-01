<?= $this->extend('Admin/layout/principal'); ?>

<?= $this->section('titulo'); ?>
PDV - Ponto de Venda
<?= $this->endSection(); ?>

<?= $this->section('estilos'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    :root {
        --ifood-green: #00a200;
        --ifood-green-dark: #008700;
        --ifood-gray: #4d4d4d;
        --ifood-light-gray: #f2f2f2;
    }
    body {
        background-color: var(--ifood-light-gray);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .ifood-bg-green { background-color: var(--ifood-green); }
    .ifood-text-green { color: var(--ifood-green); }
    .btn-ifood {
        background-color: var(--ifood-green);
        color: white;
        border: none;
        transition: background-color 0.2s;
    }
    .btn-ifood:hover {
        background-color: var(--ifood-green-dark);
        color: white;
    }
    .card-ifood {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        height: 100%;
        transition: transform 0.2s;
        cursor: pointer;
    }
    .product-card-ifood:hover {
        transform: scale(1.03);
    }
    .product-card-ifood .card-img-top {
        height: 120px;
        object-fit: cover;
    }
    .pdv-sidebar {
        background-color: #fff;
        padding: 20px;
        border-right: 1px solid #e0e0e0;
        height: 100vh;
        overflow-y: auto;
    }
    .pdv-cart-list {
        list-style: none;
        padding: 0;
    }
    .pdv-cart-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed #e0e0e0;
    }
    .pdv-cart-item:last-child {
        border-bottom: none;
    }
    .pdv-cart-item-info {
        flex-grow: 1;
    }
    .pdv-cart-item-actions {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }
    /* Ajuste para 3 produtos por linha em telas médias e maiores */
    @media (min-width: 768px) {
        .row.row-cols-md-3 > * {
            flex: 0 0 auto;
            width: 33.3333333333%;
        }
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('conteudo'); ?>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-4 pdv-sidebar">
            <div class="d-flex align-items-center mb-4">
                <h5 class="mb-0 ifood-text-green">PDV</h5>
            </div>
            <hr>

            <div class="mb-4">
                <label for="cliente" class="form-label fw-bold">Cliente</label>
                <div class="input-group">
                    <input type="text" id="cliente" class="form-control" placeholder="Nome ou CPF do cliente">
                    <button class="btn btn-outline-secondary" type="button" id="consumidor-final-btn"><i class="bi bi-person-fill-gear"></i></button>
                </div>
                <div id="resultado-clientes" class="list-group mt-2"></div>
            </div>

            <h5 class="mb-3">Itens do Pedido</h5>
            <ul class="pdv-cart-list" id="cart-items">
                <li class="text-center text-muted">O carrinho está vazio.</li>
            </ul>

            <hr>

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span>Total de Itens:</span>
                    <span id="total-itens">0</span>
                </div>
                <div class="d-flex justify-content-between fw-bold mt-2">
                    <span>Total:</span>
                    <span id="cart-total" class="ifood-text-green">R$ 0,00</span>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-lg btn-ifood" id="checkout-btn" disabled>
                    <i class="bi bi-cash me-2"></i> Finalizar Venda
                </button>
                <button class="btn btn-outline-danger" id="cancel-btn">
                    <i class="bi bi-x-circle me-2"></i> Cancelar Pedido
                </button>
            </div>
        </div>

        <div class="col-md-8 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 text-secondary">Produtos</h2>
                <input type="text" class="form-control w-50" placeholder="Buscar produtos...">
            </div>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 product-grid">
                <?php foreach ($produtos as $produto): ?>
                <div class="col">
                    <div class="card product-card-ifood shadow-sm text-center" data-id="<?= $produto->id ?>" data-nome="<?= esc($produto->nome) ?>" data-preco_minimo="<?= $produto->preco_minimo ?>">
                        <img src="<?= base_url('uploads/produtos/' . $produto->imagem) ?>" class="card-img-top" alt="<?= esc($produto->nome) ?>">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1"><?= esc($produto->nome) ?></h6>
                            <p class="card-text ifood-text-green fw-bold mb-0">R$ <?= number_format($produto->preco_minimo, 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="posVendaModal" tabindex="-1" aria-labelledby="posVendaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ifood-bg-green text-white">
                <h5 class="modal-title" id="posVendaModalLabel">Venda Finalizada!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>O que deseja fazer a seguir?</p>
                <input type="hidden" id="pedidoIdInput">
            </div>
            <div class="modal-footer d-flex justify-content-around">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" id="imprimirReciboBtn" class="btn btn-primary"><i class="bi bi-printer me-2"></i> Imprimir Recibo</button>
                <button type="button" id="enviarEmailBtn" class="btn btn-info text-white"><i class="bi bi-envelope-check me-2"></i> Enviar por E-mail</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProduto" tabindex="-1" aria-labelledby="modalProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ifood-bg-green text-white">
                <h5 class="modal-title" id="modalProdutoLabel">Detalhes do Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="modal-produto-nome" class="mb-3"></h4>
                <div id="modal-especificacoes" class="mb-4 d-none">
                    <p class="fw-bold">Escolha a Especificação:</p>
                </div>
                <div id="modal-extras" class="mb-4 d-none">
                    <p class="fw-bold">Adicionais:</p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2" id="btn-quantidade-menos">-</button>
                        <span id="quantidade-produto" class="mx-2 fw-bold">1</span>
                        <button class="btn btn-sm btn-outline-secondary ms-2" id="btn-quantidade-mais">+</button>
                    </div>
                    <h5 class="mb-0">Total: <span id="modal-total" class="ifood-text-green">R$ 0,00</span></h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-ifood" id="btn-adicionar-carrinho">Adicionar ao Carrinho</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productGrid = document.querySelector('.product-grid');
        const cartItemsList = document.querySelector('#cart-items');
        const cartTotalElement = document.querySelector('#cart-total');
        const totalItensElement = document.querySelector('#total-itens');
        const checkoutBtn = document.querySelector('#checkout-btn');
        const clienteInput = document.querySelector('#cliente');
        const resultadoClientes = document.querySelector('#resultado-clientes');
        const consumidorFinalBtn = document.querySelector('#consumidor-final-btn');
        const cancelBtn = document.querySelector('#cancel-btn');

        const posVendaModal = new bootstrap.Modal(document.getElementById('posVendaModal'));
        const pedidoIdInput = document.getElementById('pedidoIdInput');
        const imprimirReciboBtn = document.getElementById('imprimirReciboBtn');
        const enviarEmailBtn = document.getElementById('enviarEmailBtn');

        const modalProduto = new bootstrap.Modal(document.getElementById('modalProduto'));
        const modalProdutoNome = document.getElementById('modal-produto-nome');
        const modalEspecificacoes = document.getElementById('modal-especificacoes');
        const modalExtras = document.getElementById('modal-extras');
        const quantidadeProduto = document.getElementById('quantidade-produto');
        const btnQuantidadeMenos = document.getElementById('btn-quantidade-menos');
        const btnQuantidadeMais = document.getElementById('btn-quantidade-mais');
        const modalTotal = document.getElementById('modal-total');
        const btnAdicionarCarrinho = document.getElementById('btn-adicionar-carrinho');

        let cart = {};
        let total = 0;
        let clienteSelecionado = null;
        let produtoModal = {};

        function updateCart() {
            cartItemsList.innerHTML = '';
            total = 0;
            let totalItemsCount = 0;

            if (Object.keys(cart).length === 0) {
                cartItemsList.innerHTML = '<li class="text-center text-muted mt-3">O carrinho está vazio.</li>';
                checkoutBtn.disabled = true;
            } else {
                for (const key in cart) {
                    const item = cart[key];
                    const li = document.createElement('li');
                    li.className = 'pdv-cart-item';
                    let precoItem = 0;
                    let nomeCompleto = item.nome;

                    if (item.especificacao) {
                        precoItem += parseFloat(item.especificacao.preco);
                        nomeCompleto += ` (${item.especificacao.nome})`;
                    } else if (item.preco_minimo) {
                        precoItem += parseFloat(item.preco_minimo);
                    }

                    if (item.extras && item.extras.length > 0) {
                        item.extras.forEach(extra => {
                            precoItem += parseFloat(extra.preco);
                            nomeCompleto += ` + ${extra.nome}`;
                        });
                    }

                    const subtotalItem = precoItem * item.quantidade;

                    li.innerHTML = `
                        <div class="pdv-cart-item-info">
                            <span class="fw-bold">${nomeCompleto}</span><br>
                            <small class="text-muted">R$ ${precoItem.toFixed(2).replace('.', ',')} x ${item.quantidade}</small>
                        </div>
                        <div class="pdv-cart-item-actions">
                            <span class="fw-bold ifood-text-green me-3">R$ ${subtotalItem.toFixed(2).replace('.', ',')}</span>
                            <button class="btn btn-sm btn-outline-danger btn-remove-item" data-key="${key}">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    `;
                    cartItemsList.appendChild(li);
                    total += subtotalItem;
                    totalItemsCount += item.quantidade;
                }
            }

            cartTotalElement.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
            totalItensElement.textContent = `${totalItemsCount}`;
            // Ajuste na lógica para habilitar o botão
            checkoutBtn.disabled = !(Object.keys(cart).length > 0 && clienteSelecionado !== null);
        }

        function updateModalTotal() {
            let precoBase = 0;

            const especificacaoSelecionada = modalEspecificacoes.querySelector('input[name="especificacao"]:checked');
            if (especificacaoSelecionada) {
                precoBase = parseFloat(especificacaoSelecionada.dataset.preco);
            } else if (produtoModal.preco_minimo) {
                precoBase = parseFloat(produtoModal.preco_minimo);
            }

            modalExtras.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                precoBase += parseFloat(checkbox.dataset.preco);
            });

            const quantidade = parseInt(quantidadeProduto.textContent);
            modalTotal.textContent = `R$ ${(precoBase * quantidade).toFixed(2).replace('.', ',')}`;
        }

        productGrid.addEventListener('click', function(e) {
            const target = e.target.closest('.product-card-ifood');
            if (target) {
                const id = target.dataset.id;
                produtoModal.preco_minimo = target.dataset.preco_minimo;
                
                fetch(`<?= site_url('admin/pdv/buscaropcoes/') ?>${id}`)
                    .then(response => response.json())
                    .then(data => {
                        produtoModal = data.produto;
                        produtoModal.id = id;

                        modalProdutoNome.textContent = produtoModal.nome;
                        quantidadeProduto.textContent = '1';
                        modalEspecificacoes.innerHTML = '<p class="fw-bold">Escolha a Especificação:</p>';
                        modalExtras.innerHTML = '<p class="fw-bold">Adicionais:</p>';
                        modalExtras.classList.add('d-none');

                        let temEspecificacao = data.especificacoes.length > 0;
                        let temCustomizavel = false;

                        if (temEspecificacao) {
                            data.especificacoes.forEach((especificacao, index) => {
                                const checked = index === 0 ? 'checked' : '';
                                modalEspecificacoes.innerHTML += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="especificacao" id="especificacao-${especificacao.id}" value="${especificacao.id}" data-preco="${especificacao.preco}" data-nome="${especificacao.medida}" data-customizavel="${especificacao.customizavel}" ${checked}>
                                        <label class="form-check-label" for="especificacao-${especificacao.id}">
                                            ${especificacao.medida} (R$ ${parseFloat(especificacao.preco).toFixed(2).replace('.', ',')})
                                        </label>
                                    </div>
                                `;
                                if (index === 0 && especificacao.customizavel == 1) {
                                    temCustomizavel = true;
                                }
                            });
                            modalEspecificacoes.classList.remove('d-none');
                        } else {
                            modalEspecificacoes.innerHTML = '<p class="fw-bold">Preço único</p>';
                            modalEspecificacoes.classList.remove('d-none');
                        }

                        if (data.extras.length > 0 && (temCustomizavel || !temEspecificacao)) {
                            data.extras.forEach(extra => {
                                modalExtras.innerHTML += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="extra-${extra.id}" data-id="${extra.id}" data-nome="${extra.nome}" data-preco="${extra.preco}">
                                        <label class="form-check-label" for="extra-${extra.id}">
                                            ${extra.nome} (R$ ${parseFloat(extra.preco).toFixed(2).replace('.', ',')})
                                        </label>
                                    </div>
                                `;
                            });
                            modalExtras.classList.remove('d-none');
                        }
                        
                        updateModalTotal();
                        modalProduto.show();
                    });
            }
        });

        modalProduto.addEventListener('change', function(e) {
            if (e.target.name === 'especificacao') {
                const especificacaoSelecionada = modalEspecificacoes.querySelector('input[name="especificacao"]:checked');
                const customizavel = especificacaoSelecionada ? especificacaoSelecionada.dataset.customizavel : '0';
                
                if (customizavel === '1' && modalExtras.querySelectorAll('input').length > 0) {
                    modalExtras.classList.remove('d-none');
                } else {
                    modalExtras.classList.add('d-none');
                }
            }
            updateModalTotal();
        });

        btnQuantidadeMenos.addEventListener('click', function() {
            let quantidade = parseInt(quantidadeProduto.textContent);
            if (quantidade > 1) {
                quantidade--;
                quantidadeProduto.textContent = quantidade;
                updateModalTotal();
            }
        });

        btnQuantidadeMais.addEventListener('click', function() {
            let quantidade = parseInt(quantidadeProduto.textContent);
            quantidade++;
            quantidadeProduto.textContent = quantidade;
            updateModalTotal();
        });

        btnAdicionarCarrinho.addEventListener('click', function() {
            const especificacaoSelecionada = modalEspecificacoes.querySelector('input[name="especificacao"]:checked');
            const extrasSelecionados = Array.from(modalExtras.querySelectorAll('input[type="checkbox"]:checked')).map(checkbox => ({
                id: checkbox.dataset.id,
                nome: checkbox.dataset.nome,
                preco: parseFloat(checkbox.dataset.preco)
            }));
            
            if (modalEspecificacoes.querySelectorAll('input[name="especificacao"]').length > 0 && !especificacaoSelecionada) {
                alert('Por favor, selecione uma especificação.');
                return;
            }

            const itemUnico = {
                id: produtoModal.id,
                nome: produtoModal.nome,
                preco_minimo: produtoModal.preco_minimo,
                quantidade: parseInt(quantidadeProduto.textContent),
                especificacao: especificacaoSelecionada ? {
                    id: especificacaoSelecionada.value,
                    nome: especificacaoSelecionada.dataset.nome,
                    preco: parseFloat(especificacaoSelecionada.dataset.preco)
                } : null,
                extras: extrasSelecionados.length > 0 ? extrasSelecionados : null
            };

            const key = JSON.stringify(itemUnico, Object.keys(itemUnico).sort());
            
            if (cart[key]) {
                cart[key].quantidade += itemUnico.quantidade;
            } else {
                cart[key] = itemUnico;
            }

            updateCart();
            modalProduto.hide();
        });

        cartItemsList.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-remove-item');
            if (target) {
                const key = target.dataset.key;
                delete cart[key];
                updateCart();
            }
        });

        clienteInput.addEventListener('keyup', function() {
            const termo = this.value;
            if (termo.length < 3) {
                resultadoClientes.innerHTML = '';
                // Não altere clienteSelecionado aqui, para não desativar o botão de Consumidor Final
                checkoutBtn.disabled = !(Object.keys(cart).length > 0 && clienteSelecionado !== null);
                return;
            }
            
            fetch('<?= site_url('admin/pdv/buscarusuarios') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `termo=${termo}`
            })
            .then(response => response.json())
            .then(data => {
                resultadoClientes.innerHTML = '';
                data.forEach(user => {
                    const a = document.createElement('a');
                    a.href = '#';
                    a.className = 'list-group-item list-group-item-action';
                    a.textContent = user.nome;
                    a.dataset.id = user.id;
                    a.addEventListener('click', function(e) {
                        e.preventDefault();
                        clienteInput.value = user.nome;
                        clienteSelecionado = user.id;
                        resultadoClientes.innerHTML = '';
                        updateCart();
                    });
                    resultadoClientes.appendChild(a);
                });
            });
        });

        consumidorFinalBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clienteInput.value = 'Consumidor Final';
            clienteSelecionado = '0';
            resultadoClientes.innerHTML = '';
            updateCart();
        });
        
        function finalizarVenda() {
            if (checkoutBtn.disabled) {
                alert('O carrinho está vazio ou nenhum cliente foi selecionado.');
                return;
            }
            
            const itens = Object.values(cart).map(item => {
                let precoFinal = 0;
                let descricaoAdicional = '';

                if (item.especificacao) {
                    precoFinal += parseFloat(item.especificacao.preco);
                    descricaoAdicional += ` (${item.especificacao.nome})`;
                } else if (item.preco_minimo) {
                    precoFinal += parseFloat(item.preco_minimo);
                }

                if (item.extras && item.extras.length > 0) {
                    item.extras.forEach(extra => {
                        precoFinal += parseFloat(extra.preco);
                        descricaoAdicional += ` + ${extra.nome}`;
                    });
                }

                return {
                    produto_id: item.id,
                    nome: item.nome + descricaoAdicional,
                    quantidade: item.quantidade,
                    preco: precoFinal,
                };
            });

            const data = {
                usuario_id: clienteSelecionado,
                valor_total: total,
                itens: itens,
            };
            
            fetch('<?= site_url('admin/pdv/salvarvenda') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(res => {
                if (res.pedido_id) {
                    pedidoIdInput.value = res.pedido_id;
                    posVendaModal.show();
                    
                    cart = {};
                    total = 0;
                    clienteSelecionado = null;
                    updateCart();
                    clienteInput.value = '';
                } else {
                    alert('Erro: ' + res.error);
                }
            });
        }
        
        checkoutBtn.addEventListener('click', finalizarVenda);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'F10') {
                event.preventDefault();
                finalizarVenda();
            }
        });


        cancelBtn.addEventListener('click', function() {
            if(confirm('Tem certeza que deseja cancelar o pedido?')) {
                cart = {};
                total = 0;
                clienteSelecionado = null;
                clienteInput.value = '';
                updateCart();
            }
        });

        imprimirReciboBtn.addEventListener('click', function() {
            const pedidoId = pedidoIdInput.value;
            window.open('<?= site_url('admin/pedidos/imprimir/') ?>' + pedidoId, '_blank');
        });

        enviarEmailBtn.addEventListener('click', function() {
            const pedidoId = pedidoIdInput.value;
            const usuarioId = clienteSelecionado;

            if (usuarioId && usuarioId !== '0') {
                fetch('<?= site_url('admin/pedidos/enviar_email/') ?>' + pedidoId, { method: 'POST' })
                .then(response => response.json())
                .then(res => {
                    if (res.message) {
                        alert(res.message);
                    } else {
                        alert('Erro ao enviar e-mail: ' + res.error);
                    }
                    posVendaModal.hide();
                });
            } else {
                alert('Não é possível enviar o e-mail, pois a venda foi para um consumidor final.');
                posVendaModal.hide();
            }
        });
    });
</script>
<?= $this->endSection(); ?>