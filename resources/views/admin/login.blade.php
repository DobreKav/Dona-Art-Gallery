<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Најава - Dona Art Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #FAF8F5 0%, #EDE5D8 100%);
        }
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            margin: 2rem;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: #1A1A1A;
            margin-bottom: 0.3rem;
        }
        .login-brand span {
            font-size: 0.85rem;
            color: #9A9A9A;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #E8E4DF;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            border-color: #8B6914;
            box-shadow: 0 0 0 3px rgba(139,105,20,0.1);
        }
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: #8B6914;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-login:hover { background: #6B5010; }
        .error-msg {
            background: rgba(231,76,60,0.1);
            color: #C0392B;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            color: #6B6B6B;
        }
        .checkbox-row input { accent-color: #8B6914; }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #9A9A9A;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: #8B6914; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <h1>🎨 Dona Art Gallery</h1>
            <span>Админ Панел</span>
        </div>

        @if($errors->any())
            <div class="error-msg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Е-пошта</label>
                <input type="email" name="email" class="form-input" placeholder="admin@donaart.mk" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Лозинка</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>
            <div class="checkbox-row">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Запомни ме</label>
            </div>
            <button type="submit" class="btn-login">
                <i class="fa-solid fa-sign-in-alt"></i> Најава
            </button>
        </form>
        <a href="{{ route('home') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Назад кон страницата
        </a>
    </div>
</body>
</html>
