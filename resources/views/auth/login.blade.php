@extends('layout')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body" id="app">

                        <login-form
							:action="{{ json_encode(route('login.post')) }}"
						>
							{{ csrf_field() }}
						</login-form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>