@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Create')

{{-- Content body: main page content --}}
@section('content')
<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Buat level baru</h3>
        </div>
        <form method="post" action="{{ route('level.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="levelKode">Kode Level</label>
                    <input type="text" class="form-control" id="levelKode" name="levelKode" placeholder="Masukkan kode level">
                </div>
                <div class="form-group">
                    <label for="levelNama">Nama Level</label>
                    <input type="text" class="form-control" id="levelNama" name="levelNama" placeholder="Masukkan nama level">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('level.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection