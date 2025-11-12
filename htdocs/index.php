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

<div class="row">
	<div class="col-md-6">
		<div class="pt-index-left">
			<h4><?=$lang['indexpage']['h4']?></h4>
			<h2><?=$lang['indexpage']['h2']?></h2>
			<p><?=$lang['indexpage']['p']?></p>
			<div class="pt-thumb">
				<img src="<?=path?>/assets/images/family.png" / />
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="pt-index-right">
			<?php if($lg): ?>
				<h3>
					<b><?=$lang['indexpage']['my']?></b>
					<span><?=$lang['indexpage']['list']?></span>
				</h3>
				<div class="pt-form-content">
					<div class="pt-form pt-flist">
						<?php
						$sql = $db->query("SELECT * FROM ".prefix."families WHERE author = '{$lg}' || FIND_IN_SET('".us_name."', moderators) > 0 LIMIT 4") or die($db->error);
						if($sql->num_rows):

						while($rs = $sql->fetch_assoc()):
							$rs['photo'] = $rs['photo'] ? $rs['photo'] : db_get("members", "photo", $rs['id'], 'family', "AND parent = '0'");
						?>
						<div class="pt-list-item">
							<div class="media">
								<div class="media-left">
									<div class="pt-thumb"><img src="<?=$rs['photo']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=nophoto?>'"></div>
								</div>
								<div class="media-body">
									<h3><a href="<?=path?>/tree.php?id=<?=$rs['id']?>&t=<?=($rs['slug']??'id')?>"><?=$rs['name']?></a></h3>
									<p>
										<i class="fas fa-clock"></i> <span><?=fh_ago($rs['date'])?> </span>
										<i class="fas fa-users"></i> <span><b><?=db_count("members WHERE family = '{$rs['id']}'")?></b> <?=$lang['listpage']['members']?></span>
									</p>
								</div>
							</div>
						</div>
						<?php
						endwhile;
						$sql->close();
						echo '<a href="'.path.'/list.php?pg=my" class="more"><i class="fas fa-arrow-alt-circle-left"></i> '.$lang['indexpage']['more'].'</a>';
						else:
						?>
						<div class="pt-no-result"><i class="far fa-surprise"></i> <?=$lang['listpage']['no-result']?></div>
						<?php
						endif;
						?>
					</div>
				</div>
			<?php else: ?>
			<h3>
				<b><?=$lang['indexpage']['form_b']?></b>
				<span><?=$lang['indexpage']['form_s']?></span>
				<div>
					<a href="#" class="active login-link"><?=$lang['indexpage']['form_login']?></a>
					<?php if(!site_register_status): ?>
						<a href="#" class="register-link"><?=$lang['indexpage']['form_register']?></a>
					<?php endif; ?>
				</div>
			</h3>

			<div class="pt-form-content">

				<form class="pt-form" id="send-login">
					<label><?=$lang['indexpage']['form_fid_l']?></label>
					<div class="pt-input">
						<i class="far fa-user"></i>
						<input type="text" name="name" placeholder="<?=$lang['indexpage']['form_fid_i']?>">
					</div>
					<label><?=$lang['indexpage']['form_pass_l']?></label>
					<div class="pt-input">
						<i class="fas fa-key"></i>
						<input type="password" name="pass" placeholder="<?=$lang['indexpage']['form_pass_i']?>">
					</div>
					<div class="reset">
						<?=$lang['indexpage']['forget']?> <a href="#" data-toggle="modal" data-target="#resetM"><?=$lang['indexpage']['reset']?></a>
					</div>
					<hr />
					<button type="submit" class="pt-button bg-0"><i class="fas fa-login-alt"></i> <?=$lang['indexpage']['form_in']?></button>
				</form>
				<?php include __DIR__."/partials/login_password_reset.php"; ?>
				<?php if(!site_register_status): ?>
				<form class="pt-form" id="send-user">
					<label><?=$lang['indexpage']['form_fid_l']?></label>
					<div class="pt-input">
						<i class="far fa-user"></i>
						<input type="text" name="name" placeholder="<?=$lang['indexpage']['form_fid_i']?>">
					</div>
					<label><?=$lang['indexpage']['form_pass_l']?></label>
					<div class="pt-input">
						<i class="fas fa-key"></i>
						<input type="password" name="pass" placeholder="<?=$lang['indexpage']['form_pass_i']?>">
					</div>
					<label><?=$lang['indexpage']['form_email_l']?></label>
					<div class="pt-input">
						<i class="far fa-envelope"></i>
						<input type="text" name="email" placeholder="<?=$lang['indexpage']['form_email_i']?>">
					</div>
					<div class="reset"><small>
						<?=str_replace("{a}", '<a href="'.path.'/page.php?id=3">'.$lang['indexpage']['pravicy'].'</a>', $lang['indexpage']['byclick'])?>
					</small></div>
					<hr />
					<button type="submit" class="pt-button bg-0"><i class="fas fa-sign-in-alt"></i> <?=$lang['indexpage']['form_up']?></button>
				</form>
				<?php endif; ?>
			</div>

		<?php endif; ?>

		</div>
	</div>
</div>

<?php
include __DIR__."/footer.php";
?>
