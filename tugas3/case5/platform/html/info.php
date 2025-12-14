<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Info - Task Manager</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            margin: 0;
        }
        
        .header {
            background: white;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 30px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        h1 {
            color: #667eea;
            margin: 0;
        }
        
        .info-container {
            background: white;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 0 40px 40px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="back-link">← Kembali ke Home</a>
        <h1>ℹ️ PHP Configuration Info</h1>
    </div>
    <div class="info-container">
        <?php
        phpinfo();
        ?>
    </div>
</body>
</html>
