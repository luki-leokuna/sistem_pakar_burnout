<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Models\Disease;
use App\Models\Rule;
use Illuminate\Http\Request;

class DiagnoseController extends Controller
{
    public function index()
    {
        //tampilkan semua gejala di form konsultasi
        $symptoms = Symptom::all();
        return view('consultation', compact('symptoms'));
    }

    public function process(Request $request)
    {
        //ambil input user (Format: [symptom_id => cf_user])
        $inputs = $request->input('symptoms');
        
        //array untuk menampung hasiil CF per penyakit
        $results = [];

        //loop setiap gejala yang dipilih user
        foreach($inputs as $symptomId => $cfUser){
            // Ambil aturan yang berhubungan dengan gejala ini
            // (Forward Chaining: Dari Gejala cari Penyakit)
            $rules = Rule::where('symptom_id', $symptomId)->get();

            foreach ($rules as $rule) {
                // Hitung CF Gejala (CF User * CF Pakar)
                $cfGejala = floatval($cfUser) * $rule->cf_expert;

                // Kelompokkan berdasarkan penyakit (disease_id)
                $diseaseId = $rule->disease_id;

                if (!isset($results[$diseaseId])) {
                    $results[$diseaseId] = 0; // Inisialisasi
                }

                // Rumus Kombinasi Sequential (CF Combine)
                // CF_new = CF_old + CF_gejala * (1 - CF_old)
                $cfOld = $results[$diseaseId];
                $cfCombine = $cfOld + $cfGejala * (1 - $cfOld);
                
                // Simpan nilai baru
                $results[$diseaseId] = $cfCombine;
        }
    }

    // 4. Urutkan hasil dari persentase tertinggi
        arsort($results);

        // Ambil diagnosa tertinggi
        $diagnosisId = array_key_first($results);
        $highestCF = $results[$diagnosisId];
        
        $disease = Disease::find($diagnosisId);

        return view('result', [
            'disease' => $disease,
            'percentage' => round($highestCF * 100, 2),
            'all_results' => $results // Opsional: tampilkan diagnosa lain
        ]);
    }
}
