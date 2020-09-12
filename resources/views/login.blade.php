@extends('master')

@section('content')
	<form method="POST" action="/admin/login">
		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<label for="nome">Login:</label>
					<input type="text" class="form-control" id="login" name="login">
				</div>
				<div class="form-group">
					<label for="nome">Senha:</label>
					<input type="password" class="form-control" id="senha" name="senha">
				</div>		
			</div>
			<div class="col-12 text-right">
				<input type="submit" value="Entrar">		
			</div>
		</div>
	</form>
@endsection