document.addEventListener("DOMContentLoaded", function () {
    const chat = document.getElementById("chat");
    const input = document.getElementById("input");
    const botaoEnviar = document.getElementById("botao-enviar");

    botaoEnviar.addEventListener('click', enviarMensagem);
    input.addEventListener("keyup", function (event) {
        event.preventDefault();
        if (event.key === "Enter") {
            enviarMensagem();
        }
    });

    async function enviarMensagem() {
        if (!input.value.trim()) return;

        const mensagem = input.value.trim();
        input.value = "";

        const novaBolhaUsuario = criaBolhaUsuario();
        novaBolhaUsuario.textContent = mensagem;
        chat.appendChild(novaBolhaUsuario);

        const resposta = await obterRespostaDoServidor(mensagem);
        const novaBolhaBot = criaBolhaBot();
        novaBolhaBot.innerHTML = resposta;
        chat.appendChild(novaBolhaBot);

        vaiParaFinalDoChat();
    }

    async function obterRespostaDoServidor(mensagem) {
        try {
            // Envia a mensagem para chatbot.php via POST
            const response = await fetch('chatbot.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'mensagem': mensagem
                })
            });
            const data = await response.json();
            return data.resposta;
        } catch (error) {
            console.error('Erro:', error);
            return 'Desculpe, ocorreu um erro.';
        }
    }

    function criaBolhaBot() {
        const bolhaBot = document.createElement('p');
        bolhaBot.classList = 'chat__bolha chat__bolha--bot';
        return bolhaBot;
    }

    function criaBolhaUsuario() {
        const bolhaUsuario = document.createElement('p');
        bolhaUsuario.classList = 'chat__bolha chat__bolha--usuario';
        return bolhaUsuario;
    }

    function vaiParaFinalDoChat() {
        chat.scrollTop = chat.scrollHeight;
    }
});
