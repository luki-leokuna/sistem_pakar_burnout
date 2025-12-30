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
                'solution' => 'Nilai CF: 0.00 - 0.40.
                Anda mengalami gejala ringan. 
                Saran: Lakukan manajemen waktu yang lebih baik, istirahat cukup, dan luangkan waktu untuk hobi'
            ],
            [
                'id' => 2,
                'code' => 'P02',
                'name' => 'Burnout Tingkat Sedang (Moderate Burnout)',
                'solution' => 'Nilai CF: 0.41 - 0.70.
                 Kondisi ini mulai mengganggu stabilitas emosi dan studi Anda.
                 Saran: Kurangi beban tugas jika memungkinkan, cerita kepada teman (curhat), dan lakukan teknik relaksasi.'
            ],
            [
                'id' => 3,
                'code' => 'P03',
                'name' => 'Burnout Tingkat Tinggi (Severe Burnout)',
                'solution' => 'Nilai CF: 0.71 - 1.00.
                PERINGATAN: Kondisi kritis yang membutuhkan penanganan serius.
                Saran: Segera konsultasi dengan psikolog atau konselor akademik. Pertimbangkan cuti sejenak untuk pemulihan mental.'
            ]
        ];

        DB::table('diseases')->insert($diseases);

        // 2. DATA GEJALA (SYMPTOMS) - Sumber: Tabel 1 
        $symptoms = [
            ['id' => 1, 'code' => 'G01', 'name' => 'Kelelahan fisik dan mental.'],
            ['id' => 2, 'code' => 'G02', 'name' => 'Menghindari tugas atau kuliah.'],
            ['id' => 3, 'code' => 'G03', 'name' => 'Merasa bosan dan sinis terhadap perkuliahan.'],
            ['id' => 4, 'code' => 'G04', 'name' => 'Emosi tidak stabil.'],
            ['id' => 5, 'code' => 'G05', 'name' => 'Merasa tidak dihargai.'],
            ['id' => 6, 'code' => 'G06', 'name' => 'Curiga tanpa alasan yang jelas.'],
            ['id' => 7, 'code' => 'G07', 'name' => 'Merasa depresi.'],
            ['id' => 8, 'code' => 'G08', 'name' => 'Menyangkal kondisi diri.'],
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
            // --- KELOMPOK 1: Gejala Menuju Burnout TINGGI (P03) ---
            // Gejala dengan CF Tinggi (0.8) atau sifatnya parah (Depresi)
            [
                'disease_id' => 3, 
                'symptom_id' => 1, // G01: Kelelahan fisik & mental
                'cf_expert' => 0.8 
            ],
            [
                'disease_id' => 3, 
                'symptom_id' => 7, // G07: Merasa depresi
                'cf_expert' => 0.8 
            ],

            // --- KELOMPOK 2: Gejala Menuju Burnout SEDANG (P02) ---
            // Gejala dengan CF Menengah (0.7 - 0.6) yang sifatnya perilaku/penyangkalan
            [
                'disease_id' => 2, 
                'symptom_id' => 2, // G02: Menghindari tugas
                'cf_expert' => 0.7 
            ],
            [
                'disease_id' => 2, 
                'symptom_id' => 3, // G03: Bosan dan sinis
                'cf_expert' => 0.7 
            ],
            [
                'disease_id' => 2, 
                'symptom_id' => 8, // G08: Menyangkal kondisi
                'cf_expert' => 0.6 
            ],

            // --- KELOMPOK 3: Gejala Menuju Burnout RENDAH/AWAL (P01) ---
            // Gejala dengan CF lebih rendah (0.6 - 0.5) yang sifatnya emosional ringan
            [
                'disease_id' => 1, 
                'symptom_id' => 4, // G04: Emosi tidak stabil
                'cf_expert' => 0.6 
            ],
            [
                'disease_id' => 1, 
                'symptom_id' => 5, // G05: Merasa tidak dihargai
                'cf_expert' => 0.6 
            ],
            [
                'disease_id' => 1, 
                'symptom_id' => 6, // G06: Curiga tanpa alasan
                'cf_expert' => 0.5 
            ],
        ];

        DB::table('rules')->insert($rules);
    }
}