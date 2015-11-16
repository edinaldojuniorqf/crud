<?php
require_once 'core/ConnectDB.php';
require_once 'app/model/NecessidadeEspecialModel.php';
require_once 'app/model/NecessidadeEspecialDAO.php';

class NecessidadeEspecialController {
	
	public function index() {
		try {
			ConnectDB::open();
			
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			$necessidadesEspeciais = $necessidadeEspecialDAO->listar();
			
			ConnectDB::open();
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::open();
		}
		
		require_once('app/view/head.php');
		require_once('app/view/necessidade_especial_listar.php');
		require_once('app/view/footer.php');
	}
	
	public function novo() {
		$necessidadeEspecial = new NecessidadeEspecialModel();
		
		require_once 'app/view/necessidade_especial_cadastro.php';
	}
	
	public function editar() {
		$id = $_GET['id'];
		
		try {
			ConnectDB::open();
			
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			$necessidadeEspecial = $necessidadeEspecialDAO->load($id);
			
			ConnectDB::close();
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::close();
		}
		
		require_once('app/view/head.php');
		require_once('app/view/necessidade_especial_cadastro.php');
		require_once('app/view/footer.php');
	}
	
	
	public function save() {
		$nome = $_POST['nome'];
		
		try {
			$necessidadeEspecial = new NecessidadeEspecialModel();
			$necessidadeEspecial->setNome($nome);
			
			ConnectDB::open();
			
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			$necessidadeEspecialDAO->save($necessidadeEspecial);
			
			ConnectDB::close();
			
			header('location: index.php?c=NecessidadeEspecialController&m=index');
		} catch (PDOException $e) {
			ConnectDB::close();
			echo $e->getMessage();
		}
	}
	
	public function update() {
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		
		try {
			$necessidadeEspecial = new NecessidadeEspecialModel();
			$necessidadeEspecial->setId($id);
			$necessidadeEspecial->setNome($nome);
				
			ConnectDB::open();
				
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			$necessidadeEspecialDAO->update($necessidadeEspecial);
				
			ConnectDB::close();
				
			header('location: index.php?c=NecessidadeEspecialController&m=index');
		} catch (PDOException $e) {
			ConnectDB::close();
			echo $e->getMessage();
		}
	}
	
	public function excluir() {
		$id = $_GET['id'];
		
		try {
			ConnectDB::open();
			
			$necessidadeEspecialDAO = new NecessidadeEspecialDAO();
			$necessidadeEspecial = $necessidadeEspecialDAO->load($id);				
			$necessidadeEspecialDAO->excluir($necessidadeEspecial);
				
			ConnectDB::close();
				
			header('location: index.php?c=NecessidadeEspecialController&m=index');
		} catch (PDOException $e) {
			echo $e->getMessage();
			ConnectDB::close();
		}
	}
}