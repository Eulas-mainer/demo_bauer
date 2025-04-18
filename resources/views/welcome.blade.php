<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        @auth
        <h1>Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('reservations.create') }}" class="btn btn-success">Забронировать столик</a>
            <button type="submit" class="btn btn-danger">Выйти</button>
        </form>

        @else
        <div class="alert alert-info">
            <a href="{{ route('login') }}" class="btn btn-primary">Войти</a>
            <a href="{{ route('register') }}" class="btn btn-success">Регистрация</a>
        </div>
        @endauth
    </div>
</body>

</html>