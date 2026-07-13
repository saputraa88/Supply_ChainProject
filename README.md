# 🌐 Global Supply Chain Risk Intelligence Platform
> **Platform Monitoring Risiko Rantai Pasok Global Berbasis Multi-API dan Analitik Data**

Proyek ini merupakan sistem pendukung keputusan (*Decision Support System*) dan dashboard analitik yang dirancang untuk memantau, menganalisis, serta memprediksi berbagai risiko logistik dan perdagangan internasional secara *real-time*. Platform ini membantu perusahaan mengantisipasi gangguan pengiriman barang dari berbagai negara akibat cuaca ekstrem, volatilitas mata uang, geopolitik, hingga kemacetan pelabuhan.

---

## 🚀 Fitur Utama
Sistem ini mengintegrasikan data dari 6-7 API eksternal gratis untuk menyajikan metrik analitik berikut:

1. **Global Country Dashboard:** Memantau indikator makro ekonomi seperti GDP, Inflasi, Populasi, Mata Uang, dan Cuaca terkini dari negara yang dipilih.
2. **Risk Scoring Engine:** Algoritma kustom (*Simple Scoring/Weighted Risk Model*) untuk menghitung total skor risiko suatu negara berdasarkan variabel Cuaca (30%), Inflasi (20%), Berita Geopolitik (40%), dan Kurs (10%).
3. **Geospatial Port & Weather Map:** Visualisasi peta interaktif menggunakan **Leaflet.js** dan **OpenStreetMap** untuk memetakan lokasi pelabuhan dunia (*World Port Index*) serta kondisi cuaca ekstrem secara langsung.
4. **Lexicon Based Sentiment Analysis:** Analisis sentimen berita ekonomi dan logistik menggunakan algoritma berbasis kamus (*kata positif & negatif*) yang dibangun secara mandiri menggunakan PHP (Tanpa AI Berbayar).
5. **Currency Impact & Data Visualization Dashboard:** Grafik tren historis untuk pergerakan kurs, inflasi, GDP, dan risiko menggunakan **Chart.js**.
6. **Country Comparison Engine:** Fitur membandingkan metrik risiko dan ekonomi antar dua negara secara *side-by-side*.
7. **Favorite Monitoring List & Admin Panel:** Fitur bagi pengguna untuk menyimpan negara pantauan khusus serta panel admin untuk mengelola user, artikel, dan dataset pelabuhan.

---

## 🛠️ Tech Stack & Arsitektur

### Backend
* **Framework:** Laravel (PHP)
* **Database:** MySQL (15-20 Tabel Relasional)
* **API Architecture:** REST API buatan sendiri (30+ Endpoints) & Multi-API Integration.

### Frontend & Visualisasi
* **UI Style:** Bootstrap 5 (Clean & Modern Layout)
* **Interaktivitas:** AJAX (JavaScript ES6) untuk pembaruan data asinkron tanpa reload.
* **Grafik:** Chart.js
* **Peta Spasial:** Leaflet.js

### Integrasi API Eksternal
* **Open-Meteo API:** Data temperatur, curah hujan, kecepatan angin, dan risiko badai.
* **World Bank API:** Data tren GDP, Inflasi, Populasi, dan Ekspor-Impor negara.
* **REST Countries API:** Informasi detail negara, wilayah, bahasa, dan mata uang resmi.
* **ExchangeRate API:** Kurs mata uang global secara *real-time*.
* **World Port Index Dataset:** Data publik koordinat lokasi pelabuhan dunia.
* **GNews API:** Sumber berita logistik, perdagangan, dan geopolitik global.

---

## 🗄️ Endpoint API Internal yang Dibangun
Sistem ini menyediakan layanan REST API mandiri yang dapat diakses melalui:
* `GET /api/countries` - Mengambil daftar negara dan metrik dasarnya.
* `GET /api/risk` - Mengambil hasil kalkulasi skor risiko negara.
* `GET /api/ports` - Menyediakan data lokasi dan koordinat pelabuhan.
* `GET /api/news` - Mengambil cache berita beserta hasil analisis sentimennya.
* `GET /api/currency` - Menyediakan fluktuasi kurs mata uang terbaru.

---

## 💻 Cara Menjalankan Proyek secara Lokal

### Prerequisites
Pastikan Anda sudah menginstal **PHP (>= 8.x)**, **Composer**, dan **MySQL/XAMPP**.

### Langkah Instalasi
1. Clone repositori ini ke komputer lokal Anda:
   ```bash
   git clone [https://github.com/saputraa88/Supply_ChainProject.git](https://github.com/saputraa88/Supply_ChainProject.git)
   cd Supply_ChainProject<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/9d5c4600-b847-4251-b37d-082ab38bae24" />
