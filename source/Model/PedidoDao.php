<?php

namespace Source\Model;

use Error;
use Exception;
use PDO;
use Source\Controller\Connection;
use Source\Model\PedidoModel;

class PedidoDao
{  

    public function save(PedidoModel $pedido)
    {
        try {
            $con = Connection::getConnection();
            if ($con == null) throw new Error("Conexão falhou.");

            $con->beginTransaction();

            if (!$pedido->getId()) {
                $sql = "INSERT INTO Pedido(cliente_id, data_abertura, data_realizacao, marca, modelo, placa, servicos, total) 
                        VALUES (:clienteId, :dataAbertura, :dataRealizacao, :marca, :modelo, :placa, :servicos, :total);";

                $stmt = $con->prepare($sql);
                $stmt->bindValue(":clienteId", $pedido->getClienteId());
                $stmt->bindValue(":dataAbertura", $pedido->getDataAbertura());
                $stmt->bindValue(":dataRealizacao", $pedido->getDataRealizacao());
                $stmt->bindValue(":marca", $pedido->getMarca());
                $stmt->bindValue(":modelo", $pedido->getModelo());
                $stmt->bindValue(":placa", $pedido->getPlaca());
                $stmt->bindValue(":servicos", $pedido->getServicos());
                $stmt->bindValue(":total", $pedido->getTotal());

                if ($stmt->execute()) {
                    $pedido->setId($con->lastInsertId());
                    $con->commit();
                } else {
                    throw new Exception("Erro no cadastrar");
                }
            } else {
                $sql = "UPDATE Pedido SET 
                        data_abertura = :dataAbertura,
                        data_realizacao = :dataRealizacao,
                        marca = :marca,
                        modelo = :modelo,
                        placa = :placa,
                        servicos = :servicos,
                        total = :total
                        WHERE id = :id;";
                $stmt = $con->prepare($sql);

                $stmt->bindValue(":dataAbertura", $pedido->getDataAbertura());
                $stmt->bindValue(":dataRealizacao", $pedido->getDataRealizacao());
                $stmt->bindValue(":marca", $pedido->getMarca());
                $stmt->bindValue(":modelo", $pedido->getModelo());
                $stmt->bindValue(":placa", $pedido->getPlaca());
                $stmt->bindValue(":servicos", $pedido->getServicos());
                $stmt->bindValue(":total", $pedido->getTotal());
                $stmt->bindValue(":id", $pedido->getId());

                if ($stmt->execute()) {
                   $con->commit();
                } else {
                    throw new Exception("Erro ao atualizar pedido");
                }
            }
        } catch (Error $e) {
            return $e->getCode();
        } catch (Exception $e) {
            return $e->getCode();
        } finally {
            Connection::close($con);
        }
        
        return $pedido;
    }

    public function fetch(int $id = null)
    {
        try {
            $con = Connection::getConnection();
            if ($con == null) throw new Error("Conexão falhou.");
            
            $pedidos = null;
            
            if (!$id) {
                $sql = "SELECT id 
                         , cliente_id as clienteId 
                         , data_abertura as dataAbertura 
                         , data_realizacao as dataRealizacao 
                         , marca 
                         , modelo 
                         , placa 
                         , servicos 
                         , total 
                        FROM Pedido 
                        ORDER BY
                        id DESC;";

                $stmt = $con->prepare($sql);
            } else {
                $sql = "SELECT id
                         , cliente_id as clienteId 
                         , data_abertura as dataAbertura 
                         , data_realizacao as dataRealizacao 
                         , marca 
                         , modelo 
                         , placa 
                         , servicos 
                         , total 
                        FROM Pedido p
                        WHERE 
                          id = :id";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":id", $id);
            }

            if ($stmt->execute()) {
                if(!$id){
                    $pedidos = $stmt->fetchAll(PDO::FETCH_CLASS, "Source\Model\PedidoModel");
                }else{
                    $pedidos = $stmt->fetchAll(PDO::FETCH_CLASS, "Source\Model\PedidoModel");
                    if($pedidos) {
                        $pedidos = $pedidos[0];
                    }
                }
            } else {
                throw new Exception("Erro na busca.");
            }
        } catch (Error $e) {
            $pedidos = [];
            return $pedidos;
        } catch (Exception $e) {
            $pedidos = [];
            return $pedidos;
        } finally {
            Connection::close($con);
        }
        return $pedidos;
    }

    public function fetchByCliente(int $id)
    {
        try {
            $con = Connection::getConnection();
            if ($con == null) throw new Error("Conexão falhou.");
            
            $pedidos = null;
            $sql = "SELECT id
                        , cliente_id as clienteId 
                        , data_abertura as dataAbertura 
                        , data_realizacao as dataRealizacao 
                        , marca 
                        , modelo 
                        , placa 
                        , servicos 
                        , total 
                    FROM Pedido p
                    WHERE 
                        cliente_id = :clienteId";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":clienteId", $id);
            

            if ($stmt->execute()) {
                $pedidos = $stmt->fetchAll(PDO::FETCH_CLASS, "Source\Model\PedidoModel");
            } else {
                throw new Exception("Erro na busca.");
            }
        } catch (Error $e) {
            $pedidos = [];
            return $pedidos;
        } catch (Exception $e) {
            $pedidos = [];
            return $pedidos;
        } finally {
            Connection::close($con);
        }
        return $pedidos;
    }

    public function delete(int $id): bool
    {
        try {
            $con = Connection::getConnection();
            if ($con == null) throw new Error("Conexão falhou.");
            
            $result = false;
            $sql = "DELETE FROM Pedido WHERE id = :id";

            $stmt = $con->prepare($sql);
            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Erro no deletar");
            }
        } catch (Error $e) {
            return $result;
            die();
        } catch (Exception $e) {
            dd($e->getMessage());
            return $result;
        } finally {
            Connection::close($con);
        }
        return $result;
    }
}
