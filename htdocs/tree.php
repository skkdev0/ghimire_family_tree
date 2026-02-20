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

include __DIR__.'/header.php';

$rt = true;
if(!$lg && !$vp){
	$rt = false;
}
elseif($lg && ($lg != db_get("families", "author", $id) && !in_array(us_name, explode(',', db_get("families", "moderators", $id))) ) ){
	$rt = false;
}
elseif($vp && ($vp != $id)){
	$rt = false;
}

?>

<?php
$sql = $db->query("SELECT * FROM ".prefix."families WHERE id = '{$id}'");

if($sql->num_rows):
	$rs = $sql->fetch_assoc();

	$share_url  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI'];

	if(!$rt && $rs['public']){
		include __DIR__.'/partials/tree_password.php';
		include __DIR__."/footer.php";
		exit;
	}


	if($lg == $rs['author'] || (us_id && in_array(us_name, explode(',', $rs['moderators']))) || (us_id && db_rows("members WHERE user = '".us_name."' && family = '{$id}'")) || us_level == 6 ){
		include __DIR__.'/partials/tree_new_member.php';
		include __DIR__.'/partials/tree_heritate.php';
	}
	?>

<div class="pt-tree">
	<div class="pt-details">
		<?php if($lg == $rs['author'] || (us_id && in_array(us_name, explode(',', $rs['moderators'])))): ?>
			<?php if((us_level && $rs['author'] == $lg) || us_level == 6): ?>
			<a class="pt-edit" rel="<?=$rs['id']?>"><i class="fas fa-pencil-alt"></i> <span><?=$lang['treepage']['edit']?></span></a>
			<?php if ( fh_access('pdf') ): ?>
			<a href="#" data-name="<?=$rs['slug']?>" class="pdf-download"><i class="fas fa-link"></i> <?=$lang['treepage']['pdf']?></a>
			<?php endif; ?>
			<?php endif; ?>
		<?php if(!db_count("members WHERE family = '{$id}' && parent = 0")): ?>
		<a title="New" class="n tree-add" id="nid<?=$id?>" rel="<?=$id?>" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i> <?=$lang['treepage']['new']?></a>
		<?php endif; ?>
		<?php endif; ?>
		<div class="pl-share">
      <span class="pl-share-button"><i class="fa fa-share"></i> <b><?=$lang['treepage']['share']?></b></span>
      <ul class="dropdown">
				<li>
					<a class="bg-facebook" href="//www.facebook.com/sharer/sharer.php?u=<?=$share_url?>" target="_blank">
						<i class="fab fa-facebook-f"></i> <?=$lang['treepage']['share_f']?>
					</a>
				</li>
				<li>
					<a class="bg-twitter" href="//twitter.com/home?status=<?=$share_url?> <?=$rs['name']?>" target="_blank">
						<i class="fab fa-twitter"></i> <?=$lang['treepage']['share_t']?>
					</a>
				</li>
				<li>
					<a class="bg-whatsapp" href="whatsapp://send?text=<?=$share_url?>" target="_blank">
						<i class="fab fa-whatsapp"></i> <?=$lang['treepage']['share_w']?>
					</a>
				</li>
				<li>
					<a class="bg-youtube"href="mailto:?Subject=<?=$rs['name']?>&amp;Body=<?=$rs['name']?> <?=$share_url?>">
						<i class="fas fa-envelope-open-text"></i> <?=$lang['treepage']['share_e']?>
					</a>
				</li>
			</ul>
  	</div>
	</div>
	<h3><span><i class="fas fa-grin-stars"></i></span> <?=$rs['name']?><?=$lang['treepage']['fam']?></h3>
	<div class="pt-sm">
		<div class="tree" id="div">
			<?php if(db_count("members WHERE family = '{$rs['id']}'")): ?>
			<ul>
				<?php
					$sql_m = $db->query("SELECT * FROM ".prefix."members WHERE family = '{$rs['id']}' && parent = 0");
					while($rs_m = $sql_m->fetch_assoc()){
						echo get_child($rs_m['id']);
					}
					$sql_m->close();
				 ?>
			</ul>
			<?php else: ?>
			<div class="pt-no-result"><i class="far fa-surprise"></i> <?=$lang['no-result']?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php else: ?>
<div class="pt-no-result m-4"><i class="far fa-surprise"></i> <?=$lang['no-result']?></div>
<meta http-equiv="refresh" content="2;url=<?=path?>">
<?php
endif;
$sql->close();
?>


<!-- Modal View Member  -->
<div class="modal fade" id="myTree" tabindex="-1" role="dialog" aria-labelledby="myTreeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body"></div>
    </div>
  </div>
</div>


<?php include __DIR__.'/footer.php'; ?>
