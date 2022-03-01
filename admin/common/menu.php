	<section class="sidebar">
		<ul class="sidebar-menu">
			<li class="header">MENU PRINCIPAL</li>
			<?php
			$menu_categorias = db::get_all('_menu_categoria');
			$menu_itens = db::get_all('_menu', 'id');
			
			foreach ($menu_itens as $item) {
				if ($item['page'] == $_GET['page']) { 
					$categoria_ativa = $item['id_menu_categoria'];
				}
				
				if ($item['id_menu_categoria'] == '0') {
				?>
					<li class="<?=($item['page'] == $_GET['page'])?'active':''?>">
						<a href="?page=<?=$item['page']?>&action=show">
							<i class="fa fa-<?=$item['icon']?>"></i><span> <?=$item['name']?></span>
						</a>
					</li>
				<?php
				} else {
					$categorias_itens[$item['id_menu_categoria']][] = $item;
				}
			}

			foreach ($menu_categorias as $categoria) {
				if ($categoria['id'] == 0) continue;
			?>
				<li class="treeview <?=($categoria['id'] == $categoria_ativa)?'active':''?>">
					<a href="#">
						<i class="fa fa-<?=$categoria['icon']?>"></i>
						<span><?=$categoria['name']?></span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					
					<ul class="treeview-menu">
						<?php
						if (isset($categorias_itens[$categoria['id']])) {
							foreach ($categorias_itens[$categoria['id']] as $item) {	
							?>
								<li class="<?=($item['page'] == $_GET['page'])?'active':''?>">
									<a href="?page=<?=$item['page']?>&action=show"><i class="fa fa-<?=$item['icon']?>"></i> <?=$item['name']?></a>
								</li>
							<?php
							}
						}
						?>
					</ul>
				</li>
			<?php 
			}
			?>
		</ul>
	</section>