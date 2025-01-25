<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #007bff;
        }
        .content {
            font-size: 16px;
            line-height: 1.5;
        }
        .link {
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Price Change Notification</div>
        <div class="content">
            <p>The price for the link below has changed:</p>
            <p><strong>Old Price:</strong> {{ $oldPrice }} UAH</p>
            <p><strong>New Price:</strong> {{ $newPrice }} UAH</p>
            <p>Check it out here:</p>
            <a href="{{ $link->url_link }}" class="link" target="_blank">{{ $link->url_link }}</a>
        </div>
    </div>
</body>
</html>
