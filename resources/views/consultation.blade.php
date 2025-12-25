@extends('layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        
        <div class="text-center mb-5 text-white">
            <h2 class="fw-bold">Cek Tingkat Burnout Anda</h2>
            <p>Jawablah pertanyaan berikut sesuai dengan kondisi Anda saat ini.</p>
        </div>

        <form action="{{ route('diagnose.process') }}" method="POST">
            @csrf
            
            <div class="glass-card p-4 mb-4">
                @foreach($symptoms as $index => $symptom)
                <div class="mb-4 border-bottom pb-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary me-2">{{ $symptom->code }}</span>
                        <h5 class="mb-0 text-dark">{{ $symptom->name }}</h5>
                    </div>
                    
                    <div class="row g-2 ms-4">
                        <label class="form-label text-muted small">Seberapa yakin Anda merasakan ini?</label>
                        <div class="col-md-6">
                            <select name="symptoms[{{ $symptom->id }}]" class="form-select border-primary shadow-sm" style="cursor: pointer;">
                                <option value="0">⚪ Tidak Mengalami (0)</option>
                                <option value="0.2">🟡 Sedikit Yakin (0.2)</option>
                                <option value="0.4">🟠 Cukup Yakin (0.4)</option>
                                <option value="0.6">🔴 Yakin (0.6)</option>
                                <option value="0.8">🟣 Sangat Yakin (0.8)</option>
                                <option value="1.0">⚫ Pasti / Sangat Sering (1.0)</option>
                            </select>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-grid gap-2 col-md-6 mx-auto">
                <button type="submit" class="btn btn-primary-custom btn-lg py-3 rounded-pill fw-bold">
                    <i class="bi bi-search"></i> Analisa Kondisi Saya
                </button>
            </div>

        </form>
    </div>
</div>
@endsection