<!DOCTYPE html>
<html>
<head>
    <title>Login Petugas</title>
    <style>
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background:#bfbfbf;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .login-box{
            background:#e5e5e5;
            width:500px;
            padding:40px;
            text-align:center;
        }

        .logo{
            font-weight:bold;
            margin-bottom:20px;
        }

        h2{
            margin-bottom:30px;
        }

        label{
            display:block;
            text-align:left;
            margin-top:15px;
            font-size:14px;
        }

        input{
            width:100%;
            padding:8px;
            border:1px solid #888;
        }

        button{
            margin-top:25px;
            padding:10px 30px;
            background:#999;
            border:none;
            font-weight:bold;
            cursor:pointer;
        }

        button:hover{
            background:#777;
        }

        .error{
            color:red;
            margin-bottom:10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="logo">👟 SNEAKER ID</div>
    <h2>LOGIN PETUGAS</h2>

    @if(session('login_error'))
        <div class="error">{{ session('login_error') }}</div>
    @endif

    <form method="POST" action="{{ route('petugas.login.process') }}">
        @csrf

        <label>USERNAME</label>
        <input type="email" name="email" required>

        <label>PASSWORD</label>
        <input type="password" name="password" required>

        <button type="submit">MASUK</button>
    </form>
</div>

</body>
</html>