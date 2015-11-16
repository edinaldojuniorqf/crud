<?php
require_once 'core/ConnectDB.php';
require_once 'app/model/FuncionarioModel.php';
require_once 'app/model/FuncionarioDAO.php';
require_once 'app/model/NecessidadeEspecialModel.php';
require_once 'app/model/NecessidadeEspecialDAO.php';

class FuncionarioController {
	
	public function index() {
		try {
			ConnectDB::open();
		
			$funcionarioDAO = new FuncionarioDAO();
			$funcionarios = $funcionarioDAO->listar();
			
			ConnectDB::close();
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::close();
		}
		
		require_once('app/view/head.php');
		require_once('app/view/funcionario_listar.php');
		require_once('app/view/footer.php');
	}
	
	public function novo() {
		$funcionario = new FuncionarioModel();
		
		try {
			ConnectDB::open();
			
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			$necessidadesEspeciais = $necessidadeEspecialDAO->listar();
			
			ConnectDB::close();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
				
		require_once('app/view/head.php');
		require_once('app/view/funcionario_cadastro.php');
		require_once('app/view/footer.php');
	}
	
	public function editar() {
		$id = $_GET['id'];
		
		try {
			ConnectDB::open();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionario = $funcionarioDAO->load($id);
			$funcionarioDAO->loadNecessidadesEspeciais($funcionario);
			
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			$necessidadesEspeciais = $necessidadeEspecialDAO->listar();
			
			ConnectDB::close();
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::close();
		}
		
		require_once('app/view/head.php');
		require_once('app/view/funcionario_cadastro.php');
		require_once('app/view/footer.php');
	}
	
	public function save() {
		$nome = $_POST['nome'];
		$salario = $_POST['salario'];
		$necessidadesEspeciais = $_POST['necessidadesEspeciais'];
		
		try {
			ConnectDB::open();
			
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			
			$funcionario = new FuncionarioModel();
			$funcionario->setNome($nome);
			$funcionario->setSalario($salario);
			foreach ($necessidadesEspeciais as $id) {
				$necessidadeEspecial = $necessidadeEspecialDAO->load($id);
				if ($necessidadeEspecial) {
					$funcionario->addNecessidadeEspecial($necessidadeEspecial);
				}
			}
			
			ConnectDB::beginTransaction();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionarioDAO->save($funcionario);
			$funcionarioDAO->saveNecessidadesEspeciais($funcionario);
			
			ConnectDB::commit();
						
			ConnectDB::close();
			
			header('location: index.php?c=FuncionarioController&m=index');
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::rollBack();
			ConnectDB::close();
		}
	}
	
	public function update() {
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		$salario = $_POST['salario'];
		$necessidadesEspeciais = $_POST['necessidadesEspeciais'];
		
		try {
			$funcionario = new FuncionarioModel();
			$funcionario->setId($id);
			$funcionario->setNome($nome);
			$funcionario->setSalario($salario);
			foreach ($necessidadesEspeciais as $id) {
				$necessidadeEspecial = new NecessidadeEspecialModel();
				$necessidadeEspecial->setId($id);
				$funcionario->addNecessidadeEspecial($necessidadeEspecial);
			}
			
			ConnectDB::open();
			ConnectDB::beginTransaction();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionarioDAO->update($funcionario);
			$funcionarioDAO->updateNecessidadesEspeciais($funcionario);
			
			ConnectDB::commit();
			ConnectDB::close();
			
			header('location: index.php?c=FuncionarioController&m=index');
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::rollBack();
			ConnectDB::close();
		}
	}
	
	public function excluir() {
		$id = $_GET['id'];
		
		try {
			ConnectDB::open();
			
			$funcionarioDAO = new FuncionarioDAO();
			$funcionario = $funcionarioDAO->load($id);
			$funcionarioDAO->excluir($funcionario);
			
			ConnectDB::close();
			
			header('location: index.php?c=FuncionarioController&m=index');
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::close();
		}
	}
}