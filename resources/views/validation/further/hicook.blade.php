@extends('templates.templates')

@section('style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y p-0" style="border-radius: 16px;">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Hi Cook
            <a href="{{ route('report.validation.addDatahiCook') }}" class="btn btn-primary">
                +
            </a>
        </h5>
    </div>
</div>
@endsection
@section('script')
@endsection