<?php include(APPPATH . 'Views/header.php'); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

    * {
        box-sizing: border-box;
    }

    .chat-wrapper {
        max-width: 100%;
        margin: 0;
        position: relative;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .chat-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px 20px 0 0;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
    }

    .ai-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #ff6b6b, #ffd93d);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        animation: pulse 2s infinite;
        box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .chat-title {
        color: white;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .chat-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin: 5px 0 0 0;
        font-weight: 400;
    }

    .chat-container {
        background: white;
        border-left: 1px solid #e9ecef;
        border-right: 1px solid #e9ecef;
        height: 350px;
        overflow-y: auto;
        padding: 20px;
        position: relative;
        scroll-behavior: smooth;
    }

    .chat-container::-webkit-scrollbar {
        width: 6px;
    }

    .chat-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-container::-webkit-scrollbar-thumb {
        background: rgba(102, 126, 234, 0.3);
        border-radius: 10px;
    }

    .chat-container::-webkit-scrollbar-thumb:hover {
        background: rgba(102, 126, 234, 0.5);
    }

    .message-wrapper {
        display: flex;
        margin: 20px 0;
        opacity: 0;
        animation: messageSlide 0.5s ease-out forwards;
    }

    @keyframes messageSlide {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-wrapper.user {
        justify-content: flex-end;
    }

    .message-wrapper.bot {
        justify-content: flex-start;
    }

    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin: 0 12px;
        flex-shrink: 0;
    }

    .user-avatar {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }

    .bot-avatar {
        background: linear-gradient(135deg, #ff6b6b, #ffd93d);
        color: white;
        box-shadow: 0 4px 20px rgba(255, 107, 107, 0.3);
    }

    .chat-message {
        max-width: 60%;
        padding: 16px 20px;
        border-radius: 20px;
        position: relative;
        line-height: 1.5;
        font-size: 15px;
        word-wrap: break-word;
    }

    .user-message {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        border-bottom-right-radius: 6px;
    }

    .bot-message {
        background: white;
        color: #2c3e50;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-bottom-left-radius: 6px;
    }

    .input-section {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-top: none;
        border-radius: 0 0 20px 20px;
        padding: 20px 25px;
    }

    .input-container {
        display: flex;
        gap: 15px;
        align-items: center;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50px;
        padding: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .input-field {
        flex: 1;
        border: none;
        background: transparent;
        padding: 15px 20px;
        font-size: 16px;
        outline: none;
        color: #2c3e50;
        font-family: 'Inter', sans-serif;
    }

    .input-field::placeholder {
        color: #95a5a6;
    }

    .send-button {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 18px;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    }

    .send-button:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.6);
    }

    .send-button:active {
        transform: translateY(0) scale(0.95);
    }

    .typing-indicator {
        display: none;
        padding: 16px 20px;
        background: white;
        border-radius: 20px;
        border-bottom-left-radius: 6px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        margin: 20px 0;
        max-width: 60%;
    }

    .typing-dots {
        display: flex;
        gap: 4px;
    }

    .typing-dot {
        width: 8px;
        height: 8px;
        background: #95a5a6;
        border-radius: 50%;
        animation: typingDots 1.5s infinite;
    }

    .typing-dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typingDots {

        0%,
        60%,
        100% {
            transform: translateY(0);
            opacity: 0.4;
        }

        30% {
            transform: translateY(-10px);
            opacity: 1;
        }
    }

    .empty-state {
        text-align: center;
        color: #95a5a6;
        margin-top: 60px;
    }

    .empty-state-icon {
        font-size: 40px;
        margin-bottom: 15px;
        opacity: 0.7;
    }

    .empty-state-text {
        font-size: 18px;
        margin-bottom: 8px;
    }

    .empty-state-subtext {
        font-size: 14px;
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        .chat-header {
            padding: 20px;
        }

        .chat-title {
            font-size: 20px;
        }

        .chat-container {
            height: 300px;
            padding: 15px;
        }

        .chat-message {
            max-width: 85%;
            font-size: 14px;
        }

        .input-section {
            padding: 20px;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .chat-container {
            height: 350px;
            padding: 15px;
        }

        .chat-message {
            max-width: 90%;
            padding: 12px 16px;
        }

        .input-field {
            padding: 12px 16px;
            font-size: 15px;
        }

        .send-button {
            width: 44px;
            height: 44px;
        }
    }

    /* Estilos para los botones de regresar */
    .action-buttons {
        margin-top: 20px;
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-custom {
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        color: white;
    }

    .btn-custom::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
    }

    .btn-custom:hover::before {
        width: 300px;
        height: 300px;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-custom {
            width: 100%;
            max-width: 250px;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card patient-card">
                <div class="card-body-custom">
                    <div class="chat-wrapper">
                        <div class="chat-header">
                            <div class="ai-avatar">🤖</div>
                            <div>
                                <h1 class="chat-title">Asistente IA</h1>
                                <p class="chat-subtitle">Pregúntame lo que necesites</p>
                            </div>
                        </div>

                        <div class="chat-container" id="chatBox">
                            <div class="empty-state" id="emptyState">
                                <div class="empty-state-icon">💬</div>
                                <div class="empty-state-text">¡Hola! Soy tu asistente de IA</div>
                                <div class="empty-state-subtext">Escribe un mensaje para comenzar nuestra conversación</div>
                            </div>

                            <div class="typing-indicator" id="typingIndicator">
                                <div class="typing-dots">
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                    <div class="typing-dot"></div>
                                </div>
                            </div>
                        </div>

                        <div class="input-section">
                            <div class="input-container">
                                <input type="text" class="input-field" id="userInput" placeholder="Escribe tu mensaje aquí..." autocomplete="off">
                                <button class="send-button" onclick="sendMessage()" id="sendBtn">
                                    <span>➤</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <a href="<?php echo base_url('patients'); ?>" class="btn btn-custom btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>



<script>
    const chatBox = document.getElementById('chatBox');
    const userInput = document.getElementById('userInput');
    const sendBtn = document.getElementById('sendBtn');
    const typingIndicator = document.getElementById('typingIndicator');
    const emptyState = document.getElementById('emptyState');
    let messageCount = 0;

    function addMessage(message, isUser = false) {
        // Ocultar estado vacío después del primer mensaje
        if (messageCount === 0) {
            emptyState.style.display = 'none';
        }

        const messageWrapper = document.createElement('div');
        messageWrapper.classList.add('message-wrapper', isUser ? 'user' : 'bot');

        const avatar = document.createElement('div');
        avatar.classList.add('message-avatar', isUser ? 'user-avatar' : 'bot-avatar');
        avatar.innerHTML = isUser ? '👤' : '🤖';

        const messageDiv = document.createElement('div');
        messageDiv.classList.add('chat-message', isUser ? 'user-message' : 'bot-message');
        messageDiv.textContent = message;

        if (isUser) {
            messageWrapper.appendChild(messageDiv);
            messageWrapper.appendChild(avatar);
        } else {
            messageWrapper.appendChild(avatar);
            messageWrapper.appendChild(messageDiv);
        }

        chatBox.appendChild(messageWrapper);
        messageCount++;

        // Scroll suave al final
        setTimeout(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 100);
    }

    function showTyping() {
        typingIndicator.style.display = 'block';
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function hideTyping() {
        typingIndicator.style.display = 'none';
    }

    function sendMessage() {
        const prompt = userInput.value.trim();
        if (!prompt) return;

        // Deshabilitar input mientras se procesa
        userInput.disabled = true;
        sendBtn.disabled = true;
        sendBtn.style.opacity = '0.6';

        addMessage(prompt, true);
        userInput.value = '';

        // Mostrar indicador de escritura
        showTyping();

        fetch('<?php echo base_url('ia/getResponse'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'prompt=' + encodeURIComponent(prompt)
            })
            .then(response => response.json())
            .then(data => {
                hideTyping();

                if (data.error) {
                    addMessage('❌ Error: ' + data.error);
                } else {
                    // Simular delay de escritura para mejor UX
                    setTimeout(() => {
                        addMessage(data.response || 'No recibí respuesta del servidor');
                    }, 500);
                }
            })
            .catch(error => {
                hideTyping();
                setTimeout(() => {
                    addMessage('🔌 Error de conexión: No se pudo conectar con la IA. Por favor, intenta de nuevo.');
                }, 500);
                console.error('Error:', error);
            })
            .finally(() => {
                // Rehabilitar input
                userInput.disabled = false;
                sendBtn.disabled = false;
                sendBtn.style.opacity = '1';
                userInput.focus();
            });
    }

    // Enviar mensaje con Enter
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Auto-focus en el input
    userInput.focus();

    // Prevenir zoom en iOS
    userInput.addEventListener('focus', function() {
        if (window.innerWidth < 768) {
            document.querySelector('meta[name=viewport]').setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1');
        }
    });

    userInput.addEventListener('blur', function() {
        if (window.innerWidth < 768) {
            document.querySelector('meta[name=viewport]').setAttribute('content', 'width=device-width, initial-scale=1');
        }
    });
</script>

<?php include(APPPATH . 'Views/footer.php'); ?>