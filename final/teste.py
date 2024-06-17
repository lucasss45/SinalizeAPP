import cv2
import numpy as np
import time
import matplotlib.pyplot as plt

import extrator_POSICAO as posicao
import extrator_ALTURA as altura
import extrator_PROXIMIDADE as proximidade
import extrator_CORPO as corpo
import alfabeto

# Configurações
arquivo_proto = "pose_deploy.prototxt"
modeloCaffe = "pose_iter_102000.caffemodel"
nPontos = 22
PARES_POSE = [[0, 1], [1, 2], [2, 3], [3, 4], [0, 5], [5, 6], [6, 7], [7, 8], [0, 9], [9, 10], [10, 11], [11, 12],
              [0, 13], [13, 14], [14, 15], [15, 16], [0, 17], [17, 18], [18, 19], [19, 20]]

letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'I', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W']
corPonto_A, corPonto_B, corLinha, corTxtPonto, corTxtAprov, corTxtWait = (14, 201, 255), (255, 0, 128), (
192, 192, 192), (10, 216, 245), (255, 0, 128), (192, 192, 192)
tamFont, tamLine, tamCircle, espessura = 2, 1, 4, 2
fonte = cv2.FONT_HERSHEY_SIMPLEX
limite = 0.1

cap = cv2.VideoCapture(0)
hasFrame, frame = cap.read()

frameLargura = frame.shape[1]
frameAltura = frame.shape[0]
janela = frameLargura / frameAltura

entradaAltura = 256
entradaLargura = int(((janela * entradaAltura) * 8) // 8)

net = cv2.dnn.readNetFromCaffe(arquivo_proto, modeloCaffe)

# Loop principal
while True:
    t = time.time()
    hasFrame, frame = cap.read()
    frameCopia = np.copy(frame)

    # Criando a máscara para exibir somente o esqueleto em um fundo preto
    tamanho = cv2.resize(frame, (frameLargura, frameAltura))
    mapaSuave = cv2.GaussianBlur(tamanho, (3, 3), 0, 0)
    fundo = np.uint8(mapaSuave > limite)

    if not hasFrame:
        cv2.waitKey()
        break

    inpBlob = cv2.dnn.blobFromImage(frame, 1.0 / 255, (entradaLargura, entradaAltura), (0, 0, 0), swapRB=False, crop=False)
    net.setInput(inpBlob)
    saida = net.forward()
    pontos = []

    for i in range(nPontos):
        probMap = saida[0, i, :, :]
        probMap = cv2.resize(probMap, (frameLargura, frameAltura))
        minVal, prob, minLoc, point = cv2.minMaxLoc(probMap)

        if prob > limite:
            pontos.append((int(point[0]), int(point[1])))
        else:
            pontos.append((0, 0))

    # Desenhar Esqueleto
    for par in PARES_POSE:
        partA = par[0]
        partB = par[1]

        if pontos[partA] != (0, 0) and pontos[partB] != (0, 0):
            cv2.line(frameCopia, pontos[partA], pontos[partB], corLinha, tamLine, lineType=cv2.LINE_AA)
            cv2.circle(frameCopia, pontos[partA], tamCircle, corPonto_A, thickness=espessura, lineType=cv2.FILLED)
            cv2.circle(frameCopia, pontos[partB], tamCircle, corPonto_B, thickness=espessura, lineType=cv2.FILLED)

            cv2.line(fundo, pontos[partA], pontos[partB], corLinha, tamLine, lineType=cv2.LINE_AA)
            cv2.circle(fundo, pontos[partA], tamCircle, corPonto_A, thickness=espessura, lineType=cv2.FILLED)
            cv2.circle(fundo, pontos[partB], tamCircle, corPonto_B, thickness=espessura, lineType=cv2.FILLED)

    posicao.posicoes = []

    # Verificar posições dos dedos
    posicao.verificar_posicao_DEDOS(pontos[1:5], 'polegar', altura.verificar_altura_MAO(pontos))
    posicao.verificar_posicao_DEDOS(pontos[5:9], 'indicador', altura.verificar_altura_MAO(pontos))
    posicao.verificar_posicao_DEDOS(pontos[9:13], 'medio', altura.verificar_altura_MAO(pontos))
    posicao.verificar_posicao_DEDOS(pontos[13:17], 'anelar', altura.verificar_altura_MAO(pontos))
    posicao.verificar_posicao_DEDOS(pontos[17:21], 'minimo', altura.verificar_altura_MAO(pontos))

    # Verificar posições do corpo
    if corpo.verificar_bracos_ACIMA(pontos):
        cv2.putText(frameCopia, 'Bracos Acima', (50, 100), fonte, 1, corTxtAprov, tamFont, lineType=cv2.LINE_AA)
    elif corpo.verificar_bracos_ABAIXO(pontos):
        cv2.putText(frameCopia, 'Bracos Abaixo', (50, 100), fonte, 1, corTxtAprov, tamFont, lineType=cv2.LINE_AA)

    for i, a in enumerate(alfabeto.letras):
        if proximidade.verificar_proximidade_DEDOS(pontos) == alfabeto.letras[i]:
            cv2.putText(frameCopia, 'Letra: ' + letras[i], (50, 50), fonte, 1, corTxtAprov, tamFont, lineType=cv2.LINE_AA)
        else:
            cv2.putText(frameCopia, 'Analisando', (250, 50), fonte, 1, corTxtWait, tamFont, lineType=cv2.LINE_AA)

    # Exibir a saída
    cv2.imshow('Esqueleto', frameCopia)

    key = cv2.waitKey(1)
    if key == 27:
        break

    print("Tempo total = {:.2f}seg".format(time.time() - t))

cap.release()
cv2.destroyAllWindows()