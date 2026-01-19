<?php
// Composer 없이 간단하게 dotenv 읽기
$env = [];
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        [$key, $value] = explode('=', $line, 5);
        $env[trim($key)] = trim($value);
    }
}

// 기본값
$port = $env['PORT'] ?? '8080';
$host = $env['HOST'] ?? 'localhost';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSocket Sender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Send Message to WebSocket Server</h4>
        </div>
        <div class="card-body">
            <form id="wsForm" class="d-flex gap-2">
                <input type="text" id="messageInput" class="form-control" placeholder="Enter text here" required />
                <button type="submit" class="btn btn-primary">Send</button>
            </form>

            <hr />

            <h6>Server Log:</h6>
            <ul id="logList" class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;"></ul>
        </div>
    </div>
</div>

<script>
    // PHP에서 읽은 .env 값으로 WebSocket URL 설정
    const WS_URL = `ws://<?php echo $host ?>:<?php echo $port ?>/`;
    const ws = new WebSocket(WS_URL);

    const logList = document.getElementById('logList');

    function addLog(message) {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.textContent = message;
        logList.appendChild(li);
        logList.scrollTop = logList.scrollHeight;
    }

    ws.onopen = () => addLog('✅ WebSocket connection opened');
    ws.onclose = () => addLog('❌ WebSocket connection closed');
    ws.onerror = (err) => addLog('⚠️ WebSocket error: ' + err);
    ws.onmessage = (event) => addLog('📥 Server: ' + event.data);

    const form = document.getElementById('wsForm');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        if (message) {
            ws.send(message);
            addLog('📤 Sent: ' + message);
            input.value = '';
        }
    });
</script>

</body>
</html>
