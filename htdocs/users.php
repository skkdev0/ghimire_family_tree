<?php
# -------------------------------------------------#
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
#	¤                                            ¤   #
#	¤           Ghimire Family Tree 1.5           ¤   #
#	¤--------------------------------------------¤   #
#	¤              By ShyamKumarKshetri              ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Facebook : fb.com/prof.ShyamKumarKshetri       ¤   #
#	¤  Instagram : instagram.com/ShyamKumarKshetri    ¤   #
#	¤  Site : http://www.ShyamKumarKshetri.com        ¤   #
#	¤  Email: el.bouirtou@gmail.com              ¤   #
#	¤                                            ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Last Update: 13/01/2023                   ¤   #
#	¤                                            ¤   #
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
# -------------------------------------------------#

include __DIR__."/header.php";
if(us_level != 6){
	fh_go(path);
	include __DIR__."/footer.php";
	exit;
}

?>

<div class="pt-list">
	<div class="pt-title">
		<span><i class="fas fa-users"></i></span> <b><?=$lang['header']['users']?></b>
	</div>
	<div class="pt-u">
	<?php
	$sql = $db->query("SELECT * FROM ".prefix."users WHERE status = 0 ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
	if($sql->num_rows):
	while($rs = $sql->fetch_assoc()):
		$rs['photo'] = $rs['photo'] ? $rs['photo'] : nophoto;
		?>
		<div class="pt-list-item">
			<div class="media">
				<div class="media-left">
					<div class="pt-thumb"><img src="<?=$rs['photo']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=nophoto?>'"></div>
				</div>
				<div class="media-body">
					<h3><a href="#"><?=$rs['username']?></a></h3>
					<p>
						<i class="far fa-clock"></i>
						<span><?=fh_ago($rs['date'])?></span>
						<i class="far fa-user"></i>
						<span><?=db_rows("families WHERE author = '{$rs['id']}'")?> <?=$lang['dashboard']['families']?></span>
					</p>
				</div>
			</div>
		</div>
		<?php
	endwhile;
	$sql->close();
	?>
	</div>
	<?php
	echo fh_pagination("users",$limit, path."/users.php?");
	else:
	?>
	<div class="pt-no-result"><i class="far fa-surprise"></i> <?=$lang['listpage']['no-result']?></div>
	<?php
	endif;
	?>
</div>
<?php
include __DIR__."/footer.php";
