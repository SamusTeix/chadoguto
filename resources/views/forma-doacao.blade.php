@extends('master')

@section('content')
	<input type="hidden" id="doacao_id" name="doacao_id" value="{{$doacao->id}}">
	<h4>Muito obrigado por ter chegado até aqui</h4>
	<h5>Bem Vindo, <b>{{$usuario->nome}} {{$usuario->sobrenome}}</b></h5>
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
					<a href="/sacolinha/tipo" class="btn btn-success">Continuar</a>
				</div>
			</div>
		</div>			
	@endif
@endsection