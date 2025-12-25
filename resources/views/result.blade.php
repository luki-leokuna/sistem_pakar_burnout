@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        
        <div class="glass-card p-5 text-center position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(255,255,255,0.4); z-index: -1;"></div>

            <h5 class="text-muted text-uppercase letter-spacing-2 mb-3">Hasil Analisa Sistem Pakar</h5>
            
            <div class="mb-3">
                @if($percentage > 70)
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 5rem;"></i>
                @elseif($percentage > 40)
                    <i class="bi bi-activity text-warning" style="font-size: 5rem;"></i>
                @else
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                @endif
            </div>

            <h2 class="fw-bold mb-2 {{ $percentage > 70 ? 'text-danger' : ($percentage > 40 ? 'text-warning' : 'text-success') }}">
                {{ $disease->name }}
            </h2>

            <div class="display-3 fw-bold my-3 text-dark">
                {{ $percentage }}<span class="fs-4">%</span>
            </div>
            <p class="text-muted">Tingkat Keyakinan Sistem</p>

            <hr class="my-4">

            <div class="text-start bg-white p-4 rounded shadow-sm border-start border-5 border-info">
                <h5 class="fw-bold text-info"><i class="bi bi-lightbulb-fill"></i> Saran & Solusi:</h5>
                <p class="mb-0" style="white-space: pre-line; line-height: 1.8;">{{ $disease->solution }}</p>
            </div>

            <div class="mt-5">
                <a href="/" class="btn btn-outline-dark rounded-pill px-4">
                    <i class="bi bi-arrow-repeat"></i> Cek Ulang
                </a>
            </div>
        </div>

        <div class="accordion mt-4 glass-card" id="accordionExample">
            <div class="accordion-item bg-transparent border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        <i class="bi bi-calculator me-2"></i> Lihat Detail Perhitungan (Debug)
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="list-group">
                            @foreach($all_results as $id => $val)
                                @php $p = \App\Models\Disease::find($id); @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                    {{ $p->name }}
                                    <span class="badge bg-secondary rounded-pill">{{ round($val * 100, 2) }}%</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection