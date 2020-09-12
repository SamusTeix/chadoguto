@extends('master')

@section('content')
	<input type="hidden" id="doacao_id" name="doacao_id" value="{{$doacao->id}}">
	<h4>Muito obrigado por ter chegado até aqui</h4>
	<div class="row">
		<div class="col-12">
			@if($doacao_itens->count() < 1)
				<h4>Nenhum item adicionado a sacolinha!</h4>
			@else
				<div class="tab-main">
					<div class="tab-content show" pos="1">
						<div class="row">
							<div class="col-12">
								<div class="table-responsive-sm">
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
								</div>
							</div>
							<div class="col-12 text-right">
								<a href="#" class="btn btn-success" direction="next">Continuar</a>
							</div>
						</div>
					</div>
					<div class="tab-content hide" pos="2">
						<div class="row">
							<input type="hidden" id="tipo_doacao" name="tipo_doacao">
							<div class="card col-xs-12 col-sm-6 text-center card_tipo" onClick="selectTipo(this, 1)" role="button">
								<div class="card-body">
									<svg width="10em" height="10em" viewBox="0 0 16 16" class="bi bi-shop" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
									</svg>
									<h5 class="card-title"></h5>
									<h5 class="card-title">Prefiro comprar na loja</h5>
									<p class="card-text">Aqui você mesmo compra o(s) item(ns) e entrega posteriormente</p>
								</div>
							</div>
							<div class="card col-xs-12 col-sm-6 text-center card_tipo" onClick="selectTipo(this, 2)" role="button">
								
								<div class="card-body">
									<svg width="10em" height="10em" viewBox="0 0 16 16" class="bi bi-wallet" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5V3zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a1.99 1.99 0 0 1-1-.268zM1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1z"/>
									</svg>
									<h5 class="card-title"></h5>
									<h5 class="card-title">Prefiro dar o valor sugerido</h5>
									<p class="card-text">Aqui você nos repassa o valor sugerido e nós compramos o(s) item(ns)</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<a href="#" class="btn btn-primary" direction="prev">Voltar</a>
								<a href="#" class="btn btn-success disabled btn-tipo-doacao">Continuar</a>
							</div>
						</div>
					</div>
					<div class="tab-content hide" pos="3">
						<input type="hidden" id="canal_doacao" name="canal_doacao">
						<div class="row">
							@foreach($doacaoCanal as $key => $canal)
							<div class="card col-xs-12 col-sm-3 text-center card_canal" onClick="selectCanal(this, {{$canal->id}})" role="button">
								<img src="{{$canal->imagem}}" class="img-fluid rounded">
								<div class="card-body">
									<h5 class="card-title">{{$canal->nome}}</h5>
									<p class="card-text">{{$canal->descricao}}</p>
								</div>
							</div>
						@endforeach
						</div>						
						<div class="row">
							<div class="col-12">
								<a href="#" class="btn btn-primary"  direction="prev">Voltar</a>
								<a href="#" class="btn btn-success disabled btn-canal-doacao">Finalizar</a>
							</div>
						</div>
					</div>
				</div>		
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			@if($finalizadas->count() > 0)
				@foreach($finalizadas as $doacao)
					<div class="table-responsive-sm">
						<table class="table">
							<thead>
								@if($doacao->tipo == 1)
									<tr>
										<th colspan="10">Tipo de presente: <b>Prefiro comprar na loja</b></th>
									</tr>
								@else
									<tr>
										<th colspan="10">Tipo de presente: <b>Prefiro dar o valor sugerido</b></th>
									</tr>
									<tr>
										<th colspan="10">{{$doacao->canal->nome}}</th>
									</tr>
									<tr>
										<th colspan="10">
											<textarea class="form-control overflow-hidden" rows="5" style="resize: none" disabled>{!!$doacao->canal->dados!!}</textarea>
										</th>
									</tr>
									<tr>
										<td colspan="10">
											Total: {{$doacao->getValorTotal()}}
										</td>	
									</tr>								
								@endif
								<tr>
									<td></td>
									<td>Nome</td>
									<td>Tamanho</td>
									<td>Quantidade</td>
									@if($doacao->tipo == 1)
										<td>Links</td>
									@else
										<td>Valor Unitário Sugerido</td>
										<td>Valor Total Sugerido</td>
									@endif								
								</tr>
							</thead>
							<tbody>
								@foreach($doacao->itens as $item)
									<tr>
										<td>
											<img src="{{$item->imagem->link}}" class="rounded mini-thumb">
										</td>
										<td>
											{{$item->item->nome}}
										</td>
										<td>
											{{ucfirst($item->tamanho)}}
										</td>
										<td>
											{{$item->quantidade}}
										</td>
										@if($doacao->tipo == 1)
											@if($item->item->lista == 1)
												@if($item->links->count())
													<td>
														Links de exemplo:
														@foreach($item->links as $link)
															<a href="{{$link->link}}" class="btn btn-primary" target="_blank">{{$link->nome}}</a>
														@endforeach
													</td>
												@endif											
											@else
												<td>
													Link para compra:
													@foreach($item->links as $link)
														<a href="{{$link->link}}" class="btn btn-primary" target="_blank">{{$link->nome}}</a>
													@endforeach
												</td>
											@endif
										@else
											<td>{{$item->item->getPreco()}}</td>
											<td>{{$item->item->getPrecoTotal($item->quantidade)}}</td>
										@endif	
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endforeach
			@endif
		</div>		
	</div>	
@endsection

@section('script')

@endsection