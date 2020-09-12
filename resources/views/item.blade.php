@extends('master')

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-8">
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					@if(isset($imagens->first()->link))
						@foreach($imagens as $key => $imagem)
							<div class="carousel-item{{$key == 0 ? ' active' : ''}}">
								<img src="{{$imagem->link}}" class="d-block w-100" alt="Imagem Item {{$item->id}}">
							</div>
						@endforeach
					@else
						<div class="carousel-item">
							<p>Sem Imagem</p>
						</div>
					@endif
					<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<div class="col-12">
					<h3>{{$item->nome}}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h5>{{$item->descricao}}</h5>
				</div>
			</div>
			@if($item->lista == 1)
				<div class="row">
					<div class="col-12">
						<h6>
							Este é um item da lista "você escolhe". A imagem e o link são exemplos, e você pode comprar o item da sua preferência, ou dar o valor em dinheiro. A escolha é sua.
						</h6>
					</div>
				</div>
			@else
				<div class="row">
					<div class="col-12">
						<h6>Este é um item da lista "está escolhido". Este item faz parte de um conjunto, ou possui o tema do quartinho. Você pode comprar pelo link, ou dar o valor. A escolha é sua.</h6>
					</div>
				</div>
			@endif
			@if($links->count() > 0)
				<div class="row">
					<div class="col-12">
						@if($item->lista == 1)
							<h5>Links de exemplo:</h5>
						@else
							<h5>Links para compra:</h5>
						@endif
					</div>
				</div>
				@foreach($links as $link)
					<div class="row">
						<div class="offset-2 col-10">
							<h5><a href="{{$link->link}}" target="_blank">{{$link->nome}}</a></h5>
						</div>
					</div>
				@endforeach
			@endif
			<div class="row">
				<div class="col-12">
					<h4>Valor sugerido:</h4>
					<h5 class="offset-2">{{$item->getPreco()}}</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#app-modal-participa">Vou participar!</button>
				</div>
				<div class="col-6">
					<button class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#app-modal-sacolinha">Colocar na sacolinha</button>
				</div>
			</div>
		</div>
	</div>	
@endsection