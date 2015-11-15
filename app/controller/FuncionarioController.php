<?php
require_once 'core/ConnectDB.php';
require_once 'app/model/FuncionarioModel.php';
require_once 'app/model/FuncionarioDAO.php';

class FuncionarioController {
	
	public function index() {
		try {
			ConnectDB::open();
		
			$funcionarioDAO = new FuncionarioDAO();
			$funcionarios = $funcionarioDAO->listar();
			
			ConnectDB::close();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		require_once('app/view/funcionario_listar.php');
	}
	
	public function novo() {
		$funcionario = new FuncionarioModel();
		
		require_once('app/view/funcionario_cadastro.php');
	}
	
	public function editar() {
		$id = $_GET['id'];
		
		try {
			ConnectDB::open();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionario = $funcionarioDAO->load($id);
			
			ConnectDB::close();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		require_once('app/view/funcionario_cadastro.php');
	}
	
	public function save() {
		$nome = $_POST['nome'];
		$salario = $_POST['salario'];
		
		try {
			$funcionario = new FuncionarioModel();
			$funcionario->setNome($nome);
			$funcionario->setSalario($salario);
			
			ConnectDB::open();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionarioDAO->save($funcionario);
			
			ConnectDB::close();
			
			header('location: index.php?c=FuncionarioController&m=index');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function update() {
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		$salario = $_POST['salario'];
		
		try {
			$funcionario = new FuncionarioModel();
			$funcionario->setId($id);
			$funcionario->setNome($nome);
			$funcionario->setSalario($salario);
			
			ConnectDB::open();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionarioDAO->update($funcionario);
			
			ConnectDB::close();
			
			header('location: index.php?c=FuncionarioController&m=index');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function excluir() {
		$id = $_GET['id'];
		
		try {
			$funcionario = new FuncionarioModel();
			$funcionario->setId($id);
			
			ConnectDB::open();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionarioDAO->excluir($funcionario);
			
			ConnectDB::close();
			
			header('location: index.php?c=FuncionarioController&m=index');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}