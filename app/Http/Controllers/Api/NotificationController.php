<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function broadcastReminder(Request $request, NotificationService $service)
    {
        // $totalSent = $service->remindAlumni();

        // return response()->json([
        //     'success' => true,
        //     'message' => "Notifikasi pengingat berhasil dikirim ke {$totalSent} alumni."
        // ]);

        $request->validate([
            'questionnaire_id' => 'required|exists:questionnaires,id'
        ]);

        // Lempar ID kuesioner ke service untuk diproses
        $totalSent = $service->remindAlumni($request->questionnaire_id);

        return response()->json([
            'success' => true,
            'message' => "Notifikasi pengingat kuesioner berhasil dikirim ke {$totalSent} alumni."
        ]);
    }
}
