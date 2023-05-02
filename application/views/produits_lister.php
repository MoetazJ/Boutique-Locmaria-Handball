<h1>Listes des produits</h1>
<br />

<?php if($pdts != NULL): ?>
	<table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Prix adulte</th>
				<th>Prix junior</th>
				<th>Type du produit</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($pdts as $pdt): ?>
				<tr>
					<td><?php echo $pdt['pdt_id']; ?></td>
					<td><?php echo $pdt['pdt_nom']; ?></td>
					<td><?php echo $pdt['pdt_prix']; ?></td>
					<td><?php echo $pdt['pdt_prixjr']; ?></td>
					<td><?php echo $pdt['pdt_type']; ?></td>
					<td><?php echo $pdt['pdt_type']; ?></td>

					<td><a href="<?php echo base_url('index.php/compte/supprimer_pdt/'.$pdt['pdt_id']); ?>">Supprimer</a></td> 
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<p>Aucun produits n'a été trouvée.</p>
<?php endif; ?>
