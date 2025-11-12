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

include __DIR__ . "/header.php";

if ($lg) :

	if ($id && db_rows("users WHERE id = '{$id}'") && us_level == 6) {
		$sql = $db->query("SELECT * FROM " . prefix . "users WHERE id = '{$id}'");
		$rs = $sql->fetch_assoc();

		$u_username = $rs['username'];
		$u_email = $rs['email'];
		$u_photo = $rs['photo'];
		$u_plan  = $rs['plan'];
		$u_level = $rs['level'];
		$u_expired_date    = $rs['expired_date'];
		$tttt    = $rs['username'];
	} else {
		$u_username = us_name;
		$u_email    = us_email;
		$u_photo    = us_photo;
		$u_plan     = us_plan;
		$u_level    = us_level;
		$u_expired_date    = us_expired_date;
		$tttt       = '';
	}
?>
	<div class="pt-box">
		<h3>
			<?= ($id ? $tttt : $lang['detailspage']['title']) ?>
			<span class="badge <?= ($u_plan == '1' ? 'bg-gy' : ($u_plan == '2' ? 'bg-gr' : ($u_plan == '3' ? 'bg-v' : 'bg-o'))) ?>">
				<i class="fas fa-trophy"></i> <?= ($u_plan ? db_get("plans", "plan", $u_plan) : '--') ?>
			</span>
			<?php if ($u_expired_date) : ?>
				<div class="alert alert-warning mt-3 mb-0" role="alert">Your plan will expire at: <b><?= date("d/m/Y", $u_expired_date) ?></b></div>
			<?php endif; ?>

		</h3>

		<form class="pt-form" id="user-send-details">
			<div class="file-upload">
				<div class="file-select">
					<div class="file-select-button" id="fileName"><?= $lang['detailspage']['image_c'] ?></div>
					<div class="file-select-name" id="noFile"><?= $lang['detailspage']['image_n'] ?></div>
					<input type="file" name="chooseFile" id="chooseFile">
				</div>
			</div>
			<div id="thumbnails"><img src="<?= ($u_photo ? $u_photo : nophoto) ?>" onerror="this.src='<?= nophoto ?>'" class="nophoto" /></div>
			<label><?= $lang['detailspage']['username'] ?></label>
			<div class="pt-input">
				<i class="far fa-user"></i>
				<input type="text" name="name" value="<?= $u_username ?>" placeholder="<?= $lang['detailspage']['username_l'] ?>">
			</div>
			<label><?= $lang['indexpage']['form_npass_l'] ?></label>
			<div class="pt-input">
				<i class="fas fa-key"></i>
				<input type="password" name="pass" placeholder="<?= $lang['indexpage']['form_npass_i'] ?>">
			</div>
			<label><?= $lang['indexpage']['form_email_l'] ?></label>
			<div class="pt-input">
				<i class="far fa-envelope"></i>
				<input type="text" name="email" value="<?= $u_email ?>" placeholder="<?= $lang['indexpage']['form_email_i'] ?>">
			</div>
			<?php if (us_level == 6) : ?>
				<div class="form-inline">
					<label class="mr-4"><b><?= $lang['header']['plans'] ?></b></label>
					<?php
					$sql = $db->query("SELECT * FROM " . prefix . "plans");
					while ($v = $sql->fetch_assoc()) :
					?>
						<div class="form-group">
							<input class="choice" id="cb<?= $v['id'] ?>" value="<?= $v['id'] ?>" name="plan" type="radio" <?= ($u_plan == $v['id'] ? ' checked' : '') ?> />
							<label class="tgl-btn" for="cb<?= $v['id'] ?>"><?= $v['plan'] ?></label>
						</div>
					<?php
					endwhile;
					$sql->close();
					?>
				</div>
				<div class="form-inline">
					<label class="mr-4"><b>Admin</b></label>
					<div class="form-group">
						<input class="choice" id="cba6" value="6" name="level" type="radio" <?= ($u_level == 6 ? ' checked' : '') ?> />
						<label class="tgl-btn" for="cba6">Admin</label>
					</div>
					<div class="form-group">
						<input class="choice" id="cba1" value="1" name="level" type="radio" <?= ($u_level == 1 ? ' checked' : '') ?> />
						<label class="tgl-btn" for="cba1">User</label>
					</div>
				</div>
			<?php endif; ?>

			<hr />
			<input type="hidden" name="reg_id" value="<?= ($id ? $id : '') ?>" />
			<input type="hidden" name="reg_photo" value="<?= $u_photo ?>" />
			<button type="submit" class="pt-button bg-0"><i class="fas fa-sign-in-alt"></i> <?= $lang['detailspage']['send'] ?></button>
		</form>
	</div>
<?php
else :
?>
	<div class="pt-no-result"><i class="far fa-surprise"></i> <?= $lang['listpage']['no-result'] ?></div>
<?php
endif;
include __DIR__ . "/footer.php";
?>