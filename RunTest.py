#!/usr/bin/env python
import os
import wave
import time
import pickle
import pyaudio
import random
import string
from python_speech_features import mfcc
import numpy as np
import sys
from scipy.io import wavfile

FORMAT = pyaudio.paInt16
CHANNELS = 1
RATE = 44100
CHUNK = 512
RECORD_SECONDS = 10
device_index = 2
audio = pyaudio.PyAudio()
index = int(11)
audio = pyaudio.PyAudio()
stream = audio.open(format=FORMAT, channels=CHANNELS,
                    rate=RATE, input=True, input_device_index=index,
                    frames_per_buffer=CHUNK)
Recordframes = []
for i in range(0, int(RATE / CHUNK * RECORD_SECONDS)):
    data = stream.read(CHUNK)
    Recordframes.append(data)
stream.stop_stream()
stream.close()
audio.terminate()
waveFile = wave.open("tempfile.wav", 'wb')
waveFile.setnchannels(CHANNELS)
waveFile.setsampwidth(audio.get_sample_size(FORMAT))
waveFile.setframerate(RATE)
waveFile.writeframes(b''.join(Recordframes))
waveFile.close()
sample_rate, data = wavfile.read("tempfile.wav")
modelpath = "models/"
gmm_files = gmm_files = [os.path.join(modelpath, fname) for fname in
                         os.listdir(modelpath) if fname.endswith('.gmm')]
models = [pickle.load(open(fname, 'rb')) for fname in gmm_files]
ubm = pickle.load(open('testing_samples/UBM.gmm', 'rb'))
speakers = [fname.split("\\")[-1].split(".gmm")[0] for fname
            in gmm_files]
vector = mfcc(data, RATE, nfft=2048)
log_likelihood = np.zeros(len(models))
ubmscores = np.array(ubm.score(vector))
for i in range(len(models)):
    print(speakers[i])
    gmm = models[i]  # checking with each model one by one
    scores = np.array(gmm.score(vector))
    log_likelihood[i] = scores.sum()/ubmscores.sum()
    print(log_likelihood[i])
index = log_likelihood.argmin()
if log_likelihood[index] < 1.0:
    print(speakers[index])
else:
    print('unknown')
