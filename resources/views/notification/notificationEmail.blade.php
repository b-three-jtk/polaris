<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .card-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #007bff;
            text-align: center;
        }
        p {
            line-height: 1.6;
            margin: 10px 0;
        }
        ul {
            padding: 0;
            margin: 15px 0;
            list-style: none;
        }
        ul li {
            margin: 5px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        strong {
            color: #555;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">Submission Status Notification</div>
        <p>Hello, <strong>{{ $submission->submitter->user->name }}</strong></p>
        <p>Here is the status of your submission titled "<strong>{{ $submission->submission_title }}</strong>":</p>
        
        <ul>
            <li><strong>Status:</strong> {{ $submission->status }}</li>
            <li><strong>Description:</strong> {{ $submission->problem_description }}</li>
        </ul>

        <p>Thank you for your submission!</p>

    </div>
</body>
</html>