<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Home</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }
        
        h1 {
            color: #667eea;
            text-align: center;
            margin-bottom: 10px;
            font-size: 2.5em;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
            font-size: 1.1em;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .menu-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            border-radius: 15px;
            text-align: center;
            text-decoration: none;
            color: white;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .menu-item h3 {
            font-size: 1.3em;
            margin-bottom: 10px;
        }
        
        .menu-item p {
            font-size: 0.9em;
            opacity: 0.9;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }
        
        .info-box h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .info-box ul {
            list-style: none;
            padding-left: 0;
        }
        
        .info-box li {
            padding: 8px 0;
            color: #555;
        }
        
        .info-box li:before {
            content: "✓ ";
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 Task Manager</h1>
        <p class="subtitle">Aplikasi Manajemen Tugas Sederhana</p>
        
        <div class="menu-grid">
            <a href="db-test.php" class="menu-item">
                <h3>🗄️ Database Test</h3>
                <p>Uji koneksi MySQL & lihat data tasks</p>
            </a>
            
            <a href="cache-test.php" class="menu-item">
                <h3>⚡ Cache Test</h3>
                <p>Uji Redis caching & session counter</p>
            </a>
            
            <a href="info.php" class="menu-item">
                <h3>ℹ️ PHP Info</h3>
                <p>Lihat konfigurasi PHP & ekstensi</p>
            </a>
        </div>
        
        <div class="info-box">
            <h3>📌 Tentang Aplikasi</h3>
            <ul>
                <li>Server: Apache HTTP Server dengan PHP 7</li>
                <li>Database: MySQL untuk penyimpanan data persistent</li>
                <li>Caching: Redis untuk optimasi performa</li>
                <li>Container: Docker dengan Alpine Linux</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>Case 5 - Cloud Computing Course © <?php echo date('Y'); ?></p>
        </div>
    </div>
</body>
</html>
