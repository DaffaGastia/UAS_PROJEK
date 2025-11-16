@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Customer Service AI - Mocha Jane</h4>
    <div id="chat-box" class="border rounded p-3 mb-3" style="height:300px; overflow-y:auto;">
    </div>
    <div class="input-group">
        <input type="text" id="message" class="form-control" placeholder="Ketik pesan...">
        <button id="send-btn" class="btn btn-primary">Kirim</button>
    </div>
</div>

<script>
document.getElementById('send-btn').addEventListener('click', async () => {
    const message = document.getElementById('message').value.trim();
    if (!message) return;
    const box = document.getElementById('chat-box');
    box.innerHTML += `<p><strong>Kamu:</strong> ${message}</p>`;
    document.getElementById('message').value = '';
    const response = await fetch('{{ route("chat.ai") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
    });
    const data = await response.json();
    box.innerHTML += `<p><strong>AI:</strong> ${data.reply}</p>`;
    box.scrollTop = box.scrollHeight;
});
</script>
@endsection
