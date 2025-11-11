<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceptance Successful - Loan Application</title>
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
        .success-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #d4edda;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }
        .success-check {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #28a745;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        .success-title {
            color: #28a745;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .success-message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .download-link {
            color: #0066cc;
            text-decoration: underline;
            font-size: 14px;
            cursor: pointer;
        }
        .download-link:hover {
            color: #0052a3;
        }
        .application-number {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .application-number strong {
            color: #0066cc;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <div class="success-check">✓</div>
        </div>
        <h1 class="success-title">Success</h1>
        <p class="success-message">
            We have received your accepted loan application document; we'll be in touch shortly!
        </p>
        
        <div class="application-number">
            <strong>Application Number: {{ $eagreement->application_number }}</strong>
        </div>

        <div class="mt-4">
            <a class="download-link" href="{{ route('acceptance.success.pdf', $encoded) }}">
                Download Your Accepted Loan Application
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

