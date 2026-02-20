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

include __DIR__.'/configs/config.php';
?>
<!DOCTYPE html>
<html lang="<?=$lang['lang']?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?=fh_title()?></title>

	<meta name="title" content="<?=fh_title()?>">
	<meta name="description" content="<?=site_description?>">
	<meta name="keywords" content="<?=site_keywords?>">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?=site_url?>">
	<meta property="og:title" content="<?=fh_title()?>">
	<meta property="og:description" content="<?=site_description?>">
	<meta property="og:image" content="<?=site_url?>">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?=site_url?>">
	<meta property="twitter:title" content="<?=fh_title()?>">
	<meta property="twitter:description" content="<?=site_description?>">
	<meta property="twitter:image" content="<?=site_url?>">

	<!-- Google Fonts -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap">
	<link href="//fonts.googleapis.com/css?family=Coda+Caption:800|Poppins|Squada+One|Sriracha&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?=path?>/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?=path?>/assets/css/all.min.css">
	<link rel="stylesheet" href="<?=path?>/assets/css/jquery-confirm.min.css">
	<link rel="stylesheet" href="<?=path?>/assets/css/datepicker.min.css">
	<link rel="stylesheet" href="<?=path?>/assets/css/lightbox.css" />
	<link rel="stylesheet" href="<?=path?>/assets/css/fileinput.css" />
	<link rel="stylesheet" href="<?=path?>/assets/css/amsify.suggestags.css">


	<!-- Main CSS -->
	<link rel="stylesheet" href="<?=path?>/assets/css/style.css">

	<?php if ($lang["rtl"] == "rtl_true"): ?>
	<link rel="stylesheet" href="//fonts.googleapis.com/css2?family=El+Messiri:wght@400;700&family=Harmattan:wght@400;700&display=swap">
	<link rel="stylesheet" href="<?=path?>/assets/css/rtl.css">
	<?php endif; ?>

	<link rel="stylesheet" href="<?=path?>/assets/css/style.php">


</head>
<body class="pt-login pt-page<?=str_replace('-', '', page)?>">

<div class="pt-header-menu">
	<div class="pt-logo">
		<i class="fas fa-tree"></i>
	</div>
	<div class="pt-search">
		<input type="text" name="search" placeholder="<?=$lang['header']['search']?>" />
		<button type="submit"><i class="fas fa-search"></i></button>
		<div class="sresults"></div>
	</div>
	<div class="pt-list-menu">
		<div class="pt-lang">
			<?php
			$sqls = $db->query("SELECT * FROM ".prefix."languages WHERE isdefault = 1") or die ($db->error);
			$rss = $sqls->fetch_assoc();
			echo '<a class="pt-slang" rel="'.$rss['id'].'"><i class="flag-icon flag-icon-squared flag-icon-'.$rss['short'].'"></i> '.$rss['language'].'</a>';
			?>
			<ul>
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."languages") or die ($db->error);
				$i = 0;
				while ( $rs = $sql->fetch_assoc() ) {
					$i++;
					echo '<li><a class="pt-changelang" rel="'.$rs['id'].'"><i class="flag-icon flag-icon-squared flag-icon-'.$rs['short'].'"></i> '.$rs['language'].'</a></li>';
				}
				?>
			</ul>
		</div>

	<?php if(us_level==6): ?>
		<div class="pt-dash">
			<a href="<?=path?>/dashboard.php"><i class="fas fa-cog"></i></a>
		</div>
	<?php endif; ?>
	<?php if(us_level): ?>
		<div class="pt-notifi">
			<a href="#" class="pt-notyshow">
				<i class="far fa-bell"></i><b><?=db_rows("notifications WHERE user = '{$lg}' and nread = 0")?></b>
			</a>
			<ul class="pt-drop">
				<?php
				$sql_no = $db->query("SELECT * FROM ".prefix."notifications WHERE user = '{$lg}' ORDER BY id DESC LIMIT 10");
				if($sql_no->num_rows):
					while($rs_no = $sql_no->fetch_assoc()):
						$usr = db_get("users", "username", $rs_no['author']);
				?>
				<li class="<?=(!$rs_no['nread'] ? 'unread read-notifi' : '')?> " rel="<?=$rs_no['id']?>">
					<div class="pt-thumb">
						<img src="<?=db_get("users", "photo", $rs_no['author'])?>" alt="<?=$usr?>" onerror="this.src='<?=nophoto?>'">
					</div>
					<div class="pt-cnt">
						<?php
						switch ($rs_no['type']) {
							case 'moderator':
								$getfid = $rs_no['item'];
								$getf = db_get("families", "name", $getfid);
								$getsl = db_get("families", "slug", $getfid);
								echo "{$usr} have maked you <b>moderator</b> to <a href=\"".path."/tree.php?id={$getfid}&t={$getsl}\">{$getf}</a> family tree.";
							break;
							case 'member':
								$getfid = db_get("members", "family", $rs_no['item']);
								$getf = db_get("families", "name", $getfid);
								$getsl = db_get("families", "slug", $getfid);
								echo "{$usr} have linked you to a <a href=\"".path."/tree.php?id={$getfid}&t={$getsl}\">{$getf}</a> family tree <b>member</b>.";
							break;
						}
					 	?>
					</div>
				</li>
				<?php
					endwhile;
				else:
					echo '<li class="no-not">'.$lang['header']['no-not'].'</li>';
				endif;
				$sql_no->close();
				?>
			</ul>
		</div>
		<div class="pt-new-tree">
			<a href="#" data-toggle="modal" data-target="#addnewtree"><i class="fas fa-plus-circle"></i> <?=$lang['header']['newtree']?></a>
		</div>
		<?php endif; ?>

		<div class="pt-thumb">
			<img src="<?=($lg ? us_photo : nophoto)?>" onerror="this.src='<?=nophoto?>'" />
		</div>
		<span><?=($lg ? us_name : $lang['header']['welcome'])?></span>
	</div>
</div>

<div class="pt-nav-menu">
	<ul>
		<li><a href="<?=path?>/index.php"><i class="fas fa-home"></i><b><?=$lang['header']['home']?></b></a></li>
		<?php if(us_level==6): ?>
		<li class="pt-mobile-dash"><a href="<?=path?>/dashboard.php"><i class="fas fa-cog"></i><b><?=$lang['header']['dashboard']?></b></a></li>
		<li><a href="<?=path?>/users.php"><i class="far fa-user-circle"></i><b><?=$lang['header']['users']?></b></a></li>
		<?php endif; ?>
		<li><a href="<?=path?>/list.php"><i class="fas fa-sitemap"></i><b><?=$lang['header']['family']?></b></a></li>
		<?php if (!site_plans): ?>
		<li><a href="<?=path?>/plans.php"><i class="fas fa-trophy"></i><b><?=$lang['header']['plans']?></b></a></li>
		<?php endif; ?>
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."pages WHERE header = 1 ORDER BY id DESC LIMIT 5") or die ($db->error);
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
		?>
		<li><a href="<?=path?>/page.php?t=<?=($rs['slug']??'id')?>"><i class="<?=$rs['icon']?>"></i><b><?=$rs['title']?></b></a></li>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php $sql->close(); ?>
		<?php if($lg): ?>
		<li><a href="<?=path?>/details.php"><i class="far fa-address-card"></i><b><?=$lang['header']['details']?></b></a></li>
		<li><a href="#" class="logout"><i class="fas fa-power-off"></i><b><?=$lang['header']['logout']?></b></a></li>
		<?php endif; ?>
	</ul>
</div>


<?php if(us_level): ?>
<!-- New Tree -->
<div class="modal fade" id="addnewtree" tabindex="-1" role="dialog" aria-labelledby="addnewtreeLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addnewtreeLabel"><?=$lang['header']['fam']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


				<form class="pt-form" id="send-family-details">
					<label><?=$lang['indexpage']['form_fid_l']?></label>
					<div class="pt-input">
						<i class="far fa-user"></i>
						<input type="text" name="name" placeholder="<?=$lang['indexpage']['form_fid_i']?>">
					</div>
					<label><?=$lang['header']['fammanag']?></label>
					<div class="pt-input">
						<i class="fas fa-cogs"></i>
						<input type="text" class="form-control" name="planets" value="">
					</div>
					<?php if (fh_access('private')): ?>
					<div class="pt-input">
						<label class="small mb-0">
							<input class="tgl tgl-light" id="cbee3" value="1" name="check" type="checkbox" <?=(db_get("families", "public", $lg)?'':' checked')?>/>
							<label class="tgl-btn mt-3" for="cbee3"></label>
							<label><?=$lang['indexpage']['form_view']?></label>
						</label>
					</div>
					<label><?=$lang['indexpage']['form_vpass_l']?></label>
					<div class="pt-input">
						<i class="fas fa-lock"></i>
						<input type="password" name="vpass" placeholder="<?=$lang['indexpage']['form_vpass_i']?>">
					</div>
					<?php endif; ?>
					<input type="hidden" name="famid" value="" />
					<hr />
					<button type="submit" class="pt-button bg-0"><i class="fas fa-sign-in-alt"></i> <?=$lang['detailspage']['send']?></button>
				</form>


      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="pt-wrapper">

	<?php if (!fh_access("show_ads")): ?>
	
	<?php endif; ?>
