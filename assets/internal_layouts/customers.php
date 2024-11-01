<div>
	<table class='uk-table uk-table-hover uk-table-striped'>
		<thead>
			<tr>
				<th>Name</th>
				<th>Agency Account</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($accounts): ?>
				<?php foreach ($accounts as $x): ?>
					<tr>
						<td><?php echo $x->data->display_name ?></td>
						<td><input type="checkbox" data-id='<?php echo $x->data->ID ?>' class='list-switch' <?php if(get_user_meta($x->data->ID, 'smr_type', true) == 'agency') echo 'checked' ?>></td>					
					</tr>
				<?php endforeach ?>
				<?php else: ?>
					<h3>No sites have the plugin currently active</h3>
				<?php endif ?>
			</tbody>
		</table>
	</div>
</div>