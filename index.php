<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registry | NeoCore</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: #0a0a0f;
            min-height: 100vh;
            color: #e0e0e0;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(90deg, transparent 98%, rgba(0, 255, 255, 0.03) 100%),
                linear-gradient(0deg, transparent 98%, rgba(0, 255, 255, 0.03) 100%);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 80%, rgba(255, 0, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(0, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 900;
            text-align: center;
            margin-bottom: 40px;
            background: linear-gradient(90deg, #00ffff, #ff00ff, #00ffff);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        @keyframes shimmer {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        .add-btn {
            display: inline-block;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 15px 40px;
            margin-bottom: 30px;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(255, 0, 255, 0.1));
            border: 2px solid #00ffff;
            color: #00ffff;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
        }

        .add-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .add-btn:hover {
            background: rgba(0, 255, 255, 0.2);
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.5), inset 0 0 20px rgba(0, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .add-btn:hover::before {
            left: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(10, 10, 20, 0.8);
            border: 1px solid rgba(0, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 40px rgba(0, 255, 255, 0.1);
        }

        .data-table th {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 20px 15px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #00ffff;
            background: linear-gradient(180deg, rgba(0, 255, 255, 0.15), rgba(0, 255, 255, 0.05));
            border-bottom: 2px solid #00ffff;
            position: relative;
        }

        .data-table th::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ffff, transparent);
        }

        .data-table td {
            padding: 18px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .data-table tr:hover td {
            background: rgba(0, 255, 255, 0.05);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table td:first-child {
            color: #ff00ff;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
        }

        .action-btn {
            display: inline-block;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 8px 20px;
            margin-right: 8px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            clip-path: polygon(5px 0, 100% 0, 100% calc(100% - 5px), calc(100% - 5px) 100%, 0 100%, 0 5px);
        }

        .edit-btn {
            background: rgba(0, 255, 255, 0.1);
            border: 1px solid #00ffff;
            color: #00ffff;
        }

        .edit-btn:hover {
            background: #00ffff;
            color: #0a0a0f;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
        }

        .delete-btn {
            background: rgba(255, 0, 100, 0.1);
            border: 1px solid #ff0064;
            color: #ff0064;
        }

        .delete-btn:hover {
            background: #ff0064;
            color: #0a0a0f;
            box-shadow: 0 0 20px rgba(255, 0, 100, 0.5);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.2rem;
        }

        .scanlines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0, 0, 0, 0.1) 2px,
                rgba(0, 0, 0, 0.1) 4px
            );
            pointer-events: none;
            z-index: 1000;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <div class="scanlines"></div>
    <div class="container">
        <h1>⬡ Student Registry</h1>
        
        <a href="create.php" class="add-btn">+ Add Student</a>

        <?php if (count($students) > 0): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $s): ?>
                <tr>
                    <td>#<?= str_pad($s['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= htmlspecialchars($s['email']) ?></td>
                    <td><?= htmlspecialchars($s['course']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $s['id'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $s['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <p>No students found. Add your first student to get started.</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>