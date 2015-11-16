<?php
interface IDAO {
	function save(Model $obj);
	function update(Model $obj);
	function excluir(Model $obj);
	function load($id);
	function listar();
}