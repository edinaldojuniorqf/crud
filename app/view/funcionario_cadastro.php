<!doctype html>
<html>
	<head>
		<title>Cadastro de Funcionário</title>
		<meta charset="utf-8">
	</head>
	<body>
		<?php if (isset($_GET['id'])) : ?>
		<form method="post" action="index.php?c=FuncionarioController&m=update">
		<?php else : ?>
		<form method="post" action="index.php?c=FuncionarioController&m=save">
		<?php endif; ?>
			<div>
				<label for="nome">Nome:</label>
				<input type="text" id="nome" name="nome" value="<?php echo $funcionario->getNome(); ?>">
			</div>
			<div>
				<label for="salario">Salário:</label>
				<input type="text" id="salario" name="salario" value="<?php echo $funcionario->getSalarioFormate(); ?>">
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
	</body>
</html>