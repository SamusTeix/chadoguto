@extends('master')

@section('content')
	<div id="dash-main" class="row" style="display: none">
		<div id="dash-menu" class="col-2">
			<h4>
				Bem Vindo <b>{{$data['admin']['login']}}</b>
			</h4>
			<br>
			<form method="POST" action="/admin/logout">
		    	@csrf
		    	<input class="btn btn-primary" type="submit" value="Sair">
		    </form>
		    <br>
		    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
		      <a class="nav-link active" id="v-pills-doacoes-tab" data-toggle="pill" href="#v-pills-doacoes" role="tab" aria-controls="v-pills-doacoes" aria-selected="true">Doações</a>
		      <a class="nav-link" id="v-pills-tipos_doacao-tab" data-toggle="pill" href="#v-pills-tipos_doacao" role="tab" aria-controls="v-pills-tipos_doacao" aria-selected="false">Canais de Doação</a>
		      <a class="nav-link" id="v-pills-itens-tab" data-toggle="pill" href="#v-pills-itens" role="tab" aria-controls="v-pills-itens" aria-selected="false">Itens</a>
		      <a class="nav-link" id="v-pills-tipos_item-tab" data-toggle="pill" href="#v-pills-tipos_item" role="tab" aria-controls="v-pills-tipos_item" aria-selected="false">Tipos de Item</a>
		    </div>
		</div>
		<div id="dash-content" class="col-10">
			<div class="tab-content">
				{{-- tab doacoes --}}
				<div class="tab-pane fade show active" id="v-pills-doacoes" role="tabpanel" aria-labelledby="v-pills-doacoes-tab">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" colspan="10">Doações</th>
							</tr>
							<tr>
								<th>#</th>
								<th>Usuário</th>
								<th>Item</th>
								<th>Tamanho</th>
								<th>Quantidade</th>
								<th>Canal</th>
								<th>Status</th>
								<th width="15%" class="text-center">Ações</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['doacoes'] as $doacao)
								<tr>
									<td>{{$doacao->id}}</td>
									<td>{{$doacao->usuario->nomeCompleto()}}</td>
									<td>
										<ul class="list-group">
											@foreach($doacao->itens as $doacao_item)
												<li class="list-group-item">{{$doacao_item->item->nome}}</li>
											@endforeach
										</ul>
									</td>
									<td>
										<ul class="list-group">
											@foreach($doacao->itens as $doacao_item)
												<li class="list-group-item">{{ucfirst($doacao_item->tamanho)}}</li>
											@endforeach
										</ul>
									</td>
									<td>
										<ul class="list-group">
											@foreach($doacao->itens as $doacao_item)
												<li class="list-group-item">{{$doacao_item->quantidade}}</li>
											@endforeach
										</ul>
									</td>
									<td>{{$doacao->getCanal()}}</td>
									<td>{{$doacao->getFinalizado()}}</td>
									<td>
										@if($doacao->finalizado == 1)
											<a class="btn btn-success" onClick="atualizarStatusDoacao({{$doacao->id}}, 2)">Pagar</a>
										@elseif($doacao->finalizado == 2)
											<a class="btn btn-success" onClick="atualizarStatusDoacao({{$doacao->id}}, 3)">Receber</a>
										@endif

										@if($doacao->finalizado < 3)
											<a class="btn btn-danger" onClick="atualizarStatusDoacao({{$doacao->id}}, 4)">Cancelar</a>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				{{-- tab tipos_doacao --}}
				<div class="tab-pane fade" id="v-pills-tipos_doacao" role="tabpanel" aria-labelledby="v-pills-tipos_doacao-tab">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" colspan="3">Canal de Doação</th>
								<th class="text-right"><a class="btn btn-primary" href="/admin/doacao-tipo/index">Novo</a></th>
							</tr>
							<tr>
								<th>#</th>
								<th>Imagem</th>
								<th>Nome</th>
								<th width="15%" class="text-center">Ações</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['doacao_tipo'] as $doacao_tipo)
								<tr>
									<td>{{$doacao_tipo->id}}</td>
									<td><img src="{{$doacao_tipo->imagem}}" class="thumb"></td>
									<td>{{$doacao_tipo->nome}}</td>
									<td>
										<a class="btn btn-primary" href="/admin/doacao-tipo/index/{{$doacao_tipo->id}}">Editar</a>
										&nbsp;
										<a class="btn btn-danger" href="#" onclick="modalDelete('doacaoTipo', {{$doacao_tipo->id}}, 'Canal de Doação')">Excluir</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				{{-- tab itens --}}
				<div class="tab-pane fade" id="v-pills-itens" role="tabpanel" aria-labelledby="v-pills-itens-tab">
					<table class="table table-striped">
						<thead class="thead-dark sticky-top">
							<tr>
								<th class="text-center" colspan="9">Itens</th>
								<th class="text-right"><a class="btn btn-primary" href="/admin/item/index">Novo</a></th>
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
				{{-- tab tipos_item --}}
				<div class="tab-pane fade" id="v-pills-tipos_item" role="tabpanel" aria-labelledby="v-pills-tipos_item-tab">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" colspan="2">Tipos de Item</th>
								<th class="text-right"><a class="btn btn-primary" href="/admin/tipo/index">Novo</a></th>
							</tr>
							<tr>
								<th>#</th>
								<th>Nome</th>
								<th width="15%" class="text-center">Ações</th>
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
			</div>
			
		</div>
	</div>	 
@endsection

@section('script')
	<script type="text/javascript">
		$('#app').removeClass('container').addClass('container-fluid');
		$('#dash-main').toggle();
	</script>
@endsection