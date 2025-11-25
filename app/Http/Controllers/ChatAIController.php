<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ChatAIController extends Controller
{
    private $apiKey;
    private $model = 'gemini-2.0-flash';
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    public function index()
    {
        return view('chat-ai.index');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->message;
        $systemContext = $this->buildSystemContext();

        try {
            $response = Http::withHeaders([
                'x-goog-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(40)->post($this->apiUrl, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            [
                                'text' => "{$systemContext}\n\n---\nPesan pelanggan: {$userMessage}\nJawab dengan gaya customer service profesional dan ramah."
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $candidates = $data['candidates'] ?? [];
                
                if (!empty($candidates)) {
                    $aiResponse = $candidates[0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak bisa merespons saat ini.';
                    
                    return response()->json([
                        'success' => true,
                        'message' => trim($aiResponse)
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan respons dari AI.'
            ], 500);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function buildSystemContext(): string
    {
        $storeInfo = $this->getStoreInfo();
        
        $productsInfo = $this->getProductsInfo();
        $context = "
=== IDENTITAS ===
Kamu adalah 'Mocha', asisten virtual customer service untuk toko roti 'Mocha Jane Bakery'.
Kamu ramah, sopan, helpful, dan selalu menjawab dengan bahasa Indonesia yang baik.

=== INFORMASI TOKO ===
{$storeInfo}

=== DAFTAR PRODUK ===
{$productsInfo}

=== PANDUAN MENJAWAB ===
1. Selalu sapa dengan ramah dan hangat
2. Jawab pertanyaan sesuai konteks toko roti
3. Jika ditanya harga atau produk, berikan info dari daftar produk di atas
4. Jika ditanya lokasi/alamat, berikan alamat toko dengan jelas
5. Jika ditanya kontak, berikan nomor telepon/WA atau Instagram
6. Jika tidak tahu jawabannya, arahkan untuk menghubungi admin via WA atau Instagram
7. Gunakan emoji sesekali untuk kesan ramah 😊🍞
8. Jangan menjawab pertanyaan yang tidak relevan dengan toko
9. Rekomendasikan produk jika pelanggan bingung memilih
10. Promosikan keunggulan roti fresh setiap hari
11. Jika ditanya jam buka, sebutkan jam operasional
12. Untuk pemesanan, arahkan ke website atau hubungi langsung via WA
";

        return trim($context);
    }

    private function getStoreInfo(): string
    {
        return "
Nama Toko: Mocha Jane Bakery
Tagline: House of Bakery
Alamat: Dusun Sumberan, Ambulu, Jember, Jawa Timur
Telepon/WhatsApp: +62 812-3456-7890
Email: info@mochajane.com
Instagram: @mochajane.bakery
Facebook: Mocha Jane Bakery Official
TikTok: @mochajane

Jam Operasional:
- Senin - Minggu: 07:00 - 21:00 WIB
- Buka setiap hari (tidak ada hari libur)

Deskripsi:
Mocha Jane Bakery adalah toko roti yang menyediakan berbagai pilihan roti segar berkualitas tinggi. 
Semua produk dibuat fresh setiap hari menggunakan bahan-bahan pilihan terbaik.
Kami berkomitmen memberikan roti lezat dengan harga terjangkau untuk keluarga Indonesia.

Keunggulan:
✅ Roti dibuat fresh setiap hari
✅ Bahan berkualitas tinggi
✅ Harga terjangkau
✅ Varian rasa lengkap
✅ Kemasan higienis
✅ Pengiriman cepat area Jember

Metode Pembayaran:
- Cash On Delivery (COD) / Bayar di Tempat
- Transfer Bank (BCA, BRI, Mandiri)
- E-Wallet (GoPay, OVO, Dana, ShopeePay)

Pengiriman:
- Gratis ongkir untuk area Jember
- Bisa diambil langsung di toko (Pick Up)
- Pengiriman luar kota via ekspedisi
";
    }

    private function getProductsInfo(): string
    {
        try {
            $products = Product::orderBy('name')->get();
            if ($products->isEmpty()) {
                return $this->getDefaultProducts();
            }
            $productList = "Produk yang tersedia saat ini:\n\n";
            foreach ($products as $product) {
                $price = number_format($product->price, 0, ',', '.');
                $stock = $product->stock > 0 ? "Stok: {$product->stock}" : 'Stok: Tersedia';
                
                $productList .= "🍞 {$product->name}\n";
                $productList .= "   Harga: Rp {$price}\n";
                $productList .= "   {$stock}\n\n";
            }
            $productList .= "\nCatatan: Semua roti dibuat fresh setiap hari! 🥖✨";
            return $productList;
        }catch (\Exception $e) {
            return $this->getDefaultProducts();
        }
    }

    private function getDefaultProducts(): string
    {
        return "
Produk yang tersedia:

🍞 Roti Coklat
    Harga: Rp 5.000 - Rp 22.000 (berbagai ukuran)
    Stok: Tersedia

🍞 Roti Sobek
    Harga: Rp 15.000 - Rp 20.000
    Stok: Tersedia

🍞 Roti Keju
    Harga: Rp 6.000 - Rp 18.000
    Stok: Tersedia

🍞 Roti Tawar
    Harga: Rp 12.000 - Rp 15.000
    Stok: Tersedia

🍞 Roti Manis Aneka Rasa
    Harga: Rp 5.000 - Rp 10.000
    Stok: Tersedia

Catatan: Semua roti dibuat fresh setiap hari! 🥖✨
";
    }
}