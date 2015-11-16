<?php
class FuncionarioModel {
	private $id;
	private $nome;
	private $salario;
	private $necessidadesEspeciais = array();
	
	public function setId($id) {
		if ($id > 0) {
			$this->id = $id;
		} else {
			throw new Exception('Id deve ser maior que 0');
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setNome($nome) {
		$this->nome = $nome;
	}
	
	public function getNome() {
		return $this->nome;
	}
	
	public function setSalario($salario) {
		if (!is_float($salario)) {
			$salario = str_replace('.', '', $salario);
			$salario = str_replace(',', '.', $salario);
		
			settype($salario, 'float');
		}
		
		if ($salario > 0) {
			$this->salario = $salario;
		} else {
			$this->salario = 0;
		}
	}
	
	public function getSalario() {
		return $this->salario;
	}
	
	public function getSalarioFormate() {
		return number_format($this->salario, 2, ',', '.');
	}
	
	public function getSalarioSimbolo() {
		return 'R$ ' . number_format($this->salario, 2, ',', '.');
	}
	
	public function addNecessidadeEspecial(NecessidadeEspecialModel $necessidadeEspecial) {
		$id = $necessidadeEspecial->getId();
		$this->necessidadesEspeciais[$id] = $necessidadeEspecial;
	}
	
	public function removeNecessidadeEspecial(NecessidadeEspecialModel $necessidadeEspecial) {
		$id = $necessidadeEspecial->getId();
		unset($this->necessidadesEspeciais[$id]);
	}
	
	public function getNecessidadesEspeciais() {
		return $this->necessidadesEspeciais;
	}
	
	public function getNecessidadeEspecial($id) {
		if (isset($this->necessidadesEspeciais[$id])) {
			return $this->necessidadesEspeciais[$id];
		} else {
			return null;
		}
	}
}