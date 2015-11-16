<?php
class NecessidadeEspecialDAO {
	private $conn;
	
	public function __construct() {
		$this->conn = ConnectDB::getConn();
	}
	
	public function save(NecessidadeEspecialModel $necessidadeEspecial) {
		$this->conn->exec("INSERT INTO necessidadesespeciais(nome) VALUES('{$necessidadeEspecial->getNome()}')");
	}
	
	public function update(NecessidadeEspecialModel $necessidadeEspecial) {
		$this->conn->exec("UPDATE necessidadesespeciais SET nome = '{$necessidadeEspecial->getNome()}' WHERE id = {$necessidadeEspecial->getId()}");
	}
	
	public function excluir(NecessidadeEspecialModel $necessidadeEspecial) {
		$this->conn->exec("DELETE FROM necessidadesespeciais WHERE id = {$necessidadeEspecial->getId()}");
	}
	
	public function listar() {
		$result =  $this->conn->query("SELECT * FROM necessidadesespeciais ORDER BY id DESC");
		return $result->fetchAll(PDO::FETCH_CLASS, 'NecessidadeEspecialModel');
	}
	
	public function load($id) {
		$result =  $this->conn->query("SELECT * FROM necessidadesespeciais WHERE id = $id");		
		return $result->fetchObject('NecessidadeEspecialModel');
	}
}