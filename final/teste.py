import time
import cv2
import numpy as np
import matplotlib.pyplot as plt

import extrator_POSICAO as posicao
import extrator_ALTURA as altura
import extrator_PROXIMIDADE as proximidade
import alfabeto
import sys
from IPython.display import HTML
from base64 import b64decode
import io
from PIL import Image

sys.path.append(r'C:\Users\Win10\Desktop\IA\final\content\modulos')

# Verificar se o caminho foi adicionado corretamente
print(sys.path)

import extrator_POSICAO as posicao
import extrator_ALTURA as altura
import extrator_PROXIMIDADE as proximidade
import alfabeto


VIDEO_HTML = """
<video autoplay
 width=%d height=%d style='cursor: pointer;'></video>
<script>
var video = document.querySelector('video')
navigator.mediaDevices.getUserMedia({ video: true })
  .then(stream => video.srcObject = stream)
var data = new Promise(resolve => {
  video.onclick = () => {
    var canvas = document.createElement('canvas')
    var [w, h] = [video.offsetWidth, video.offsetHeight]
    canvas.width = w
    canvas.height = h
    canvas.getContext('2d')
          .drawImage(video, 0, 0, w, h)
    video.srcObject.getVideoTracks()[0].stop()
    video.replaceWith(canvas)
    resolve(canvas.toDataURL('image/jpeg', %f))
  }
})
</script>
"""

def take_photo(filename='photo.jpg', quality=2, size=(400,300)):
  display(HTML(VIDEO_HTML % (size[0], size[1], quality)))
  data = eval_js("data")
  binary = b64decode(data.split(',')[1])
  f = io.BytesIO(binary)
  return np.asarray(Image.open(f))

cap = take_photo()  # Clicar na imagem da webcam para tirar uma foto

arquivoProto = r"C:\Users\Win10\Desktop\IA\final\content\pose\hand\pose_deploy.prototxt"
modeloCaffe = r"C:\Users\Win10\Desktop\IA\final\content\pose\hand\pose_iter_102000.caffemodel"

nPontos = 22
PARES_POSE = [[0, 1], [1, 2], [2, 3], [3, 4], [0, 5], [5, 6], [6, 7], [7, 8], [0, 9], [9, 10], [10, 11], [11, 12],
              [0, 13], [13, 14], [14, 15], [15, 16], [0, 17], [17, 18], [18, 19], [19, 20]]

letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'I', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W']

net = cv2.dnn.readNetFromCaffe(arquivoProto, modeloCaffe)

limite = 0.1

frame = cap

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
