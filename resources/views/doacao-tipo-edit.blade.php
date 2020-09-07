@extends('master')

@section('content')
	<h5>{{$title}}</h5>
	<form method="POST" action="/admin/doacao-tipo/save" enctype="multipart/form-data">
		@csrf
		<div id="content_tipo-form">
			<input type="hidden" id="id" name="id" value="{{$doacaoTipo->id}}">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="nome">Nome:</label>
						<input type="text" class="form-control" id="nome" name="nome" value="{{$doacaoTipo->nome}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="descricao">Descrição:</label>
						<input type="text" class="form-control" id="descricao" name="descricao" value="{{$doacaoTipo->descricao}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="dados">Dados:</label>
						<textarea class="form-control" id="dados" name="dados">{{$doacaoTipo->dados}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					@if(! $doacaoTipo->imagem == null)
						<img src="{{$doacaoTipo->imagem}}" class="img-fluid img-thumbnail">
					@endif
					<input type="file" id="imagem" name="imagem">
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
	
@endsection