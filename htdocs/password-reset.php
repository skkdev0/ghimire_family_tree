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


# Header Page
include __DIR__.'/header.php';

if(db_get('reset_passwords', 'date', $token, 'token') < (time()-3600*24) || db_get('reset_passwords', 'status', $token, 'token') != 0){
	echo fh_alerts('This token is expired!');
	$sidebar = false;
	include __DIR__.'/footer.php';
	exit;
}

# Main Page
if(!us_level):
?>
<div class="pt-box">
	<h3><i class="fas fa-lock"></i> <?=$lang['resetpage']['title']?></h3>

	<form class="pt-form" id="password-reset">
		<div class="row">
			<div class="col-6">
				<label>
					<?=$lang['resetpage']['npass']?> <b class="red">*</b>
					<input type="password" name="reg_pass" placeholder="<?=$lang['resetpage']['npass_l']?>">
				</label>
			</div>
			<div class="col-6">
				<label>
					<?=$lang['resetpage']['rpass']?> <b class="red">*</b>
					<input type="password" name="reg_repass" placeholder="<?=$lang['resetpage']['rpass_l']?>">
				</label>
			</div>
		</div>
		<hr/>
		<input type="hidden" name="token" value="<?=$token?>">
		<input type="hidden" name="t" value="<?=$t?>">
		<button type="submit" class="btn"><?=$lang['submit']?> <i class="fas fa-arrow-circle-right"></i></button>
	</form>

</div>

<?php
else:
	echo fh_alerts($lang['alerts']['permission']);
	$sidebar = false;
endif;
# Footer Page
include __DIR__.'/footer.php';
