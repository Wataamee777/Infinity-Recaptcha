<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Googleから提供されたシークレットキー
    $recaptcha_secret = "6LfWS-QqAAAAAE4NkeYdGLi-S76NGV0fYUe4L1YF";
    
    // ユーザーが送信したreCAPTCHAの応答
    $recaptcha_response = $_POST["g-recaptcha-response"];
    
    // GoogleのreCAPTCHA APIエンドポイント
    $url = "https://www.google.com/recaptcha/api/siteverify";
    
    // POSTデータを作成
    $data = [
        "secret" => $recaptcha_secret,
        "response" => $recaptcha_response
    ];
    
    // HTTPリクエストオプションを設定
    $options = [
        "http" => [
            "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($data)
        ]
    ];
    
    // コンテキストを作成し、HTTPリクエストを送信
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    // レスポンスをデコードしてJSON形式で取得
    $response = json_decode($result, true);
    
    if ($response["success"]) {
        // 認証成功メッセージ
        echo "<h3>✅ reCAPTCHA認証成功！</h3>";
        echo "<script>setTimeout(() => location.reload(), 2000);</script>";
    } else {
        // 認証失敗メッセージ
        echo "<h3>❌ 認証失敗！もう一度試してください。</h3>";
    }
}
?>
