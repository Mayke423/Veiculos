<?php $v->layout("__theme"); ?>


<form>
    <div class="list">
        <h1 class="list-text">Cadastrar novo pedido</h1>
        <a class="btn btn-primary" href="/pedido/<?= $idCliente ?>">voltar</a>
    </div>

    <input type="hidden" name="_method" value="POST" />
    <input type="hidden" class="form-control" id="clienteId" value="<?= $idCliente ?>" >

    <fieldset>
        <legend>Dados pessoais</legend>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="required" id="label-nome" for="nome">Nome Completo / Razao Social</label>
                <input type="text" class="form-control" disabled id="nome" value="<?= $nomeCliente ?>" placeholder="Ex: José nascimento da silva pereira">
            </div>

            <div class="form-group col-md-3">
                <label class="required" id="label-dataAbertura" for="dataAbertura">Data abertura</label>
                <input type="date" class="form-control" id="dataAbertura" >
            </div>

            <div class="form-group col-md-3">
                <label class="required" id="label-dataRealizacao" for="dataRealizacao">Data realizacao</label>
                <input type="date" class="form-control" id="dataRealizacao">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label class="required" id="label-Marca" for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" placeholder="Ex: Chevrolet">
            </div>

            <div class="form-group col-md-3">
                <label class="required" id="label-Placa" for="modelo">Modelo</label>
                <input type="text" class="form-control" id="modelo" placeholder="Ex: CLassic">
            </div>

            <div class="form-group col-md-3">
                <label class="required" id="label-Placa" for="placa">Placa do Veiculo</label>
                <input type="text" class="form-control" id="placa" placeholder="Ex: PNP-0000">
            </div>
        </div>
        
        <div class="form-container col-md-3">
            <label class="required" id="label-servicos" for="servicos">Serviço Realizado</label>
            <select id="servicos" name="servicos" multiple>
                <option value="Manutenção">Manutenção</option>
                <option value="Abastecimento">Abastecimento</option>
                <option value="Lavagem">Lavagem</option>
                <option value="Locação">Locação</option>
             </select>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label class="required" id="label-total" for="total">Total do pedido</label>
                <input type="number" class="form-control" id="total" placeholder="Ex: R$ 1200">
            </div>
        </div>
    </fieldset>

    <input type="submit" id="btn-adicionar" ng-click="adicionar();" value="Cadastrar" class="btn btn-outline-primary btn-form">
</form>

<?php $v->start("script"); ?>
<script src="https://unpkg.com/imask"></script>
<script src="<?= url() ?>/template/assets/js/sweet.min.js"></script>
<script src="<?= url() ?>/template/assets/js/formAdicionarPedido.js"></script>
<?php $v->stop(); ?>