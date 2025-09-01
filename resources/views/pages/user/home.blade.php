@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🏥 Dashboard</h4>
                </div>
                <div class="card-body">
                    <p class="lead">Selamat datang, <strong>{{ Auth::user()->username }}</strong> 👋</p>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Data Rumah Sakit</h5>
                                    <p class="card-text">Kelola daftar rumah sakit.</p>
                                    <a href="{{ route('hospitals.index') }}" class="btn btn-outline-primary">
                                        Lihat Data
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Data Pasien</h5>
                                    <p class="card-text">Kelola data pasien.</p>
                                    <a href="{{ route('patients.index') }}" class="btn btn-outline-success">
                                        Lihat Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Refresh</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
