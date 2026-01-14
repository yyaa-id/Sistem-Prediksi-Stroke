# 🚑 Sistem Prediksi Stroke (Stroke Prediction System)

![Python](https://img.shields.io/badge/Python-3.x-blue.svg)
![Machine Learning](https://img.shields.io/badge/Focus-Machine%20Learning-orange.svg)
![Status](https://img.shields.io/badge/Status-Completed-success.svg)

## 📌 Deskripsi Proyek
Proyek ini adalah sistem berbasis **Machine Learning** yang dirancang untuk memprediksi kemungkinan seseorang mengalami stroke berdasarkan parameter kesehatan dan demografi. Menurut data WHO, stroke adalah salah satu penyebab utama kematian di dunia. Sistem ini bertujuan sebagai alat bantu deteksi dini (skrining) untuk meminimalkan risiko stroke melalui analisis data medis.

## 📊 Dataset
Dataset yang digunakan mencakup beberapa fitur kunci yang relevan dengan risiko stroke, antara lain:
* **Gender**: Jenis kelamin.
* **Age**: Usia pasien.
* **Hypertension**: Riwayat hipertensi (0: Tidak, 1: Ya).
* **Heart Disease**: Riwayat penyakit jantung (0: Tidak, 1: Ya).
* **Ever Married**: Status pernikahan.
* **Work Type**: Jenis pekerjaan.
* **Residence Type**: Jenis tempat tinggal (Urban/Rural).
* **Avg Glucose Level**: Rata-rata kadar glukosa dalam darah.
* **BMI**: Body Mass Index.
* **Smoking Status**: Status merokok.
* **Stroke**: Variabel target (1 jika stroke, 0 jika tidak).

## 🛠️ Alur Pengerjaan
1. **Data Cleaning & Preparation**: Menangani nilai yang hilang (missing values) dan membersihkan data.
2. **Exploratory Data Analysis (EDA)**: Menganalisis korelasi antar fitur dan distribusi data.
3. **Data Preprocessing**: Melakukan *encoding* pada data kategori dan *scaling* pada data numerik.
4. **Model Development**: Melatih model klasifikasi (seperti Random Forest, SVM, atau Logistic Regression).
5. **Model Evaluation**: Menguji akurasi model menggunakan *confusion matrix* dan *classification report*.

## 🚀 Cara Menjalankan
Pastikan kamu sudah menginstal Python di komputer kamu, kemudian ikuti langkah berikut:

1. **Clone Repository:**
   ```bash
   git clone [https://github.com/yyaa-id/Sistem-Prediksi-Stroke.git](https://github.com/yyaa-id/Sistem-Prediksi-Stroke.git)
