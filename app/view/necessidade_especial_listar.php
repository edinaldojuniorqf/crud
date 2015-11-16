<a href="index.php?c=IndexController&m=index">INÍCIO</a>
<a href="index.php?c=NecessidadeEspecialController&m=novo">NOVO</a>
<table>
	<thead>
		<tr>
			<th>Código</th>
			<th>Nome</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($necessidadesEspeciais as $necessidadeEspecial) : ?>
		<tr>
			<td><?php echo $necessidadeEspecial->getId(); ?></td>
			<td><?php echo $necessidadeEspecial->getNome() ?></td>
			<td><a href="index.php?c=NecessidadeEspecialController&m=editar&id=<?php echo $necessidadeEspecial->getId() ?>">Editar</a></td>
			<td><a href="index.php?c=NecessidadeEspecialController&m=excluir&id=<?php echo $necessidadeEspecial->getId() ?>">Excluir</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>