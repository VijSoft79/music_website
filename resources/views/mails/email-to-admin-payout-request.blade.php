<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payout Request Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content p {
            line-height: 1.6;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #eeeeee;
            color: #666666;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            font-size: 16px;
            color: #ffffff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Email Header -->
        <div class="header">
            <h1>Payout Request Received</h1>
        </div>
        
        <!-- Email Content -->
        <div class="content">
            <p>Dear Admin,</p>
            <p>We have received a new payout request from {{ $curator->name }}. The details of the request are as follows:</p>
            
            <p><strong>Payout Details:</strong></p>
            <ul>
                <li><strong>Request Date:</strong> {{$transaction->created_at}}</li>
                <li><strong>Requested Amount:</strong> ${{$transaction->amount}}</li>
                <li><strong>Payment Method:</strong> Paypal</li>
            </ul>

            <p>Please review and process this request</p>

            <a href="[Your Admin Dashboard URL]" class="button">Review Request</a>
            
            <p>Thank you,<br>Youhearus Team</p>
        </div>
        
        <!-- Email Footer -->
        <div class="footer">
            <p>&copy; 2024 You Hear Us. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
