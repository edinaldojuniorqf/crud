<?php
class FuncionarioDAO {
	private $conn;
	
	public function __construct() {
		$this->conn = ConnectDB::getConn();
	}
	
	public function save(FuncionarioModel $funcionarioModel) {
		$this->conn->exec("INSERT INTO funcionario(nome, salario) VALUES('{$funcionarioModel->getNome()}', {$funcionarioModel->getSalario()})");
	}
	
	public function update(FuncionarioModel $funcionarioModel) {
		$this->conn->exec("UPDATE funcionario SET nome = '{$funcionarioModel->getNome()}', salario = {$funcionarioModel->getSalario()} WHERE id = {$funcionarioModel->getid()}");
	}
	
	public function load($id) {
		$result =  $this->conn->query("SELECT * FROM funcionario WHERE id = $id");		
		return $result->fetchObject('FuncionarioModel');
	}
	
	public function listar() {
		$result =  $this->conn->query("SELECT * FROM funcionario ORDER BY id DESC");
		return $result->fetchAll(PDO::FETCH_CLASS, 'FuncionarioModel');
	}
	
	public function excluir(FuncionarioModel $funcionario) {
		$this->conn->exec("DELETE FROM funcionario WHERE id = {$funcionario->getId()}");
	}
}