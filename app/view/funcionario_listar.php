<a href="index.php?c=IndexController&m=index">INÍCIO</a>
<a href="index.php?c=FuncionarioController&m=novo">NOVO</a>
<table>
	<thead>
		<tr>
			<th>Código</th>
			<th>Nome</th>
			<th>Salário</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($funcionarios as $funcionario) : ?>
		<tr>
			<td><?php echo $funcionario->getId(); ?></td>
			<td><?php echo $funcionario->getNome() ?></td>
			<td><?php echo $funcionario->getSalarioSimbolo() ?></td>
			<td><a href="index.php?c=FuncionarioController&m=editar&id=<?php echo $funcionario->getId() ?>">Editar</a></td>
			<td><a href="index.php?c=FuncionarioController&m=excluir&id=<?php echo $funcionario->getId() ?>">Excluir</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>