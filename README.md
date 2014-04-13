Konsep Menyimpan dan Memaparkan Data Kehadiran
==============================================

Projek ini sangat ringkas (dibuat dalam sehari) sebagai contoh kepada cara menyimpan dan memaparkan kehadiran bagi sesebuah kursus dengan kelas berkala.

Untuk memasang projek ini, pastikan anda 

* membina pengkalan dengan dengan db.sql
* menukar maklumat akses pengkalan data di libs/dbmodel.php

Demo ini menggunakan PHP raw tanpa framework. Ianya tidak menggunakan sebarang Javascript mahupun Ajax agar lebih mudah memahami kod dan implementasi. Ia juga mengabaikan banyak error trapping dan input validation.

Buat masa ini ianya hanya menunjukkan kehadiran, menambah/membuang kelas untuk kursus dan menambah pelajar untuk kursus.

Ianya tidak mempunyai

* pengurusan pensyarah
* pengurusan pelajar
* pengurusan kursus

Untuk bermain, saudara-saudari boleh gunakan sebarang aplikasi klien MySQL untuk mengubah data, menambah kursus, pelajar dan lain-lain.

Pengkalan Data
--------------

Berikut ini adalah sedikit maklumat tentang pengkalan data dan tabel yang dibina

**penysarah** - menyimpan data pensyarah

**pelajar** - menyimpan data pelajar

**kursus** - merujuk kepada sesuatu kursus seperti Prinsip Akaun oleh Dr. Ali Husin atau Grafik oleh Karim Salim. kursus mempunyai kelas

**kelas** - merujuk kepada waktu di mana kelas atau kuliah berlangsung. Ianya menyimpan maklumat tarikh dan masa juga kursus bagi kelas ini.

**kursus_pelajar** - menyimpan senarai pelajar yang telah mendaftar untuk sesuatu kursus. hanya merujuk kepada id-id yang terlibat

**kehadiran** - menyimpan data kehadiran bagi sesuatu kelas, bagi pelajar tertentu

