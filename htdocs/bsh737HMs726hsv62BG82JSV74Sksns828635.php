<?php
error_reporting(E_ALL);
ini_set('display_errors', 'Off');
include __DIR__ . '/configs/connection.php';

session_start();

// Password protection
$correct_password = "admin123"; // यो password लाई परिवर्तन गर्नुहोस्
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $correct_password) {
            $_SESSION['authenticated'] = true;
        } else {
            $error = "गलत पासवर्ड!";
        }
    }
    
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        ?>
        <!DOCTYPE html>
        <html lang="ne">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>लगइन गर्नुहोस्</title>
            <style>
                body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
                .login-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 300px; }
                .login-container h2 { text-align: center; color: #333; margin-bottom: 20px; }
                .form-group { margin-bottom: 15px; }
                .form-group label { display: block; margin-bottom: 5px; color: #555; }
                .form-group input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
                .btn { background: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
                .btn:hover { background: #0056b3; }
                .error { color: red; text-align: center; margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <div class="login-container">
                <h2>लगइन गर्नुहोस्</h2>
                <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="password">पासवर्ड:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn">लगइन गर्नुहोस्</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
}

// Database operations
$message = '';

// Table name with prefix
$table_name = 'Ghimire_users';

// Delete user
if (isset($_GET['delete_id'])) {
    $delete_id = $db->real_escape_string($_GET['delete_id']);
    $sql = "DELETE FROM $table_name WHERE id = '$delete_id'";
    if ($db->query($sql)) {
        $message = "<div class='success'>प्रयोगकर्ता सफलतापूर्वक मेटाइयो!</div>";
    } else {
        $message = "<div class='error'>मेटाउँदा त्रुटि भयो: " . $db->error . "</div>";
    }
}

// Update user
if (isset($_POST['update'])) {
    $id = $db->real_escape_string($_POST['id']);
    $username = $db->real_escape_string($_POST['username']);
    $status = $db->real_escape_string($_POST['status']);
    $family = $db->real_escape_string($_POST['family']);
    $firstname = $db->real_escape_string($_POST['firstname']);
    $lastname = $db->real_escape_string($_POST['lastname']);
    $gender = $db->real_escape_string($_POST['gender']);
    $birth = $db->real_escape_string($_POST['birth']);
    $death = $db->real_escape_string($_POST['death']);
    $type = $db->real_escape_string($_POST['type']);
    $photo = $db->real_escape_string($_POST['photo']);
    $email = $db->real_escape_string($_POST['email']);
    $site = $db->real_escape_string($_POST['site']);
    $tel = $db->real_escape_string($_POST['tel']);
    $mobile = $db->real_escape_string($_POST['mobile']);
    $birthplace = $db->real_escape_string($_POST['birthplace']);
    $deathplace = $db->real_escape_string($_POST['deathplace']);
    $profession = $db->real_escape_string($_POST['profession']);
    $company = $db->real_escape_string($_POST['company']);
    $interests = $db->real_escape_string($_POST['interests']);
    $bio = $db->real_escape_string($_POST['bio']);
    $level = $db->real_escape_string($_POST['level']);
    $parent = $db->real_escape_string($_POST['parent']);
    $birthday = $db->real_escape_string($_POST['birthday']);
    $birthmonth = $db->real_escape_string($_POST['birthmonth']);
    $birthyear = $db->real_escape_string($_POST['birthyear']);
    $deathday = $db->real_escape_string($_POST['deathday']);
    $deathmonth = $db->real_escape_string($_POST['deathmonth']);
    $deathyear = $db->real_escape_string($_POST['deathyear']);
    $birthdate = $db->real_escape_string($_POST['birthdate']);
    $mariagedate = $db->real_escape_string($_POST['mariagedate']);
    $deathdate = $db->real_escape_string($_POST['deathdate']);
    $facebook = $db->real_escape_string($_POST['facebook']);
    $instagram = $db->real_escape_string($_POST['instagram']);
    $twitter = $db->real_escape_string($_POST['twitter']);
    $plan = $db->real_escape_string($_POST['plan']);
    $slug = $db->real_escape_string($_POST['slug']);
    $frequency = $db->real_escape_string($_POST['frequency']);
    
    $sql = "UPDATE $table_name SET 
        username = '$username', status = '$status', family = '$family', firstname = '$firstname', lastname = '$lastname', 
        gender = '$gender', birth = '$birth', death = '$death', type = '$type', photo = '$photo', email = '$email', 
        site = '$site', tel = '$tel', mobile = '$mobile', birthplace = '$birthplace', deathplace = '$deathplace', 
        profession = '$profession', company = '$company', interests = '$interests', bio = '$bio', level = '$level', 
        parent = '$parent', birthday = '$birthday', birthmonth = '$birthmonth', birthyear = '$birthyear', deathday = '$deathday', 
        deathmonth = '$deathmonth', deathyear = '$deathyear', birthdate = '$birthdate', mariagedate = '$mariagedate', deathdate = '$deathdate', 
        facebook = '$facebook', instagram = '$instagram', twitter = '$twitter', plan = '$plan', slug = '$slug', frequency = '$frequency',
        updated_at = UNIX_TIMESTAMP()
        WHERE id = '$id'";
    
    if ($db->query($sql)) {
        $message = "<div class='success'>प्रयोगकर्ता सफलतापूर्वक अपडेट भयो!</div>";
    } else {
        $message = "<div class='error'>अपडेट गर्दा त्रुटि भयो: " . $db->error . "</div>";
    }
}

// Get all users
$users_result = $db->query("SELECT id, username, email, firstname, lastname, status, level, plan FROM $table_name");
$users = [];
if ($users_result) {
    $users = $users_result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<div class='error'>त्रुटि: " . $db->error . "</div>";
}

// Get single user for editing
$edit_user = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $db->real_escape_string($_GET['edit_id']);
    $result = $db->query("SELECT * FROM $table_name WHERE id = '$edit_id'");
    if ($result && $result->num_rows > 0) {
        $edit_user = $result->fetch_assoc();
    } else {
        echo "<div class='error'>प्रयोगकर्ता भेटिएन!</div>";
    }
}

// Status mapping
$status_options = [
    0 => 'सक्रिय (Active)',
    1 => 'भेरिफाई गर्न बाँकी (Pending Verification)', 
    2 => 'ईमेल भेरिफाई गर्न बाँकी (Email Verification Pending)'
];
?>

<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>प्रयोगकर्ता व्यवस्थापन</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .user-list { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        tr:hover { background-color: #f5f5f5; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; margin: 2px; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-update { background: #28a745; color: white; }
        .btn-cancel { background: #6c757d; color: white; }
        .btn-view { background: #17a2b8; color: white; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-group textarea { height: 100px; resize: vertical; }
        .edit-form { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px; }
        .form-row { display: flex; gap: 15px; margin-bottom: 15px; }
        .form-col { flex: 1; }
        .status-active { color: green; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
        .status-email { color: #dc3545; font-weight: bold; }
        .user-details { display: none; background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>प्रयोगकर्ता व्यवस्थापन</h1>
        
        <?php echo $message; ?>
        
        <div class="user-list">
            <h2>प्रयोगकर्ता सूची</h2>
            <?php if (count($users) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>नाम</th>
                            <th>इमेल</th>
                            <th>स्थिति</th>
                            <th>स्तर</th>
                            <th>योजना</th>
                            <th>कार्यहरू</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <?php 
                                    $status_class = '';
                                    $status_text = '';
                                    switch($user['status']) {
                                        case 0:
                                            $status_class = 'status-active';
                                            $status_text = 'सक्रिय';
                                            break;
                                        case 1:
                                            $status_class = 'status-pending';
                                            $status_text = 'भेरिफाई बाँकी';
                                            break;
                                        case 2:
                                            $status_class = 'status-email';
                                            $status_text = 'ईमेल भेरिफाई बाँकी';
                                            break;
                                        default:
                                            $status_class = 'status-pending';
                                            $status_text = 'अज्ञात';
                                    }
                                    ?>
                                    <span class="<?php echo $status_class; ?>">
                                        <?php echo $status_text; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($user['level']); ?></td>
                                <td><?php echo htmlspecialchars($user['plan']); ?></td>
                                <td>
                                    <a href="?edit_id=<?php echo $user['id']; ?>" class="btn btn-edit">सम्पादन</a>
                                    <a href="?delete_id=<?php echo $user['id']; ?>" class="btn btn-delete" onclick="return confirm('के तपाइँ यो प्रयोगकर्ता मेटाउन निश्चित हुनुहुन्छ?')">मेटाउनुहोस्</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>कुनै प्रयोगकर्ता भेटिएन।</p>
            <?php endif; ?>
        </div>

        <?php if ($edit_user): ?>
        <div class="edit-form">
            <h2>प्रयोगकर्ता सम्पादन गर्नुहोस् - <?php echo htmlspecialchars($edit_user['username']); ?></h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_user['id']); ?>">
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($edit_user['username']); ?>" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="email">इमेल:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($edit_user['email']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="firstname">पहिलो नाम:</label>
                            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($edit_user['firstname']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="lastname">थर:</label>
                            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($edit_user['lastname']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="status">स्थिति:</label>
                            <select id="status" name="status" required>
                                <?php foreach($status_options as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo $edit_user['status'] == $value ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="level">स्तर:</label>
                            <input type="number" id="level" name="level" value="<?php echo htmlspecialchars($edit_user['level']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="gender">लिङ्ग:</label>
                            <select id="gender" name="gender">
                                <option value="0" <?php echo $edit_user['gender'] == 0 ? 'selected' : ''; ?>>नखुलाउनुहोस्</option>
                                <option value="1" <?php echo $edit_user['gender'] == 1 ? 'selected' : ''; ?>>पुरुष</option>
                                <option value="2" <?php echo $edit_user['gender'] == 2 ? 'selected' : ''; ?>>महिला</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="plan">योजना:</label>
                            <input type="number" id="plan" name="plan" value="<?php echo htmlspecialchars($edit_user['plan']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mobile">मोबाइल:</label>
                            <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($edit_user['mobile']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="tel">टेलिफोन:</label>
                            <input type="text" id="tel" name="tel" value="<?php echo htmlspecialchars($edit_user['tel']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="profession">पेशा:</label>
                    <input type="text" id="profession" name="profession" value="<?php echo htmlspecialchars($edit_user['profession']); ?>">
                </div>

                <div class="form-group">
                    <label for="company">कम्पनी:</label>
                    <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($edit_user['company']); ?>">
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="birthplace">जन्मस्थान:</label>
                            <input type="text" id="birthplace" name="birthplace" value="<?php echo htmlspecialchars($edit_user['birthplace']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="birthdate">जन्म मिति (timestamp):</label>
                            <input type="number" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($edit_user['birthdate']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="interests">रुचिहरू:</label>
                    <input type="text" id="interests" name="interests" value="<?php echo htmlspecialchars($edit_user['interests']); ?>">
                </div>

                <div class="form-group">
                    <label for="bio">जीवनी:</label>
                    <textarea id="bio" name="bio"><?php echo htmlspecialchars($edit_user['bio']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="facebook">Facebook:</label>
                            <input type="text" id="facebook" name="facebook" value="<?php echo htmlspecialchars($edit_user['facebook']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="instagram">Instagram:</label>
                            <input type="text" id="instagram" name="instagram" value="<?php echo htmlspecialchars($edit_user['instagram']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="twitter">Twitter:</label>
                            <input type="text" id="twitter" name="twitter" value="<?php echo htmlspecialchars($edit_user['twitter']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Additional fields -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="birthday">जन्म दिन:</label>
                            <input type="number" id="birthday" name="birthday" min="0" max="31" value="<?php echo htmlspecialchars($edit_user['birthday']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="birthmonth">जन्म महिना:</label>
                            <input type="number" id="birthmonth" name="birthmonth" min="0" max="12" value="<?php echo htmlspecialchars($edit_user['birthmonth']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="birthyear">जन्म वर्ष:</label>
                            <input type="number" id="birthyear" name="birthyear" min="0" max="9999" value="<?php echo htmlspecialchars($edit_user['birthyear']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="slug">Slug:</label>
                            <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($edit_user['slug']); ?>">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="frequency">Frequency:</label>
                            <input type="number" id="frequency" name="frequency" value="<?php echo htmlspecialchars($edit_user['frequency']); ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" name="update" class="btn btn-update">अपडेट गर्नुहोस्</button>
                <a href="?" class="btn btn-cancel">रद्द गर्नुहोस्</a>
            </form>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>