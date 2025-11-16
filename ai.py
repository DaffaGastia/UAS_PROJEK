import requests
import json
import time
import os

API_KEY = "AIzaSyAZkrMBKJX3io0o0Pdagz5rG25bItppGco"
MODEL = "gemini-2.0-flash"
URL = f"https://generativelanguage.googleapis.com/v1beta/models/{MODEL}:generateContent"

def load_system_context():
    """
    Membaca konteks sistem dari file info.txt agar AI tahu informasi toko.
    """
    file_path = "info.txt"
    if not os.path.exists(file_path):
        print("File info.txt tidak ditemukan. Menggunakan konteks default.")
        return (
            "Kamu adalah asisten customer service toko roti bernama Mocha Jane "
            "yang berlokasi di Dusun Sumberan, Ambulu, Jember, Jawa Timur."
        )
    try:
        with open(file_path, "r", encoding="utf-8") as f:
            context = f.read().strip()
            print("Konteks berhasil dimuat dari info.txt.")
            return context
    except Exception as e:
        print(f"Gagal membaca info.txt: {e}")
        return "Kamu adalah asisten toko roti Mocha Jane yang membantu pelanggan dengan ramah."

SYSTEM_CONTEXT = load_system_context()

def ai(prompt: str):
    """
    Mengirim permintaan ke API Gemini dan menampilkan respons AI.
    """
    headers = {
        "x-goog-api-key": API_KEY,
        "Content-Type": "application/json",
    }

    body = {
        "contents": [
            {
                "role": "user",
                "parts": [
                    {
                        "text": (
                            f"{SYSTEM_CONTEXT}\n\n"
                            f"---\n"
                            f"Pesan pelanggan: {prompt}\n"
                            f"Jawab dengan gaya customer service profesional dan ramah."
                        )
                    }
                ]
            }
        ]
    }

    try:
        response = requests.post(URL, headers=headers, json=body, timeout=40)
        response.raise_for_status()

        data = response.json()
        candidates = data.get("candidates", [])
        if not candidates:
            print("Tidak ada respons dari AI.")
            return

        text = candidates[0]["content"]["parts"][0].get("text", "").strip()
        print("\nMocha Jane CS:", text)

    except requests.exceptions.RequestException as e:
        print("\n Gagal terhubung ke API!")
        print("Detail:", e)
        if 'response' in locals():
            print("Response:", response.text)
    except (KeyError, IndexError, json.JSONDecodeError) as e:
        print("Gagal membaca respons AI:", e)

def chat_loop():
    """
    Menjalankan mode interaktif customer service AI.
    """
    print("==================================================")
    print("Customer Service Mocha Jane aktif!")
    print("Ketik 'exit' untuk keluar dari sesi chat.")
    print("==================================================\n")

    while True:
        try:
            user_input = input("Kamu: ").strip()
            if not user_input:
                continue
            if user_input.lower() in ["exit", "quit", "keluar"]:
                print("Terima kasih telah menggunakan layanan Mocha Jane CS!")
                break

            ai(user_input)
            time.sleep(0.5)

        except KeyboardInterrupt:
            print("\nChat dihentikan.")
            break

if __name__ == "__main__":
    chat_loop()
