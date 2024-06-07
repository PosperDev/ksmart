document.getElementById('chat-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        // Evitar el comportamiento predeterminado de Enter
        e.preventDefault();
        // Salto de línea en el cuadro de texto
        this.value += '\n';
    } else if (e.key === 'Enter' && e.ctrlKey) {
        // Envía el mensaje si se presiona Ctrl + Enter
        sendMessage();
    }
});

function toggleChat() {
    const chatWindow = document.getElementById('chat-window');
    chatWindow.style.display = chatWindow.style.display === 'none' ? 'block' : 'none';
}

function sendMessage() {
    const chatInput = document.getElementById('chat-input');
    const message = chatInput.value.trim();
    if (message === '') return;

    const chatBody = document.getElementById('chat-body');
    const userMessageDiv = document.createElement('div');
    userMessageDiv.textContent = message;
    userMessageDiv.className = 'bg-gray-200 p-2 rounded my-2';
    chatBody.appendChild(userMessageDiv);

    chatInput.value = '';

    // Simulate bot response
    setTimeout(() => {
        const botMessageDiv = document.createElement('div');
        botMessageDiv.textContent = 'Respuesta automática del bot';
        botMessageDiv.className = 'bg-blue-100 p-2 rounded my-2';
        chatBody.appendChild(botMessageDiv);

        chatBody.scrollTop = chatBody.scrollHeight;
    }, 1000);
}
