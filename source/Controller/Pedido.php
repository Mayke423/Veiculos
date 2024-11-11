<?php

namespace Source\Controller;

use Source\Model\PedidoDao;
use Source\Model\PedidoModel;
use Source\Model\ClienteDao;
use Source\Model\ClienteModel;
use Exception;

class Pedido extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function listar(array $data): void
    {
        $id = addslashes($data["cliente"]);
        $id = htmlspecialchars_decode($id);

        if (empty($id)) {
            http_response_code(400);
            echo $this->ajaxResponse("Cliente", ["error" => "Cliente invalido."]);
            die();
        }

        $clienteDao = new ClienteDao();
        $cliente = $clienteDao->fetch($id);

        $idCliente = $cliente->getId();
        $nomeCliente = null;

        if($cliente->getFisicaJuridica()){
            $nomeCliente = $cliente->getNome();
        }else{
            $nomeCliente = $cliente->getRazaoSocial();
        }

        $pedidoDao = new PedidoDao();
        $pedidos = $pedidoDao->fetchByCliente($idCliente);

        echo $this->view->render("listarPedidos", [
            "title" => "Pedidos",
            "idCliente" => $idCliente,
            "nomeCliente" => $nomeCliente,
            "pedidos" => $pedidos
        ]);
    }

    public function adicionar(array $data): void
    {
        try {

            error_log("Iniciando método adicionarPedido");

            $pedidoDAO = new PedidoDao();
            $pedido = new PedidoModel();

            if (empty($data["clienteId"]) || empty($data["dataAbertura"])  || empty($data["dataRealizacao"]) ||
                empty($data["marca"]) || empty($data["modelo"]) || empty($data["placa"])    ||
                empty($data["servicos"]) || empty($data['total'])
            ) {
                http_response_code(400);
                echo $this->ajaxResponse("pedido", ["error" => "Preencha todos os campos."]);
                die();
            }

            if (!empty($data["id"]) ) {
                $pedido->setId($data["id"]);
            }

            $pedido->setClienteId($data["clienteId"]);
            $pedido->setDataAbertura($data["dataAbertura"]);
            $pedido->setDataRealizacao($data["dataRealizacao"]);
            $pedido->setMarca($data["marca"]);
            $pedido->setModelo($data["modelo"]);
            $pedido->setPlaca($data["placa"]);
            $pedido->setServicos($data["servicos"]);
            $pedido->setTotal($data["total"]);

            $pedido = $pedidoDAO->save($pedido);

            if (gettype($pedido) == "string" && $pedido == "23000") {
                throw new Exception("Pedido já cadastrado.");
            }

            if (gettype($pedido) != "string") {
                echo $this->ajaxResponse("Pedido", [
                    "id"                => $pedido->getId(),
                    "clienteId"         => $pedido->getClienteId(),
                    "dataAbertura"      => $pedido->getDataAbertura(),
                    "dataRealizacao"    => $pedido->getDataRealizacao(),
                    "marca"             => $pedido->getMarca(),
                    "modelo"            => $pedido->getModelo(),
                    "placa"             => $pedido->getPlaca(),
                    "servicos"          => $pedido->getServicos(),
                    "total"             => $pedido->getTotal(),
                ]);
            } else {
                throw new Exception("Erro ao cadastrar pédido.");
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo $this->ajaxResponse("pedido", ["error" => $e->getMessage()]);
            die();
        }
    }

    public function editar(array $data)
    {
        $pedidoDao = new PedidoDao();
        $pedido = new PedidoModel();

        if (empty($data["clienteId"]) || empty($data["dataAbertura"])  || empty($data["dataRealizacao"]) ||
            empty($data["marca"]) || empty($data["modelo"]) || empty($data["placa"])    ||
            empty($data["servicos"]) || empty($data['total'])
        ) {
            http_response_code(400);
            echo $this->ajaxResponse("pedido", ["error" => "Preencha todos os campos."]);
            die();
        }

        $pedido->setId($data["id"]);
        $pedido->setClienteId($data["clienteId"]);
        $pedido->setDataAbertura($data["dataAbertura"]);
        $pedido->setDataRealizacao($data["dataRealizacao"]);
        $pedido->setMarca($data["marca"]);
        $pedido->setModelo($data["modelo"]);
        $pedido->setPlaca($data["placa"]);
        $pedido->setServicos($data["servicos"]);
        $pedido->setTotal($data["total"]);
                
        $pedido = $pedidoDao->save($pedido);

        if (gettype($pedido) == "string" && $pedido == "23000") {
            throw new Exception("Pedido já cadastrado.");
        }

        if ((bool)$pedido) {
            echo $this->ajaxResponse("Pedido", ["success" => "Pedido editado com sucesso."]);
        } else {
            http_response_code(400);
            echo $this->ajaxResponse("Pedido", ["error" => "Erro ao editar pedido."]);
        }
    }

    public function excluir(array $data)
    {
        $id = addslashes($data["id"]);
        $id = htmlspecialchars_decode($id);

        if (empty($id)) {
            http_response_code(400);
            echo $this->ajaxResponse("Pedido", ["error" => "Pedido invalido."]);
            die();
        }

        $pedidoDao = new PedidoDao();
        $result = $pedidoDao->delete($id);
        if ($result) {
            echo $this->ajaxResponse("Pedido", ["success" => "Pedido deletado com sucesso."]);
        } else {
            http_response_code(400);

            echo $this->ajaxResponse("Pedido", ["error" => $result]);
            die();
        }
    }
    
    public function formAdicionar(array $data) 
    {
        $id = addslashes($data["cliente"]);
        $id = htmlspecialchars_decode($id);

        if (empty($id)) {
            http_response_code(400);
            echo $this->ajaxResponse("Cliente", ["error" => "Cliente invalido."]);
            die();
        }

        $clienteDao = new ClienteDao();
        $cliente = $clienteDao->fetch($id);

        $idCliente = $cliente->getId();
        $nomeCliente = null;

        if($cliente->getFisicaJuridica()){
            $nomeCliente = $cliente->getNome();
        }else{
            $nomeCliente = $cliente->getRazaoSocial();
        }

        echo $this->view->render("formAdicionarPedido", [
            "title" => "Adicionar Pedido",
            "idCliente" => $idCliente,
            "nomeCliente" => $nomeCliente,
        ]);
    }

    public function formEditar(array $data)
    {
        $id = addslashes($data["pedido"]);
        $id = htmlspecialchars_decode($id);

        if (empty($id)) {
            http_response_code(400);
            echo $this->ajaxResponse("Pedido", ["error" => "Pedido invalido."]);
            die();
        }

        $pedidoDao = new PedidoDao();
        $pedido = $pedidoDao->fetch($id);

        $clienteDao = new ClienteDao();
        $cliente = $clienteDao->fetch($pedido->getClienteId());

        $idCliente = $cliente->getId();
        $nomeCliente = null;

        if($cliente->getFisicaJuridica()){
            $nomeCliente = $cliente->getNome();
        }else{
            $nomeCliente = $cliente->getRazaoSocial();
        }

        $servicos = explode(", ", $pedido->getServicos());
        $dataAbertura = date("Y-m-d", strtotime($pedido->getDataAbertura()));
        $dataRealizacao = date("Y-m-d", strtotime($pedido->getDataRealizacao()));

        echo $this->view->render("formEditarPedido", [
            "title" => "Editar Pedido",
            "pedido" => $pedido,
            "idCliente" => $idCliente,
            "nomeCliente" => $nomeCliente,
            "dataAbertura" => $dataAbertura,
            "dataRealizacao" => $dataRealizacao,
            "servicos" => $servicos,
        ]);
    }

}
