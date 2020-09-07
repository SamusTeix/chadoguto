@extends('master')

@section('content')
	<div class="jumbotron">
		<div class="row">
			<div class="col-8">
				<h1 class="display-4">Olá, sou o Augusto</h1>
			  <p class="lead">
			  	Como eu quis vir no meio da pandemia, a mamãe e o papai não estão conseguindo visitar a família e os amigos. Por causa disso também não poderão fazer meu chá de bebê e nem convidar vocês para irem me ver logo quando eu chegar.
			  </p>
			  <hr class="my-4">
				<p>
					Apesar de ficarmos tristes com isso muita gente querida por nós está querendo dar uma lembrancinha para minha chegada e, para que eu não fique com coisinhas repetidas, a mamãe e o papai resolveram fazer essa listinha de todo meu enxoval, para as pessoas que quiserem me dar algo ficarem à vontade para escolher.
				</p>
				<p>
					Na listinha não colocamos fraldas, pois posso nascer pequeno ou grandão, e até mesmo com alguma alergia. Pensando nisso, todo dinheiro que for economizado com os outros itens do enxoval irá para minhas fraldinhas quando eu chegar e assim a mamãe ver qual vai ficar melhor em mim.
				</p>
				<p>
					Também sabemos que está difícil para algumas pessoas saírem, por serem do grupo de risco ou só por precaução, sem contar que algumas lojas estão fechadas. Nesse caso temos algumas sugestões de lojas online e de alguns itens que combinam com a decoração do meu quartinho. Caso vocês queiram dar uma olhada e ver algum produto que já selecionamos e fazer a compra, vocês escolhem como fica melhor.
				</p>
				<p>
					Para entregar meu presentinho temos duas opções: pode ser feito pessoalmente, assim vamos nos ver de longe, ou entrega pelos correios (nas compras virtuais) e quando as coisas melhorarem iremos nos ver de pertinho.
				</p>
				<p>
					Estamos torcendo para tudo passar logo e a gente comemorar com muitos abraços, pois de longe e pela internet não tem como a mamãe e o papai mostrarem para vocês o quão felizes estão com a minha chegada e o que eles mais queriam agora era estar festejando com todo mundo.
				</p>
			</div>
			<div class="col-4">
				<div class="row" style="background-color: white; padding: 15px 0;">
					<div class="col-12">
						<h4>É a primeira vez que venho aqui...</h4>
						<div class="form-group">
							<label for="nome">Nome:</label>
							<input type="text" class="form-control" id="nome" name="nome">
						</div>
						<div class="form-group">
							<label for="sobrenome">Sobrenome:</label>
							<input type="text" class="form-control" id="sobrenome" name="sobrenome">
						</div>
						<div class="form-group">
							<label for="email">E-mail:</label>
							<input type="text" class="form-control" id="email" name="email">
						</div>
						<a class="btn btn-success btn-block" id="btn-enviar">Enviar</a>
					</div>
				</div>
				<hr class="my-4">	
				<div class="row" style="background-color: white; padding: 15px 0;">
					<div class="col-12">
						<h4>Estou voltando...</h4>
						<div class="form-group">
							<label for="email">E-mail:</label>
							<input type="text" class="form-control" id="login" name="login">
						</div>
						<a class="btn btn-success btn-block" id="btn-acessar">Acessar</a>
					</div>
				</div>		
			</div>
		</div>
	</div>
@endsection