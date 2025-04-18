<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Бронирование столика</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Бронирование столика</div>

                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif

                        <form method="POST" action="{{ route('reservations.store') }}">
                            @csrf

                            <!-- Дата и время -->
                            <div class="mb-3">
                                <label for="reservation_date" class="form-label">Дата и время</label>
                                <input type="datetime-local"
                                    class="form-control @error('reservation_date') is-invalid @enderror"
                                    id="reservation_date"
                                    name="reservation_date"
                                    required>
                                @error('reservation_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Количество гостей -->
                            <div class="mb-3">
                                <label for="guests_count" class="form-label">Количество гостей</label>
                                <select class="form-select @error('guests_count') is-invalid @enderror"
                                    id="guests_count"
                                    name="guests_count"
                                    required>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                                @error('guests_count')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Телефон -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Контактный телефон</label>
                                <input type="tel"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    value="{{ Auth::user()->phone }}"
                                    pattern="\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}"
                                    placeholder="+7(XXX)-XXX-XX-XX"
                                    required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Забронировать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Скрипт маски телефона (аналогичный регистрации)
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