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

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

include __DIR__ . "/header.php";

$paymentId = isset($_GET['paymentId']) ? sc_sec($_GET['paymentId']) : '';
$payerID   = isset($_GET['PayerID']) ? sc_sec($_GET['PayerID']) : '';
$token     = isset($_GET['token']) ? sc_sec($_GET['token']) : '';

if (empty($paymentId) || empty($payerID)) {
	echo fh_alerts("The response is missing the payments id!", "danger", path, 2);
	include __DIR__ . "/footer.php";
	exit;
}


$payment   = Payment::get($paymentId, $apiContext);

$execution = new PaymentExecution();
$execution->setPayerId(sc_sec($_GET['PayerID']));

try {
	$payment->execute($execution, $apiContext);

	try {
		$payment = Payment::get($paymentId, $apiContext);


		$pp        = $payment->getTransactions();
		$pp_amount = $pp[0]->amount->total;
		$pp_status = $pp[0]->related_resources[0]->sale->state;

		$pp_monthly = -1;

		if (db_rows("plans WHERE price_m = {$pp_amount}")) {
			$pp_monthly = 1;
			$pp_date = time() + 31 * 24 * 3600;
			$get_plan = db_rs("plans WHERE price_m = {$pp_amount}");
		}

		if (db_rows("plans WHERE price_y = {$pp_amount}")) {
			$pp_monthly = 0;
			$pp_date = time() + 365 * 24 * 3600;
			$get_plan = db_rs("plans WHERE price_y = {$pp_amount}");
		}


		if ($pp_monthly != -1) {
			db_update("users", ["plan" => $get_plan['id'], "lastpayment" => time(), "expired_date" => $pp_date, "frequency" => $pp_monthly], us_id);

			db_insert("payments", [
				"plan"         => "'{$get_plan['id']}'",
				"payment_id"   => "'{$paymentId}'",
				"payer_id"     => "'{$payerID}'",
				"token"        => "'{$token}'",
				"price"        => "'{$pp_amount}'",
				"frequency"    => "'{$pp_monthly}'",
				"expired_date" => "'{$pp_date}'",
				"date"         => "'" . time() . "'",
				"author"       => "'" . us_id . "'",
				"status"       => "'{$pp_status}'",
			]);

			echo '<div id="loading">' . fh_alerts($lang['alerts']['payment'], "success", path, 1) . '</div>';
			fh_go(path, 2);
		}
	} catch (Exception $e) {
		echo $lang['alerts']['payment_f'];
	}
} catch (Exception $e) {
	echo '<div id="loading">' . fh_alerts("Failed to take payment", "danger", path, 3) . '</div>';
}

include __DIR__ . "/footer.php";
