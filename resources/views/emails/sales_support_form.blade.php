<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New support Submission</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #043870; /* dark blue base */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #e0e6ed; /* light text */
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #012352;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            text-align: left;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 180px;
            height: auto;
        }

        h2 {
            color: #61dafb;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .message-box {
            background-color: #324a5f;
            border-left: 4px solid #61dafb;
            padding: 12px;
            margin-top: 10px;
            border-radius: 4px;
            color: #f1f1f1;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #adb5bd;
            border-top: 1px solid #2c3e50;
            padding-top: 15px;
        }

        strong {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
             <img src="{{ asset('uploads/pics/logo1.png') }}" alt="Kumoyo logo">
        </div>

        <h2> Sales support Submission</h2>

        <p><strong>First Name:</strong> {{ $submission->first_name }}</p>
        <p><strong>Last Name:</strong> {{ $submission->last_name }}</p>
        <p><strong>Company:</strong> {{ $submission->company }}</p>
        <p><strong>Job Title:</strong> {{ $submission->job_title }}</p>
        <p><strong>Email:</strong> {{ $submission->email }}</p>
        <p><strong>Phone:</strong> {{ $submission->phone ?? 'N/A' }}</p>
        <p><strong>Country:</strong> {{ $submission->country }}</p>
        <p><strong>Consent:</strong> {{ $submission->consent ? 'Yes' : 'No' }}</p>

        <p><strong>Message:</strong></p>
        <div class="message-box">
            {{ $submission->message ?? 'No message provided.' }}
        </div>

        <div class="footer">
            This message was sent via the <strong>Kumoyo</strong> support form<br>
            <strong>From:</strong> {{ $submission->first_name }} {{ $submission->last_name }} ({{ $submission->email }})
        </div>
    </div>
</body>
</html>
