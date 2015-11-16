<?php
class FuncionarioDAO {
	private $conn;
	
	public function __construct() {
		$this->conn = ConnectDB::getConn();
	}
	
	public function save(FuncionarioModel $funcionarioModel) {
		$this->conn->exec("INSERT INTO funcionario(nome, salario) VALUES('{$funcionarioModel->getNome()}', {$funcionarioModel->getSalario()})");	
	}
	
	public function saveNecessidadesEspeciais(FuncionarioModel $funcionarioModel) {
		$result = $this->conn->query("SELECT last_value FROM funcionario_id_seq");
		$last_value = $result->fetch()['last_value'];
		
		$funcionarioModel->setId($last_value);
		
		foreach ($funcionarioModel->getNecessidadesEspeciais() as $necessidadeEspecial) {
			$stmt = $this->conn->prepare("INSERT INTO funcionario_necessidadesespeciais (funcionario_id, necessidadeespecial_id, data_cadastro) VALUES (?,?,?)");
			$stmt->bindValue(1, $funcionarioModel->getId());
			$stmt->bindValue(2, $necessidadeEspecial->getId());
			$stmt->bindValue(3, date('Y-m-d H:i:s'));
			$stmt->execute();
		}
	}
	
	public function update(FuncionarioModel $funcionarioModel) {
		$this->conn->exec("UPDATE funcionario SET nome = '{$funcionarioModel->getNome()}', salario = {$funcionarioModel->getSalario()} WHERE id = {$funcionarioModel->getid()}");
	}
	
	public function updateNecessidadesEspeciais(FuncionarioModel $funcionarioModel) {		
		// Remover necessidades especias que não estão agregadas ao funcionario
		$necessidadesEspeciaisIds = array();
		foreach ($funcionarioModel->getNecessidadesEspeciais() as $necessidadeEspecial) {
			$necessidadesEspeciaisIds[] = $necessidadeEspecial->getId();
		}
		if (sizeof($necessidadesEspeciaisIds) > 0) {
			$necessidadesEspeciaisIds_str = implode(',', $necessidadesEspeciaisIds);
		} else {
			$necessidadesEspeciaisIds_str = '0';
		}
		
		$this->conn->exec("DELETE FROM funcionario_necessidadesespeciais WHERE funcionario_id = {$funcionarioModel->getId()} AND necessidadeespecial_id NOT IN($necessidadesEspeciaisIds_str)");
		
		// Inserir necessidades especiais que não estão cadastradas
		$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
		
		foreach ($necessidadesEspeciaisIds as $necessidadeEspecialId) {
			if (!$this->hasNecessidadeEspecial($funcionarioModel, $necessidadeEspecialId)) {
				$stmt = $this->conn->prepare("INSERT INTO funcionario_necessidadesespeciais (funcionario_id, necessidadeespecial_id, data_cadastro) VALUES (?,?,?)");
				$stmt->bindValue(1, $funcionarioModel->getId());
				$stmt->bindValue(2, $necessidadeEspecialId);
				$stmt->bindValue(3, date('Y-m-d H:i:s'));
				$stmt->execute();
			}
		}
		
		/*		
		 // Excluir todas as necessidades especiais
		 $this->conn->exec("DELETE FROM funcionario_necessidadesespeciais WHERE funcionario_id = {$funcionarioModel->getId()}");
		
		 // Inserir todas as necessidades especiais
		 foreach ($funcionarioModel->getNecessidadesEspeciais() as $necessidadeEspecial) {
			 $stmt = $this->conn->prepare("INSERT INTO funcionario_necessidadesespeciais (funcionario_id, necessidadeespecial_id, data_cadastro) VALUES (?,?,?)");
			 $stmt->bindValue(1, $funcionarioModel->getId());
			 $stmt->bindValue(2, $necessidadeEspecial->getId());
			 $stmt->bindValue(3, date('Y-m-d H:i:s'));
			 $stmt->execute();
		 }
		 */
	}
	
	public function excluir(FuncionarioModel $funcionario) {
		$this->conn->exec("DELETE FROM funcionario WHERE id = {$funcionario->getId()}");
	}
	
	public function load($id) {
		$result =  $this->conn->query("SELECT * FROM funcionario WHERE id = $id");		
		return $result->fetchObject('FuncionarioModel');
	}
	
	public function listar() {
		$result =  $this->conn->query("SELECT * FROM funcionario ORDER BY id DESC");
		return $result->fetchAll(PDO::FETCH_CLASS, 'FuncionarioModel');
	}
	
	public function loadNecessidadesEspeciais(FuncionarioModel $funcinoario) {
		$result = $this->conn->query("
			SELECT necessidadesespeciais.* FROM 
			funcionario,funcionario_necessidadesespeciais,necessidadesespeciais 
			WHERE funcionario.id = funcionario_id 
			AND necessidadeespecial_id = necessidadesespeciais.id
			AND funcionario.id = {$funcinoario->getId()}
		");
		$necessidadesEspeciais = $result->fetchAll(PDO::FETCH_CLASS, 'NecessidadeEspecialModel');
		
		foreach ($necessidadesEspeciais as $necessidadeEspecial) {
			$funcinoario->addNecessidadeEspecial($necessidadeEspecial);
		}
	}
	
	/**
	 * Verifica se um funcionário tem necessidades especiais, caso tenha retorna quantas ele tem.
	 * @param FuncionarioModel $funcinoario
	 * @param integer $necessidadeEspecialId
	 */
	public function hasNecessidadeEspecial(FuncionarioModel $funcinoario, $necessidadeEspecialId = null) {
		$sql = "SELECT id FROM funcionario_necessidadesespeciais WHERE funcionario_id = {$funcinoario->getId()}";
		if ($necessidadeEspecialId) {
			$sql .= " AND necessidadeespecial_id = $necessidadeEspecialId";
		}
		$result = $this->conn->query($sql);
		return $result->rowCount();
	}
}