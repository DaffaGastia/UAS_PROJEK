<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatAIController extends Controller
{
    /**
     * Kirim pesan dari user ke AI Gemini (model gratis 2.0-flash)
     */
    public function send(Request $request)
    {
        $apiKey = env('AI_API_KEY');
        $model  = 'gemini-2.0-flash';
        $url    = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        if (!$apiKey) {
            return back()->with('response', 'API key tidak ditemukan di file .env.');
        }

        $prompt = trim($request->input('message'));
        if (empty($prompt)) {
            return back()->with('response', 'Silakan ketik pesan terlebih dahulu.');
        }

        $context = file_exists(base_path('info.txt'))
            ? file_get_contents(base_path('info.txt'))
            : "Kamu adalah asisten customer service toko roti Mocha Jane yang ramah dan membantu pelanggan.";

        $body = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => "{$context}\n\nUser: {$prompt}\nAI:"]
                    ]
                ]
            ]
        ];

        try {
            $response = Http::withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type'   => 'application/json',
            ])->post($url, $body);
            Log::info('AI Response:', $response->json());

            if ($response->failed()) {
                Log::error('AI API Error', ['response' => $response->json()]);
                return back()->with('response', 'Gagal menghubungi AI. Silakan coba lagi nanti.');
            }

            $data = $response->json();

            if (isset($data['error'])) {
                $reply = "Error dari API: " . ($data['error']['message'] ?? 'Tidak diketahui.');
            } elseif (!empty($data['candidates'][0]['content']['parts'][0]['text'])) {
                $reply = $data['candidates'][0]['content']['parts'][0]['text'];
            } elseif (!empty($data['promptFeedback']['blockReason'])) {
                $reply = "Pesan diblokir oleh AI (alasan: " . $data['promptFeedback']['blockReason'] . ")";
            } else {
                $reply = "AI tidak memberikan jawaban.";
            }

            return back()->with('response', $reply);

        } catch (\Exception $e) {
            Log::error('AI Exception', ['error' => $e->getMessage()]);
            return back()->with('response', 'Terjadi kesalahan internal: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman chat AI.
     */
    public function index()
    {
        return view('chat.index');
    }
}
