<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM students WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['id' => $id])) {
        header("Location: index.php");
    } else {
        echo "Error deleting student.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student | NeoCore</title>
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
            max-width: 600px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            text-align: center;
            margin-bottom: 40px;
            background: linear-gradient(90deg, #ff0064, #ff00ff, #ff0064);
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

        .message {
            text-align: center;
            padding: 40px;
            background: rgba(10, 10, 20, 0.8);
            border: 1px solid rgba(255, 0, 100, 0.3);
            border-radius: 10px;
            box-shadow: 0 0 40px rgba(255, 0, 100, 0.1);
        }

        .message p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .back-btn {
            display: inline-block;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 15px 40px;
            background: transparent;
            border: 1px solid #00ffff;
            color: #00ffff;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
        }

        .back-btn:hover {
            background: #00ffff;
            color: #0a0a0f;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.5);
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
        <h1>⬡ Delete Student</h1>
        
        <div class="message">
            <p>Student has been deleted successfully!</p>
            <a href="index.php" class="back-btn">Back to Registry</a>
        </div>
    </div>
</body>
</html>