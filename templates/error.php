<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Error - Movie Booking System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            margin: 20px;
        }
        .error-icon {
            font-size: 64px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 28px;
        }
        p {
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn {
            background: #3498db;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2980b9;
        }
        .error-code {
            background: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            margin: 20px 0;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>Oops! Something went wrong</h1>
        <p>We're sorry, but an unexpected error has occurred. Our team has been notified and is working to fix the issue.</p>
        
        <div class="error-code">
            Error ID: <?php echo uniqid(); ?>
        </div>
        
        <p>Please try again in a few moments. If the problem persists, contact our support team.</p>
        
        <a href="javascript:history.back()" class="btn">Go Back</a>
        <a href="/" class="btn">Home Page</a>
    </div>
</body>
</html>
