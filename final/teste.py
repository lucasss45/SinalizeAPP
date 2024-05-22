import time
import sys
import cv2
import numpy as np
import matplotlib.pyplot as plt
from base64 import b64decode
import io
from PIL import Image

# Adicione o caminho da pasta de módulos
sys.path.append(r'C:\Users\Win10\Desktop\IA\final\content\modulos')

# Verifique se o caminho foi adicionado corretamente
print(sys.path)

import extrator_POSICAO as posicao
import extrator_ALTURA como altura
import extrator_PROXIMIDADE como proximidade
import alfabeto

# Função para capturar uma imagem da webcam
def take_photo():
    cap = cv2.VideoCapture(0)
    if not cap.isOpened():
        raise IOError("Cannot open webcam")
    
    ret, frame = cap.read()
    if not ret:
        raise IOError("Cannot read from webcam")
    
    cap.release()
    cv2.destroyAllWindows()
    
    return frame

# Captura da imagem
frame = take_photo()

# Caminhos para os arquivos do modelo
arquivoProto = r"C:\Users\Win10\Desktop\IA\final\content\pose\hand\pose_deploy.prototxt"
modeloCaffe = r"C:\Users\Win10\Desktop\IA\final\content\pose\hand\pose_iter_102000.caffemodel"

# Parâmetros de configuração
nPontos = 22
PARES_POSE = [[0, 1], [1, 2], [2, 3], [3, 4], [0, 5], [5, 6], [6, 7], [7, 8], [0, 9], [9, 10], [10, 11], [11, 12],
              [0, 13], [13, 14], [14, 15], [15, 16], [0, 17], [17, 18], [18, 19], [19, 20]]

letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'I', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W']

net = cv2.dnn.readNetFromCaffe(arquivoProto, modeloCaffe)

limite = 0.1

frameCopia = np.copy(frame)

frameLargura = frame.shape[1]
frameAltura = frame.shape[0]
janela = frameLargura / frameAltura

corPonto_A, corPonto_B, corLinha, corTxtPonto, corTxtAprov, corTxtWait = (14, 201, 255), (255, 0, 128), (192, 192, 192), \
                                                                         (10, 216, 245), (255, 0, 128), (192, 192, 192)
tamFont, tamLine, tamCircle, espessura = 2, 1, 4, 2
fonte = cv2.FONT_HERSHEY_SIMPLEX

t = time.time()
entradaAltura = 368
entradaLargura = int(((janela * entradaAltura) * 8) // 8)

inpBlob = cv2.dnn.blobFromImage(frame, 1.0 / 255, (entradaLargura, entradaAltura), (0, 0, 0), swapRB=False, crop=False)

net.setInput(inpBlob)
saida = net.forward()
print("Tempo da Rede: {:.2f} sec".format(time.time() - t))

pontos = []

tamanho = cv2.resize(frame, (frameLargura, frameAltura))
mapaSuave = cv2.GaussianBlur(tamanho, (3, 3), 0, 0)
fundo = np.uint8(mapaSuave > limite)

for i in range(nPontos):
    mapaConfianca = saida[0, i, :, :]
    mapaConfianca = cv2.resize(mapaConfianca, (frameLargura, frameAltura))

    minVal, confianca, minLoc, ponto = cv2.minMaxLoc(mapaConfianca)

    if confianca > limite:
        cv2.circle(frameCopia, (int(ponto[0]), int(ponto[1])), 5, corPonto_A, thickness=espessura, lineType=cv2.FILLED)
        cv2.putText(frameCopia, ' ' + (str(int(ponto[0]))) + ',' + str(int(ponto[1])), (int(ponto[0]), int(ponto[1])),
                    fonte, 0.3, corTxtAprov, 0, lineType=cv2.LINE_AA)

        cv2.circle(frame, (int(ponto[0]), int(ponto[1])), tamCircle, corPonto_A, thickness=espessura,
                   lineType=cv2.FILLED)
        cv2.putText(frame, ' ' + "{}".format(i), (int(ponto[0]), int(ponto[1])), cv2.FONT_HERSHEY_SIMPLEX, 0.3,
                    corTxtAprov, 0, lineType=cv2.LINE_AA)

        cv2.circle(fundo, (int(ponto[0]), int(ponto[1])), tamCircle, corPonto_A, thickness=espessura,
                   lineType=cv2.FILLED)
        cv2.putText(fundo, ' ' + "{}".format(i), (int(ponto[0]), int(ponto[1])), cv2.FONT_HERSHEY_SIMPLEX, 0.3,
                    corTxtAprov, 0, lineType=cv2.LINE_AA)

        pontos.append((int(ponto[0]), int(ponto[1])))

    else:
        pontos.append((0, 0))

for par in PARES_POSE:
    partA = par[0]
    partB = par[1]

    if pontos[partA] != (0, 0) and pontos[partB] != (0, 0):
        cv2.line(frameCopia, pontos[partA], pontos[partB], corLinha, tamLine, lineType=cv2.LINE_AA)
        cv2.line(frame, pontos[partA], pontos[partB], corLinha, tamLine, lineType=cv2.LINE_AA)
        cv2.line(fundo, pontos[partA], pontos[partB], corLinha, tamLine, lineType=cv2.LINE_AA)

posicao.posicoes = []

# Dedo polegar
posicao.verificar_posicao_DEDOS(pontos[1:5], 'polegar', altura.verificar_altura_MAO(pontos))

# Dedo indicador
posicao.verificar_posicao_DEDOS(pontos[5:9], 'indicador', altura.verificar_altura_MAO(pontos))

# Dedo médio
posicao.verificar_posicao_DEDOS(pontos[9:13], 'medio', altura.verificar_altura_MAO(pontos))

# Dedo anelar
posicao.verificar_posicao_DEDOS(pontos[13:17], 'anelar', altura.verificar_altura_MAO(pontos))

# Dedo mínimo
posicao.verificar_posicao_DEDOS(pontos[17:21], 'minimo', altura.verificar_altura_MAO(pontos))

print(proximidade.verificar_proximidade_DEDOS(pontos))

for i, a in enumerate(alfabeto.letras):
    if proximidade.verificar_proximidade_DEDOS(pontos) == alfabeto.letras[i]:
        cv2.putText(frame, '' + letras[i], (50, 50), fonte, 1.5, corTxtAprov, tamFont,
                    lineType=cv2.LINE_AA)

# Exibir as imagens
plt.figure(figsize=[7, 5])
plt.imshow(cv2.cvtColor(frame, cv2.COLOR_BGR2RGB))
plt.title("Imagem com pontos e letras")

plt.figure(figsize=[7, 5])
plt.imshow(cv2.cvtColor(frameCopia, cv2.COLOR_BGR2RGB))
plt.title("Imagem com pontos conectados")

plt.figure(figsize=[7, 5])
plt.imshow(fundo, cmap='gray')
plt.title("Imagem de fundo")

plt.show()

print("Tempo total de execução: {:.3f} segundos".format(time.time() - t))

cv2.waitKey(0)
