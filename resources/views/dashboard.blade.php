@extends('master')

@section('content')
	{{-- cabeçalho --}}
	<div class="row">
		<div class="col-8">
			Bem Vindo <b>{{$data['user']['login']}}</b>
		</div>
		<div class="col-4 text-right">
			<form method="POST" action="/admin/logout">
		    	@csrf
		    	<input class="btn btn-primary" type="submit" value="Sair">
		    </form>		
		</div>
	</div>

	{{-- tabela de itens --}}
	<div class="row">
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th class="text-center" colspan="9">Itens</th>
					<th class="text-right"><a class="btn btn-primary" href="/admin/item/index">Novo Item</a></th>
				</tr>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Thumb</th>
					<th class="text-center">Nome</th>
					<th class="text-center">Descrição</th>
					<th class="text-center" colspan="4">Quantidade</th>
					<th class="text-center">Links?</th>
					<th class="text-center" width="15%">Ações</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['itens'] as $item)
					{{-- <?php dd($item); ?> --}}
					<tr>
						<td>{{$item->id}}</td>
						@if(isset($item->imagem->first()->link))
							<td><img src="{{$item->imagem->first()->link}}" style="height: 60px;"></td>
						@else
							<td>Sem Imagem Adicionada</td>
						@endif						
						<td>{{$item->nome}}</td>
						<td>{{$item->descricao}}</td>
						<td>P: {{$item->tamanho->first()->pequeno}}</td>
						<td>M: {{$item->tamanho->first()->medio}}</td>
						<td>G: {{$item->tamanho->first()->grande}}</td>
						<td>U: {{$item->tamanho->first()->unico}}</td>
						@if(isset($item->link->first()->link))
							<td>Sim</td>
						@else
							<td>Não</td>
						@endif						
						<td class="text-right">
							<a class="btn btn-primary" href="/admin/item/index/{{$item->id}}">Editar</a>
							&nbsp;
							<a class="btn btn-danger" href="#" onclick="modalDelete('Item', {{$item->id}})">Excluir</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	{{-- tabela de tipos --}}
	<div class="row">
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th class="text-center" colspan="2">Tipos</th>
					<th class="text-right"><a class="btn btn-primary" href="/admin/tipo/index">Novo Tipo</a></th>
				</tr>
				<tr>
					<th>#</th>
					<th>Nome</th>
					<th width="15%" class="text-right">Ações</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['tipos'] as $tipo)
					<tr>
						<td>{{$tipo->id}}</td>
						<td>{{$tipo->nome}}</td>
						<td class="text-right">
							<a class="btn btn-primary" href="/admin/tipo/index/{{$tipo->id}}">Editar</a>
							&nbsp;
							<a class="btn btn-danger" href="#" onclick="modalDelete('tipo', {{$tipo->id}})">Excluir</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	{{-- tabela de doacoes --}}
	<div class="row">
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th class="text-center" colspan="10">Doações</th>
				</tr>
				<tr>
					<th>#</th>
					<th>Usuário</th>
					<th>Item</th>
					<th>Canal</th>
					<th>Finalizado</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['doacoes'] as $doacao)
					<tr>
						<td>{{$doacao->id}}</td>
						<td>{{$doacao->nome}}</td>
						<td>{{$doacao->descricao}}</td>
						<td>{{$doacao->quantidade}}</td>
						<td><a class="btn btn-primary" href="/admin/doacao/edit/{{$doacao->id}}">Editar</a>&nbsp;<a class="btn btn-danger" href="#">Excluir</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>			
	</div>
	 
@endsection