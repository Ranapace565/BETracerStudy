<?php

namespace App\Notifications;

use App\Models\Questionnaire;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionnaireReminder extends Notification
{
    use Queueable;

    protected $questionnaire;

    public function __construct(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    // Notifikasi dikirim ke database (lonceng UI) dan Email
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    // Template Email
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengingat: Pengisian Kuesioner Tracer Study ' . $this->questionnaire->title)
            ->greeting('Halo, ' . $notifiable->username . '!') // mengambil data dari model User
            ->line('Kami ingin mengingatkan Anda untuk mengisi kuesioner Tracer Study tahun ' . $this->questionnaire->year . '.')
            ->action('Isi Kuesioner Sekarang', url('/api/questionnaires'))
            ->line('Kontribusi Anda sangat penting untuk akreditasi dan pengembangan kampus.');
    }

    // Template untuk disimpan di database (Lonceng Notifikasi UI)
    public function toArray(object $notifiable): array
    {
        return [
            'questionnaire_id' => $this->questionnaire->id,
            'title' => $this->questionnaire->title,
            'message' => 'Yuk sempatkan waktu mengisi kuesioner Tracer Study terbaru.',
        ];
    }
}