@extends('master')

@section('content')
	<div class="jumbotron">
	  {{-- <h1 class="display-4">Hello, world!</h1> --}}
	  <p class="lead text-center">Sintam-se bem a vontade para comprar o que fica melhor para vocês, tem itens de vários preços.</p>
	  <hr class="my-4">
	  <p>
	  	Fizemos duas listas de presentinhos para você verificar qual forma prefere comprar meu presentinho. Leia como funciona cada uma, escolha o seu item preferido e clique em cima para ver a sugestão, o valor e como deve proceder para sabermos que já podemos riscar a quantidade que você irá dar da lista, sim, você pode dar de 1 item até o número total que colocamos como necessário, por isso precisamos saber quantos já foram.
	  </p>
	  <p>
	  	A primeira é para quem deseja comprar na loja ou no modelo de sua preferência. Mas também pode seguir a sugestão que colocamos ou até mesmo transferir o valor para a mamãe e o papai comprarem.
	  </p>
	  <p>
	  	A segunda lista é para quem puder comprar diretamente o modelo e na loja que a mamãe e o papai escolheram, assim deixando meu quartinho todo igual. Nesse caso seria a compra do item específico ou a transferência do valor para que meus papais comprem e deixem meu quarto lindo
	  </p>
	  <hr class="my-4">
	  <p class="lead text-center">
	  	Vamos ficar felizes com o ato de carinho de vocês, se não puderem dar nada nesse momento, não tem problema também, só pedimos para deixar uma mensagem de carinho para mim!
	  </p>
	  <hr class="my-4">
	  <p>
	  	Se ficarem na dúvida de como é tudo ou quiserem fazer de outra forma a mamãe e o papai vão sempre estar disponíveis para conversar com vocês. Eles tentaram fazer de uma forma que facilitasse para todos, já que a mamãe está se cuidando e não terá nem lista em loja e nem festinha.
	  </p>
	  {{-- <p class="lead">
	    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
	  </p> --}}
	</div>
	<div class="row">
		<div class="col-12">
			<ul class="nav nav-pills nav-fill">
				<li class="nav-item">
					<a class="nav-link{{empty($tipo_selecionado) ? ' active' : ''}}" href="/list">Todas</a>
				</li>
				@foreach($tipos as $tipo)
					<li class="nav-item">
						<a class="nav-link{{$tipo_selecionado == $tipo->id ? ' active' : ''}}" href="/list/{{$tipo->id}}">{{$tipo->nome}}</a>
					</li>
				@endforeach
			</ul>	
		</div>		
	</div>
	<div class="row">
		@foreach($itens as $item)
			<div class="card col-3" style="padding: 5px;">
				@if(isset($item->imagem->first()->link))
					<a href="/item/{{$item->id}}">
						<img class="card-img-top" src="{{$item->imagem->first()->link}}" alt="Imagem Item {{$item->id}}">
					</a>					
				@else
					<p>Sem Imagem Adicionada</p>
				@endif			  
			  <div class="card-body">
			    <h5 class="card-title">{{$item->nome}}</h5>
			    <p class="card-text">{{$item->descricao}}</p>
			  </div>
			  <div>
			  	<a href="/item/{{$item->id}}" class="btn btn-primary col-12">Ver</a>
			  </div>
			</div>
		@endforeach
	</div>
@endsection