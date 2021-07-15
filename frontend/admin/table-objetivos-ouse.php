<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if ($variaveis) {
	$objetivosOuse = $variaveis;
} else {
	$objetivosOuse = pdi_get_objetivos_ouse_all();
}
?>
<table class="wp-list-table widefat fixed striped pdi-table">
	<tbody>
		<?php if (!$objetivosOuse['error']) : ?>
			<?php foreach ($objetivosOuse as $ouse) : ?>
				<?php if ($ouse->active != 0) : ?>
					<tr>
						<td data-ouse-id="<?php echo $ouse->id ?>">
							<a href="?indicador_id=<?php echo $ouse->id ?>"><?php echo $ouse->id . ' - ' . $ouse->descricao ?></a>
						</td>

					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<tr>
				<td><?php echo $objetivosOuse['error'] ?></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>