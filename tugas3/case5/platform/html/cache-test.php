<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cache Test - Task Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        h1 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .status {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .counter-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
        }
        
        .counter-box h2 {
            font-size: 3em;
            margin-bottom: 10px;
        }
        
        .counter-box p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .cache-data {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .cache-data h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .cache-item {
            background: white;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .cache-item strong {
            color: #667eea;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Kembali ke Home</a>
        <h1>⚡ Redis Cache Test</h1>
        
        <?php
        // Redis configuration
        $redis_host = getenv('REDIS_HOST') ?: 'redis';
        $redis_port = getenv('REDIS_PORT') ?: 6379;
        
        echo '<div class="info">';
        echo '<p><strong>Redis Host:</strong> ' . htmlspecialchars($redis_host) . '</p>';
        echo '<p><strong>Redis Port:</strong> ' . htmlspecialchars($redis_port) . '</p>';
        echo '</div>';
        
        try {
            // Connect to Redis
            $redis = new Redis();
            $redis->connect($redis_host, $redis_port);
            
            echo '<div class="status success">';
            echo '<strong>✓ Koneksi ke Redis berhasil!</strong><br>';
            echo 'Redis version: ' . $redis->info()['redis_version'];
            echo '</div>';
            
            // Page view counter
            $counter_key = 'page_views:cache-test';
            $views = $redis->incr($counter_key);
            
            echo '<div class="counter-box">';
            echo '<h2>' . number_format($views) . '</h2>';
            echo '<p>Total halaman ini dikunjungi</p>';
            echo '<p style="font-size: 0.9em; margin-top: 10px;">(Counter tersimpan di Redis)</p>';
            echo '</div>';
            
            // Store some sample cache data
            $cache_data = [
                'last_visit' => date('Y-m-d H:i:s'),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
            ];
            
            foreach ($cache_data as $key => $value) {
                $redis->setex('visitor:' . $key, 3600, $value); // Cache for 1 hour
            }
            
            // Display cached data
            echo '<div class="cache-data">';
            echo '<h3>📊 Data yang Tersimpan di Cache</h3>';
            
            echo '<div class="cache-item">';
            echo '<strong>Last Visit:</strong> <span>' . $redis->get('visitor:last_visit') . '</span>';
            echo '</div>';
            
            echo '<div class="cache-item">';
            echo '<strong>User Agent:</strong> <span>' . htmlspecialchars($redis->get('visitor:user_agent')) . '</span>';
            echo '</div>';
            
            echo '<div class="cache-item">';
            echo '<strong>IP Address:</strong> <span>' . $redis->get('visitor:ip_address') . '</span>';
            echo '</div>';
            
            echo '<div class="cache-item">';
            echo '<strong>Total Keys in Redis:</strong> <span>' . $redis->dbSize() . ' keys</span>';
            echo '</div>';
            
            echo '</div>';
            
            // Test set and get
            $test_key = 'test:message';
            $test_value = 'Hello from Redis Cache!';
            $redis->setex($test_key, 60, $test_value);
            
            echo '<div class="info" style="margin-top: 20px;">';
            echo '<h3>🧪 Cache Test</h3>';
            echo '<p><strong>Set Key:</strong> ' . $test_key . '</p>';
            echo '<p><strong>Value:</strong> ' . $test_value . '</p>';
            echo '<p><strong>TTL:</strong> ' . $redis->ttl($test_key) . ' seconds</p>';
            echo '<p><strong>Retrieved Value:</strong> ' . $redis->get($test_key) . '</p>';
            echo '</div>';
            
            $redis->close();
            
        } catch (Exception $e) {
            echo '<div class="status error">';
            echo '<strong>✗ Error:</strong> ' . $e->getMessage();
            echo '<br><br><em>Pastikan Redis service sudah berjalan dan extension PHP Redis sudah terinstall.</em>';
            echo '</div>';
        }
        ?>
        
        <a href="cache-test.php" class="btn">🔄 Refresh Counter</a>
    </div>
</body>
</html>
