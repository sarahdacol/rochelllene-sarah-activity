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
            background: linear-gradient(135deg, #f0f4ff 0%, #e8eef8 50%, #f5f8ff 100%);
            min-height: 100vh;
            color: #1a1a2e;
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
                linear-gradient(90deg, transparent 98%, rgba(128, 0, 255, 0.08) 100%),
                linear-gradient(0deg, transparent 98%, rgba(128, 0, 255, 0.08) 100%);
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
            background: radial-gradient(circle at 20% 80%, rgba(255, 0, 128, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(0, 200, 255, 0.15) 0%, transparent 50%);
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
            background: linear-gradient(90deg, #8000ff, #ff0080, #00c8ff, #8000ff);
            background-size: 300% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-shadow: 0 0 30px rgba(128, 0, 255, 0.3);
        }

        @keyframes shimmer {
            0% { background-position: 0% center; }
            100% { background-position: 300% center; }
        }

        .add-btn {
            display: inline-block;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 15px 40px;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #8000ff, #ff0080);
            border: none;
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
            box-shadow: 0 4px 15px rgba(128, 0, 255, 0.4);
        }

        .add-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .add-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(128, 0, 255, 0.6);
        }

        .add-btn:hover::before {
            left: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(128, 0, 255, 0.3);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(128, 0, 255, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        }

        .data-table th {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 20px 15px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #8000ff;
            background: linear-gradient(180deg, rgba(128, 0, 255, 0.1), rgba(128, 0, 255, 0.05));
            border-bottom: 2px solid #8000ff;
            position: relative;
        }

        .data-table th::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #8000ff, transparent);
        }

        .data-table td {
            padding: 18px 15px;
            border-bottom: 1px solid rgba(128, 0, 255, 0.1);
            transition: all 0.3s ease;
            color: #1a1a2e;
        }

        .data-table tr:hover td {
            background: linear-gradient(90deg, rgba(128, 0, 255, 0.08), rgba(255, 0, 128, 0.05));
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table td:first-child {
            color: #ff0080;
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
            background: linear-gradient(135deg, rgba(0, 200, 255, 0.15), rgba(0, 200, 255, 0.05));
            border: 1px solid #00c8ff;
            color: #00a0cc;
        }

        .edit-btn:hover {
            background: #00c8ff;
            color: #fff;
            box-shadow: 0 0 25px rgba(0, 200, 255, 0.5);
        }

        .delete-btn {
            background: linear-gradient(135deg, rgba(255, 0, 80, 0.15), rgba(255, 0, 80, 0.05));
            border: 1px solid #ff0050;
            color: #cc0040;
        }

        .delete-btn:hover {
            background: #ff0050;
            color: #fff;
            box-shadow: 0 0 25px rgba(255, 0, 80, 0.5);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(26, 26, 46, 0.5);
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
                rgba(128, 0, 255, 0.03) 2px,
                rgba(128, 0, 255, 0.03) 4px
            );
            pointer-events: none;
            z-index: 1000;
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