@extends ('layouts.app')

{{-- Customize layout section --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Level')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('level.create') }}" class="btn btn-primary">Add Level</a>
            </div>
            <div class="card-body">Manage Level</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush