@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 py-4">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                @if (!empty($success))
                    <div class="alert alert-success">{{ $success }}</div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
