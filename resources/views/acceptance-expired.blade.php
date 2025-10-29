<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Expired - Loan Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .expired-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .expired-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #f8d7da;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }
        .expired-x {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        .expired-title {
            color: #dc3545;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .expired-message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="expired-container">
        <div class="expired-icon">
            <div class="expired-x">✕</div>
        </div>
        <h1 class="expired-title">Link Expired</h1>
        <p class="expired-message">
            This acceptance link has expired or has already been used. Please contact support for assistance.
        </p>
    </div>
</body>
</html>

