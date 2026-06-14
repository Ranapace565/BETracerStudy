<?php

namespace App\Services;

use App\Models\User;
use App\Models\Questionnaire;
use App\Notifications\QuestionnaireReminder;

class NotificationService
{
    /**
     * Mengirim pengingat ke semua alumni yang belum mengisi kuesioner aktif.
     */
    /**
 * Mengirim pengingat HANYA ke alumni yang belum mengisi kuesioner aktif.
 */
    public function remindAlumni(?int $questionnaireId = null)
    {
        // // 1. Cari kuesioner yang sedang aktif
        // $activeQuestionnaire = \App\Models\Questionnaire::where('is_active', true)->first();
        // if (!$activeQuestionnaire) return 0;

        // // 2. Ambil User alumni yang BELUM mengisi kuesioner aktif tersebut
        // $lazyAlumni = User::where('role', 'alumni')
        //     ->whereHas('alumni', function ($query) use ($activeQuestionnaire) {
        //         // Filter: Cari alumni yang TIDAK PUNYA data di tabel answers untuk kuesioner ini
        //         $query->whereDoesntHave('answers', function ($q) use ($activeQuestionnaire) {
        //             $q->where('questionnaire_id', $activeQuestionnaire->id);
        //         });
        //     })
        //     ->get();

        // // 3. Kirim ke yang belum mengisi saja
        // foreach ($lazyAlumni as $user) {
        //     $user->notify(new \App\Notifications\QuestionnaireReminder($activeQuestionnaire));
        // }

        // return $lazyAlumni->count(); // Mengembalikan jumlah email yang terkirim

            // 1. Tentukan kuesioner mana yang mau dikirim pengingatnya
            if ($questionnaireId) {
                $questionnaire = Questionnaire::find($questionnaireId);
            } else {
                $questionnaire = Questionnaire::where('is_active', true)->first();
            }

            // Jika kuesioner tidak ditemukan, stop proses
            if (!$questionnaire) return 0;

            // 2. Ambil alumni yang BELUM mengisi kuesioner SPESIFIK tersebut
            $lazyAlumni = User::where('role', 'alumni')
                ->whereHas('alumni', function ($query) use ($questionnaire) {
                    $query->whereDoesntHave('answers', function ($q) use ($questionnaire) {
                        $q->where('questionnaire_id', $questionnaire->id);
                    });
                })
                ->get();

            // 3. Kirim email ke alumni yang terjaring filter
            foreach ($lazyAlumni as $user) {
                $user->notify(new QuestionnaireReminder($questionnaire));
            }

            return $lazyAlumni->count();
        
    }
}
