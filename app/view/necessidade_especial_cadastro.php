<?php if (isset($_GET['id'])) : ?>
<form method="post" action="index.php?c=NecessidadeEspecialController&m=update">
<?php else : ?>
<form method="post" action="index.php?c=NecessidadeEspecialController&m=save">
<?php endif; ?>
	<div>
		<label for="nome">Nome:</label>
		<input type="text" id="nome" name="nome" value="<?php echo $necessidadeEspecial->getNome(); ?>">
	</div>
	<div>
		<?php if (isset($_GET['id'])) : ?>
		<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
		<input type="submit" value="Atualizar">
		<?php else : ?>
		<input type="submit" value="Salvar">
		<?php endif; ?>
	</div>
</form>