<?php $v->layout("__theme"); ?>

<div class="list">
    <h1 class="list-text">Editar Pedido</h1>
    <a class="btn btn-primary" href="/pedido/<?= $idCliente ?>">Voltar</a>
</div>

<?php if ($pedido) : ?>
    <form method="PUT" action="editar" class="form">
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="id" id="id" value="<?= $pedido->getId() ?>" />
        <input type="hidden" name="clienteId" id="clienteId" value="<?= $idCliente ?>" />

        <fieldset>
            <legend>Dados pessoais</legend>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="required" id="label-nome" for="nome">Nome Completo / Razao Social</label>
                    <input type="text" class="form-control" disabled id="nome" value="<?= $nomeCliente ?>" placeholder="Ex: José nascimento da silva pereira">
                </div>

                <div class="form-group col-md-3">
                    <label class="required" id="label-dataAbertura" for="dataAbertura">Data abertura</label>
                    <input type="date" class="form-control" id="dataAbertura" value="<?= $dataAbertura ?>">
                </div>

                <div class="form-group col-md-3">
                    <label class="required" id="label-dataRealizacao" for="dataRealizacao">Data realizacao</label>
                    <input type="date" class="form-control" id="dataRealizacao" value="<?= $dataRealizacao ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label class="required" id="label-Marca" for="marca">Marca</label>
                    <input type="text" class="form-control" id="marca" placeholder="Ex: Chevrolet" value="<?= $pedido->getMarca() ?>">
                </div>

                <div class="form-group col-md-3">
                    <label class="required" id="label-Placa" for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" placeholder="Ex: CLassic" value="<?= $pedido->getModelo() ?>">
                </div>

                <div class="form-group col-md-3">
                    <label class="required" id="label-Placa" for="placa">Placa do Veiculo</label>
                    <input type="text" class="form-control" id="placa" placeholder="Ex: PNP-0000" value="<?= $pedido->getPlaca() ?>">
                </div>
            </div>
            
            <div class="form-container col-md-3">
                <label class="required" id="label-servicos" for="servicos">Serviço Realizado</label>
                <select id="servicos" name="servicos[]" multiple>
                    <option value="Manutenção" <?php echo in_array("Manutenção", $servicos) ? 'selected' : ''; ?>>Manutenção</option>
                    <option value="Abastecimento" <?php echo in_array("Abastecimento", $servicos) ? 'selected' : ''; ?>>Abastecimento</option>
                    <option value="Lavagem" <?php echo in_array("Lavagem", $servicos) ? 'selected' : ''; ?>>Lavagem</option>
                    <option value="Locação" <?php echo in_array("Locação", $servicos) ? 'selected' : ''; ?>>Locação</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label class="required" id="label-total" for="total">Total do pedido</label>
                    <input type="number" class="form-control" id="total" placeholder="Ex: R$ 1200" value="<?= $pedido->getTotal() ?>">
                </div>
            </div>
        </fieldset>

        <input type="submit" id="btn-editar" value="Editar" class="btn btn-outline-primary btn-form">
    </form>
<?php else : ?>
    <h1 class="text-center text-danger">Pedido não encotrado.</h1>
<?php endif; ?>

<?php $v->start("script"); ?>

<script src="https://unpkg.com/imask"></script>
<script src="<?= url() ?>/template/assets/js/sweet.min.js"></script>
<script src="<?= url() ?>/template/assets/js/formEditarPedido.js"></script>
<?php $v->stop(); ?>