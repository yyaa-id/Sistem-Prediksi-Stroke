from flask import Flask, request, jsonify
import pickle
import pandas as pd
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

with open('model_stroke.pkl', 'rb') as f:
    model = pickle.load(f)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    df_input = pd.DataFrame([data])
    prediction = model.predict(df_input)
    return jsonify({'result': int(prediction[0])})

if __name__ == '__main__':
    app.run(port=5000)