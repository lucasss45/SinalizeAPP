//index.js
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
            const response = await fetch('http://127.0.0.1:5000/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ msg: mensagem }),
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

// let chat = document.querySelector('#chat');
// let input = document.querySelector('#input');
// let botaoEnviar = document.querySelector('#botao-enviar');

// async function enviarMensagem() {
//     if (!input.value.trim()) return;

//     const mensagem = input.value.trim();
//     input.value = "";

//     const novaBolhaUsuario = criaBolhaUsuario();
//     novaBolhaUsuario.textContent = mensagem;
//     chat.appendChild(novaBolhaUsuario);

//     const novaBolhaBot = criaBolhaBot();
//     chat.appendChild(novaBolhaBot);
//     vaiParaFinalDoChat();

//     // Simulação da resposta da API localmente
//     if (window.location.hostname === "localhost") {
//         setTimeout(() => {
//             const respostaSimulada = "Resposta simulada do ChatBot para: " + mensagem;
//             const novaBolhaBotParte = criaBolhaBot();
//             novaBolhaBotParte.innerHTML = respostaSimulada;
//             chat.appendChild(novaBolhaBotParte);
//             vaiParaFinalDoChat();
//         }, 50000); // Simula um atraso de 1 segundo
//     } else {
//         // Envia requisição com a mensagem para a API do ChatBot
//         try {
//             const resposta = await fetch("http://127.0.0.1:5000/chat", {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/json",
//                 },
//                 body: JSON.stringify({ 'msg': mensagem }),
//             });

//             const decodificador = new TextDecoder();
//             const leitorDaResposta = resposta.body.getReader();
//             let respostaParcial = "";

//             while (true) {
//                 const { done: terminou, value: pedacoDaResposta } = await leitorDaResposta.read();
//                 if (terminou) break;

//                 respostaParcial += decodificador.decode(pedacoDaResposta).replace(/\n/g, '<br>');

//                 const novaBolhaBotParte = criaBolhaBot();
//                 novaBolhaBotParte.innerHTML = respostaParcial;
//                 chat.appendChild(novaBolhaBotParte);
//             }

//             vaiParaFinalDoChat();
//         } catch (erro) {
//             console.error("Erro na requisição:", erro);
//         }
//     }
// }

// // Restante do código ...

// function vaiParaFinalDoChat() {
//     chat.scrollTop = chat.scrollHeight;
// }
