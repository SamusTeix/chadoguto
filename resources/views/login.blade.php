@extends('master')

@section('content')
	
    <form method="POST" action="/admin/login">
    	@csrf
    	Login: <input type="text" name="login">
    	Senha: <input type="password" name="senha">
    	<input type="submit" value="Entrar">
    </form>
@endsection