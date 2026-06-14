<?php

namespace App\Exports;

use App\Models\Alumni;
use App\Models\Question;
use App\Models\Questionnaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnswersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $questionnaireId;
    protected $questions;

    public function __construct(int $questionnaireId)
    {
        $this->questionnaireId = $questionnaireId;
        // Ambil semua pertanyaan di kuesioner ini untuk dijadikan Header Kolom Excel
        $this->questions = Question::where('questionnaire_id', $questionnaireId)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Mengambil semua data alumni yang sudah mengisi kuesioner ini
     */
    public function collection()
    {
        return Alumni::whereHas('answers', function ($q) {
            $q->where('questionnaire_id', $this->questionnaireId);
        })->with(['user', 'answers'])->get();
    }

    /**
     * Membuat Baris Header (Baris Pertama Excel)
     */
    public function headings(): array
    {
        $headers = ['NIM', 'Nama Alumni', 'Tahun Lulus'];

        // Tambahkan kode pertanyaan (f8, f502, dll) sebagai judul kolom
        foreach ($this->questions as $question) {
            $headers[] = $question->kode . ' (' . ucfirst($question->type) . ')';
        }

        return $headers;
    }

    /**
     * Memetakan data Jawaban Alumni ke dalam baris-baris Kolom Excel
     */
    public function map($alumni): array
    {
        // Data dasar alumni
        $row = [
            $alumni->nim,
            $alumni->user->username, // Mengambil nama dari relasi user
            $alumni->tahun_lulus
        ];

        // Looping setiap pertanyaan untuk mengambil jawaban milik alumni ini
        foreach ($this->questions as $question) {
            // Cari jawaban alumni untuk ID pertanyaan spesifik ini
            $answer = $alumni->answers
                ->where('question_id', $question->id)
                ->where('questionnaire_id', $this->questionnaireId)
                ->first();

            if ($answer) {
                // Jika pertanyaan punya opsi jawaban (radio/checkbox) dan ada opsinya, tampilkan teks opsinya
                if ($answer->question_option_id) {
                    $row[] = $answer->option->option_text ?? $answer->answer_text;
                } else {
                    $row[] = $answer->answer_text; // Jika esai/text/number
                }
            } else {
                $row[] = '-'; // Jika dikosongi (misal karena pertanyaan lompatan/bersyarat)
            }
        }

        return $row;
    }
}