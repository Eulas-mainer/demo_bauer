<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        #phone::placeholder {
            color: #999;
            opacity: 1;
        }

        #phone:-ms-input-placeholder {
            color: #999;
        }

        #phone::-ms-input-placeholder {
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Регистрация</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Логин -->
                            <div class="mb-3">
                                <label for="login" class="form-label">Логин</label>
                                <input id="login" type="text"
                                    class="form-control @error('login') is-invalid @enderror"
                                    name="login"
                                    required
                                    autocomplete="login"
                                    autofocus
                                    pattern="[a-zA-Zа-яА-Я0-9]{6,}">
                                @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Имя -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Имя</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" required>
                            </div>

                            <!-- Фамилия -->
                            <div class="mb-3">
                                <label for="surname" class="form-label">Фамилия</label>
                                <input id="surname" type="text"
                                    class="form-control @error('surname') is-invalid @enderror"
                                    name="surname" required>
                            </div>

                            <!-- Телефон -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон</label>
                                <input id="phone" type="tel"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    name="phone"
                                    placeholder="+7(XXX)-XXX-XX-XX"
                                    required
                                    inputmode="numeric">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" required>
                            </div>

                            <!-- Пароль -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required
                                    minlength="6">
                            </div>

                            <!-- Подтверждение пароля -->
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Подтвердите пароль</label>
                                <input id="password-confirm" type="password"
                                    class="form-control"
                                    name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('phone').addEventListener('input', function(e) {
            let number = e.target.value.replace(/\D/g, '');

            if (number.startsWith('8') && number.length === 11) {
                number = '7' + number.substring(1);
            }

            if (number.length >= 11) {
                number = number.substring(0, 11);
                const match = number.match(/^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})$/);

                if (match) {
                    e.target.value = `+7(${match[2]})-${match[3]}-${match[4]}-${match[5]}`;
                }
            } else {
                let formatted = '+7(';
                if (number.length > 1) {
                    formatted += number.substring(1, 4);
                }
                if (number.length > 4) {
                    formatted += ')-' + number.substring(4, 7);
                }
                if (number.length > 7) {
                    formatted += '-' + number.substring(7, 9);
                }
                if (number.length > 9) {
                    formatted += '-' + number.substring(9, 11);
                }
                e.target.value = formatted;
            }
        });
    </script>
</body>

</html>