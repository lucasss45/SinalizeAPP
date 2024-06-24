from flask import Flask, request, jsonify
import random
import json
import torch
import os

from model import NeuralNet
from nltk_utils import bag_of_words, tokenize

app = Flask(__name__)

device = torch.device('cuda' if torch.cuda.is_available() else 'cpu')

# Obtenha o caminho absoluto do diretório atual
current_dir = os.path.dirname(os.path.abspath(__file__))
# Combine o caminho absoluto com o nome do arquivo
file_path = os.path.join(current_dir, 'intents.json')

if os.path.exists(file_path):
    with open(file_path, 'r') as f:
        intents = json.load(f)

FILE = "data.pth"
data = torch.load(FILE)

input_size = data["input_size"]
hidden_size = data["hidden_size"]
output_size = data["output_size"]
all_words = data['all_words']
tags = data['tags']
model_state = data["model_state"]

model = NeuralNet(input_size, hidden_size, output_size).to(device)
model.load_state_dict(model_state)
model.eval()

@app.route('/')
def home():
    return "Servidor Flask funcionando"

@app.route('/chat', methods=['POST'])
def chat():
    data = request.get_json()

    sentence = data['mensagem']
    sentence = tokenize(sentence)
    X = bag_of_words(sentence, all_words)
    X = X.reshape(1, X.shape[0])
    X = torch.from_numpy(X).to(device)

    output = model(X)
    _, predicted = torch.max(output, dim=1)

    tag = tags[predicted.item()]

    probs = torch.softmax(output, dim=1)
    prob = probs[0][predicted.item()]
    if prob.item() > 0.75:
        for intent in intents['intents']:
            if tag == intent["tag"]:
                response = random.choice(intent['responses'])
                return jsonify({'resposta': response})
    else:
        return jsonify({'resposta': "Desculpe, não entendi..."})

if __name__ == "__main__":
    app.run(debug=True)
