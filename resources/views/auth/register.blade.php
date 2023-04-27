@extends('layout')

@section('content')
<main class="login-form">
	<div class="cotainer">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Register</div>
					<div class="card-body" id="app">
						<register-form
							:action="{{ json_encode(route('register.post')) }}"
						>
							{{ csrf_field() }}
						</register-form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
