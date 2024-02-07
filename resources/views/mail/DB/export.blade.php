<!DOCTYPE html>
<html>
<head>
    <title>Database Backup Email</title>
</head>
<body>
    <p>Dear user,</p>
    
    <p>Attached is the database backup file: <strong>{{ $filename }}</strong></p>

    <p>
        You can download the file by clicking the link below:
        <a href="{{ $downloadLink }}" download>Download Backup</a>
    </p>

    <p>Thank you!</p>
</body>
</html>
