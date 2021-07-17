<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$grande_tema = pdi_get_grande_tema_all();
?>
<div class="container-fluid pdi-container">
	<div class="pdi-plugin-title">
		<span class="dashicons dashicons-analytics"></span>
		PDI / Objetivos Ouse
	</div>
	<div class="card card-full p-0">
		<form action="">
			<div class="form-row row">
				<div class="col-md-3 col-label">
					<div class="">Selecionar Grande Tema Estratégico</div>
				</div>
				<div class="form-group col-md-9">
					<select name="grande_tema" id="grande-tema" class="form-control admin-filter-ouse">
						<option>Selecione</option>
						<?php foreach ($grande_tema as $gt) : ?>
							<?php if ($gt->active != 0) : ?>
								<option value="<?php echo $gt->id ?>"><?php echo $gt->descricao ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</form>
	</div>
	<div class="load-table">
		<?php pdi_get_template_front('admin/table-objetivos-ouse'); ?>
	</div>
</div>