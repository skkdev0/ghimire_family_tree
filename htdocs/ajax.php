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



if ($pg == 'search') {
	$searsh = sc_sec($_POST["search"]);
	$aa = '';
	$sql = $db->query("SELECT * FROM " . prefix . "families WHERE name LIKE '%{$searsh}%' LIMIT 14");
	$aa .= '<ul class="pt-drop">';
	if (!empty($searsh)) {
		if ($sql->num_rows) {
			while ($rs = $sql->fetch_assoc()) {
				$aa .= "<li><a href='" . path . "/tree.php?id={$rs['id']}&t={$rs['slug']}'>{$rs['name']}</a></li>";
			}
		} else {
			$aa .= "<li>{$lang['no-result']}</li>";
		}
	} else {
		$aa .= "<li>{$lang['no-result']}</li>";
	}
	$aa .= '</ul>';
	echo $aa;
}

#############################
####                     ####
####    1) Tree Page     ####
####                     ####
#############################

# ** Edit Tree Member --

elseif ($pg == 'tree-edit') {
	$sql = $db->query("SELECT * FROM " . prefix . "members WHERE id = '{$id}'");
	$rs = $sql->fetch_assoc();
	$rs['birthdate'] = $rs['birthdate'] ? date("m/d/Y", $rs['birthdate']) : '';
	$rs['mariagedate'] = $rs['mariagedate'] ? date("m/d/Y", $rs['mariagedate']) : '';
	$rs['deathdate'] = $rs['deathdate'] ? date("m/d/Y", $rs['deathdate']) : '';
	$rs['useredit'] = $rs['user'] != us_name ? true : false;
	$rs['photos'] = '';
	$sql_i = $db->query("SELECT * FROM " . prefix . "images WHERE member = '{$id}'");
	if ($sql_i->num_rows) {
		while ($rs_i = $sql_i->fetch_assoc()) {
			$rs['photos'] .= '<a href="' . path . '/' . $rs_i['url'] . '" data-lightbox="image-' . $rs_i['id'] . '" data-alt="images-' . $rs_i['member'] . '" class="pt-images">
					<img src="' . path . '/' . $rs_i['url'] . '" onerror="this.src=\'' . nophoto . '\'" />
					<span class="pt-delete-album" rel="' . $rs_i['id'] . '"><i class="fas fa-trash-alt"></i></span>
				</a>';
		}
	}

	echo json_encode($rs);
}

# ** Delete album Image --

elseif ($pg == 'delete-image') {

	$member = db_get("images", "member", $id);
	$author = db_get("members", "author", $member);

	if (us_id == $author || us_level == 6) {
		db_delete("images", $id);
	}
}

# ** Edit Family Details --

elseif ($pg == 'family-edit') {
	$sql = $db->query("SELECT * FROM " . prefix . "families WHERE id = '{$id}'");
	if ($sql->num_rows) {
		$rs = $sql->fetch_assoc();
		if ($rs['author'] != $lg) {
			$rs = [];
		}
	}
	echo json_encode($rs);
}

# ** vPass Send --

elseif ($pg == 'vpass-send') {
	$id  = (int)($_POST['id']);
	$vpass  = sc_sec($_POST['vpass']);

	if (empty($vpass)) {
		$alert = ["type" => "danger", "msg" => fh_alerts($lang['alerts']['required'])];
	} else {
		$sql = db_select([
			'table'  => 'families',
			'where'  => 'id = "' . $id . '" && vpassword = "' . sc_pass($vpass) . '"'
		]);
		if ($sql->num_rows) {
			$rs = $sql->fetch_assoc();
			$_SESSION['vpass']  = $rs['id'];
			$alert = ["id" => $rs['id'], "type" => "success", "msg" => fh_alerts($lang['alerts']['login'], "success")];
		} else {
			$alert = ["type" => "danger", "msg" => fh_alerts($lang['alerts']['viewp'])];
		}
	}
	echo json_encode($alert);
}

# ** Heritage Send --

elseif ($pg == 'newheritage') {
	$family  = (int)($_POST['family']);
	$member  = (int)($_POST['member']);
	$heritage  = sc_sec($_POST['heritage']);

	if (!$family || !$member || empty($heritage)) {
		$alert = ["type" => "danger", "msg" => fh_alerts($lang['alerts']['required'])];
	} else {

		$ex_user = explode(',', $heritage);
		foreach ($ex_user as $key => $value) {
			$values = array_filter(preg_split("/\D+/", $value));
			$value = reset($values);
			$value = (int)($value);
			if ($family == $value) {
				$alert = ["type" => "danger", "msg" => fh_alerts("you can't herirate the same family!")];
			} elseif (!db_rows("families WHERE id = '{$value}' && author = '" . us_id . "'")) {
				$alert = ["type" => "danger", "msg" => fh_alerts($lang['alerts']['her_1'])];
			} elseif (db_rows("heritage WHERE heritage = '{$value}' && family = '{$family}'")) {
				$alert = ["type" => "danger", "msg" => fh_alerts($lang['alerts']['her_2'])];
			} elseif (db_rows("families WHERE id = '{$value}' && author = '" . us_id . "' && public = '1'")) {
				$alert = ["type" => "danger", "msg" => fh_alerts($lang['alerts']['her_3'])];
			} elseif (db_rows("heritage WHERE heritage = '{$family}' && family = '{$value}'")) {
				$alert = ["type" => "danger", "msg" => fh_alerts($lang['alerts']['her_4'])];
			} elseif (!db_rows("members WHERE family = '{$value}'")) {
				$alert = ["type" => "danger", "msg" => fh_alerts("you can't herirate this family because it is empty!")];
			} else {
				$data = [
					"family"   => "'{$family}'",
					"member"   => "'{$member}'",
					"date"     => "'" . time() . "'",
					"author"   => "'" . us_id . "'",
					"heritage" => "'{$value}'"
				];
				db_insert('heritage', $data);
				$alert = ["type" => "success", "msg" => $lang['alerts']['alldone']];
			}
		}
	}
	echo json_encode($alert);
}


# ** Delete Tree Member

elseif ($pg == "tree-delete") {
	if ($lg == db_get("members", "author", $id)) {
		db_delete("members", $id);
		db_delete("members", $id, "parent");
	}
}


# ** New Member

elseif ($pg == 'send-newmember') {

	include __DIR__ . '/configs/class.upload.php';

	$id = (int)($_POST['id']);
	$nid = (int)($_POST['nid']);
	$photo = sc_sec($_POST['photo']);


	$poll_imgurl = '';

	$dir_dest = 'uploads';
	$handle = new \Verot\Upload\Upload($_FILES['poll_file']);
	if ($handle->uploaded) {

		$handle->file_safe_name = true;
		$fileNewName = base64_encode($handle->file_src_name_body) . "_" . time();
		$handle->file_new_name_body = $fileNewName;

		$handle->image_resize          = true;
		$handle->image_ratio_crop      = true;
		$handle->image_y               = 250;
		$handle->image_x               = 250;

		$handle->Process($dir_dest);
		if ($handle->processed) {
			$poll_imgurl = $dir_dest . '/' . $handle->file_dst_name;
		} else {
			$alert = ["type" => "danger", "msg" => fh_alerts('File not uploaded to the wanted location<br />Error: ' . $handle->error)];
		}

		$handle->Clean();
	} else {
		$alert = ["type" => "danger", "msg" => fh_alerts('File not uploaded on the server<br />Error: ' . $handle->error)];
	}

	$photo = ($poll_imgurl) ? $poll_imgurl : $photo;

	function fh_strtotime($d)
	{
		if ($d) {
			$date = new DateTime($d);
			return $date->getTimestamp();
		} else {
			return $d;
		}
	}


	$gender      = (isset($_POST['gender']) ? (int)($_POST['gender']) : 0);
	$type        = (isset($_POST['type']) ? (int)($_POST['type']) : 0);
	$death       = (isset($_POST['death']) ? (int)($_POST['death']) : 0);

	$firstname   = isset($_POST['firstname']) ? sc_sec($_POST['firstname']) : '';

	if (empty($firstname)) {
		$alert = ["type" => "danger", "msg" => "firstname is required!"];
		echo json_encode($alert);
		exit;
	}




	$lastname    = isset($_POST['lastname']) ? sc_sec($_POST['lastname']) : '';
	$birthdate   = isset($_POST['birthdate']) ? (int)(fh_strtotime(sc_sec($_POST['birthdate']))) : 0;
	$mariagedate = isset($_POST['mariagedate']) ? (int)(fh_strtotime(sc_sec($_POST['mariagedate']))) : 0;
	$deathdate   = isset($_POST['deathdate']) ? (int)(fh_strtotime(sc_sec($_POST['deathdate']))) : 0;
	$photo       = isset($photo) ? $photo : '';
	$facebook    = isset($_POST['facebook']) ? sc_sec($_POST['facebook']) : '';
	$instagram   = isset($_POST['instagram']) ? sc_sec($_POST['instagram']) : '';
	$twitter     = isset($_POST['twitter']) ? sc_sec($_POST['twitter']) : '';
	$email       = isset($_POST['email']) ? sc_sec($_POST['email']) : '';
	$site        = isset($_POST['site']) ? sc_sec($_POST['site']) : '';
	$tel         = isset($_POST['tel']) ? sc_sec($_POST['tel']) : '';
	$mobile      = isset($_POST['mobile']) ? sc_sec($_POST['mobile']) : '';
	$birthplace  = isset($_POST['birthplace']) ? sc_sec($_POST['birthplace']) : '';
	$deathplace  = isset($_POST['deathplace']) ? sc_sec($_POST['deathplace']) : '';
	$profession  = isset($_POST['profession']) ? sc_sec($_POST['profession']) : '';
	$company     = isset($_POST['company']) ? sc_sec($_POST['company']) : '';
	$interests   = isset($_POST['interests']) ? sc_sec($_POST['interests']) : '';
	$bio         = isset($_POST['bio']) ? sc_sec($_POST['bio']) : '';
	$muser       = isset($_POST['user']) ? sc_sec($_POST['user']) : '';
	$avatar      = isset($_POST['avatar']) ? sc_sec($_POST['avatar']) : '';

	$ex_user = explode(',', $muser);
	$mm = '';
	foreach ($ex_user as $key => $value) {
		if (db_rows("users WHERE username = '" . sc_sec($value) . "'")) {
			$mm = sc_sec($value);
		}
	}

	$navatar = '';
	if (!empty($avatar)) $navatar = $avatar ? "assets/images/avatar/{$avatar}.jpg" : '';
	if (!empty($photo)) $photo  = $navatar  ? $navatar : $photo;

	$photo  = $navatar  ? $navatar : $photo;


	$data = [
		"firstname"  => "'" . $firstname . "'",
		"lastname"   => "'" . $lastname . "'",
		"gender"     => "'" . $gender . "'",
		"birthdate"  => "'" . $birthdate . "'",
		"mariagedate" => "'" . $mariagedate . "'",
		"deathdate"  => "'" . $deathdate . "'",
		"type"       => "'" . $type . "'",
		"death"      => "'" . $death . "'",
		"photo"      => "'" . $photo . "'",
		"facebook"   => "'" . $facebook . "'",
		"instagram"  => "'" . $instagram . "'",
		"twitter"    => "'" . $twitter . "'",
		"email"      => "'" . $email . "'",
		"site"       => "'" . $site . "'",
		"tel"        => "'" . $tel . "'",
		"mobile"     => "'" . $mobile . "'",
		"birthplace" => "'" . $birthplace . "'",
		"deathplace" => "'" . $deathplace . "'",
		"profession" => "'" . $profession . "'",
		"company"    => "'" . $company . "'",
		"interests"  => "'" . $interests . "'",
		"bio"        => "'" . $bio . "'"
	];


	if (!$id && !fh_access('members', (int)($_POST['family_id']))) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['members']];
		echo json_encode($alert);
		exit;
	}



	if ($id) {
		if (db_get('members', 'user', $id) != us_name) {
			$data["user"] = "'" . $mm . "'";
			$get_parent = (int)($_POST['parent']);
			$get_family = db_get('members', 'family', $get_parent);
		}
		db_update('members', $data, $id);
	} else {
		$data["user"] = "'" . $mm . "'";
		$get_parent = (int)($_POST['parent']);
		$get_family = db_get('members', 'family', $get_parent);
		$data["parent"] = ($nid ? "'0'" : "'" . $get_parent . "'");
		$data["family"] = ($nid ? "'" . $get_parent . "'" : "'" . $get_family . "'");

		$data["author"] = "'" . $lg . "'";
		$data["date"] = "'" . time() . "'";

		$data["parent"] = ($type == 4 ? (!db_get('members', 'parent', $get_parent) ? 0 : 1) : $data["parent"]);

		db_insert('members', $data);

		if ($type == 4) {
			if (!db_get('members', 'parent', $get_parent)) {
				db_update('members', ['type' => 1, 'parent' => "'" . db_get("members", "id", $firstname, 'firstname', 'ORDER BY id DESC LIMIT 1') . "'"], str_replace("'", '', $get_parent));
			}
		}
	}

	foreach ($ex_user as $key => $value) {
		if (db_rows("users WHERE username = '" . sc_sec($value) . "'")) {
			$nuser = db_get("users", "id", sc_sec($value), "username");
			$item = $id ? $id : db_get("members", "id", $firstname, "firstname", "&& family = '{$get_family}'");
			if (!db_rows("notifications WHERE user = '{$nuser}' && item = '{$item}'"))
				db_insert('notifications', ['author' => "'{$lg}'", 'user' => "'{$nuser}'", 'date' => "'" . time() . "'", 'item' => "'{$item}'", 'type' => "'member'"]);
		}
	}


	if (isset($_POST['images_tmp'])) {
		echo print_r($_POST['images_tmp'], true);
		foreach ($_POST['images_tmp'] as $key => $val) {
			$ff = sc_sec($val);
			if (file_exists(__DIR__ . '/' . $ff)) {
				$answer_i_rename = 'uploads/users/' . sc_folderName(us_name) . str_replace('uploads/temp', '', $ff);
				newImgFolder(__DIR__ . '/uploads/users/' . sc_folderName(us_name));
				rename($ff, $answer_i_rename);
				$mma = ($id ? $id : db_get("members", "id", $get_family, 'family', 'ORDER BY id DESC LIMIT 1'));
				db_insert('images', [
					"family" => "'" . (int)($get_family) . "'",
					"date"   => "'" . time() . "'",
					"member" => "'" . $mma . "'",
					"url"    => "'" . $answer_i_rename . "'"
				]);
			}
		}
	}

	$alert = ["type" => "success", "msg" => $lang['alerts']['alldone']];
	echo json_encode($alert);
}

# ** Family Details

elseif ($pg == 'family-details') {
	$name   = sc_sec($_POST['name']);
	$vpass  = (isset($_POST['vpass']) ? sc_sec($_POST['vpass']) : '');
	$moderators  = sc_sec($_POST['planets']);
	$check  = (isset($_POST['check']) ? 0 : 1);
	$public = (!fh_access('private') ? 0 : $check);
	$famid  = (isset($_POST['famid']) ? (int)($_POST['famid']) : 0);

	if (empty($name)) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['name']];
	} elseif (db_rows("families WHERE name = '{$name}'") && !$famid) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['famexist']];
	} elseif ($famid && !db_rows("families WHERE id = '{$famid}' && author='{$lg}'")) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['wrong']];
	} else {
		$ex_mod = explode(',', $moderators);
		$mm = [];
		foreach ($ex_mod as $key => $value) {
			if (db_rows("users WHERE username = '" . sc_sec($value) . "'")) {
				$mm[] = sc_sec($value);
			}
		}

		$data = [
			"name"       => "'{$name}'",
			"slug"       => "'" . $slugify->slugify($name) . "'",
			"moderators" => "'" . implode(',', $mm) . "'",
			"public"     => "'" . $public . "'"
		];

		if (!fh_access('families') && !$famid) {
			$alert = ["type" => "danger", "msg" => $lang['alerts']['families']];
			echo json_encode($alert);
			exit;
		}

		if ($vpass) {
			$data['vpassword'] = "'" . sc_pass($vpass) . "'";
		}

		if ($famid) {
			db_update('families', $data, $famid);
		} else {
			$data['date'] = "'" . time() . "'";
			$data['author'] = "'" . $lg . "'";
			db_insert('families', $data);
		}

		foreach ($ex_mod as $key => $value) {
			if (db_rows("users WHERE username = '" . sc_sec($value) . "'")) {
				$nuser = db_get("users", "id", sc_sec($value), "username");
				$item = $famid ? $famid : db_get("families", "id", $name, "name");
				if (!db_rows("notifications WHERE user = '{$nuser}' && item = '{$item}'"))
					db_insert('notifications', ['author' => "'{$lg}'", 'user' => "'{$nuser}'", 'date' => "'" . time() . "'", 'item' => "'{$item}'", 'type' => "'moderator'"]);
			}
		}

		$alert = ["type" => "success", "msg" => $lang['alerts']['alldone']];
	}
	echo json_encode($alert);
}


# ** Upload photos

elseif ($pg == "upload") {

	include __DIR__ . '/configs/class.upload.php';

	$output = [];

	if (isset($_FILES['images'])) {
		$files = [];
		foreach ($_FILES['images'] as $k => $l) {
			foreach ($l as $i => $v) {
				if (!array_key_exists($i, $files))
					$files[$i] = array();
				$files[$i][$k] = $v;
			}
		}

		$paths = [];
		$file_output = [];
		$i = 0;
		foreach ($files as $file) {
			$handle = new \Verot\Upload\Upload($file);
			if ($handle->uploaded) {
				$handle->allowed            = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');
				$handle->file_new_name_body = md5(uniqid());
				$handle->Process(__DIR__ . '/uploads/temp/');
				if ($handle->processed) {
					$file_output[$i]['message'] = 'OK';
					$file_output[$i]['success'] = true;
					$file_output[$i]['path']    = "uploads/temp" . DIRECTORY_SEPARATOR . $handle->file_dst_name;
					$file_output[$i]['name']    = $handle->file_src_name_body;
					$paths[]               = "uploads/temp" . DIRECTORY_SEPARATOR . $handle->file_dst_name;
				} else {
					$output[$i]['message'] = 'Error: ' . $handle->error;
					$output[$i]['success'] = false;
					$output[$i]['path']    = '';
					$output[$i]['name']    = '';
				}
			} else {
				$output[$i]['message'] = 'Error: ' . $handle->error;
				$output[$i]['success'] = false;
				$output[$i]['path']    = '';
				$output[$i]['name']    = '';
			}
			unset($handle);
			$i++;
		}
	}

	$output['file_output'] = $file_output;
	$output['paths'] = $paths;
	echo json_encode($output);
}





#############################
####                     ####
####    2) User Page     ####
####                     ####
#############################

# ** Send User Registration --

elseif ($pg == 'user-send') {
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);
	$email = sc_sec($_POST['email']);

	if (empty($name) || empty($pass) || empty($email)) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['required']];
	} elseif (!check_email($email)) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['correctemail']];
	} elseif (db_rows("users WHERE email = '{$email}'")) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['existemail']];
	} elseif (db_rows("users WHERE username = '{$name}'")) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['existusername']];
	} else {

		$token     = bin2hex(openssl_random_pseudo_bytes(16));
		$reset_url = path . "/email-verification.php?action=reset&token=" . $token . "&t=" . sha1($email);

		$data = [
			"username"     => "'" . sc_sec($_POST['name']) . "'",
			"password" => "'" . sc_pass(sc_sec($_POST['pass'])) . "'",
			"date"     => "'" . time() . "'",
			"status"     => "'" . site_register . "'",
			"token"     => "'{$token}'",
			"plan"     => "'1'",
			"email"    => "'" . sc_sec($_POST['email']) . "'"
		];

		if (!db_rows("users")) {
			$data['level'] = "'6'";
		}

		if (!site_register) {
			$alert = ["type" => "success", "msg" => $lang['alerts']['regsuccess']];
		} elseif (site_register == 2) {


			$subject = "Email Verification";

			$mail->addAddress($email, $name);
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = fh_email_tmp($name, $email, $reset_url);
			if ($mail->send()) {
				$alert = ["type" => "success", "msg" => $lang['alerts']['regsuccess1']];
			}
		} else {
			$alert = ["type" => "success", "msg" => $lang['alerts']['regsuccess2']];
		}

		db_insert('users', $data);
	}
	echo json_encode($alert);
}

# ** Send User Edit Details --

elseif ($pg == 'user-send-details') {
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);
	$email = sc_sec($_POST['email']);
	$photo = sc_sec($_POST['reg_photo']);
	$plan = isset($_POST['plan']) ? sc_sec($_POST['plan']) : 0;
	$level = isset($_POST['level']) ? sc_sec($_POST['level']) : 1;
	$reg_uid = sc_sec($_POST['reg_id']);

	$u_id = ($reg_uid && us_level == 6 ? $reg_uid : us_id);

	$u_name = ($reg_uid && us_level == 6 ? $name : us_name);
	$u_email = ($reg_uid && us_level == 6 ? $email : us_email);
	$u_plan = ($reg_uid && us_level == 6 ? $plan : us_plan);
	$u_level = ($reg_uid && us_level == 6 ? $level : us_level);

	if (empty($name) || empty($email)) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['required']];
	} elseif (!check_email($email)) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['correctemail']];
	} elseif ($u_email != $email && db_rows("users WHERE email = '{$email}'")) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['existemail']];
	} elseif ($u_name != $name && db_rows("users WHERE username = '{$name}'")) {
		$alert = ["type" => "danger", "msg" => $lang['alerts']['existusername']];
	} else {
		$data = [
			"username" => "'" . sc_sec($_POST['name']) . "'",
			"updated_at" => "'" . time() . "'",
			"photo"     => "'{$photo}'",
			"email"    => "'{$u_email}'",
			"plan"    => "'{$u_plan}'",
		];
		if ($u_id != 1) {
			$data['level'] = "'{$u_level}'";
		}
		if ($pass) {
			$data['password'] = "'" . sc_pass(sc_sec($_POST['pass'])) . "'";
		}
		db_update('users', $data, $u_id);
		$alert = ["type" => "success", "msg" => $lang['alerts']['famsuccess']];
	}
	echo json_encode($alert);
}


# ** Login

elseif ($pg == 'login-send') {
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);

	if (empty($name) || empty($pass)) {
		$alert = ["type" => "danger", "msg" => "All fields are required!"];
	} else {
		if (db_rows('users WHERE username = "' . $name . '" || email = "' . $name . '"')) {
			$sql = db_select([
				'table'  => 'users',
				'where'  => '(username = "' . $name . '" || email = "' . $name . '") && password = "' . sc_pass($pass) . '"'
			]);
			if ($sql->num_rows) {
				$rs = $sql->fetch_assoc();
				if ($rs['status'] == 0) {
					$_SESSION['login']  = $rs['id'];
					$alert = ["id" => $rs['id'], "type" => "success", "msg" => $lang['alerts']['logsuccess']];
				} elseif ($rs['status'] == 1) {
					$alert = ["id" => $rs['id'], "type" => "success", "msg" => $lang['alerts']['logapprov']];
				} else {
					$alert = ["id" => $rs['id'], "type" => "success", "msg" => $lang['alerts']['logverif']];
				}
			} else {
				$alert = ["type" => "danger", "msg" => $lang['alerts']['logerror']];
			}
		} else {
			$alert = ["type" => "danger", "msg" => $lang['alerts']['logerror']];
		}
	}
	echo json_encode($alert);
}


# ** Logout

elseif ($pg == "logout") {

	session_unset();
	session_destroy();
}

# ** Uplaod Image User Details

elseif ($pg == 'imageupload') {
	if (us_level) {
		include __DIR__ . '/configs/class.upload.php';
		$imgurl = '';
		$dir_dest = 'uploads';

		$handle = new \Verot\Upload\Upload($_FILES['file']);
		if ($handle->uploaded) {
			$handle->file_safe_name = true;
			$fileNewName = base64_encode($handle->file_src_name_body) . "_" . time();
			$handle->file_new_name_body = $fileNewName;

			$handle->image_resize          = true;
			$handle->image_ratio_crop      = true;
			$handle->image_y               = 250;
			$handle->image_x               = 250;

			$handle->process($dir_dest);
			if ($handle->processed) {
				$imgurl = $dir_dest . '/' . $handle->file_dst_name;
			} else {
			}
			$handle->clean();
		}

		echo path . "/" . $imgurl;
	}
}




#############################
####                     ####
####    2) Admin Page    ####
####                     ####
#############################

elseif ($pg == 'adminstats') {
	if (us_level == 6) {
		$aa = [];
		if ($request == "daily") {
			$start = new DateTime('now');
			$end = new DateTime('- 7 day');
			$diff = $end->diff($start);
			$interval = DateInterval::createFromDateString('-1 day');
			$period = new DatePeriod($start, $interval, $diff->days);

			foreach ($period as $date) {
				$aa['data'][] = db_rows("families WHERE FROM_UNIXTIME(date,'%m-%d-%Y') = '" . $date->format('m-d-Y') . "'");
				$aa['labels'][] = $date->format('M d');
			}

			$aa['data'] = array_reverse($aa['data']);
			$aa['labels'] = array_reverse($aa['labels']);
			$aa['title'] = "Families " . $lang['dashboard']['stats_line_d'];
		} elseif ($request == "monthly") {
			$aa = [];
			for ($i = 1; $i <= 12; $i++) {
				$aa['data'][] = db_rows("families WHERE MONTH(FROM_UNIXTIME(date)) = '{$i}'");
				$aa['labels'][] = date('F', mktime(0, 0, 0, $i, 10));
			}
			$aa['title'] = "Families " . $lang['dashboard']['stats_line_m'];
		}
		echo json_encode($aa);
	}
} elseif ($pg == 'adminstatsbars') {
	if (us_level == 6) {
		$aa = [];
		if ($request == "daily") {
			$start = new DateTime('now');
			$end = new DateTime('- 7 day');
			$diff = $end->diff($start);
			$interval = DateInterval::createFromDateString('-1 day');
			$period = new DatePeriod($start, $interval, $diff->days);

			foreach ($period as $date) {
				$aa['data'][] = db_rows("users WHERE FROM_UNIXTIME(date,'%m-%d-%Y') = '" . $date->format('m-d-Y') . "'");
				$aa['labels'][] = $date->format('M d');
				$colors = randomColor();
				$aa['colors'][] = "#" . $colors['hex'];
			}

			$aa['data'] = array_reverse($aa['data']);
			$aa['labels'] = array_reverse($aa['labels']);
			$aa['title'] = "Users " . $lang['dashboard']['stats_line_d'];
		} elseif ($request == "monthly") {
			$aa = [];
			for ($i = 1; $i <= 12; $i++) {
				$aa['data'][] = db_rows("users WHERE MONTH(FROM_UNIXTIME(date)) = '{$i}'");
				$aa['labels'][] = date('F', mktime(0, 0, 0, $i, 10));
				$colors = randomColor();
				$aa['colors'][] = "#" . $colors['hex'];
			}
			$aa['title'] = "Users " . $lang['dashboard']['stats_line_m'];
		}
		echo json_encode($aa);
	}
} elseif ($pg == 'tree-addpar') {
	echo db_get("members", "parent", $id);
} elseif ($pg == 'changelang') {
	$id = isset($_GET['id']) ? sc_sec($_GET['id']) : 'en';
	setcookie("lang", $id, time() + 3600 * 24 * 30 * 6);
} elseif ($pg == 'newlang') {
	$sql = $db->query("SELECT content FROM " . prefix . "languages WHERE id = 1") or die($db->error);
	$rs = $sql->fetch_assoc();

	$data = [
		"language"  => "'LANGUAGE NAME'",
		"short"     => "'ENG'",
		"isdefault" => "'0'",
		"content"   => "'" . addslashes($rs['content']) . "'",
	];
	db_insert("languages", $data);
} elseif ($pg == 'sendlanguage') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6) {

		$lang_name    = isset($_POST['lang_name']) ? sc_sec($_POST['lang_name'])   : "";
		$lang_short   = isset($_POST['lang_short']) ? sc_sec($_POST['lang_short']) : "";
		$lang_default = isset($_POST['lang_default']) ? 1                          : 0;
		$lang_id      = isset($_POST['lang_id']) ? (int)($_POST['lang_id'])        : 0;

		if (empty($lang_name) || empty($lang_short)) {
			$alert = [
				'type'  => 'danger',
				'alert' => 'title is required'
			];
		} else {

			$language = [];
			$keys = array_keys($lang);


			foreach (sc_sec(explode("\r\n", $_POST['language']['a'])) as $k => $v) {
				$language[$keys[$k]] = sc_sec($v);
			}

			foreach ($_POST['language'] as $k => $v) {
				if ($k != 'a') {
					$keys = array_keys($lang[$k]);
					$vals = sc_sec(explode("\r\n", $v));
					foreach ($keys as $kk => $vv) {
						$language[$k][$vv] = $vals[$kk];
					}
				}
			}


			$var = json_encode($language, JSON_UNESCAPED_UNICODE);
			$var = addslashes(str_replace(array("\r", "\n"), '', $var));

			$data = [
				"language"  => "'{$lang_name}'",
				"short"     => "'{$lang_short}'",
				"isdefault" => "'{$lang_default}'",
				"content"   => "'{$var}'",
			];


			if ($lang_default) {
				$db->query("UPDATE " . prefix . "languages SET isdefault = '0'");
			}

			if ($lang_id) {
				$data["updated_at"] = "'" . time() . "'";
				db_update("languages", $data, $lang_id);
			} else {
				$data["created_at"] = "'" . time() . "'";
				db_insert("languages", $data);
			}

			$alert = [
				'type'  => 'success',
				'alert' => $lang['alerts']['alldone']
			];
		}






		echo json_encode($alert);
	}
} elseif ($pg == 'sendsettings') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6) {

		$pg_title         = sc_sec($_POST['site_title']);
		$pg_description   = sc_sec($_POST['site_description']);
		$pg_keywords      = sc_sec($_POST['site_keywords']);
		$pg_url           = sc_sec($_POST['site_url']);
		$pg_reg_status    = isset($_POST['reg_status']) ? (int)($_POST['reg_status']) : 0;
		$pg_site_r_status = isset($_POST['site_register_status']) ? (int)($_POST['site_register_status']) : 0;
		$pg_site_f_status = isset($_POST['site_families_status']) ? (int)($_POST['site_families_status']) : 0;
		$pg_color1           = sc_sec($_POST['color1']);
		$pg_color2           = sc_sec($_POST['color2']);
		$pg_color2           = sc_sec($_POST['color2']);
		$pg_color3           = sc_sec($_POST['color3']);
		$pg_color4           = sc_sec($_POST['color4']);
		$pg_color5           = sc_sec($_POST['color5']);
		$pg_color6           = sc_sec($_POST['color6']);
		$pg_color7           = sc_sec($_POST['color7']);
		$pg_color9           = sc_sec($_POST['color9']);
		$pg_color8           = sc_sec($_POST['color8']);
		$pg_color10           = sc_sec($_POST['color10']);
		//$site_ads1           = $db->real_escape_string($_POST['site_ads1']);


		$site_paypal_live          = isset($_POST['site_paypal_live']) ? (int)($_POST['site_paypal_live']) : 0;
		$site_paypal_id            = sc_sec($_POST['site_paypal_id']);
		$site_paypal_client_id     = sc_sec($_POST['site_paypal_client_id']);
		$site_paypal_client_secret = sc_sec($_POST['site_paypal_client_secret']);
		$site_currency_name        = sc_sec($_POST['site_currency_name']);
		$site_currency_symbol      = sc_sec($_POST['site_currency_symbol']);

		$site_smtp            = isset($_POST['site_smtp']) ? (int)($_POST['site_smtp']) : 0;
		$site_smtp_host       = sc_sec($_POST['site_smtp_host']);
		$site_smtp_username   = sc_sec($_POST['site_smtp_username']);
		$site_smtp_password   = sc_sec($_POST['site_smtp_password']);
		$site_smtp_encryption = sc_sec($_POST['site_smtp_encryption']);
		$site_smtp_auth       = sc_sec($_POST['site_smtp_auth']);
		$site_smtp_port       = sc_sec($_POST['site_smtp_port']);

		$site_noreply       = sc_sec($_POST['site_noreply']);

		$site_plans = isset($_POST['site_plans']) ? 1 : 0;

		if (empty($pg_title)) {
			$alert = [
				'type'  => 'danger',
				'alert' => 'title is required'
			];
		} else {
			db_update_global('site_title', $pg_title);
			db_update_global('site_description', $pg_description);
			db_update_global('site_keywords', $pg_keywords);
			db_update_global('site_url', $pg_url);
			db_update_global('site_register', $pg_reg_status);
			db_update_global('site_register_status', $pg_site_r_status);
			db_update_global('site_families_status', $pg_site_f_status);
			db_update_global('color1', $pg_color1);
			db_update_global('color2', $pg_color2);
			db_update_global('color2', $pg_color2);
			db_update_global('color3', $pg_color3);
			db_update_global('color4', $pg_color4);
			db_update_global('color5', $pg_color5);
			db_update_global('color6', $pg_color6);
			db_update_global('color7', $pg_color7);
			db_update_global('color9', $pg_color9);
			db_update_global('color8', $pg_color8);
			db_update_global('color10', $pg_color10);
			//db_update_global('site_ads1', $site_	);


			db_update_global('site_paypal_live', $site_paypal_live);
			db_update_global('site_paypal_id', $site_paypal_id);
			db_update_global('site_paypal_client_id', $site_paypal_client_id);
			db_update_global('site_paypal_client_secret', $site_paypal_client_secret);
			db_update_global('site_currency_name', $site_currency_name);
			db_update_global('site_currency_symbol', $site_currency_symbol);

			db_update_global('site_smtp', $site_smtp);
			db_update_global('site_smtp_host', $site_smtp_host);
			db_update_global('site_smtp_username', $site_smtp_username);
			db_update_global('site_smtp_password', $site_smtp_password);
			db_update_global('site_smtp_encryption', $site_smtp_encryption);
			db_update_global('site_smtp_auth', $site_smtp_auth);
			db_update_global('site_smtp_port', $site_smtp_port);

			db_update_global('site_noreply', $site_noreply);

			db_update_global('site_plans', $site_plans);

			$alert = [
				'type'  => 'success',
				'alert' => ($lang['alerts']['alldone'])
			];
		}
		echo json_encode($alert);
	}
} elseif ($pg == 'sendplans') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6) {
		$site_plans = isset($_POST['site_plans']) ? 1 : 0;
		$id = isset($_POST['id']) ? (int)($_POST['id']) : 0;
		$plan_arr = [];

		$sql = $db->query("DESCRIBE " . prefix . "plans");
		while ($row = $sql->fetch_array()) {
			if ($row['Field'] != 'id') {
				if ($row['Type'] == "tinyint(1)") {
					$vv = isset($_POST[$row['Field']]) ? 1 : 0;
				} elseif ($row['Type'] == "int(11)") {
					$vv = isset($_POST[$row['Field']]) ? (int)($_POST[$row['Field']]) : 0;
				} elseif ($row['Type'] == "float(10,2)") {
					$vv = isset($_POST[$row['Field']]) ? (float)($_POST[$row['Field']]) : 0;
				} else {
					$vv = isset($_POST[$row['Field']]) ? sc_sec($_POST[$row['Field']]) : '';
				}
				$plan_arr["{$row['Field']}"] = "'$vv'";
			}
		}
		if ($id) {
			db_update("plans", $plan_arr, $id);
		} else {
			db_insert("plans", $plan_arr);
		}


		$alert = [
			'type'  => 'success',
			'alert' => ($lang['dashboard']['planalert'])
		];

		print_r($_POST);

		echo json_encode($alert);
	}
} elseif ($pg == 'editplan') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {


		$id = isset($_POST['id']) ? (int)($_POST['id']) : 0;
		$plan_arr = [];

		if ($id == 9999) {
			$sql = $db->query("SELECT * FROM " . prefix . "plans");
			$rs = [];
			while ($row = $sql->fetch_array()) {
				$rs[$row['id']] = $row;
			}
		} else {
			$rs = db_rs("plans WHERE id = '{$id}'");
		}


		echo json_encode($rs);
	}
} elseif ($pg == 'sendpage') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6) {

		$pg_title     = sc_sec($_POST['pg_title']);
		$pg_content   = sc_sec($_POST['pg_content']);
		$pg_icon      = sc_sec($_POST['pg_icon']);
		$pg_header    = isset($_POST['pg_header']) ? 1 : 0;
		$pg_id    = isset($_POST['pg_id']) ? (int)($_POST['pg_id']) : 0;

		if (empty($pg_title) || empty($pg_content)) {
			$alert = [
				'type'  => 'danger',
				'alert' => 'title and content are required'
			];
		} else {
			$data = [
				'icon' => "'{$pg_icon}'",
				'title' => "'{$pg_title}'",
				"slug"       => "'" . $slugify->slugify($pg_title) . "'",
				'content' => "'{$pg_content}'",
				'header' => "'{$pg_header}'",
				'date'  => "'" . time() . "'"
			];
			if ($pg_id) {
				db_update('pages', $data, $pg_id);
			} else {
				db_insert('pages', $data);
			}


			$alert = [
				'type'  => 'success',
				'alert' => $lang['alerts']['alldone']
			];
		}
		echo json_encode($alert);
	}
} elseif ($pg == 'sendpaypalplan') {

	include __DIR__ . '/sendpaypalplan.php';
} elseif ($pg == 'userstatus') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6) {

		$pg_user     = sc_sec($_POST['value']);
		$pg_status   = sc_sec($_POST['status']);

		if (!db_rows("users WHERE id = '{$pg_user}'")) {
			$alert = [
				'type'  => 'danger',
				'alert' => 'this user isnt exist'
			];
		} else {

			$status = $pg_status == 'true' ? 0 : 1;

			db_update('users', ["status" => "'{$status}'"], $pg_user);


			$alert = [
				'type'  => 'success',
				'alert' => $lang['alerts']['alldone']
			];
		}
		echo json_encode($alert);
	}
} elseif ($pg == 'familystatus') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6) {

		$pg_user     = sc_sec($_POST['value']);
		$pg_status   = sc_sec($_POST['status']);

		if (!db_rows("families WHERE id = '{$pg_user}'")) {
			$alert = [
				'type'  => 'danger',
				'alert' => 'this family isnt exist'
			];
		} else {

			$status = $pg_status == 'true' ? 0 : 1;

			db_update('families', ["status" => "'{$status}'"], $pg_user);


			$alert = [
				'type'  => 'success',
				'alert' => $lang['alerts']['alldone']
			];
		}
		echo json_encode($alert);
	}
} elseif ($pg == 'delete') {

	if (us_level == 6) {
		db_delete($request, $id);
		if ($request == "families")
			db_delete("members", $id, "family");
	}
} elseif ($pg == 'read-not') {

	if (us_level) {
		if (db_rows("notifications WHERE user = '{$lg}' && id = '{$id}' && nread = '0'"))
			db_update("notifications", ["nread" => "'1'"], $id);
	}
} elseif ($pg == 'resetpassword') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!us_level) {
			$reg_email   = sc_sec($_POST['reset_email']);

			if (empty($reg_email)) {
				$alert = [
					'type'  => 'danger',
					'alert' => $lang['alerts']['required']
				];
			} elseif (!db_rows("users WHERE email = '" . $reg_email . "'")) {
				$alert = [
					'type'  => 'danger',
					'alert' => $lang['alerts']['reseterror']
				];
			} else {


				$login     = db_get('users', 'username', $reg_email, 'email');
				$token     = bin2hex(openssl_random_pseudo_bytes(16));
				$reset_url = path . "/password-reset.php?action=reset&token=" . $token . "&t=" . sha1($reg_email);

				$subject = "Password Reset";


				$mail->addAddress($reg_email, $login);
				$mail->isHTML(true);
				$mail->Subject = $subject;
				$mail->Body    = fh_reset_tmp($login, $reg_email, $reset_url);
				if ($mail->send()) {
					$data = [
						'email' => "'{$reg_email}'",
						'token' => "'{$token}'",
						'date'  => "'" . time() . "'"
					];
					db_insert('reset_passwords', $data);

					$alert = [
						'type'  => 'success',
						'alert' => $lang['alerts']['resetsuccess']
					];
				} else {
					$alert = [
						'type'  => 'danger',
						'alert' => $lang['alerts']['wrong']
					];
				}
			}

			echo json_encode($alert);
		}
	}
} elseif ($pg == 'sendpassword') {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!us_level) {
			$reg_token  = sc_sec($_POST['token']);
			$reg_t      = sc_sec($_POST['t']);
			$reg_pass   = sc_sec($_POST['reg_pass']);
			$reg_repass = sc_sec($_POST['reg_repass']);

			$reg_email   = db_get('users', 'email', $reg_t, 'sha1(email)');
			$token_email = db_get('reset_passwords', 'email', $reg_token, 'token');

			if (!$reg_email || $reg_email != $token_email) {
				$alert = [
					'type'  => 'danger',
					'alert' => $lang['alerts']['wrong']
				];
			} elseif (empty($reg_pass) || empty($reg_repass)) {
				$alert = [
					'type'  => 'danger',
					'alert' => $lang['alerts']['required']
				];
			} elseif (strlen($reg_pass) < 6 || strlen($reg_pass) > 32) {
				$alert = [
					'type'  => 'danger',
					'alert' => $lang['alerts']['pass1']
				];
			} elseif ($reg_pass != $reg_repass) {
				$alert = [
					'type'  => 'danger',
					'alert' => $lang['alerts']['pass2']
				];
			} else {

				db_update('reset_passwords', ['status' => '1'], $reg_token, 'token');
				db_update('users', ['password' => "'" . sc_pass($reg_pass) . "'"], $reg_email, 'email');

				$alert = [
					'type'  => 'success',
					'alert' => $lang['alerts']['pass3']
				];
			}

			echo json_encode($alert);
		}
	}
}
