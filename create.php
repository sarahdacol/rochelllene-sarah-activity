<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students (name, email, course) VALUES (:name, :email, :course)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute(['name' => $name, 'email' => $email, 'course' => $course])) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student | NeoCore</title>
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

        .form-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(128, 0, 255, 0.3);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(128, 0, 255, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            color: #8000ff;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 15px 20px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.1rem;
            font-weight: 500;
            color: #1a1a2e;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(128, 0, 255, 0.2);
            border-radius: 8px;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #8000ff;
            box-shadow: 0 0 20px rgba(128, 0, 255, 0.3), inset 0 0 10px rgba(128, 0, 255, 0.05);
        }

        input::placeholder {
            color: rgba(26, 26, 46, 0.4);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .submit-btn {
            flex: 1;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 15px 30px;
            background: linear-gradient(135deg, #8000ff, #ff0080);
            border: none;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
            box-shadow: 0 4px 15px rgba(128, 0, 255, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(128, 0, 255, 0.6);
        }

        .back-btn {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 15px 30px;
            background: transparent;
            border: 2px solid rgba(128, 0, 255, 0.4);
            color: #8000ff;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
        }

        .back-btn:hover {
            border-color: #ff0080;
            color: #ff0080;
            box-shadow: 0 0 20px rgba(255, 0, 128, 0.3);
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
        <h1>⬡ Add Student</h1>
        
        <div class="form-card">
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter full name" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter email address" required>
                </div>
                
                <div class="form-group">
                    <label>Course</label>
                    <input type="text" name="course" placeholder="Enter course name" required>
                </div>
                
                <div class="btn-group">
                    <button type="submit" class="submit-btn">Add Student</button>
                    <a href="index.php" class="back-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>