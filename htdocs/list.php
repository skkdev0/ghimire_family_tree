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
?>

<div class="pt-list">
	<div class="pt-title">
		<span><i class="fas fa-list"></i></span> <b><?=$lang['listpage']['title']?></b>
		<div class="pt-options">
			<a href="<?=path?>/list.php?pg=my"><i class="fas fa-list"></i> <?=$lang['listpage']['my']?></a>
		</div>
	</div>
<?php
$trees = ($pg && us_name? "&& (author = '{$lg}' || FIND_IN_SET('".us_name."', moderators) > 0)" : '');
$trees = ($pg && !us_name? "&& author = 0" : $trees);
$sql = $db->query("SELECT * FROM ".prefix."families WHERE public = 0 {$trees} LIMIT {$startpoint} , {$limit}") or die($db->error);
if($sql->num_rows):

while($rs = $sql->fetch_assoc()):
	$rs['photo'] = $rs['photo'] ? $rs['photo'] : db_get("members", "photo", $rs['id'], 'family', "AND parent = '0'");
?>
<div class="pt-list-item">
	<div class="media">
		<div class="media-left">
			<div class="pt-thumb"><img src="<?=path."/".$rs['photo']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=nophoto?>'"></div>
		</div>
		<div class="media-body">
			<h3><a href="<?=path?>/tree.php?id=<?=$rs['id']?>&t=<?=($rs['slug']??'id')?>"><?=$rs['name']?></a></h3>
			<p><?=fh_ago($rs['date'])?></p>
			<div class="pt-options">
				<?php if((us_level && $rs['author'] == $lg) || us_level == 6): ?>
				<a class="pt-edit" rel="<?=$rs['id']?>"><i class="fas fa-edit"></i> <span><?=$lang['listpage']['edit']?></span></a>
				<?php endif; ?>
				<a class="pt-members"><i class="fas fa-users"></i> <span><b><?=db_count("members WHERE family = '{$rs['id']}'")?></b> <?=$lang['listpage']['members']?></span></a>
			</div>
		</div>
	</div>
</div>
<?php
endwhile;
$sql->close();
echo fh_pagination("families WHERE public = 0 {$trees}",$limit, path."/list.php?".($pg=='my'?'pg=my&':''));
else:
?>
<div class="pt-no-result"><i class="far fa-surprise"></i> <?=$lang['listpage']['no-result']?></div>
<?php
endif;
?>
</div>
<?php
include __DIR__."/footer.php";
?>
