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

if (site_plans) {
	echo fh_alerts($lang['alerts']['permission']);
	exit;
}
?>
<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?= $lang['plans']['title'] ?></h3>
		<p><?= str_replace('[br]', '<br />', $lang['plans']['desc']) ?></p>
	</div>
</div>

<div class="container">

	<div class="pt-plans">
		<div class="form-group pt-plantype d-flex justify-content-center">
			<label>Monthly</label>
			<div class="mr-3 ml-3">
				<input class="tgl tgl-light" id="cb5" value="0" name="plantype" type="checkbox" />
				<label class="tgl-btn" for="cb5"></label>
			</div>
			<label>Yearly</label>
		</div>
		<div class="row">
			<?php
			$sql = $db->query("SELECT * FROM " . prefix . "plans");
			while ($value = $sql->fetch_assoc()) :
			?>
				<div class="col">
					<div class="pt-plan pt-plan<?= $value['id'] ?>">
						<h5><?= $value['plan'] ?></h5>
						<h6><span><?= $value['currency'] ?></span><b class="pt-price"><?= $value['price_m'] ?></b></h6>
						<p class="pt-per"><?= $lang['plans']['month'] ?></p>
						<form class="sendpaypalplan">
							<input type="hidden" name="item_name" value="<?= $value['plan'] ?>">
							<input type="hidden" name="item_number" value="Plan#<?= $value['id'] ?>">
							<input type="hidden" name="item_monthly" value="1">
							<?php if (!us_level) : ?>
								<button type="button" name="button" data-toggle="modal" href="#registerModal"><?= $lang['plans']['btn'] ?> <i class="fas fa-arrow-alt-circle-right"></i></button>
							<?php else : ?>
								<?php if ($value['price_m'] == 0) : ?>
									<button type="submit" name="button" disabled class="pt-disabled"><?= $lang['plans']['btn'] ?> <i class="fas fa-arrow-alt-circle-right"></i></button>
								<?php else : ?>
									<button type="submit" name="button"><?= $lang['plans']['btn'] ?> <i class="fas fa-arrow-alt-circle-right"></i></button>
								<?php endif; ?>

							<?php endif; ?>
						</form>
						<ul>
							<?php
							$value['specifics'] = [
								[str_replace('[n]', "<b class='pt-families'>{$value['families_m']}</b>", $value['desc1']), 'green', '1'],
								[str_replace('[n]', "<b class='pt-members'>{$value['members_m']}</b>", $value['desc2']), '', '1'],
								[str_replace('[n]', "<b class='pt-privates'>{$value['privates_m']}</b>", $value['desc3']), '', '1'],
								[$value['desc4'], '', $value['heritate']],
								[$value['desc5'], '', $value['albums']],
								[$value['desc6'], '', $value['pdf']],
								[$value['desc7'], '', $value['show_ads']],
								[$value['desc8'], '', $value['support']]
							];
							foreach ($value['specifics'] as $v) :
							?>
								<li<?= ($v[1] == 'green' ? ' class="alert-success"' : '') ?>>
									<span><i class="fas fa-<?= ($v[2] == '1' ? 'check' : 'times') ?>"></i></span> <?= $v[0] ?>
									</li>
								<?php
							endforeach;
								?>
						</ul>
					</div>
				</div>
			<?php
			endwhile;
			?>
		</div>
	</div>


</div>
<?php
include __DIR__ . "/footer.php";
