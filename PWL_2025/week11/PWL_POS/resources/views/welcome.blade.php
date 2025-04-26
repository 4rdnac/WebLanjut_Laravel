@extends('layouts.template')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Halo, {{ Auth::user()->nama }}!</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            Selamat datang {{ Auth::user()->nama }}.
        </div>
    </div>

@endsection
