@extends('layouts.app')
@section('title', 'Chat AI - Mocha Jane Bakery')

@section('content')
<div class="chat-container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card chat-card border-0 shadow">
                <div class="card-header chat-header">
                    <div class="d-flex align-items-center">
                        <div class="chat-avatar me-3">
                            <div class="avatar-circle">
                                <i class="bi bi-robot"></i>
                            </div>
                            <span class="status-dot"></span>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Mocha AI Assistant</h5>
                            <small class="text-white-50">
                                <i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>
                                Online - Siap membantu Anda
                            </small>
                        </div>
                    </div>
                    <div class="header-actions">
                        <button class="btn btn-icon" id="clearChat" title="Hapus Chat">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body chat-messages" id="chatMessages">
                    <div class="message bot-message">
                        <div class="message-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="message-content">
                            <div class="message-bubble">
                                <p class="mb-2">Halo! 👋 Selamat datang di <strong>Mocha Jane Bakery</strong>!</p>
                                <p class="mb-2">Saya <strong>Mocha</strong>, asisten virtual yang siap membantu Anda.</p>
                                <p class="mb-0">Ada yang bisa saya bantu hari ini? 😊</p>
                            </div>
                            <span class="message-time">{{ now()->format('H:i') }}</span>
                        </div>
                    </div>

                    <div class="quick-actions">
                        <p class="quick-label">Pertanyaan Populer:</p>
                        <div class="quick-buttons">
                            <button class="quick-btn" data-message="Apa saja produk yang tersedia?">
                                <i class="bi bi-bag"></i> Daftar Produk
                            </button>
                            <button class="quick-btn" data-message="Berapa harga roti coklat?">
                                <i class="bi bi-tag"></i> Cek Harga
                            </button>
                            <button class="quick-btn" data-message="Dimana lokasi toko?">
                                <i class="bi bi-geo-alt"></i> Lokasi Toko
                            </button>
                            <button class="quick-btn" data-message="Jam buka toko kapan?">
                                <i class="bi bi-clock"></i> Jam Buka
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-footer chat-input-wrapper">
                    <form id="chatForm" class="chat-form">
                        @csrf
                        <div class="input-group">
                            <input 
                                type="text" 
                                class="form-control chat-input" 
                                id="messageInput"
                                placeholder="Ketik pesan Anda..."
                                autocomplete="off"
                                maxlength="1000"
                                required>
                            <button type="submit" class="btn btn-send" id="sendBtn">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                        <small class="text-muted mt-1 d-block">
                            Tekan Enter untuk mengirim pesan
                        </small>
                    </form>
                </div>
            </div>

            <!-- <div class="card info-card border-0 shadow-sm mt-3">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center justify-content-center gap-4 flex-wrap">
                        <div class="info-item">
                            <i class="bi bi-shield-check text-success"></i>
                            <span>100% Aman</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-lightning text-warning"></i>
                            <span>Respons Cepat</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-clock text-primary"></i>
                            <span>24/7 Online</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');
    const sendBtn = document.getElementById('sendBtn');
    const clearBtn = document.getElementById('clearChat');
    const quickBtns = document.querySelectorAll('.quick-btn');

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            sendMessage(message);
        }
    });

    quickBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const message = this.dataset.message;
            sendMessage(message);
        });
    });

    clearBtn.addEventListener('click', function() {
        if (confirm('Hapus semua riwayat chat?')) {
            const messages = chatMessages.querySelectorAll('.message:not(:first-child), .quick-actions');
            messages.forEach(msg => msg.remove());
            
            addQuickActions();
        }
    });

    function sendMessage(message) {
        appendMessage(message, 'user');
        messageInput.value = '';
        
        const quickActions = chatMessages.querySelector('.quick-actions');
        if (quickActions) quickActions.style.display = 'none';

        showTyping();

        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            hideTyping();
            if (data.success) {
                appendMessage(data.message, 'bot');
            } else {
                appendMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
            }
        })
        .catch(error => {
            hideTyping();
            appendMessage('Maaf, tidak dapat terhubung ke server.', 'bot');
            console.error('Error:', error);
        });
    }

    function appendMessage(text, sender) {
        const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        const icon = sender === 'bot' ? 'bi-robot' : 'bi-person-fill';
        
        const formattedText = text
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        const messageHtml = `
            <div class="message ${sender}-message">
                <div class="message-avatar">
                    <i class="bi ${icon}"></i>
                </div>
                <div class="message-content">
                    <div class="message-bubble">
                        <p class="mb-0">${formattedText}</p>
                    </div>
                    <span class="message-time">${time}</span>
                </div>
            </div>
        `;

        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
        scrollToBottom();
    }

    function showTyping() {
        sendBtn.disabled = true;
        const typingHtml = `
            <div class="message bot-message typing-message">
                <div class="message-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        chatMessages.insertAdjacentHTML('beforeend', typingHtml);
        scrollToBottom();
    }

    function hideTyping() {
        sendBtn.disabled = false;
        const typing = chatMessages.querySelector('.typing-message');
        if (typing) typing.remove();
    }

    function addQuickActions() {
        const quickActionsHtml = `
            <div class="quick-actions">
                <p class="quick-label">Pertanyaan Populer:</p>
                <div class="quick-buttons">
                    <button class="quick-btn" data-message="Apa saja produk yang tersedia?">
                        <i class="bi bi-bag"></i> Daftar Produk
                    </button>
                    <button class="quick-btn" data-message="Berapa harga roti coklat?">
                        <i class="bi bi-tag"></i> Cek Harga
                    </button>
                    <button class="quick-btn" data-message="Dimana lokasi toko?">
                        <i class="bi bi-geo-alt"></i> Lokasi Toko
                    </button>
                    <button class="quick-btn" data-message="Jam buka toko kapan?">
                        <i class="bi bi-clock"></i> Jam Buka
                    </button>
                </div>
            </div>
        `;
        chatMessages.insertAdjacentHTML('beforeend', quickActionsHtml);
        
        document.querySelectorAll('.quick-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                sendMessage(this.dataset.message);
            });
        });
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
</script>
@endpush