<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Data Source: Damayanti & Aulia (2025). Adaptasi Academic Burnout Scale Versi Indonesia.
     * Jurnal Manajemen Pendidikan dan Ilmu Sosial (JMPIS), 6(6).
     */
    public function run()
    {
        // 1. DATA PENYAKIT (TINGKAT BURNOUT)
        $diseases = [
            [
                'id' => 1,
                'code' => 'P01',
                'name' => 'Burnout Tingkat Rendah (Mild Burnout)',
                'solution' => 'Anda mengalami indikasi awal kelelahan akademik.
                Solusi:
                1. Perbaiki manajemen waktu antara kuliah dan istirahat.
                2. Fokus pada skala prioritas tugas.
                3. Tetap jaga komunikasi positif dengan keluarga.'
            ],
            [
                'id' => 2,
                'code' => 'P02',
                'name' => 'Burnout Tingkat Sedang (Moderate Burnout)',
                'solution' => 'Tingkat stres Anda mulai mengganggu produktivitas dan emosi.
                Solusi:
                1. Kurangi ekspektasi perfeksionis pada diri sendiri.
                2. Cari dukungan sosial (curhat) kepada teman dekat untuk mengurangi beban emosional[cite: 187].
                3. Luangkan waktu khusus untuk hobi tanpa memikirkan akademik.'
            ],
            [
                'id' => 3,
                'code' => 'P03',
                'name' => 'Burnout Tingkat Tinggi (Severe Burnout)',
                'solution' => 'PERINGATAN: Anda berada pada fase kritis yang berisiko pada kesehatan mental dan putus studi.
                Solusi:
                1. Segera konsultasi ke psikolog/konselor kampus (Professional Help).
                2. Pertimbangkan untuk mengambil cuti akademik sementara jika memungkinkan.
                3. Ikuti terapi kelompok atau peer support group[cite: 200].'
            ]
        ];

        DB::table('diseases')->insert($diseases);

        // 2. DATA GEJALA (SYMPTOMS) - Sumber: Tabel 1 
        $symptoms = [
            // --- Dimensi: Parental Pressure (Tekanan Orang Tua) ---
            ['id' => 1, 'code' => 'G01', 'name' => 'Orangtua tidak memberikan apresiasi terhadap prestasi akademik saya.'],
            ['id' => 2, 'code' => 'G02', 'name' => 'Saya tidak dapat mengambil jurusan/mata kuliah yang saya minati karena tekanan dari orangtua.'],
            ['id' => 3, 'code' => 'G03', 'name' => 'Orangtua saya biasanya membandingkan hasil akademik (IPK) saya dengan anak kerabat.'],
            ['id' => 4, 'code' => 'G04', 'name' => 'Orangtua sering membandingkan nilai IPK saya dengan saudara-saudara saya.'],
            
            // --- Dimensi: Subjective Overload (Beban Berlebih) ---
            ['id' => 5, 'code' => 'G05', 'name' => 'Perkuliahan saya sangat menguras tenaga dan pikiran.'],
            ['id' => 6, 'code' => 'G06', 'name' => 'Saya merasa kelelahan secara fisik saat datang ke kampus.'],
            ['id' => 7, 'code' => 'G07', 'name' => 'Rasa lelah saya tidak sepenuhnya hilang meskipun sudah istirahat atau tidur dengan cukup.'],
            
            // --- Dimensi: Negative Teacher-Student Relation (Hubungan Negatif dgn Dosen) ---
            ['id' => 8, 'code' => 'G08', 'name' => 'Saya merasa kesulitan dalam berkomunikasi dengan dosen-dosen.'],
            ['id' => 9, 'code' => 'G09', 'name' => 'Saya merasa dosen-dosen bersikap tidak adil kepada saya.'],
            ['id' => 10, 'code' => 'G10', 'name' => 'Saya merasa kurang dihargai dan kehadiran saya dimanfaatkan saat berada di kampus.'],
            ['id' => 11, 'code' => 'G11', 'name' => 'Dosen seringkali mengkritik saya dalam belajar.'],

            // --- Dimensi: Exhaustion (Kelelahan Ekstrem) ---
            ['id' => 12, 'code' => 'G12', 'name' => 'Saya harus menyelesaikan tugas dengan tekanan waktu yang mendesak.'],
            ['id' => 13, 'code' => 'G13', 'name' => 'Akibat kesibukan akademik, saya tidak punya waktu untuk menghadiri acara keluarga.'],
            ['id' => 14, 'code' => 'G14', 'name' => 'Stress akibat studi menimbulkan masalah pada hubungan pribadi saya.'],
            ['id' => 15, 'code' => 'G15', 'name' => 'Saya membutuhkan waktu lebih banyak untuk bersantai dan merasa lebih baik.'],

            // --- Dimensi: Academic Inefficacy (Ketidakefektifan Akademik) ---
            ['id' => 16, 'code' => 'G16', 'name' => 'Saya merasa tidak puas dengan hasil akademik saya.'],
            ['id' => 17, 'code' => 'G17', 'name' => 'Saya merasa tidak meraih pencapaian apapun dalam studi saya.'],

            // --- Dimensi: Negative Peer Relation (Hubungan Negatif Teman Sebaya) ---
            // *Dimensi ini memiliki pengaruh paling tinggi menurut jurnal [cite: 181]*
            ['id' => 18, 'code' => 'G18', 'name' => 'Teman-teman sekelas saya sering membuat saya merasa kesal dan jengkel.'],
            ['id' => 19, 'code' => 'G19', 'name' => 'Saya sering kecewa dengan perilaku teman-teman sekelas saya.'],
            ['id' => 20, 'code' => 'G20', 'name' => 'Teman-teman sekelas saya membuat saya sangat marah.'],
        ];

        DB::table('symptoms')->insert($symptoms);

        // ==========================================================
        // 3. DATA RULES (BASIS PENGETAHUAN) - Sumber Bobot: Tabel 4 
        // ==========================================================
        // Logika: 
        // - Gejala ringan/awal -> P01 (CF Kecil/Sedang)
        // - Gejala fisik/emosi -> P02 (CF Sedang)
        // - Gejala sosial/putus asa -> P03 (CF Besar, sesuai Factor Loading tinggi di jurnal)

        $rules = [
            // --- Aturan ke P01 (Burnout Rendah) ---
            ['disease_id' => 1, 'symptom_id' => 5, 'cf_expert' => 0.4],  // Menguras tenaga (Gejala umum)
            ['disease_id' => 1, 'symptom_id' => 12, 'cf_expert' => 0.5], // Tekanan waktu
            ['disease_id' => 1, 'symptom_id' => 15, 'cf_expert' => 0.4], // Butuh santai

            // --- Aturan ke P02 (Burnout Sedang) ---
            ['disease_id' => 2, 'symptom_id' => 1, 'cf_expert' => 0.6],  // Kurang apresiasi ortu
            ['disease_id' => 2, 'symptom_id' => 6, 'cf_expert' => 0.6],  // Lelah fisik di kampus
            ['disease_id' => 2, 'symptom_id' => 8, 'cf_expert' => 0.5],  // Sulit komunikasi dosen
            ['disease_id' => 2, 'symptom_id' => 13, 'cf_expert' => 0.7], // Tidak ada waktu keluarga
            ['disease_id' => 2, 'symptom_id' => 16, 'cf_expert' => 0.6], // Tidak puas hasil

            // --- Aturan ke P03 (Burnout Tinggi) ---
            // Menggunakan bobot tinggi untuk item dengan Factor Loading tertinggi di jurnal
            
            // Dimensi Parental Pressure (Kuat)
            ['disease_id' => 3, 'symptom_id' => 3, 'cf_expert' => 0.8],  // Dibandingkan anak kerabat 
            ['disease_id' => 3, 'symptom_id' => 4, 'cf_expert' => 0.8],  // Dibandingkan saudara 
            
            // Dimensi Exhaustion & Overload
            ['disease_id' => 3, 'symptom_id' => 7, 'cf_expert' => 0.7],  // Lelah tidak hilang (Kronis)
            ['disease_id' => 3, 'symptom_id' => 14, 'cf_expert' => 0.8], // Masalah hubungan pribadi
            
            // Dimensi Negative Teacher (High conflict)
            ['disease_id' => 3, 'symptom_id' => 11, 'cf_expert' => 0.7], // Dosen mengkritik
            
            // Dimensi Inefficacy (Merasa Gagal)
            ['disease_id' => 3, 'symptom_id' => 17, 'cf_expert' => 0.9], // Tidak meraih pencapaian apapun (Inefficacy)
            
            // Dimensi Negative Peer Relation (Paling Berpengaruh [cite: 181])
            ['disease_id' => 3, 'symptom_id' => 18, 'cf_expert' => 0.9], // Teman membuat kesal (Factor Loading 0.906)
            ['disease_id' => 3, 'symptom_id' => 19, 'cf_expert' => 0.8], // Kecewa teman
            ['disease_id' => 3, 'symptom_id' => 20, 'cf_expert' => 0.9], // Teman membuat marah
        ];

        DB::table('rules')->insert($rules);
    }
}