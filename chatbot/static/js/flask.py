from flask import Flask, request, jsonify
import chat.py  # Importe seu chatbot

app = Flask(__name__)

@app.route('/chat', methods=['POST'])
def chat():
    mensagem = request.json.get('msg')
    resposta = seu_chatbot.obter_resposta(mensagem)  # Supondo que você tenha uma função obter_resposta no seu chatbot
    return jsonify({'resposta': resposta})

if __name__ == '__main__':
    app.run(debug=True)
