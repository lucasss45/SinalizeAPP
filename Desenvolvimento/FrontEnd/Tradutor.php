<?php
    include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real-Time LIBRAS Recognition</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/handpose"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/knn-classifier"></script>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IALibras</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/handpose"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/knn-classifier"></script>
    <style>
        #container {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-bottom: 10px;
        }

        #videoContainer {
            border: 1px solid black; /* Adiciona a borda preta */
            border-radius: 10px; /* Adiciona a borda preta */
            padding: 10px; /* Adiciona espaço interno para a borda */
            margin-bottom: 10px;
        }

        #video {
            width: 100%; /* Ajusta o vídeo para ocupar 100% da largura do container */
            border-radius: 10px; /* Adiciona borda arredondada ao vídeo */
        }

        #buttonContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap; /* Permite que os botões quebrem para a próxima linha */
        }

        button {
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ffc107;
            background-color: transparent;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        button:hover {
            background-color: #ffc107;
            color: #fff;
        }

        input[type="text"] {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 5px;
            width: 70%; /* Define a largura do input como 100% */
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="videoContainer">
            <video id="video" autoplay style="display:none;"></video>
            <canvas id="outputCanvas"></canvas>
        </div>
        <div id="buttonContainer">
            <input type="text" id="letterInput" placeholder="Enter a letter" maxlength="1" style="margin-bottom: 5px;">
            <button onclick="startAddingExamples()">Start Adding Examples</button>
            <button onclick="saveModel()">Save Model</button>
            <input type="file" id="loadModelInput" style="display:none;" onchange="loadModel(event)">
            <button onclick="document.getElementById('loadModelInput').click()">Load Model</button>
        </div>
    </div>
    <script type="text/javascript">
        let model, classifier;
        let addExampleInterval;
        const classes = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split(''); // Define all possible classes

        async function main() {
            const video = document.getElementById('video');
            const outputCanvas = document.getElementById('outputCanvas');
            const outputContext = outputCanvas.getContext('2d');

            model = await handpose.load();
            classifier = knnClassifier.create();

            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error('Error accessing media devices.', err);
                });

            video.addEventListener('play', async () => {
                outputCanvas.width = video.videoWidth;
                outputCanvas.height = video.videoHeight;

                async function processFrame() {
                    outputContext.drawImage(video, 0, 0, outputCanvas.width, outputCanvas.height);

                    const predictions = await model.estimateHands(video);

                    if (predictions.length > 0) {
                        const landmarks = predictions[0].landmarks;

                        // Draw hand landmarks
                        for (let i = 0; i < landmarks.length; i++) {
                            const x = landmarks[i][0];
                            const y = landmarks[i][1];
                            outputContext.beginPath();
                            outputContext.arc(x, y, 5, 0, 2 * Math.PI);
                            outputContext.fillStyle = 'yellow';
                            outputContext.fill();
                        }

                        // Convert landmarks to tensor and classify
                        if (classifier.getNumClasses() > 0) {
                            const tensor = tf.tensor(landmarks.flat());
                            const result = await classifier.predictClass(tensor);

                            const label = classes[result.label] || 'Unknown'; // Use 'Unknown' if the label is not found in classes array
                            const probability = result.confidences[result.label] || 0;

                            console.log(`Recognized ${label} with confidence ${probability.toFixed(2)}`);
                            outputContext.font = '20px Arial';
                            outputContext.fillStyle = 'blue';
                            outputContext.fillText(`${label}: ${probability.toFixed(2)}`, 10, 30);
                        } else {
                            console.log('Add examples to start classification');
                            outputContext.font = '20px Arial';
                            outputContext.fillStyle = 'yellow';
                            outputContext.fillText('Add examples to start classification', 10, 30);
                        }
                    }

                    requestAnimationFrame(processFrame);
                }

                processFrame();
            });
        }

        function startAddingExamples() {
            const letterInput = document.getElementById('letterInput');
            const label = letterInput.value.toUpperCase();

            if (!classes.includes(label)) {
                alert('Please enter a valid letter.');
                return;
            }

            addExampleInterval = setInterval(() => {
                addExample(label);
            }, 150); // Capture examples every 150ms

            setTimeout(() => {
                clearInterval(addExampleInterval);
                alert(`Finished adding examples for ${label}`);
            }, 10000); // Stop capturing after 10 seconds
        }

        function addExample(label) {
            const video = document.getElementById('video');

            model.estimateHands(video).then(predictions => {
                if (predictions.length > 0) {
                    const landmarks = predictions[0].landmarks;
                    const tensor = tf.tensor(landmarks.flat());
                    classifier.addExample(tensor, classes.indexOf(label));
                    console.log(`Added example for ${label}`);
                } else {
                    console.log('No hand detected');
                }
            });
        }

        async function saveModel() {
            const dataset = classifier.getClassifierDataset();
            const datasetObj = {};

            Object.keys(dataset).forEach(key => {
                datasetObj[key] = dataset[key].arraySync();
            });

            const jsonStr = JSON.stringify(datasetObj);
            const blob = new Blob([jsonStr], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'model.json';
            a.click();
            URL.revokeObjectURL(url);
        }

        function loadModel(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = async function(e) {
                const dataset = JSON.parse(e.target.result);
                const tensorObj = {};

                Object.keys(dataset).forEach(key => {
                    tensorObj[key] = tf.tensor(dataset[key]);
                });

                classifier.setClassifierDataset(tensorObj);
                alert('Model loaded successfully');
            };
            reader.readAsText(file);
        }

        main();
    </script>
</body>
</html>
