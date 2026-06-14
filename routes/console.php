<?php

use App\Services\NotificationService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Membuat perintah kustom (opsional, bisa dipanggil lewat 'php artisan app:remind-alumni')
Artisan::command('app:remind-alumni', function () {
    $this->info('Memulai pengiriman email pengingat...');
    $service = app(NotificationService::class);
    $total = $service->remindAlumni();
    $this->info("Sukses mengirimkan pengingat ke {$total} alumni.");
})->purpose('Mengirim email pengingat tracer study ke alumni yang belum mengisi');

// --- PASANG JADWAL OTOMATISNYA DI SINI ---
Schedule::command('app:remind-alumni')->weeklyOn(1, '08:00'); 
// Berjalan otomatis setiap hari Senin jam 08:00 pagi