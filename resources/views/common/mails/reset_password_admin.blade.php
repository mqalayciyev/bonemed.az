<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<title>Total Records</title>
</head>
<body>
 <h1>{{ config('app.name') }}</h1>
 <h4>Şifrəni dəyişmək üçün aşşağıdakı linkə daxil olun</h4>
 <a href='{{$reset['link']}}'>Reset Password</a>
</body>
</html>