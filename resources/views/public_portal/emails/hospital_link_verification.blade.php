<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>

<p>Hello {{$emailContent['recipient']}},</p>
<p>Your link to {{$emailContent['hospital_name']}} has been successfully created. Please click on the verification link ({{$emailContent['verification_link']}}) to verify your email address.</p>
<p>
    Cheers,<br>
    The Smart Medicare Team
</p>

</body>
</html>