<!DOCTYPE html>
<html>
<head>
    <title>Telegram Bot Test</title>
</head>
<body>
    <h2>Send Telegram Message from InfinityFree</h2>
    
    <form method="POST">
        <textarea name="message" rows="4" cols="50" placeholder="Enter your message"></textarea>
        <br><br>
        <button type="submit" name="send">Send to Telegram</button>
    </form>

    <?php
    if(isset($_POST['send'])) {
        $message = $_POST['message'];
        if(!empty($message)) {
            $botToken = "8150966168:AAFl1hFo6aU2Iex8P7-bBiSNNEiAmzC_aIk";
            $chatId = "8350296048";
            
            $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
            $data = [
                'chat_id' => $chatId,
                'text' => $message
            ];
            
            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                ]
            ];
            
            $context = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            
            if($result !== FALSE) {
                echo "<p style='color: green;'>Message sent successfully!</p>";
            } else {
                echo "<p style='color: red;'>Failed to send message. Trying cURL...</p>";
                
                // cURL fallback
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                
                $curlResult = curl_exec($ch);
                if($curlResult !== FALSE) {
                    echo "<p style='color: green;'>Message sent via cURL!</p>";
                } else {
                    echo "<p style='color: red;'>Both methods failed.</p>";
                }
                curl_close($ch);
            }
        }
    }
    ?>
</body>
</html>