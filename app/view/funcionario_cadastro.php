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
		<label for="necessidadesEspeciais">Necessidades Especiais:</label>
		<select name="necessidadesEspeciais[]" multiple>
			<?php foreach ($necessidadesEspeciais as $necessidadeEspecial) : ?>
			<optoin value=""></optoin>
			<option 
				value="<?php echo $necessidadeEspecial->getId() ?>"
				<?php
				$id = $necessidadeEspecial->getId();
				$funcionarioNecessidadeEspecial = $funcionario->getNecessidadeEspecial($id);
				if (!empty($funcionarioNecessidadeEspecial)) {
					if ($funcionarioNecessidadeEspecial->getId() == $necessidadeEspecial->getId()) {
						echo ' selected';
					}
				}
				?>
			>
				<?php echo $necessidadeEspecial->getNome() ?>
			</option>
			<?php endforeach; ?>
		</select>
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