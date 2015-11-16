<?php
interface ICRUD {
	function index();
	function novo();
	function editar();
	function save();
	function update();
	function excluir();
}