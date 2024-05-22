A = ['polegar esticado vertical: afastado do indicador', 'indicador dobrado: proximo ao medio', 'medio dobrado: proximo ao anelar', 'anelar dobrado: proximo ao minimo', 'minimo dobrado: proximo ao anelar']
B = ['polegar dobrado: afastado do indicador', 'indicador esticado vertical: proximo ao medio', 'medio esticado vertical: proximo ao anelar', 'anelar esticado vertical: proximo ao minimo', 'minimo esticado vertical: proximo ao anelar']
C = ['polegar esticado horizontal: afastado do indicador', 'indicador esticado vertical: proximo ao medio', 'medio esticado vertical: proximo ao anelar', 'anelar esticado vertical: proximo ao minimo', 'minimo esticado vertical: proximo ao anelar']
D = ['polegar esticado horizontal: afastado do indicador', 'indicador esticado vertical: afastado do medio', 'medio dobrado: proximo ao anelar', 'anelar dobrado: proximo ao minimo', 'minimo dobrado: proximo ao anelar']

letras = [A, B, C, D, E, F, G, I, L, M, N, O, P, Q, R, S, T, U, V, W]

# não foram usadas as letras: H, J, K, X, ,Y , Z
# devido ao movimento adicional para a execução correta das letras.
# Estas letras podem ser analisadas em uma função diferente, semelhante a função de
# análise de posicionamento do corpo, onde comparamos a transição entre pontos

# Letra T: para o dedo polegar, devido a estar sobreposto pelo dedo indicador, o algoritmo não reconhece os pontos da ponta do dedo
# Letra N e U se confundem
