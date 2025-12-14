<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Test - Task Manager</title>
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
            max-width: 900px;
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
        
        .info p {
            margin: 5px 0;
            color: #555;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        
        th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .priority-high {
            color: #dc3545;
            font-weight: bold;
        }
        
        .priority-medium {
            color: #ffc107;
            font-weight: bold;
        }
        
        .priority-low {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-completed {
            background: #28a745;
            color: white;
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 0.85em;
        }
        
        .status-pending {
            background: #ffc107;
            color: #333;
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 0.85em;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Kembali ke Home</a>
        <h1>🗄️ Database Connection Test</h1>
        
        <?php
        // Database configuration
        $db_host = getenv('DB_HOST') ?: 'mysql';
        $db_user = getenv('DB_USER') ?: 'root';
        $db_pass = getenv('DB_PASS') ?: 'password';
        $db_name = getenv('DB_NAME') ?: 'taskmanager';
        
        echo '<div class="info">';
        echo '<p><strong>Host:</strong> ' . htmlspecialchars($db_host) . '</p>';
        echo '<p><strong>Database:</strong> ' . htmlspecialchars($db_name) . '</p>';
        echo '<p><strong>User:</strong> ' . htmlspecialchars($db_user) . '</p>';
        echo '</div>';
        
        try {
            // Connect to MySQL
            $conn = new mysqli($db_host, $db_user, $db_pass);
            
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            
            echo '<div class="status success">';
            echo '<strong>✓ Koneksi ke MySQL berhasil!</strong><br>';
            echo 'Server version: ' . $conn->server_info;
            echo '</div>';
            
            // Create database if not exists
            $conn->query("CREATE DATABASE IF NOT EXISTS $db_name");
            $conn->select_db($db_name);
            
            // Create table if not exists
            $create_table = "CREATE TABLE IF NOT EXISTS tasks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
                status ENUM('Pending', 'Completed') DEFAULT 'Pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->query($create_table);
            
            // Insert sample data if table is empty
            $result = $conn->query("SELECT COUNT(*) as count FROM tasks");
            $row = $result->fetch_assoc();
            
            if ($row['count'] == 0) {
                $sample_tasks = [
                    ["Belajar Docker", "Memahami konsep containerization", "High", "Completed"],
                    ["Setup MySQL", "Konfigurasi database untuk aplikasi", "High", "Completed"],
                    ["Implementasi Redis", "Menambahkan caching layer", "Medium", "Pending"],
                    ["Deploy ke Cloud", "Upload aplikasi ke Azure/AWS", "Low", "Pending"],
                    ["Testing Aplikasi", "Unit test dan integration test", "Medium", "Pending"]
                ];
                
                $stmt = $conn->prepare("INSERT INTO tasks (title, description, priority, status) VALUES (?, ?, ?, ?)");
                foreach ($sample_tasks as $task) {
                    $stmt->bind_param("ssss", $task[0], $task[1], $task[2], $task[3]);
                    $stmt->execute();
                }
                echo '<div class="status success">';
                echo '✓ Sample data berhasil ditambahkan!';
                echo '</div>';
            }
            
            // Display tasks
            echo '<h2>📝 Daftar Tasks</h2>';
            $result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
            
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<tr><th>ID</th><th>Title</th><th>Description</th><th>Priority</th><th>Status</th><th>Created</th></tr>';
                
                while ($row = $result->fetch_assoc()) {
                    $priority_class = 'priority-' . strtolower($row['priority']);
                    $status_class = 'status-' . strtolower($row['status']);
                    
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td><strong>' . htmlspecialchars($row['title']) . '</strong></td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '<td class="' . $priority_class . '">' . $row['priority'] . '</td>';
                    echo '<td><span class="' . $status_class . '">' . $row['status'] . '</span></td>';
                    echo '<td>' . date('d/m/Y H:i', strtotime($row['created_at'])) . '</td>';
                    echo '</tr>';
                }
                
                echo '</table>';
            } else {
                echo '<p>Tidak ada task dalam database.</p>';
            }
            
            $conn->close();
            
        } catch (Exception $e) {
            echo '<div class="status error">';
            echo '<strong>✗ Error:</strong> ' . $e->getMessage();
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
