@extends('master')

@section('content')
	<h5>{{$title}}</h5>
	<form method="POST" action="/admin/tipo/save">
		@csrf
		<div id="content_tipo-form">
			<div class="row">
				<div class="col-12">
					<input type="hidden" id="id" name="id" value="{{$tipo->id}}">
					<div class="form-group">
						<label for="nome">Nome:</label>
						<input type="text" class="form-control" id="nome" name="nome" value="{{$tipo->nome}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-right">
					<a href="/admin" class="btn btn-primary">Voltar</a>
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>
			</div>
		</div>
	</form>		
@endsection

@section('script')
	{{-- <script type="text/javascript" src="http://localhost/js/components/item-form.js"></script> --}}
@endsection