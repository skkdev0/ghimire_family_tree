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
?>

<div class="pt-list">
	<div class="pt-title">
		<span><i class="far fa-envelope"></i></span> <b><?= $lang['header']['emailver'] ?></b>
	</div>

	<div class="pt-list-item">
		<?php
		$sql = $db->query("SELECT * FROM " . prefix . "users WHERE status = 2 && token = '" . sc_sec($_GET['token']) . "' LIMIT 1");
		if ($sql->num_rows) {
			$rs = $sql->fetch_assoc();
			if (sha1($rs['email']) == sc_sec($_GET['t'])) {
				echo fh_alerts($lang['alerts']['emailver'], "success");
				db_update("users", ["status" => "'0'"], sc_sec($_GET['token']), 'token');
			}
		}
		?>
	</div>
</div>
<?php
include __DIR__ . "/footer.php";
?>