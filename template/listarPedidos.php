<?php $v->layout("__theme"); ?>
<div class="list">
    <h1 class="list-text">MJA Alocações</h1>
</div>

<div class="list-pesquisa form-inline">
    <a class="btn btn-primary btn-adicionar" href="adicionarPedido/<?= $idCliente ?>">Cadastrar novo pedido</a>
    <a class="btn btn-primary ml-2" href="<?= url() ?>">voltar</a>
</div>

<span>Cliente: <?= $nomeCliente ?></span>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Código Pedido</th>
                <th>Data abertura</th>
                <th>Data realizada</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Placa</th>
                <th>Serviços</th>
                <th>Total</th>
                <th>Editar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <?php foreach ($pedidos as $pedido) : ?>
                <tr id="tr-<?= $pedido->getId() ?>" class="tr-pedidos">
                    <td><?= $pedido->getId() ?></td>
                    <td><?= $pedido->getDataAbertura() ?></td>
                    <td><?= $pedido->getDataRealizacao() ?></td>
                    <td><?= $pedido->getMarca()  ?></td>
                    <td><?= $pedido->getModelo()  ?></td>
                    <td><?= $pedido->getPlaca()  ?></td>
                    <td><?= $pedido->getServicos()  ?></td>
                    <td><?= $pedido->getTotal()  ?></td>
                    <td><a class="table-link" href="editarPedido/<?= $pedido->getId() ?>"><i class="icon-pencil2"></i></a></td>
                    <td><a href="" class="excluir table-link" id="<?= $pedido->getId() ?>"><i class="icon-bin"></i></a></td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($pedidos) == 0) : ?>
                <tr>
                    <td colspan="9">Nenhum resultado encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php $v->start("script") ?>
    <script src="<?= url() ?>/template/assets/js/sweet.min.js"></script>
    <script src="<?= url() ?>/template/assets/js/listarPedidos.js"></script>
    <?php $v->stop(); ?>
</div>