<?php
$metadata = db::get_meta($_GET['page']);
if (empty($metadata)) {
	die();
}
$entries = db::get_all($_GET['page']);

?>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-list-ul"></i> Listando registros em: <?=$breadcrumb['name']?></h3>
			</div>

			<div class="box-body">
				<table class="table table-bordered table-hover" id="table-<?=$_GET['page']?>">
					<thead>
						<tr>
							<?php 
							$novo = true;
							foreach ($metadata as $key=>$meta) {
								if ($meta['COLUMN_NAME'] == 'id') {
									if (isset($meta['COLUMN_COMMENT']['single'])) {
										$novo = false;
										unset($metadata[$key]);
										continue;
									} else {
										$column_name = "#";
									}
								} else {
									$column_name = ucfirst($meta['COLUMN_NAME']);
								}
								
								if (isset($meta['COLUMN_COMMENT']['name'])) $column_name = $meta['COLUMN_COMMENT']['name']['value'];
								
								if (isset($meta['COLUMN_COMMENT']['fk'])) {
									foreach ($entries as $key=>$entry) {
										$fk = $meta['COLUMN_COMMENT']['fk'];
										
										$data = db::get_by_id($fk['table'], $entry[$meta['COLUMN_NAME']]);
										$ref = $data[$fk['ref']];
										
										$entries[$key][$meta['COLUMN_NAME']] = $ref;
									}
								}
								
								if ($meta['DATA_TYPE'] == 'tinyint') {
									foreach ($entries as $key=>$entry) {
										if ($entry[$meta['COLUMN_NAME']]) {
											$entries[$key][$meta['COLUMN_NAME']] = '<b hidden>1</b><i class="fa fa-fw fa-check-square-o"></i>';
										} else {
											$entries[$key][$meta['COLUMN_NAME']] = '<b hidden>0</b><i class="fa fa-fw fa-square-o"></i>';
										}
									}
								}
								
								if ($meta['DATA_TYPE'] == 'text') {
									if (isset($meta['COLUMN_COMMENT']['photo'])) {
										foreach ($entries as $key=>$entry) {
											$pics = json_decode($entry[$meta['COLUMN_NAME']]);
											
											$fieldvalue = "";
											foreach ($pics as $pic) {
												if (@is_array(getimagesize("../upload/$pic"))) {
													$fieldvalue .= '<img style="border:1px solid #eee;max-width:50px;max-height:50px" src="../upload/'.$pic.'" />';
												} else {
													$filename = explode('/', $pic);
													$filename = end($filename);
													$fieldvalue .= " <i class='fa fa-fw fa-file-archive-o'></i><label class='file-name-label'>$filename</label><br>";
												}
											}
											
											$fieldvalue = rtrim($fieldvalue, "<br>");
											$entries[$key][$meta['COLUMN_NAME']] = $fieldvalue;
										}
									} else {
										foreach ($entries as $key=>$entry) {
											$entries[$key][$meta['COLUMN_NAME']] = substr(strip_tags($entry[$meta['COLUMN_NAME']]), 0, 200);
										}
									}
								}
							?>
								<th><?=$column_name?></th>
							<?php
							}
							?>
							<th width="80">
								<?php if ($novo) { ?>
								<a title="Novo" class="pull-right btn btn-sm btn-default" href="?page=<?=$_GET['page']?>&action=new"><i class="fa fa-plus"></i> Novo</a></th>
								<?php } ?>
							</tr>
					</thead>

					<tbody>
						<?php foreach ($entries as $entry) { ?>
						<tr>
							<?php foreach ($metadata as $meta) { ?>
								<td><?=$entry[$meta['COLUMN_NAME']]?></td>
							<?php } ?>
							<td>
								<?php if ($novo) { ?>
								<a title="Remover" class="pull-right btn-ss btn-danger confirm" href="?page=<?=$_GET['page']?>&action=remove&id=<?=$entry['id']?>">
									<i class="fa fa-fw fa-remove"></i>
								</a>
								<?php } ?>
								<a title="Editar" class="pull-right btn-ss btn-info" href="?page=<?=$_GET['page']?>&action=edit&id=<?=$entry['id']?>">
									<i class="fa fa-fw fa-edit"></i>
								</a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>