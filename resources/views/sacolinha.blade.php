@extends('master')

@section('content')
	<input type="hidden" id="doacao_id" name="doacao_id" value="{{$doacao->id}}">
	<h4>Muito obrigado por ter chegado até aqui</h4>
	@if(empty($doacao->id_usuario))
		<h5>Esta é a sua sacolinha. Abaixo tem os campos de nome, sobrenome e e-mail. Pedimos apenas que preencha seu nome e sobrenome, para sabermos a quem devemos agradecer.</h5>
		<h5>Caso você preencha seu e-mail também, pode ficar tranquilo. Os itens escolhidos por você ficarão salvos e você poderá ve-los aqui</h5>
		<div class="row">
			<div class="col-6">
				<div class="form-group">
					<label for="nome">Nome:</label>
					<input type="text" class="form-control" id="nome" name="nome">
				</div>	
			</div>
			<div class="col-6">
				<div class="form-group">
					<label for="sobrenome">Sobrenome:</label>
					<input type="text" class="form-control" id="sobrenome" name="sobrenome">
				</div>	
			</div>
		</div>
		<span id="msg-erro-nome-sobrenome" class="alert alert-danger btn-block" style="display: none;">Nome e sobrenome são obrigatórios!</span>
		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<label for="email">E-mail:</label>
					<input type="text" class="form-control" id="email" name="email">
				</div>
			</div>
		</div>
	@else
		<input type="hidden" id="usuario_id" name="usuario_id" value="{{$doacao->id_usuario}}">
		<h5>Bem Vindo, <b>{{$doacao->usuario->nome}} {{$doacao->usuario->sobrenome}}</b></h5>
	@endif
	@if($doacao_itens->count() < 1)
		<h4>Nenhum item adicionado a sacolinha!</h4>
	@else
		<div class="row">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th></th>
						<th>Item</th>
						<th>Tamanho</th>
						<th>Quantidade</th>
						<th>Valor estimado unitário</th>
						<th>Valor estimado total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($doacao_itens as $key => $item)
						<tr>
							<td>{{$key + 1}}</td>
							<td><img src="{{$item->imagem->link}}" style="width: 100px"></td>
							<td id="nome_item_{{$item->item->id}}_tamanho_{{$item->tamanho}}">{{$item->item->nome}}</td>
							<td>{{ucfirst($item->tamanho)}}</td>
							<td>
								<select class="form-control" name="quantidade_item_{{$item->item->id}}_tamanho_{{$item->tamanho}}" onchange="alteraSacolinhaQuantidade(this)" valueOnLoad="{{$item->quantidade}}">
									@for($i = 0; $i <= $item->tamanhos->{$item->tamanho}; $i++)
										<option value="{{$i}}" {{$i == $item->quantidade ? 'selected' : ''}}>{{$i}}</option>
									@endfor
								</select>
							</td>
							<td>{{$item->item->getPreco()}}</td>
							<td>{{$item->item->getPrecoTotal($item->quantidade)}}</td>
							<td><a href="#" class="btn btn-danger" onclick="excluiSacolinhaItem({{$item->item->id}}, '{{$item->tamanho}}')">Excluir</a></td>
						</tr>
					@endforeach	
				</tbody>				
			</table>
			<div class="row">
				<div class="col-12 text-right">
					<button class="btn btn-success text-right" onClick="saveDoacao()">Continuar</button>
				</div>
			</div>
		</div>			
	@endif
@endsection