<?php

namespace Source\Model;

class PedidoModel
{
    private $id;
    private $clienteId;
    private $dataAbertura;
    private $dataRealizacao;
    private $marca;
    private $modelo;
    private $placa;
    private $servicos;
    private $total;

    function __construct(){
        
    }

    public function getId() : ?int{
        return $this->id;
    }

    public function getClienteId() : int{
        return $this->clienteId;
    }

    public function getDataAbertura() : string{
        return $this->dataAbertura;
    }

    public function getDataRealizacao() : string{
        return $this->dataRealizacao;
    }

    public function getMarca() : string{
        return $this->marca;
    }

    public function getModelo() : string{
        return $this->modelo;
    }

    public function getPlaca() : string{
        return $this->placa;
    }

    public function getServicos() : string{
        return $this->servicos;
    }

    public function getTotal() : float {
        return $this->total;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setClienteId(int $clienteId){
        $this->clienteId = $clienteId;
    }

    public function setDataAbertura(string $dataAbertura){
        $this->dataAbertura = $dataAbertura;
    }

    public function setDataRealizacao(string $dataRealizacao){
        $this->dataRealizacao = $dataRealizacao;
    }

    public function setMarca(string $marca){
        $this->marca = $marca;
    }

    public function setModelo(string $modelo){
        $this->modelo = $modelo;
    }

    public function setPlaca(?string $placa){
         $this->placa = $placa;
    }

    public function setServicos(?string $servicos){
         $this->servicos = $servicos;
    }

    public function setTotal(float $total){
        $this->total = $total;
   }
}