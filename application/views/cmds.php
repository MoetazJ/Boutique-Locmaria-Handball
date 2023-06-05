<?php ?>
<h1>Listes des commandes</h1>
<br />

<?php if($cmds != NULL): ?>
	<table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
		<thead>
			<tr>
				<th>Command ID</th>
				<th>User mail</th>
				<th>Product Status</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($cmds as $cmd): ?>
				<tr>
                    <td><a href="<?php echo base_url('index.php/compte/voir_commandes/'.$cmd['order_id']); ?>"><?php echo $cmd['order_id']; ?></a></td>

					<td><?php $cpt_mail = $this->db_model->get_cpt($cmd['cpt_id']);echo $cpt_mail->cpt_mail; ?></td>
					<td><?php echo $cmd['order_status']; ?></td>
					<td><?php echo $cmd['order_date']; ?></td>
				<!--<td><a href="<?php// echo base_url('commande/supprimer/'.$cmd['cmd_id']); ?>">Supprimer</a></td> -->
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<p>Aucune commande n'a été trouvée.</p>
<?php endif; ?>
