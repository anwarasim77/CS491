import json
import tensorflow as tf
from tensorflow import keras

model = keras.models.load_model('model.h5')

with open('dictionary.txt', 'r') as file:
    diction = json.load(file)


def review_encode(s):
    encoded = []

    for word in s:
        if word.lower() in diction:
            encoded.append(diction[word.lower()])
        else:
            encoded.append(0)
    return encoded


with open('text.txt', encoding='utf-8') as f:
    for line in f.readlines():
        nline = line.replace(',', '').replace('.', '').replace('/', '').strip().split(' ')
        encode = review_encode(nline)
        encode = keras.preprocessing.sequence.pad_sequences([encode], padding='post', maxlen=200)
        predict = model.predict(encode)
        # print(line)
        # print(encode)
        for i in predict:
            for t in i:
                answer = t * 100
                print('%.3f' % answer + '%')