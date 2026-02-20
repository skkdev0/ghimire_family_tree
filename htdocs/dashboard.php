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

include __DIR__ . '/configs/config.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang['lang'] ?>">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= site_title ?></title>

	<!-- Google Fonts -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,900%7CGentium+Basic:400italic&subset=latin,latin">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,300,700">
	<link href="//fonts.googleapis.com/css?family=Coda+Caption:800|Poppins|Squada+One|Sriracha&display=swap" rel="stylesheet">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?= path ?>/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?= path ?>/assets/css/all.min.css">
	<link rel="stylesheet" href="<?= path ?>/assets/css/jquery-confirm.min.css">
	<link rel="stylesheet" href="<?= path ?>/assets/css/datepicker.min.css">
	<link rel="stylesheet" href="<?= path ?>/assets/css/lightbox.css" />
	<link rel="stylesheet" href="<?= path ?>/assets/css/fileinput.css" />
	<link rel="stylesheet" href="<?= path ?>/assets/js/minified/themes/default.min.css" />
	<link rel="stylesheet" href="<?= path ?>/assets/css/fontawesome-iconpicker.min.css" />
	<link rel="stylesheet" href="<?= path ?>/assets/css/spectrum.css" />

	<!-- Main CSS -->
	<link rel="stylesheet" href="<?= path ?>/assets/css/style.css">


	<?php if ($lang["rtl"] == "rtl_true") : ?>
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=El+Messiri">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Harmattan">
		<link rel="stylesheet" href="<?= path ?>/assets/css/rtl.css">
	<?php endif; ?>
</head>

<body class="pt-page<?= str_replace('-', '', page) ?>">
	<?php

	if (us_level == 6) :
	?>
		<div class="pt-wrapper">
			<div class="pt-admin-nav">
				<div class="pt-logo"><i class="fas fa-tree"></i></div>
				<ul>
					<li><a href="<?= path ?>/index.php"><i class="fas fa-home"></i><b></b></a></li>
					<li<?= ($pg == "" ? ' class="pt-active"' : '') ?>><a href="<?= path ?>/dashboard.php"><i class="fas fa-tachometer-alt"></i><b></b></a></li>
						<li<?= ($pg == "users" ? ' class="pt-active"' : '') ?>>
							<a href="<?= path ?>/dashboard.php?pg=users"><i class="fas fa-users"></i>
								<?= (db_rows("users WHERE status != 0") ? '<b class="noti">' . db_rows("users WHERE status != 0") . '</b>' : '') ?>
							</a>
							</li>
							<li<?= ($pg == "families" ? ' class="pt-active"' : '') ?>><a href="<?= path ?>/dashboard.php?pg=families"><i class="fas fa-sitemap"></i><b></b></a></li>
								<li<?= ($pg == "pages" ? ' class="pt-active"' : '') ?>><a href="<?= path ?>/dashboard.php?pg=pages"><i class="fas fa-copy"></i><b></b></a></li>
									<li<?= ($pg == "plans" ? ' class="pt-active"' : '') ?>><a href="<?= path ?>/dashboard.php?pg=plans"><i class="fas fa-trophy"></i><b></b></a></li>
										<li<?= ($pg == "payments" ? ' class="pt-active"' : '') ?>><a href="<?= path ?>/dashboard.php?pg=payments"><i class="fas fa-money-bill-wave"></i><b></b></a></li>
											<li<?= ($pg == "languages" ? ' class="pt-active"' : '') ?>><a href="<?= path ?>/dashboard.php?pg=languages"><i class="fas fa-language"></i><b></b></a></li>
												<li<?= ($pg == "setting" ? ' class="pt-active"' : '') ?>><a href="<?= path ?>/dashboard.php?pg=setting"><i class="fas fa-cogs"></i><b></b></a></li>
													<li><a href="#" class="logout"><i class="fas fa-power-off"></i><b></b></a></li>
				</ul>
			</div>
			<div class="pt-admin-body">
				<div class="pt-welcome">
					<h3><?= $lang['dashboard']['hello'] ?> <?= us_name ?>!</h3>
					<p><?= $lang['dashboard']['welcome'] ?></p>
					<span><i class="fas fa-chart-line"></i></span>
				</div>
				<div class="pt-stats">
					<ul>
						<li><span><i class="fas fa-poll"></i></span><b><?= $lang['dashboard']['families'] ?></b> <em><?= db_rows("families") ?></em></li>
						<li><span><i class="fas fa-users"></i></span><b><?= $lang['dashboard']['users'] ?></b> <em><?= db_rows("users") ?></em></li>
						<li><span><i class="fas fa-hand-holding-heart"></i></span><b><?= $lang['dashboard']['responses'] ?></b> <em><?= db_rows("members") ?></em></li>
						<li><span><i class="far fa-question-circle"></i></span><b><?= $lang['dashboard']['questions'] ?></b> <em><?= db_rows("images") ?></em></li>
					</ul>
				</div>



				<?php if (!$pg) : ?>
					<div class="row">
						<div class="col-6">
							<div class="pt-charts">
								<div class="pt-adminstatslinks pt-adminlines">
									<a href="#daily" rel="1"><?= $lang['dashboard']['days'] ?></a>
									<a href="#monthly" rel="1"><?= $lang['dashboard']['months'] ?></a>
								</div>
								<div class="pt-adminstats">
									<canvas id="line-chart" width="800" height="450"></canvas>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="pt-charts">
								<div class="pt-adminstatslinks pt-adminbars">
									<a href="#daily" rel="1"><?= $lang['dashboard']['days'] ?></a>
									<a href="#monthly" rel="1"><?= $lang['dashboard']['months'] ?></a>
								</div>
								<div class="pt-adminstats">
									<canvas id="bar-chart" width="800" height="450"></canvas>
								</div>

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="pt-admin-box">
								<h5><i class="far fa-user"></i> <?= $lang['dashboard']['new_u'] ?></h5>
								<div class="pt-content pt-scroll">
									<ul>
										<?php
										$sql = $db->query("SELECT * FROM " . prefix . "users WHERE date >= '" . (time() - 3600 * 24) . "' ORDER BY id DESC") or die($db->error);
										if ($sql->num_rows) :
											while ($rs = $sql->fetch_assoc()) :
										?>
												<li>
													<div class="media">
														<div class="media-left">
															<div class="pt-thumb"><img src="<?= path . '/' . $rs['photo'] ?>" onerror="this.src='<?= nophoto ?>'" /></div>
														</div>
														<div class="media-body">
															<?= $rs['username'] ?>
															<p>
																<span><i class="far fa-clock"></i> <?= fh_ago($rs['date']) ?></span>
																<span><i class="fas fa-poll"></i> <?= db_rows("families WHERE author = '{$rs['id']}'") ?> <?= $lang['dashboard']['families'] ?></span>
															</p>
														</div>
													</div>
												</li>
										<?php
											endwhile;
										else :
											echo '<li>' . fh_alerts($lang['alerts']['nodata'], "info") . '</li>';
										endif;
										$sql->close();
										?>
									</ul>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="pt-admin-box">
								<h5><i class="fas fa-sitemap"></i> <?= $lang['dashboard']['latest_f'] ?></h5>
								<div class="pt-content">
									<ul>
										<?php
										$sql = $db->query("SELECT * FROM " . prefix . "families WHERE date >= '" . (time() - 3600 * 24) . "' ORDER BY id DESC") or die($db->error);
										if ($sql->num_rows) :
											while ($rs = $sql->fetch_assoc()) :
										?>
												<li>
													<div class="media">
														<div class="media-left">
															<div class="pt-thumb"><img src="<?= path . '/' . db_get("members", "photo", $rs['id'], "family", "and parent ='0'") ?>" onerror="this.src='<?= nophoto ?>'" /></div>
														</div>
														<div class="media-body">
															<?= ($rs['name']) ?>
															<p>
																<span><i class="far fa-clock"></i> <?= fh_ago($rs['date']) ?></span>
															</p>
														</div>
													</div>
												</li>
										<?php
											endwhile;
										else :
											echo '<li>' . fh_alerts($lang['alerts']['nodata'], "info") . '</li>';
										endif;
										$sql->close();
										?>
									</ul>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="pt-admin-box">
								<h5><i class="fas fa-users"></i> <?= $lang['dashboard']['latest_m'] ?></h5>
								<div class="pt-content pt-scroll">
									<ul>
										<?php
										$sql = $db->query("SELECT * FROM " . prefix . "members WHERE date >= '" . (time() - 3600 * 24) . "' ORDER BY id DESC") or die($db->error);
										if ($sql->num_rows) :
											while ($rs = $sql->fetch_assoc()) :
										?>
												<li>
													<div class="media">
														<div class="media-left">
															<div class="pt-thumb"><img src="<?= (path . '/' . $rs['photo']) ?>" onerror="this.src='<?= nophoto ?>'" /></div>
														</div>
														<div class="media-body">
															<?= ($rs['firstname']) ?>
															<p>
																<span><i class="far fa-clock"></i> <?= fh_ago($rs['date']) ?></span>
																<span><i class="far fa-sitemap"></i> <?= db_get("families", "name", $rs['family']) ?></span>
															</p>
														</div>
													</div>
												</li>
										<?php
											endwhile;
										else :
											echo '<li>' . fh_alerts($lang['alerts']['nodata'], "info") . '</li>';
										endif;
										$sql->close();
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>





				<?php elseif ($pg == "plans") : ?>

					<div class="pt-body">
						<div class="pt-plans">
							<div class="pt-title">
								<h3><?= $lang['header']['plans'] ?></h3>
								<div class="pt-options">
									<a href="#myModal" data-toggle="modal" class="btn bg-gy text-white"><i class="fas fa-plus"></i> Add Plan</a>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Plan</th>
											<th scope="col">Monthly price</th>
											<th scope="col">Yearly price</th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = $db->query("SELECT * FROM " . prefix . "plans") or die($db->error);
										if ($sql->num_rows) :
											while ($rs = $sql->fetch_assoc()) :
										?>
												<tr>
													<td><?= $rs['plan'] ?></td>
													<td><?= $rs['currency'] ?><?= $rs['price_m'] ?></td>
													<td><?= $rs['currency'] ?><?= $rs['price_y'] ?></td>
													<td class="pt-options">
														<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
														<ul class="pt-drop">
															<li><a href="#myModal" data-toggle="modal" class="editplan" rel="<?= $rs['id'] ?>"><i class="far fa-edit"></i> <?= $lang['dashboard']['edit'] ?></a></li>
															<li><a href="#" class="pt-delete" data-id="<?= $rs['id'] ?>" data-request="plans"><i class="fas fa-trash-alt"></i> <?= $lang['dashboard']['delete'] ?></a></li>
														</ul>
													</td>
												</tr>
											<?php
											endwhile;
										else :
											?>
											<tr>
												<td colspan="8">
													<?= fh_alerts($lang['alerts']["nodata"], "info") ?>
												</td>
											</tr>
										<?php
										endif;
										$sql->close();
										?>
									</tbody>
								</table>
							</div>


							<!-- The Modal -->
							<form id="sendplans" class="pt-form">
								<div class="modal fade newmodal" id="myModal">
									<div class="modal-dialog">
										<div class="modal-content">

											<div class="modal-header">
												<h4 class="modal-title">Create a plan</h4>
												<button type="button" class="close" data-dismiss="modal">×</button>
											</div>

											<div class="modal-body">
												<div class="form-row">
													<div class="col">
														<label>Plan name </label>
														<input type="text" name="plan" placeholder="Plan name">
													</div>
													<div class="col">
														<label>Currency</label>
														<input type="text" name="currency" placeholder="Currency">
													</div>
												</div>
												<label>Options Description<br /><small>[n] will changes with the option number</small></label>

												<div class="form-row">
													<?php for ($i = 1; $i <= 8; $i++) : ?>
														<div class="col-6">
															<input type="text" name="desc<?php echo $i ?>" placeholder="Option <?php echo $i ?>">
														</div>
													<?php endfor; ?>
												</div>

												<div class="form-row">
													<div class="col">
														<label>Monthly</label>
														<input type="text" name="price_m" placeholder="Price">
														<input type="text" name="families_m" placeholder="Families">
														<input type="text" name="members_m" placeholder="Members per family">
														<input type="text" name="privates_m" placeholder="Private Famillies">

													</div>
													<div class="col">
														<label>Yearly</label>
														<input type="text" name="price_y" placeholder="Price">
														<input type="text" name="families_y" placeholder="Families">
														<input type="text" name="members_y" placeholder="Members">
														<input type="text" name="privates_y" placeholder="Private Famillies">
													</div>
												</div>

												<div class="form-row">
													<div class="col">
														<input class="tgl tgl-light" id="pdf" value="1" type="checkbox" name="pdf" />
														<label class="tgl-btn mt-3" for="pdf"></label>
														<label>PDF Export<label>
													</div>
													<div class="col">
														<input class="tgl tgl-light" id="show_ads" value="1" type="checkbox" name="show_ads" />
														<label class="tgl-btn mt-3" for="show_ads"></label>
														<label>show ads<label>
													</div>
												</div>
												<div class="form-row">
													<div class="col">
														<input class="tgl tgl-light" id="heritate" value="1" type="checkbox" name="heritate" />
														<label class="tgl-btn mt-3" for="heritate"></label>
														<label>Heritate families<label>
													</div>
													<div class="col">
														<input class="tgl tgl-light" id="albums" value="1" type="checkbox" name="albums" />
														<label class="tgl-btn mt-3" for="albums"></label>
														<label>Create albums<label>
													</div>
												</div>
												<div class="form-row">
													<div class="col">
														<input class="tgl tgl-light" id="Support" value="1" type="checkbox" name="support" />
														<label class="tgl-btn mt-3" for="Support"></label>
														<label>Support<label>
													</div>
													<div class="col">
														<!-- <input class="tgl tgl-light" id="lools1" value="1" type="checkbox" name=""/>
									<label class="tgl-btn mt-3" for="lools1"></label>
									<label>Create albums<label> -->
													</div>
												</div>



												<div class="pt-msg"></div>
											</div>

											<div class="modal-footer">
												<input type="hidden" name="id">
												<button type="submit" class="btn bg-gr"><?= $lang['dashboard']['save'] ?></button>
											</div>

										</div>
									</div>
								</div>
							</form>

							<!-- <form id="sendplan">
		<div class="pt-box">
			<input class="tgl tgl-light" id="cb1" value="1" name="site_plans" type="checkbox"<?= (site_plans ? ' checked' : '') ?>/>
			<label class="tgl-btn" for="cb1"></label>
			<label><?= $lang['dashboard']['p_disacticate'] ?></label>
		</div>
		<div class="row">
			<?php
					$sql = $db->query("SELECT * FROM " . prefix . "plans");
					while ($rs = $sql->fetch_assoc()) :
			?>
	    <div class="col-4">
				<div class="pt-box">
				<?php foreach ($rs as $key => $value) : ?>
					<?php if (!in_array($key, ['id', 'created_at', 'backgound', 'statistics', 'export_statistics', 'show_ads', 'integrations', 'support'])) : ?>
					<label class="mb-2"> <?php if (in_array($key, ['quizzes', 'takers', 'questions'])) : ?>
						<b>
						<?php if ($key == 'quizzes') : ?>
							Families
						<?php elseif ($key == 'takers') : ?>
							Members
						<?php else : ?>
							Private Famillies
						<?php endif; ?>
						</b>
						<?php endif; ?>
						<input type="text" name="<?= $key ?>[<?= $rs['id'] ?>]" placeholder="plan <?= ($key == 'price_y' ? 'yearly price' : str_replace('_', ' ', $key)) ?>" value="<?= $value ?>">
					</label>
					<?php endif; ?>
					<?php if (in_array($key, ['backgound', 'statistics', 'export_statistics', 'show_ads', 'integrations', 'support'])) : ?>
						<div class="mb-3">
							<input class="tgl tgl-light" id="<?= $key . $rs['id'] ?>" value="1"type="checkbox" name="<?= $key ?>[<?= $rs['id'] ?>]"<?= ($value == 1 ? 'checked' : '') ?>/>
							<label class="tgl-btn" for="<?= $key . $rs['id'] ?>"></label>
							<label><label>
								<?php if ($key == 'export_statistics') : ?>
									PDF Export
								<?php elseif ($key == 'backgound') : ?>
									Enable to heritate families
								<?php elseif ($key == 'integrations') : ?>
									Enable to create albums
								<?php else : ?>
									<?= str_replace('_', ' ', $key) ?>
								<?php endif; ?>

							</label></label>
						</div>

					<?php endif; ?>
				<?php endforeach; ?>
	    </div>
	    </div>
			<?php
					endwhile;
					$sql->close();
			?>
		</div>
		<div class="p-3">
			<button type="submit" class="btn btn-success">
				<span><?= $lang['dashboard']['save'] ?> <i class="fas fa-arrow-circle-right"></i></span>
			</button>
		</div>
  </form> -->
						</div>


					</div>



				<?php elseif ($pg == "families") : ?>
					<div class="pt-body">
						<div class="pt-title">
							<h3><?= $lang['dashboard']['families'] ?></h3>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col"><?= $lang['dashboard']['status'] ?></th>
										<th scope="col"><?= $lang['dashboard']['name'] ?></th>
										<th scope="col"><?= $lang['dashboard']['public'] ?></th>
										<th scope="col"><?= $lang['dashboard']['members'] ?></th>
										<th scope="col"><?= $lang['dashboard']['moderators'] ?></th>
										<th scope="col"><?= $lang['dashboard']['date'] ?></th>
										<th scope="col"></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = $db->query("SELECT * FROM " . prefix . "families ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die($db->error);
									if ($sql->num_rows) :
										while ($rs = $sql->fetch_assoc()) :
											$rs['photo'] = $rs['photo'] ? $rs['photo'] : db_get("members", "photo", $rs['id'], 'family', "AND parent = '0'");
									?>
											<tr>
												<th scope="row" class="pt-status">
													<input class="tgl tgl-light familystatus" id="cb<?= $rs['id'] ?>" value="<?= $rs['id'] ?>" type="checkbox" <?= (!$rs['status'] ? ' checked' : '') ?> />
													<label class="tgl-btn" for="cb<?= $rs['id'] ?>"></label>
												</th>
												<td>
													<div class="media">
														<div class="media-left">
															<div class="pt-thumb"><img src="<?= path . "/" . $rs['photo'] ?>" onerror="this.src='<?= nophoto ?>'" title="<?= $rs['author'] ?>" /></div>
														</div>
														<div class="media-body">
															<a href="<?= path ?>/tree.php?id=<?= $rs['id'] ?>&t=<?= ($rs['slug'] ?? 'id') ?>"><?= $rs['name'] ?></a>
														</div>
													</div>
												</td>
												<td><?= ($rs['public'] ? '<span class="bg-youtube pt-lb">No</span>' : '<span class="bg-whatsapp pt-lb">Yes</span>') ?></td>
												<td><?= db_rows("members WHERE family = '{$rs['id']}'") ?></td>
												<td class="pt-progress"><?= $rs['moderators'] ?></td>
												<td><?= fh_ago($rs['date']) ?></td>
												<td class="pt-options">
													<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
													<ul class="pt-drop">
														<li><a href="<?= path ?>/tree.php?id=<?= $rs['id'] ?>&t=<?= ($rs['slug'] ?? 'id') ?>"><i class="far fa-edit"></i> <?= $lang['dashboard']['edit'] ?></a></li>
														<li><a href="#" class="pt-delete" data-id="<?= $rs['id'] ?>" data-request="families"><i class="fas fa-trash-alt"></i> <?= $lang['dashboard']['delete'] ?></a></li>
													</ul>
												</td>
											</tr>
										<?php
										endwhile;
										if (db_rows("families") > $limit) :
											echo '<tr><td colspan="8">' . fh_pagination("families", $limit, path . "/dashboard.php?pg=families&") . '</td></tr>';
										endif;
									else :
										?>
										<tr>
											<td colspan="8">
												<?= fh_alerts($lang['alerts']["nodata"], "info") ?>
											</td>
										</tr>
									<?php
									endif;
									$sql->close();
									?>
								</tbody>
							</table>
						</div>
					</div>

				<?php elseif ($pg == "users") : ?>
					<div class="pt-body">
						<div class="pt-title">
							<h3><?= $lang['dashboard']['u_users'] ?></h3>
							<div class="pt-options">
								<a href="#myModal" data-toggle="modal" class="btn bg-gy text-white"><i class="fas fa-plus"></i> <?= $lang['dashboard']['u_create'] ?></a>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col"><?= $lang['dashboard']['u_status'] ?></th>
										<th scope="col"><?= $lang['dashboard']['u_username'] ?></th>
										<th scope="col"><?= $lang['dashboard']['verification'] ?></th>
										<th scope="col"><?= $lang['dashboard']['families'] ?></th>
										<th scope="col"><?= $lang['dashboard']['responses'] ?></th>
										<th scope="col"><?= $lang['dashboard']['u_registred'] ?></th>
										<th scope="col"><?= $lang['dashboard']['u_updated'] ?></th>
										<th scope="col"></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = $db->query("SELECT * FROM " . prefix . "users ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die($db->error);
									if ($sql->num_rows) :
										while ($rs = $sql->fetch_assoc()) :
									?>
											<tr>
												<th scope="row" class="pt-status">
													<input class="tgl tgl-light userstatus" id="cb<?= $rs['id'] ?>" value="<?= $rs['id'] ?>" type="checkbox" <?= (!$rs['status'] ? ' checked' : '') ?> />
													<label class="tgl-btn" for="cb<?= $rs['id'] ?>"></label>
												</th>
												<td>
													<div class="pt-thumb">
														<img src="<?= ($rs['photo'] ? $rs['photo'] : nophoto) ?>" />
													</div>
													<a href="#"><?= $rs['username'] ?></a>
												</td>
												<td>
													<span class="pt-plan-badg <?= ($rs['status'] == 1 ? 'p3' : ($rs['status'] == 2 ? 'p2' : (!$rs['status'] ? 'p1' : ''))) ?>">
														<?= ($rs['status'] == 1 ? 'Need Approval' : ($rs['status'] == 2 ? 'Need Email Verification' : (!$rs['status'] ? 'Active' : ''))) ?>
													</span>
												</td>
												<td><?= db_rows("families WHERE author = '{$rs['id']}'") ?></td>
												<td><?= db_rows("members WHERE author = '{$rs['id']}'") ?></td>
												<td><?= fh_ago($rs['date']) ?></td>
												<td><?= ($rs['updated_at'] ? fh_ago($rs['updated_at']) : '--') ?></td>
												<td class="pt-options">
													<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
													<ul class="pt-drop">
														<li><a href="<?= path ?>/details.php?id=<?= $rs['id'] ?>"><i class="far fa-edit"></i> <?= $lang['dashboard']['u_edit'] ?></a></li>
														<li><a href="#" class="pt-delete" data-id="<?= $rs['id'] ?>" data-request="users"><i class="fas fa-trash-alt"></i> <?= $lang['dashboard']['u_delete'] ?></a></li>
													</ul>
												</td>
											</tr>
										<?php
										endwhile;
										if (db_rows("users") > $limit) :
											echo '<tr><td colspan="8">' . fh_pagination("users", $limit, path . "/dashboard.php?pg=users&") . '</td></tr>';
										endif;
									else :
										?>
										<tr>
											<td colspan="8">
												<?= fh_alerts($lang['alerts']["nodata"], "info") ?>
											</td>
										</tr>
									<?php
									endif;
									$sql->close();
									?>
								</tbody>
							</table>
						</div>
					</div>


					<!-- The Modal -->
					<form id="send-user" class="pt-form">
						<div class="modal fade newmodal" id="myModal">
							<div class="modal-dialog">
								<div class="modal-content">

									<div class="modal-header">
										<h4 class="modal-title"><?= $lang['dashboard']['u_create'] ?></h4>
										<button type="button" class="close" data-dismiss="modal">×</button>
									</div>

									<div class="modal-body">
										<div class="form-row">
											<div class="col">
												<label><?= $lang['indexpage']['form_fid_l'] ?> <small class="text-danger">*</small></label>
												<input type="text" name="name" placeholder="<?= $lang['indexpage']['form_fid_i'] ?>">
											</div>
											<div class="col">
												<label><?= $lang['indexpage']['form_pass_l'] ?> <small class="text-danger">*</small></label>
												<input type="password" name="pass" placeholder="<?= $lang['indexpage']['form_pass_i'] ?>">
											</div>
										</div>

										<div class="form-groups">
											<label><?= $lang['indexpage']['form_email_l'] ?> <small class="text-danger">*</small></label>
											<input type="text" name="email" placeholder="<?= $lang['indexpage']['form_email_i'] ?>">
										</div>
										<div class="pt-msg"></div>
									</div>

									<div class="modal-footer">
										<button type="submit" class="btn bg-gr"><?= $lang['dashboard']['save'] ?></button>
									</div>

								</div>
							</div>
						</div>
					</form>



				<?php elseif ($pg == "languages") : ?>
					<div class="pt-body pt-box-languages">
						<div class="pt-title">
							<h3>Languages</h3>
						</div>

						<div class="p-4 pt-0">

							<ul class="nav nav-tabs">
								<?php
								$sql = $db->query("SELECT * FROM " . prefix . "languages") or die($db->error);
								$i = 0;
								while ($rs = $sql->fetch_assoc()) {
									$i++;
									echo '<li class="nav-item"><a class="nav-link ' . ($i == 1 ? 'active' : '') . '" data-toggle="tab" href="#' . str_replace(" ", "_", $rs['language']) . '">' . $rs['language'] . '</a></li>';
								}
								?>
								<li class="nav-item"><a class="nav-link pt-newlang" href="#"><i class="fas fa-plus"></i></a></li>
							</ul>


							<!-- Tab panes -->
							<div class="tab-content">
								<?php
								$sql2 = $db->query("SELECT * FROM " . prefix . "languages ORDER BY isdefault ASC") or die($db->error);
								while ($rs2 = $sql2->fetch_assoc()) :
									$langs = json_decode($rs2['content'], true);
								?>
									<div id="<?php echo str_replace(" ", "_", $rs2['language']) ?>" class="container tab-pane <?= ($rs2['isdefault'] ? ' active' : '') ?> pt-tab2"><br>
										<form class="pt-sendlanguage pt-form">
											<div class="row">
												<div class="col">
													<div class="form-group">
														<label>Language</label>
														<input type="text" name="lang_name" placeholder="English" value="<?php echo $rs2['language'] ?>">
													</div>
												</div>
												<div class="col">
													<div class="form-group">
														<label>Short name</label>
														<input type="text" name="lang_short" placeholder="en" value="<?php echo $rs2['short'] ?>">
														<input type="hidden" name="lang_id" value="<?php echo $rs2['id'] ?>">
													</div>
												</div>
												<div class="col">
													<div class="pt-box m-0 mt-5">
														<input class="tgl tgl-light" id="cb1" value="1" name="lang_default" type="checkbox" <?= ($rs2['isdefault'] ? ' checked' : '') ?> />
														<label class="tgl-btn m-3" for="cb1"></label>
														<label>Default language</label>
														<div class="float-right"><a href="#" class="pt-delete btn btn-danger btn-sm m-1" data-id="<?= $rs2['id'] ?>" data-request="languages"><i class="fas fa-trash-alt"></i> <?= $lang['dashboard']['delete'] ?></a></div>
													</div>
												</div>
											</div>
											<ul class="nav nav-tabs">
												<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#<?php echo str_replace(" ", "_", $rs2['language']) ?>_gen">General</a></li>
												<?php foreach ($langs as $key => $value) : if (is_array($value)) : ?>
														<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#<?php echo str_replace(" ", "_", $rs2['language']) ?>_<?php echo $key ?>"><?php echo $key ?></a></li>
												<?php endif;
												endforeach; ?>
											</ul>
											<div class="tab-content">
												<div id="<?php echo str_replace(" ", "_", $rs2['language']) ?>_gen" class="container active tab-pane">
													<textarea name="language[a]" class="pt-nowhitespaces pt-textzebra"><?php foreach ($langs as $key => $value) if (!is_array($value)) echo stripslashes($value) . '&#13' ?></textarea>
												</div>
												<?php foreach ($langs as $key => $value) : if (is_array($value)) : ?>
														<div id="<?php echo str_replace(" ", "_", $rs2['language']) ?>_<?php echo $key ?>" class="container tab-pane">
															<textarea name="language[<?php echo $key ?>]" class="pt-nowhitespaces pt-textzebra"><?php foreach ($value as $k => $v) echo stripslashes($v) . '&#13' ?></textarea>
														</div>
												<?php endif;
												endforeach; ?>
											</div>
											<hr>
											<button type="submit" class="btn bg-gr pt-2 pb-2 pl-4 pr-4 text-white">submit</button>

										</form>
									</div>
								<?php endwhile; ?>
							</div>


						</div>




					</div>





				<?php elseif ($pg == "pages") : ?>
					<div class="pt-body">
						<div class="pt-title">
							<h3><?= $lang['dashboard']['u_pages'] ?></h3>
							<div class="pt-options">
								<a href="<?= path ?>/dashboard.php?pg=newpage" class="btn btn-primary"><i class="fas fa-plus"></i> <?= $lang['dashboard']['npage'] ?></a>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col"><?= $lang['dashboard']['title'] ?></th>
										<th scope="col"><?= $lang['dashboard']['inmenu'] ?></th>
										<th scope="col"><?= $lang['dashboard']['created'] ?></th>
										<th scope="col"></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = $db->query("SELECT * FROM " . prefix . "pages ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die($db->error);
									if ($sql->num_rows) :
										while ($rs = $sql->fetch_assoc()) :
									?>
											<tr>
												<td>
													<span></span>
													<a href="<?= path ?>/page.php?t=<?= $rs['slug'] ?>"><?= $rs['title'] ?></a>
												</td>
												<td>
													<span class="pt-plan-badg <?= ($rs['header'] == 1 ? 'p1' : 'p2') ?>">
														<?= ($rs['header'] == 1 ? 'yes' : 'no') ?>
													</span>
												</td>
												<td><?= fh_ago($rs['date']) ?></td>
												<td class="pt-options">
													<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
													<ul class="pt-drop">
														<li><a href="<?= path ?>/dashboard.php?pg=newpage&id=<?= $rs['id'] ?>"><i class="far fa-edit"></i> <?= $lang['dashboard']['edit'] ?></a></li>
														<li><a href="#" class="pt-delete" data-id="<?= $rs['id'] ?>" data-request="pages"><i class="fas fa-trash-alt"></i> <?= $lang['dashboard']['delete'] ?></a></li>
													</ul>
												</td>
											</tr>
										<?php
										endwhile;
										if (db_rows("users") > $limit) :
											echo '<tr><td colspan="8">' . fh_pagination("pages", $limit, path . "/dashboard.php?pg=pages&") . '</td></tr>';
										endif;
									else :
										?>
										<tr>
											<td colspan="8">
												<?= fh_alerts($lang['alerts']["nodata"], "info") ?>
											</td>
										</tr>
									<?php
									endif;
									$sql->close();
									?>
								</tbody>
							</table>
						</div>
					</div>


				<?php elseif ($pg == "payments") : ?>

					<div class="pt-body">
						<div class="pt-title">
							<h3><?= $lang['dashboard']['p_title'] ?></h3>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col"><?= $lang['dashboard']['p_user'] ?></th>
										<th scope="col" class="text-center"><?= $lang['dashboard']['u_plan'] ?></th>
										<th scope="col" class="text-center"><?= $lang['dashboard']['p_amount'] ?></th>
										<th scope="col" class="text-center"><?= $lang['dashboard']['p_paymentid'] ?></th>
										<th scope="col" class="text-center"><?= $lang['dashboard']['p_payerid'] ?></th>
										<th scope="col" class="text-center"><?= $lang['dashboard']['created_at'] ?></th>
										<th scope="col" class="text-center">frequency</th>
										<th scope="col" class="text-center">Expired date</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = $db->query("SELECT * FROM " . prefix . "payments ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die($db->error);
									if ($sql->num_rows) :
										while ($rs = $sql->fetch_assoc()) :
									?>
											<tr>
												<td width="20%">
													<div class="pt-thumb">
														<img src="<?= db_get("users", "photo", $rs['author']) ?>" onerror="this.src='<?= nophoto ?>'" />
													</div>
													<a href="#" class="pt-name"><?= db_get("users", "username", $rs['author']) ?></a>
												</td>
												<td class="text-center">
													<span class="badge text-white bg-<?= ($rs['plan'] == '1' ? 'gy' : ($rs['plan'] == '2' ? 'gr' : ($rs['plan'] == '3' ? 'v' : ($rs['plan'] == '4' ? 'o' : '')))) ?>">
														<?= ($rs['plan'] ? db_get("plans", "plan", $rs['plan']) : '--') ?>
													</span>
												</td>
												<td class="text-center"><?= ($rs['price'] ? dollar_sign . $rs['price'] : '--') ?></td>
												<td class="text-center"><?= ($rs['payment_id'] ? $rs['payment_id'] : '--') ?></td>
												<td class="text-center"><?= ($rs['payer_id'] ? $rs['payer_id'] : '--') ?></td>
												<td class="text-center"><?= fh_ago($rs['date']) ?></td>
												<td class="text-center"><?= ($rs['frequency'] ? 'Monthly' : 'Yearly') ?></td>
												<td class="text-center"><?= date('d/m/Y', $rs['expired_date']) ?></td>
											</tr>
										<?php
										endwhile;
										echo '<tr><td colspan="6">' . fh_pagination("payments", $limit, path . "/dashboard.php?pg=payments&") . '</td></tr>';
									else :
										?>
										<tr>
											<td colspan="6">
												<?= fh_alerts($lang['alerts']["nodata"], "info") ?>
											</td>
										</tr>
									<?php
									endif;
									$sql->close();
									?>
								</tbody>
							</table>
						</div>
					</div>





				<?php elseif ($pg == "setting") : ?>
					<div class="pt-body">
						<div class="pt-title">
							<h3><?= $lang['dashboard']['set_title'] ?></h3>
						</div>
						<form class="pt-sendsettings pt-form">
							<div class="pt-admin-setting">

								<ul class="nav nav-tabs">
									<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#gen">General</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Options">Options & Colors</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Paypal">Paypal</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#PHPMAILER">PHPMAILER SMTP</a></li>
								</ul>
								<div class="tab-content p-3">
									<div id="gen" class="container active tab-pane">
										<div class="form-group">
											<label><?= $lang['dashboard']['set_stitle'] ?></label>
											<input type="text" name="site_title" value="<?= site_title ?>">
										</div>
										<div class="form-group">
											<label><?= $lang['dashboard']['set_keys'] ?></label>
											<input type="text" name="site_keywords" value="<?= site_keywords ?>">
										</div>
										<div class="form-group">
											<label><?= $lang['dashboard']['set_desc'] ?></label>
											<textarea name="site_description"><?= site_description ?></textarea>
										</div>
										<div class="form-group">
											<label><?= $lang['dashboard']['set_url'] ?></label>
											<input type="text" name="site_url" value="<?= site_url ?>">
										</div>
										<div class="form-group">
											<label>No reply</label>
											<input type="text" name="site_noreply" value="<?= site_noreply ?>">
										</div>

									
									</div>
									<div id="Paypal" class="container tab-pane">
										<!-- <h3 class="cp-form-title">Paypal</h3>
							<hr /> -->
										<div class="form-group">
											<input class="tgl tgl-light" id="cb5" value="1" name="site_paypal_live" type="checkbox" <?= (site_paypal_live ? ' checked' : '') ?> />
											<label class="tgl-btn" for="cb5"></label>
											<label class="m-0 ml-1">Live</label>
										</div>
										<div class="form-row">
											<div class="col form-group">
												<label>Paypal id</label>
												<input type="text" name="site_paypal_id" placeholder="Paypal id" value="<?= site_paypal_id ?>">
											</div>
											<div class="col form-group">
												<label>Client id</label>
												<input type="password" name="site_paypal_client_id" placeholder="Paypal Client id" value="<?= site_paypal_client_id ?>">
											</div>
											<div class="col form-group">
												<label>Client Secret</label>
												<input type="password" name="site_paypal_client_secret" placeholder="Paypal Client Secret" value="<?= site_paypal_client_secret ?>">
											</div>
											<div class="col-1 form-group">
												<label>Currency</label>
												<input type="text" name="site_currency_name" placeholder="Currency name" value="<?= site_currency_name ?>">
											</div>
											<div class="col-1 form-group">
												<label>Symbol</label>
												<input type="text" name="site_currency_symbol" placeholder="Currency Symbol" value="<?= site_currency_symbol ?>">
											</div>
										</div>
									</div>
									<div id="PHPMAILER" class="container tab-pane">
										<!-- <h3 class="cp-form-title">PHPMAILER SMTP</h3>
							<hr /> -->

										<div class="form-group">
											<input class="tgl tgl-light" id="cb6" value="1" name="site_smtp" type="checkbox" <?= (site_smtp ? ' checked' : '') ?> />
											<label class="tgl-btn" for="cb6"></label>
											<label class="m-0 ml-1">is SMTP</label>
										</div>
										<div class="form-row">
											<div class="col form-group">
												<label>Host</label>
												<input type="text" name="site_smtp_host" placeholder="SMTP Host" value="<?= site_smtp_host ?>">
											</div>
											<div class="col form-group">
												<label>Username</label>
												<input type="text" name="site_smtp_username" placeholder="SMTP Username" value="<?= site_smtp_username ?>">
											</div>
											<div class="col form-group">
												<label>Password</label>
												<input type="password" name="site_smtp_password" placeholder="SMTP Password" value="<?= site_smtp_password ?>">
											</div>
											<div class="col form-group">
												<label>Port</label>
												<input type="text" name="site_smtp_port" placeholder="SMTP Port" value="<?= site_smtp_port ?>">
											</div>
											<div class="col form-group">
												<label>Auth</label>
												<select name="site_smtp_auth">
													<option value="0" <?= (site_smtp_auth == '0' ? 'selected' : '') ?>>False</option>
													<option value="1" <?= (site_smtp_auth == '1' ? 'selected' : '') ?>>True</option>
												</select>
											</div>
											<div class="col form-group">
												<label>Encryption</label>
												<select name="site_smtp_encryption">
													<option value="none" <?= (site_smtp_encryption == 'none' ? 'selected' : '') ?>>None</option>
													<option value="tls" <?= (site_smtp_encryption == 'tls' ? 'selected' : '') ?>>TLS</option>
												</select>
											</div>
										</div>
									</div>
									<div id="Options" class="container tab-pane">
										<div class="form-group">

											<div class="form-inline">
												<div class="form-group"><label><?= $lang['dashboard']['regstatus'] ?></label></div>
												<div class="form-group">
													<input type="radio" name="reg_status" value="2" id="sradioe1" class="choice" <?= (site_register == 2 ? ' checked' : '') ?>>
													<label for="sradioe1"><?= $lang['dashboard']['byemail'] ?></label>
												</div>
												<div class="form-group">
													<input type="radio" name="reg_status" value="1" id="sradioe2" class="choice" <?= (site_register == 1 ? ' checked' : '') ?>>
													<label for="sradioe2"><?= $lang['dashboard']['mneedsapproval'] ?></label>
												</div>
												<div class="form-group">
													<input type="radio" name="reg_status" value="0" id="sradioe3" class="choice" <?= (!site_register ? ' checked' : '') ?>>
													<label for="sradioe3"><?= $lang['dashboard']['open'] ?></label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<input class="tgl tgl-light" id="cb1ss" value="1" name="site_plans" type="checkbox" <?= (site_plans ? ' checked' : '') ?> />
											<label class="tgl-btn" for="cb1ss"></label><span><?= $lang['dashboard']['p_disacticate'] ?></span>
										</div>
										<div class="form-group">
											<input class="tgl tgl-light" id="cb1" name="site_register_status" value="1" type="checkbox" <?= (site_register_status ? ' checked' : '') ?> />
											<label class="tgl-btn" for="cb1"></label> <span><?= $lang['dashboard']['hidereg'] ?></span>
										</div>
										<div class="form-group">
											<input class="tgl tgl-light" id="cb2" name="site_families_status" value="1" type="checkbox" <?= (site_families_status ? ' checked' : '') ?> />
											<label class="tgl-btn" for="cb2"></label> <span><?= $lang['dashboard']['fneedsapproval'] ?></span>
										</div>
										<div class="form-group">
											<label><?= $lang['dashboard']['colors'] ?>:</label>
											<input class="colorpicker-popup" name="color1" value="<?= color1 ?>" type="text">
											<input class="colorpicker-popup" name="color2" value="<?= color2 ?>" type="text">
											<input class="colorpicker-popup" name="color3" value="<?= color3 ?>" type="text">
											<input class="colorpicker-popup" name="color4" value="<?= color4 ?>" type="text">
											<input class="colorpicker-popup" name="color5" value="<?= color5 ?>" type="text">
											<input class="colorpicker-popup" name="color6" value="<?= color6 ?>" type="text">
											<input class="colorpicker-popup" name="color7" value="<?= color7 ?>" type="text">
											<input class="colorpicker-popup" name="color8" value="<?= color8 ?>" type="text">
											<input class="colorpicker-popup" name="color9" value="<?= color9 ?>" type="text">
											<input class="colorpicker-popup" name="color10" value="<?= color10 ?>" type="text">
										</div>
									</div>
								</div>




								<hr />



								<div>
									<button type="submit" class="btn btn-success p-3 btn-lg"><?= $lang['dashboard']['save'] ?> <i class="fas fa-arrow-circle-right"></i></button>
								</div>
							</div>

						</form>
					</div>


				<?php elseif ($pg == "newpage") : ?>
					<?php
					$sql = $db->query("SELECT * FROM " . prefix . "pages WHERE id = '{$id}' ORDER BY id") or die($db->error);
					if ($sql->num_rows) :
						$rs = $sql->fetch_assoc();
					else :
						$rs['title'] = '';
						$rs['content'] = '';
						$rs['id'] = '';
						$rs['header'] = '';
						$rs['icon'] = '';
					endif;
					?>
					<div class="pt-body">
						<div class="pt-title">
							<h3><?= $lang['dashboard']['set_title'] ?></h3>
						</div>
						<form class="pt-sendpage pt-form">
							<div class="pt-admin-setting">
								<div class="form-group">
									<label><?= $lang['dashboard']['ptitle'] ?></label>
									<input type="text" name="pg_title" value="<?= $rs['title'] ?>">
								</div>
								<div class="form-group">
									<label><?= $lang['dashboard']['picon'] ?></label>
									<input type="text" name="pg_icon" class="my" value="<?= $rs['icon'] ?>">
								</div>
								<div class="form-group">
									<label><?= $lang['dashboard']['pcontent'] ?></label>
									<textarea name="pg_content" id="wysibb-editor"><?= $rs['content'] ?></textarea>
								</div>
								<div class="form-group">
									<input class="tgl tgl-light" id="cb1" name="pg_header" value="1" type="checkbox" <?= ($rs['header'] ? ' checked' : '') ?> />
									<label class="tgl-btn" for="cb1"></label> <span><?= $lang['dashboard']['dmenu'] ?></span>
								</div>
								<div>
									<input type="hidden" name="pg_id" value="<?= $rs['id'] ?>">
									<button type="submit" class="btn btn-success p-3 btn-lg"><?= $lang['dashboard']['save'] ?> <i class="fas fa-arrow-circle-right"></i></button>
								</div>
							</div>

						</form>
					</div>


				<?php endif; ?>

				<div class="pt-footer">
					<div>
						Copyright © <?php echo date('Y') ?> <a href="#"><?= site_title ?></a>. All Rights Reserved.<br>
					</div>
				</div>
			</div>
		</div>
	<?php
	else :
		echo '<meta http-equiv="refresh" content="0;url=' . path . '">';
	endif;
	?>
	<!-- jQuery Library -->
	<script src="<?= path ?>/assets/js/jquery.min.js"></script>
	<script src="<?= path ?>/assets/js/popper.min.js"></script>
	<script src="<?= path ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?= path ?>/assets/js/jquery.livequery.js"></script>
	<script src="<?= path ?>/assets/js/jquery-confirm.min.js"></script>
	<script src="<?= path ?>/assets/js/fileinput.min.js"></script>
	<script src="<?= path ?>/assets/js/lightbox.js"></script>
	<script src="<?= path ?>/assets/js/datepicker.min.js"></script>
	<script src="<?= path ?>/assets/js/datepicker.en.js"></script>
	<script src="<?= path ?>/assets/js/fontawesome-iconpicker.min.js"></script>
	<script src="<?= path ?>/assets/js/Chart.min.js"></script>
	<script src="<?= path ?>/assets/js/jquery.uploader.js"></script>

	<script src="<?= path ?>/assets/js/minified/sceditor.min.js"></script>
	<script src="<?= path ?>/assets/js/minified/formats/bbcode.js"></script>
	<script src="<?= path ?>/assets/js/minified/icons/material.js"></script>

	<script src="<?= path ?>/assets/js/spectrum.js"></script>

	<script>
		var path = '<?= path ?>',
			nophoto = '<?= nophoto ?>',
			lang = <?= json_encode($lang) ?>;
	</script>

	<!-- Main JS -->
	<script src="<?= path ?>/assets/js/custom.js"></script>

</body>

</html>