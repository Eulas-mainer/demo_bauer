<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            Log::warning('Попытка доступа к бронированию без авторизации');
            return redirect()->route('login');
        }
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        // Проверка авторизации
        if (!Auth::check()) {
            Log::warning('Попытка бронирования без авторизации');
            return redirect()->route('login');
        }

        $userId = Auth::id();
        Log::info("Начало обработки бронирования для user_id: {$userId}");

        // Проверка существования пользователя
        if (!User::where('id', $userId)->exists()) {
            Log::error("Пользователь с ID {$userId} не существует");
            Auth::logout();
            return redirect()->route('login')->withErrors('Сессия устарела, войдите снова');
        }

        // Валидация данных
        $validated = $request->validate([
            'reservation_date' => [
                'required', 
                'date_format:Y-m-d\TH:i',
                'after:now'
            ],
            'guests_count' => [
                'required',
                'integer',
                'min:1',
                'max:10'
            ],
            'phone' => [
                'required',
                'regex:/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/'
            ]
        ]);

        try {
            DB::beginTransaction();

            // Создание бронирования
            $reservation = Reservation::create([
                'user_id' => $userId,
                'reservation_date' => $validated['reservation_date'],
                'guests_count' => $validated['guests_count'],
                'phone' => $validated['phone']
            ]);

            DB::commit();
            Log::info("Бронирование создано успешно. ID: {$reservation->id}");

            return redirect()->route('profile')->with('success', 'Бронирование успешно создано!');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("Ошибка базы данных: " . $e->getMessage());
            return back()->withErrors('Ошибка при сохранении данных');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Общая ошибка: " . $e->getMessage());
            return back()->withErrors('Произошла ошибка');
        }
    }
}