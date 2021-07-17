<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Fuinctions Ajax
 */

/**
 * Salvar Nova Ação
 */
function pdi_save_new_acao()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	if ($args->objetivo_especifico) {
		$objEspecificos = [];
		foreach ($args->objetivo_especifico as $objetivo_especifico) {
			$get = pdi_get_objetivo_especifico(['descricao' => $objetivo_especifico]);
			if (!$get) {
				$objetivoEspecifico = [
					'descricao' => $objetivo_especifico,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];

				$format = [
					'%s',
					'%s',
					'%s',
				];

				$insert = pdi_set_objetivo_especifico($objetivoEspecifico, $format);
				if ($insert) $objEspecificos[] = $insert;
			} else {
				$objEspecificos[] = intval($get[0]->id);
			}
		}
	}

	$acao = [
		'indicador_id' => $args->indicador_meta,
		'eixo_id' => $args->eixo,
		'objetivo_especifico' => json_encode($objEspecificos),
		'descricao_acao' => $args->desc_acao,
		'ator' => $args->ator_acao,
		'percentual_cumprido' => convert_real_float($args->percentual_cumprido),
		'data_registro' => convert_data_db($args->data_registro),
		'ano_acao' => intval($args->ano_acao),
		'justificativa' => $args->justificativa_acao,
		'user_id' => get_current_user_id(),
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s'),
	];

	$format = [
		'%d',
		'%d',
		'%s',
		'%s',
		'%d',
		'%f',
		'%s',
		'%d',
		'%s',
		'%d',
		'%s',
		'%s',
	];

	$insertAcao = pdi_set_acoes($acao, $format);

	wp_send_json(
		array(
			'status' => true,
			'form' => $args,
			'objetivosEspecificos' => $objEspecificos,
			'acao' => $insertAcao,
		)
	);
	exit;
}
add_action('wp_ajax_pdi_save_new_acao', 'pdi_save_new_acao');
add_action('wp_ajax_nopriv_pdi_save_new_acao', 'pdi_save_new_acao');

/**
 * Editar Ação
 */
function pdi_update_acao()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	if ($args->objetivo_especifico) {
		$objEspecificos = [];
		foreach ($args->objetivo_especifico as $objetivo_especifico) {
			$get = pdi_get_objetivo_especifico(['descricao' => $objetivo_especifico]);
			if (!$get) {
				$objetivoEspecifico = [
					'descricao' => $objetivo_especifico,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];

				$format = [
					'%s',
					'%s',
					'%s',
				];

				$insert = pdi_set_objetivo_especifico($objetivoEspecifico, $format);
				if ($insert) $objEspecificos[] = $insert;
			} else {
				$objEspecificos[] = intval($get[0]->id);
			}
		}
	}

	$acao = [
		'indicador_id' => intval($args->indicador_meta),
		'eixo_id' => intval($args->eixo),
		'objetivo_especifico' => json_encode($objEspecificos),
		'descricao_acao' => $args->desc_acao,
		'ator' => intval($args->ator_acao),
		'percentual_cumprido' => convert_real_float($args->percentual_cumprido),
		'data_registro' => convert_data_db($args->data_registro),
		'ano_acao' => intval($args->ano_acao),
		'justificativa' => $args->justificativa_acao,
		'updated_at' => date('Y-m-d H:i:s'),
	];

	$format = [
		'%d',
		'%d',
		'%s',
		'%s',
		'%d',
		'%f',
		'%s',
		'%d',
		'%s',
		'%s',
	];

	$where = ['id' => intval($args->id)];
	$where_format = ['%d'];

	$updateAcao = pdi_update_acoes($acao, $where, $format, $where_format);
	pdi_update_metas_email($args->indicador_meta);
	
	wp_send_json(
		array(
			'status' => true,
			'form' => $args,
			'objetivosEspecificos' => $objEspecificos,
			'acao' => $acao,
			'update' => $updateAcao,
		)
	);
	exit;
}

add_action('wp_ajax_pdi_update_acao', 'pdi_update_acao');
add_action('wp_ajax_nopriv_pdi_update_acao', 'pdi_update_acao');

/**
 * Salvar Meta
 */
function pdi_save_meta()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$indicador = [
		'grande_tema_id' => intval($args->grande_tema),
		'objetivo_ouse_id' => intval($args->objetivo_ouse),
		'titulo' => $args->indicador,
		'descricao' => $args->desc_meta,
		'ods' => json_encode($args->ods),
		'pne' => json_encode($args->pne),
		'valor_meta' => convert_real_float($args->valor_meta),
		'valor_inicial' => convert_real_float($args->valor_inicial_meta),
		'data_registro' => convert_data_db($args->data_registro_meta),
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s'),
	];

	$format = [
		'%d',
		'%d',
		'%s',
		'%s',
		'%s',
		'%s',
		'%f',
		'%f',
		'%s',
		'%s',
		'%s',
	];

	$insert_indicador = pdi_set_indicadores($indicador, $format);

	if ($insert_indicador) {
		$i = 0;
		$insert_indicador_ano = [];
		foreach ($args->ano_meta as $ano_meta) {
			$indicadorAno = [
				'indicador_id' => intval($insert_indicador),
				'ano' => intval($ano_meta),
				'valor' => convert_real_float($args->valor_ano_meta[$i]),
				'valor_previsto' => convert_real_float($args->valor_previsto_ano_meta[$i]),
				'data_registro' => convert_data_db($args->data_registro_ano_meta[$i]),
				'justificativa' => $args->justificativa_ano_meta[$i],
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];

			$format = [
				'%d',
				'%d',
				'%f',
				'%f',
				'%s',
				'%s',
				'%s',
				'%s',
			];

			$insert_indicador_ano[] = pdi_set_indicadores_anos($indicadorAno, $format);

			$i++;
		}
	}

	wp_send_json(
		array(
			'status' => true,
			'indicador' => $insert_indicador,
			'args' => $args,
			'meta' => $indicador,
		)
	);
	exit;
}
add_action('wp_ajax_pdi_save_meta', 'pdi_save_meta');
add_action('wp_ajax_nopriv_pdi_save_meta', 'pdi_save_meta');

/**
 * Editar Meta
 */
function pdi_update_meta()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$indicador = [
		'grande_tema_id' => intval($args->grande_tema),
		'objetivo_ouse_id' => intval($args->objetivo_ouse),
		'titulo' => $args->indicador,
		'descricao' => $args->desc_meta,
		'ods' => json_encode($args->ods),
		'pne' => json_encode($args->pne),
		'valor_meta' => convert_real_float($args->valor_meta),
		'valor_inicial' => convert_real_float($args->valor_inicial_meta),
		'data_registro' => convert_data_db($args->data_registro_meta),
		'updated_at' => date('Y-m-d H:i:s'),
	];

	$format = [
		'%d',
		'%d',
		'%s',
		'%s',
		'%s',
		'%s',
		'%f',
		'%f',
		'%s',
		'%s',
	];

	$where = ['id' => $args->id];
	$where_format = ['%d'];

	pdi_update_metas_email(intval($args->id));
	$update_indicador = pdi_update_indicadores($indicador, $where, $format, $where_format);

	if ($update_indicador) {
		$i = 0;
		$update_indicador_ano = [];
		foreach ($args->ano_meta as $ano_meta) {
			$indicadorAno = [
				'indicador_id' => intval($args->id),
				'ano' => intval($ano_meta),
				'valor' => convert_real_float($args->valor_ano_meta[$i]),
				'valor_previsto' => convert_real_float($args->valor_previsto_ano_meta[$i]),
				'data_registro' => convert_data_db($args->data_registro_ano_meta[$i]),
				'justificativa' => $args->justificativa_ano_meta[$i],
			];

			$format = [
				'%d',
				'%d',
				'%f',
				'%f',
				'%s',
				'%s',
			];

			$get_anos = pdi_get_indicadores_anos($indicadorAno);
			$get_anos_[] = $get_anos;
			if (!$get_anos) {
				$indicadorAno['created_at'] = date('Y-m-d H:i:s');
				$indicadorAno['updated_at'] = date('Y-m-d H:i:s');
				$insert =  pdi_set_indicadores_anos($indicadorAno, $format);
				$update_indicador_ano[] = $insert;
			} else {
				$indicadorAno['updated_at'] = date('Y-m-d H:i:s');
				$where = ['id' => $args->ano_id[$i]];
				$where_format = ['%d'];
				$update_indicador_ano[] = pdi_update_indicadores_anos($indicadorAno, $where, $format, $where_format);
			}

			$i++;
		}
	}

	foreach ($args->remove_ano_id as $remove_ano_id) {
		pdi_delete_indicadores_anos(['id' => $remove_ano_id]);
	}

	wp_send_json(
		array(
			'status' => true,
			'update_indicador' => $update_indicador,
			'get_anos' => $get_anos_,
			'insert' => $insert,
			'indicador' => $indicador,
			'args' => $args,
		)
	);
	exit;
}

add_action('wp_ajax_pdi_update_meta', 'pdi_update_meta');
add_action('wp_ajax_nopriv_pdi_update_meta', 'pdi_update_meta');

/**
 * Filtrar Ação
 */
function pdi_filter_acao()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	global $wpdb;

	$query = "SELECT " . PREFIXO_TABLE . TABLE_ACOES . ".active, " . PREFIXO_TABLE . TABLE_ACOES . ".descricao_acao, " . PREFIXO_TABLE . TABLE_ACOES . ".id FROM " . PREFIXO_TABLE . TABLE_ACOES
		. " INNER JOIN " . PREFIXO_TABLE . TABLE_INDICADORES
		. " ON " . PREFIXO_TABLE . TABLE_INDICADORES . ".id = " . PREFIXO_TABLE . TABLE_ACOES . ".indicador_id";

	if ($args->eixo_estruturante || $args->grande_tema || $args->objetivo_ouse) {
		$where = " WHERE ";
		if ($args->eixo_estruturante) {
			$where .= PREFIXO_TABLE . TABLE_ACOES . ".eixo_id = " . $args->eixo_estruturante . " AND ";
		}
		if ($args->grande_tema) {
			$where .= PREFIXO_TABLE . TABLE_INDICADORES . ".grande_tema_id = " . $args->grande_tema . " AND ";
		}
		if ($args->objetivo_ouse) {
			$where .= PREFIXO_TABLE . TABLE_INDICADORES . ".objetivo_ouse_id = " . $args->objetivo_ouse . " AND ";
		}
		$where = rtrim($where, ' AND ');

		$query = $query . $where;
	}

	$select = $wpdb->get_results(
		$wpdb->prepare(
			$query
		)
	);

	if (!$select) $select['error'] = 'Nenhum registro escontrado';

	ob_start();
	pdi_get_template_front('admin/table-acoes', $select);
	$html = ob_get_clean();
	wp_send_json(
		array(
			'status' => true,
			'form' => $args,
			'query' => $query,
			'select' => $select,
			'html' => $html,
		)
	);
	exit;
}
add_action('wp_ajax_pdi_filter_acao', 'pdi_filter_acao');
add_action('wp_ajax_nopriv_pdi_filter_acao', 'pdi_filter_acao');

/**
 * Filtrar Metas
 */
function pdi_filter_metas()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$filter = [];
	if ($args->grande_tema) $filter['grande_tema_id'] = intval($args->grande_tema);
	if ($args->objetivo_ouse) $filter['objetivo_ouse_id'] = intval($args->objetivo_ouse);

	$select = pdi_get_indicadores_all($filter);

	if (!$select) $select['error'] = 'Nenhum registro escontrado';
	ob_start();
	pdi_get_template_front('admin/table-metas', $select);
	$html = ob_get_clean();

	wp_send_json(
		array(
			'status' => true,
			'indicador' => $select,
			'html' => $html
		)
	);
	exit;
}
add_action('wp_ajax_pdi_filter_metas', 'pdi_filter_metas');
add_action('wp_ajax_nopriv_pdi_filter_metas', 'pdi_filter_metas');

/**
 * Filtrar Objetivos Ouse
 */
function pdi_filter_objetivos_ouse()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;


	wp_send_json(
		array(
			'status' => true,
		)
	);
	exit;
}
add_action('wp_ajax_pdi_filter_objetivos_ouse', 'pdi_filter_objetivos_ouse');
add_action('wp_ajax_nopriv_pdi_filter_objetivos_ouse', 'pdi_filter_objetivos_ouse');

/**
 * Buscar Objetivos Especificos
 */
function pdi_search_objetivo_especifico()
{
	$valor = (isset($_POST['valor'])) ? $_POST['valor'] : null;
	global $wpdb;
	$query = "SELECT * FROM meta." . PREFIXO_TABLE . TABLE_OBJETIVO_ESPECIFICO . " "
		. "WHERE descricao LIKE '%{$valor}%' AND active = 1";

	$select = $wpdb->get_results(
		$wpdb->prepare(
			$query
		)
	);

	wp_send_json(
		array(
			'status' => true,
			'valor' => $valor,
			'retorno' => $select,
		)
	);
	exit;
}
add_action('wp_ajax_pdi_search_objetivo_especifico', 'pdi_search_objetivo_especifico');
add_action('wp_ajax_nopriv_pdi_search_objetivo_especifico', 'pdi_search_objetivo_especifico');


function pdi_load_select_ano_acoes()
{
	$indicador_id = filter_input(INPUT_POST, 'indicador_id', FILTER_SANITIZE_STRING);

	$indicadores_anos = pdi_get_indicadores_anos(['indicador_id' => intval($indicador_id)]);
	ob_start();
	foreach ($indicadores_anos as $indicador_anos) {
?>
		<option value="<?php echo $indicador_anos->ano ?>">
			<?php echo $indicador_anos->ano ?>
		</option>
	<?php
	}
	print_r(ob_get_clean());
	exit();
}

add_action('wp_ajax_pdi_load_select_ano_acoes', 'pdi_load_select_ano_acoes');
add_action('wp_ajax_nopriv_pdi_load_select_ano_acoes', 'pdi_load_select_ano_acoes');


function pdi_filter_front_metas()
{
	$page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_NUMBER_INT);
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$filters = ['active' => 1];
	if ($args->grande_tema) $filters['grande_tema_id'] = intval($args->grande_tema);
	if ($args->objetivo_ouse) $filters['objetivo_ouse_id'] = intval($args->objetivo_ouse);
	if ($args->ano_referencia) {
		$indicadores_anos = pdi_get_indicadores_anos_all(['ano' => $args->ano_referencia]);
		$filters['id'] = [];
		foreach ($indicadores_anos as $indc_ano) {
			$filters['id'][] = intval($indc_ano->indicador_id);
		}
	}
	if ($args->ods) {
		global $wpdb;
		$query = "SELECT id FROM " . PREFIXO_TABLE . TABLE_INDICADORES
			. " WHERE ods LIKE '%\"{$args->ods}\"%'";
		$select = $wpdb->get_results(
			$wpdb->prepare(
				$query
			)
		);
		foreach ($select as $ods) {
			$filters['id'][] = intval($ods->id);
		}
	}

	if ($filters['id']) $filters['id'] = array_unique($filters['id'], SORT_STRING);

	ob_start();
	$view_pagination = 5;
	$indicadores = pdi_get_indicadores_all($filters, $view_pagination, $page);
	$count_total = pdi_count_indicadores_all($filters);
	$pagnation = ceil(intval($count_total) / $view_pagination);
	$variavevis = [
		'active' => true,
		'indicadores' => $indicadores,
		'filters' => $filters,
		'page' => $page,
		'pagnation' => $pagnation,
	];
	pdi_get_template_front('view/card-metas', $variavevis);
	print_r(ob_get_clean());
	exit();
}

add_action('wp_ajax_pdi_filter_front_metas', 'pdi_filter_front_metas');
add_action('wp_ajax_nopriv_pdi_filter_front_metas', 'pdi_filter_front_metas');


function pdi_add_notification()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;


	if (!$args->notification_name) {
		wp_send_json(
			array(
				'status' => 'error',
				'msg_error' => 'O campo Nome é obrigatório',
				'args' => $args
			)
		);
		exit;
	}

	if (!$args->notification_email) {
		wp_send_json(
			array(
				'status' => 'error',
				'msg_error' => 'O campo E-mail é obrigatório',
				'args' => $args
			)
		);
		exit;
	}

	$dados = [
		'indicador_id' => intval($args->notification_indicador_id),
		'nome' => $args->notification_name,
		'email' => $args->notification_email,
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s'),
	];
	$format = [
		'%d',
		'%s',
		'%s',
		'%s',
		'%s',
	];

	$insert = pdi_set_notification($dados);

	if (!$insert) {
		wp_send_json(
			array(
				'status' => 'error',
				'args' => $args,
				'msg_error' => 'Ocorreu um erro interno ao realizar o cadastro, tente novamente mais tarde.',
				'insert' => $insert,
				'dados' => $dados,
			)
		);
	}

	wp_send_json(
		array(
			'status' => 'success',
			'args' => $args,
			'insert' => $insert,
			'indicador_id' => $args->notification_indicador_id
		)
	);
	exit;
}

add_action('wp_ajax_pdi_add_notification', 'pdi_add_notification');
add_action('wp_ajax_nopriv_pdi_add_notification', 'pdi_add_notification');


function pdi_add_comments()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$user_id = get_current_user_id();
	$user = get_user_by('id', $user_id);

	$dados = [
		'indicador_id' => intval($args->indicador_id),
		'user_id' => intval($user_id),
		'name' => $user->first_name . ' ' . $user->last_name,
		'comment' => $args->text_comment,
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s')
	];
	$format = [
		'%d',
		'%d',
		'%s',
		'%s',
		'%s',
		'%s',
	];
	if ($args->comment_reply) {
		$dados['comment_parent'] = $args->comment_reply;
		$format[count($format)] = '%d';
	}



	$insert = pdi_set_comments($dados, $format);

	wp_send_json(
		array(
			'status' => 'success',
			'args' => $args,
			'dados' => $dados,
			'insert' => $insert
		)
	);
	exit;
}

add_action('wp_ajax_pdi_add_comments', 'pdi_add_comments');
add_action('wp_ajax_nopriv_pdi_add_comments', 'pdi_add_comments');

function pdi_comments_reload()
{
	$indicador_id = filter_input(INPUT_POST, 'indicador_id', FILTER_SANITIZE_STRING);
	ob_start();
	pdi_get_template_front('view/comments-preview', ['indicador_id' => intval($indicador_id)]);
	print_r(ob_get_clean());
	exit();
}

add_action('wp_ajax_pdi_comments_reload', 'pdi_comments_reload');
add_action('wp_ajax_nopriv_pdi_comments_reload', 'pdi_comments_reload');


function pdi_delete_comments()
{
	$comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_STRING);
	$reply = filter_input(INPUT_POST, 'reply', FILTER_SANITIZE_STRING);

	global $wpdb;

	if ($reply == 'true') {
		$query = "DELETE FROM " . PREFIXO_TABLE . TABLE_COMMENTS . " WHERE id=" . $comment_id;
		$delete = $wpdb->query(
			$wpdb->prepare(
				$query
			)
		);
	} else {
		$comment = pdi_get_comments(['id' => intval($comment_id)]);
		$query = "DELETE FROM " . PREFIXO_TABLE . TABLE_COMMENTS . " WHERE id=" . $comment_id . " OR comment_parent=" . $comment_id;
		$delete = $wpdb->query(
			$wpdb->prepare(
				$query
			)
		);
	}

	wp_send_json(
		array(
			'status' => 'success',
			'delete' => $delete,
			'query' => $query,
		)
	);
}

add_action('wp_ajax_pdi_delete_comments', 'pdi_delete_comments');
add_action('wp_ajax_nopriv_pdi_delete_comments', 'pdi_delete_comments');

function pdi_add_users_permission()
{
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$update = update_user_meta(intval($args->user), 'pdi_ator', $args->user_group);

	wp_send_json(
		array(
			'status' => 'success',
			'args' => $args,
			'update' => $update
		)
	);
}

add_action('wp_ajax_pdi_add_users_permission', 'pdi_add_users_permission');
add_action('wp_ajax_nopriv_pdi_add_users_permission', 'pdi_add_users_permission');

function pdi_remove_users_permission()
{
	$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);
	$delete = delete_user_meta(intval($user_id), 'pdi_ator');
	wp_send_json(
		array(
			'status' => 'success',
			'user_id' => $user_id,
			'delete' => $delete
		)
	);
}

add_action('wp_ajax_pdi_remove_users_permission', 'pdi_remove_users_permission');
add_action('wp_ajax_nopriv_pdi_remove_users_permission', 'pdi_remove_users_permission');

function pdi_reload_table_users_permission()
{
	ob_start();
	pdi_get_template_front('admin/table-user-permission');
	print_r(ob_get_clean());
	exit();
}

add_action('wp_ajax_pdi_reload_table_users_permission', 'pdi_reload_table_users_permission');
add_action('wp_ajax_nopriv_pdi_reload_table_users_permission', 'pdi_reload_table_users_permission');


function pdi_import_xls()
{
	//$files = (isset($_FILES)) ? $_FILES : null;
	//parse_str($form, $args);
	//$args = (object) $args;

	wp_send_json(
		array(
			'status' => 'success',
			'files' => $files,
		)
	);
}

add_action('wp_ajax_pdi_import_xls', 'pdi_import_xls');
add_action('wp_ajax_nopriv_pdi_import_xls', 'pdi_import_xls');

function pdi_pagination_comments()
{
	$page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_NUMBER_INT);
	$indicador_id = filter_input(INPUT_POST, 'indicador_id', FILTER_SANITIZE_NUMBER_INT);

	$dados = [
		'page' => $page,
		'indicador_id' => $indicador_id
	];

	ob_start();
	pdi_get_template_front('view/comments-preview', $dados);
	print_r(ob_get_clean());
	exit();
}

add_action('wp_ajax_pdi_pagination_comments', 'pdi_pagination_comments');
add_action('wp_ajax_nopriv_pdi_pagination_comments', 'pdi_pagination_comments');


function pdi_pagination_indicadores()
{
	$page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_NUMBER_INT);
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$filters = ['active' => 1];
	if ($args->grande_tema) $filters['grande_tema_id'] = intval($args->grande_tema);
	if ($args->objetivo_ouse) $filters['objetivo_ouse_id'] = intval($args->objetivo_ouse);
	if ($args->ano_referencia) {
		$indicadores_anos = pdi_get_indicadores_anos_all(['ano' => $args->ano_referencia]);
		$filters['id'] = [];
		foreach ($indicadores_anos as $indc_ano) {
			$filters['id'][] = intval($indc_ano->indicador_id);
		}
	}
	if ($args->ods) {
		global $wpdb;
		$query = "SELECT id FROM " . PREFIXO_TABLE . TABLE_INDICADORES
			. " WHERE ods LIKE '%\"{$args->ods}\"%'";
		$select = $wpdb->get_results(
			$wpdb->prepare(
				$query
			)
		);
		foreach ($select as $ods) {
			$filters['id'][] = intval($ods->id);
		}
	}

	if ($filters['id']) $filters['id'] = array_unique($filters['id'], SORT_STRING);

	ob_start();
	$view_pagination = 5;
	$indicadores = pdi_get_indicadores_all($filters, $view_pagination, $page);
	$count_total = pdi_count_indicadores_all($filters);
	$pagnation = ceil(intval($count_total) / $view_pagination);

	$variaveis = [
		'active' => true,
		'indicadores' => $indicadores,
		'filters' => $filters,
		'page' => $page,
		'pagnation' => $pagnation,
	];
	pdi_get_template_front('view/card-metas', $variaveis);
	print_r(ob_get_clean());
	exit();
}

add_action('wp_ajax_pdi_pagination_indicadores', 'pdi_pagination_indicadores');
add_action('wp_ajax_nopriv_pdi_pagination_indicadores', 'pdi_pagination_indicadores');

function pdi_loaad_objetivos_ouse()
{
	$grande_tema_id = filter_input(INPUT_POST, 'grande_tema_id', FILTER_SANITIZE_STRING);

	$filter = [
		'active' => 1,
	];
	if($grande_tema_id) {
		$filter['grande_tema_id'] = intval($grande_tema_id);
	}
	
	$objetivos_ouse = pdi_get_objetivos_ouse_all($filter);

	ob_start();
	?>
	<option value="">Selecione...</option>
	<?php foreach ($objetivos_ouse as $ouse) : ?>
		<option value="<?php echo $ouse->id ?>"><?php echo $ouse->descricao ?></option>
	<?php endforeach; ?>
<?php
	echo ob_get_clean();
	exit();
}

add_action('wp_ajax_pdi_loaad_objetivos_ouse', 'pdi_loaad_objetivos_ouse');
add_action('wp_ajax_nopriv_pdi_loaad_objetivos_ouse', 'pdi_loaad_objetivos_ouse');

function pdi_indicador_edit_active()
{
	$indicador_id = filter_input(INPUT_POST, 'indicador_id', FILTER_SANITIZE_NUMBER_INT);
	$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;


	$active = ($status == 'false') ? 1 : 0;

	$dados = ['active' => $active];
	$format = ['%d'];
	$where = ['id' => intval($indicador_id)];
	$format_where = ['%d'];

	/* pdi_update_metas_email(intval($indicador_id)); */
	$update = pdi_update_indicadores($dados, $where, $format, $format_where);

	$filter = [];
	if ($args->grande_tema) $filter['grande_tema_id'] = intval($args->grande_tema);
	if ($args->objetivo_ouse) $filter['objetivo_ouse_id'] = intval($args->objetivo_ouse);

	$select = pdi_get_indicadores_all($filter);

	if (!$select) $select['error'] = 'Nenhum registro escontrado';

	ob_start();
	pdi_get_template_front('admin/table-metas', $select);
	$html = ob_get_clean();

	wp_send_json(
		array(
			'status' => true,
			'html' => $html,
		)
	);
	exit;
}

add_action('wp_ajax_pdi_indicador_edit_active', 'pdi_indicador_edit_active');
add_action('wp_ajax_nopriv_pdi_indicador_edit_active', 'pdi_indicador_edit_active');

function pdi_remove_indicador()
{
	$indicador_id = filter_input(INPUT_POST, 'indicador_id', FILTER_SANITIZE_NUMBER_INT);
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$delete = pdi_delete_indicadores(['id' => $indicador_id], ['%d']);
	$delete_acoes = pdi_delete_acoes(['indicador_id' => $indicador_id], ['%d']);

	$filter = [];
	if ($args->grande_tema) $filter['grande_tema_id'] = intval($args->grande_tema);
	if ($args->objetivo_ouse) $filter['objetivo_ouse_id'] = intval($args->objetivo_ouse);

	$select = pdi_get_indicadores_all($filter);

	if (!$select) $select['error'] = 'Nenhum registro escontrado';

	ob_start();
	pdi_get_template_front('admin/table-metas', $select);
	$html = ob_get_clean();

	wp_send_json(
		array(
			'status' => true,
			'html' => $html,
		)
	);
	exit;
}

add_action('wp_ajax_pdi_remove_indicador', 'pdi_remove_indicador');
add_action('wp_ajax_nopriv_pdi_remove_indicador', 'pdi_remove_indicador');


function pdi_acao_edit_active()
{
	$acao_id = filter_input(INPUT_POST, 'acao_id', FILTER_SANITIZE_NUMBER_INT);
	$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$active = ($status == 'false') ? 1 : 0;

	$dados_ = ['active' => $active];
	$format = ['%d'];
	$wh = ['id' => intval($acao_id)];
	$format_where = ['%d'];

	$update = pdi_update_acoes($dados_, $wh, $format, $format_where);

	global $wpdb;

	$query = "SELECT " . PREFIXO_TABLE . TABLE_ACOES . ".active, " . PREFIXO_TABLE . TABLE_ACOES . ".descricao_acao, " . PREFIXO_TABLE . TABLE_ACOES . ".id FROM " . PREFIXO_TABLE . TABLE_ACOES
		. " INNER JOIN " . PREFIXO_TABLE . TABLE_INDICADORES
		. " ON " . PREFIXO_TABLE . TABLE_INDICADORES . ".id = " . PREFIXO_TABLE . TABLE_ACOES . ".indicador_id";

	if ($args->eixo_estruturante || $args->grande_tema || $args->objetivo_ouse) {
		$where = " WHERE ";
		if ($args->eixo_estruturante) {
			$where .= PREFIXO_TABLE . TABLE_ACOES . ".eixo_id = " . $args->eixo_estruturante . " AND ";
		}
		if ($args->grande_tema) {
			$where .= PREFIXO_TABLE . TABLE_INDICADORES . ".grande_tema_id = " . $args->grande_tema . " AND ";
		}
		if ($args->objetivo_ouse) {
			$where .= PREFIXO_TABLE . TABLE_INDICADORES . ".objetivo_ouse_id = " . $args->objetivo_ouse . " AND ";
		}
		$where = rtrim($where, ' AND ');

		$query = $query . $where;
	}

	$select = $wpdb->get_results(
		$wpdb->prepare(
			$query
		)
	);

	if (!$select) $select['error'] = 'Nenhum registro escontrado';

	ob_start();
	pdi_get_template_front('admin/table-acoes', $select);
	$html = ob_get_clean();

	wp_send_json(
		array(
			'status' => true,
			'html' => $html,
		)
	);
	exit;
}

add_action('wp_ajax_pdi_acao_edit_active', 'pdi_acao_edit_active');
add_action('wp_ajax_nopriv_pdi_acao_edit_active', 'pdi_acao_edit_active');

function pdi_remove_acao()
{
	$acao_id = filter_input(INPUT_POST, 'acao_id', FILTER_SANITIZE_NUMBER_INT);
	$form = (isset($_POST['form'])) ? $_POST['form'] : null;
	parse_str($form, $args);
	$args = (object) $args;

	$delete = pdi_delete_acoes(['id' => $acao_id], ['%d']);

	global $wpdb;

	$query = "SELECT " . PREFIXO_TABLE . TABLE_ACOES . ".active, " . PREFIXO_TABLE . TABLE_ACOES . ".descricao_acao, " . PREFIXO_TABLE . TABLE_ACOES . ".id FROM " . PREFIXO_TABLE . TABLE_ACOES
		. " INNER JOIN " . PREFIXO_TABLE . TABLE_INDICADORES
		. " ON " . PREFIXO_TABLE . TABLE_INDICADORES . ".id = " . PREFIXO_TABLE . TABLE_ACOES . ".indicador_id";

	if ($args->eixo_estruturante || $args->grande_tema || $args->objetivo_ouse) {
		$where = " WHERE ";
		if ($args->eixo_estruturante) {
			$where .= PREFIXO_TABLE . TABLE_ACOES . ".eixo_id = " . $args->eixo_estruturante . " AND ";
		}
		if ($args->grande_tema) {
			$where .= PREFIXO_TABLE . TABLE_INDICADORES . ".grande_tema_id = " . $args->grande_tema . " AND ";
		}
		if ($args->objetivo_ouse) {
			$where .= PREFIXO_TABLE . TABLE_INDICADORES . ".objetivo_ouse_id = " . $args->objetivo_ouse . " AND ";
		}
		$where = rtrim($where, ' AND ');

		$query = $query . $where;
	}

	$select = $wpdb->get_results(
		$wpdb->prepare(
			$query
		)
	);

	if (!$select) $select['error'] = 'Nenhum registro escontrado';

	ob_start();
	pdi_get_template_front('admin/table-acoes', $select);
	$html = ob_get_clean();

	wp_send_json(
		array(
			'status' => true,
			'html' => $html,
		)
	);
	exit;
}

add_action('wp_ajax_pdi_remove_acao', 'pdi_remove_acao');
add_action('wp_ajax_nopriv_pdi_remove_acao', 'pdi_remove_acao');

function pdi_export_metas()
{
	if (!class_exists('XLSXWriter')) {
		include_once('inc/xlsxwriter.class.php');
	}

	// # set the destination file
	$fileLocation = 'Metas_' . date('dmYHis') . '.xlsx';
	$results = pdi_get_indicadores_all();
	// # prepare the data set
	$header = [
		'DESC_TEMA' => 'string',
		'DESC_OUSE' => 'string',
		'COD_META' => 'integer',
		'TITULO_INDICADOR' => 'string',
		'DESC_META' => 'string',
		'ODS' => 'string',
		'PNE' => 'string',
		'META_INDICADOR' => 'string',
		'META_INICIAL' => 'string',
		'DATA REGISTRO' => 'string',
		'ANO_INDICADOR' => 'string',
		'META_ANUAL_INDICADOR' => 'string',
		'VALOR_INDICADOR' => 'string',
		'DATA_RESGISTO_ANO' => 'string',
		'JUSTIVICATIVA_INDICADOR' => 'string',
	];
	$data = [];
	$i = 0;
	foreach ($results as $meta) {
		$meta->grandeTema = pdi_get_grande_tema(['id' => intval($meta->grande_tema_id)]);
		$meta->ouse = pdi_get_objetivos_ouse(['id' => intval($meta->objetivo_ouse_id)]);
		$meta->indicadoresAnos = pdi_get_indicadores_anos_all(['indicador_id' => $meta->id]);
		$ods = json_decode($meta->ods);
		$ods__ = '';
		foreach ($ods as $ods_) {
			$o = pdi_get_ods(['id' => $ods_]);
			$ods__ .= $o[0]->titulo . ';';
		}
		$ods__ = rtrim($ods__, ';');
		$pne = json_decode($meta->pne);
		$pne__ = '';
		foreach ($pne as $pne_) {
			$p = pdi_get_pne(['id' => $pne_]);
			$pne__ .= $p[0]->titulo . ';';
		}
		$pne__ = rtrim($pne__, ';');
		$anoIndicador = '';
		$metaAnualIndicador = '';
		$valorIndicador = '';
		$dataRegistroAno = '';
		$justificativaIndicador = '';
		foreach ($meta->indicadoresAnos as $indicador_anos) {
			$anoIndicador .= $indicador_anos->ano . ';';
			$metaAnualIndicador .= format_real($indicador_anos->valor_previsto) . ';';
			$valorIndicador .= format_real($indicador_anos->valor) . ';';
			$dataRegistroAno .= convert_data_front($indicador_anos->data_registro) . ';';
			$justificativaIndicador .= $indicador_anos->justificativa . ';';
		}
		$anoIndicador = rtrim($anoIndicador, ';');
		$metaAnualIndicador = rtrim($metaAnualIndicador, ';');
		$valorIndicador = rtrim($valorIndicador, ';');
		$dataRegistroAno = rtrim($dataRegistroAno, ';');
		$justificativaIndicador = rtrim($justificativaIndicador, ';');

		$dados = [
			$meta->grandeTema[0]->descricao,
			$meta->ouse[0]->descricao,
			$meta->id,
			$meta->titulo,
			$meta->descricao,
			$ods__,
			$pne__,
			format_real($meta->valor_meta),
			format_real($meta->valor_inicial),
			convert_data_front($meta->data_registro),
			$anoIndicador,
			$metaAnualIndicador,
			$valorIndicador,
			$dataRegistroAno,
			$justificativaIndicador,
		];

		$data[$i] = $dados;
		$i++;
	}

	// # call the class and generate the excel file from the $data
	$writer = new XLSXWriter();
	$writer->writeSheetHeader('Metas', $header);
	foreach ($data as $row)
		$writer->writeSheetRow('Metas', $row);
	$writer->writeToFile($fileLocation);

	// # prompt download popup
	header('Content-Description: File Transfer');
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=" . basename($fileLocation));
	header("Content-Transfer-Encoding: binary");
	header("Expires: 0");
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header('Content-Length: ' . filesize($fileLocation));

	ob_clean();
	flush();

	readfile($fileLocation);
	unlink($fileLocation);
	exit;
}
add_action('wp_ajax_pdi_export_metas', 'pdi_export_metas');
add_action('wp_ajax_nopriv_pdi_export_metas', 'pdi_export_metas');

function pdi_export_acoes()
{
	if (!class_exists('XLSXWriter')) {
		include_once('inc/xlsxwriter.class.php');
	}

	// # set the destination file
	$fileLocation = 'Ações_' . date('dmYHis') . '.xlsx';
	$results = pdi_get_acoes_all();
	// # prepare the data set
	$header = array(
		'COD_META' => 'integer',
		'EIXO_ESTRUTURANTE' => 'integer',
		'DESC_OBJETIVO_ESPECIFICO' => 'string',
		'ATOR_ENVOLVIDO' => 'string',
		'DESC_ACAO' => 'string',
		'ANO_ACAO' => 'integer',
		'PERCENTUAL_CUMPRIDO' => 'string',
		'DATA_REGISTRO' => 'string',
		'JUSTIFICATIVA_PLANO' => 'string',
	);
	$data = [];
	$i = 0;
	foreach ($results as $acoes) {
		$acoes->atores = pdi_get_atores(['id' => intval($acoes->ator)]);
		$objEspecificos = json_decode($acoes->objetivo_especifico);
		$obj = '';
		foreach ($objEspecificos as $objetivo_especifico) {
			$objs = pdi_get_objetivo_especifico(['id' => $objetivo_especifico]);
			$obj .= $objs[0]->descricao . ';';
		}
		$obj = rtrim($obj, ';');

		$dados = [
			$acoes->indicador_id,
			$acoes->eixo_id,
			$obj,
			$acoes->atores[0]->descricao,
			$acoes->descricao_acao,
			$acoes->ano_acao,
			format_real($acoes->percentual_cumprido),
			convert_data_front($acoes->data_registro),
			$acoes->justificativa
		];

		$data[$i] = $dados;
		$i++;
	}

	// # call the class and generate the excel file from the $data
	$writer = new XLSXWriter();
	$writer->writeSheetHeader('Ações', $header);
	foreach ($data as $row)
		$writer->writeSheetRow('Ações', $row);
	//$writer->writeSheet($data);
	$writer->writeToFile($fileLocation);

	// # prompt download popup
	header('Content-Description: File Transfer');
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=" . basename($fileLocation));
	header("Content-Transfer-Encoding: binary");
	header("Expires: 0");
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header('Content-Length: ' . filesize($fileLocation));

	ob_clean();
	flush();

	readfile($fileLocation);
	unlink($fileLocation);
	exit;
}
add_action('wp_ajax_pdi_export_acoes', 'pdi_export_acoes');
add_action('wp_ajax_nopriv_pdi_export_acoes', 'pdi_export_acoes');
