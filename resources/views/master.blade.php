<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Chá do Guto</title>	
	{{-- Estilos --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="http://localhost/css/app.css" rel="stylesheet">

    <style>
    	.show {
    		display: block;
    	}

    	.hide {
    		display: none;
    	}

    	.thumb {
    		width: 10vw;
    	}

    	.mini-thumb {
    		width: 5vw;
    	}
    </style>
</head>
<body>
	<div id="app" class="container">
		<nav class="navbar fixed-top navbar-light bg-light" style="background-image: url('/storage/fundo.png'); background-repeat: repeat-x;">
			<div class="navbar-brand">
				<a href="{{isset(session('permission')['user']) && session('permission')['user'] == true ? '/list' : '/'}}">
					<img src="/storage/coroa.png" style="position: relative; left: 40px; top: -20px;">
					<img src="/storage/titulo.png" style="border: 10px solid rgb(45, 69, 115); border-radius: 19px; background-color: rgb(254, 254, 254); position: relative; left: -10px; top: 16px; width: 40%;">
					<img src="/storage/urso.png" style="height: 107px; position: relative; left: -31px; top: 8px;">
				</a>
			</div>
			<div class="navbar-brand">
				<a href="/sacolinha">
					<div style="border: 10px solid rgb(45, 69, 115); border-radius: 19px; background-color: rgb(254, 254, 254);">
						<img src="/storage/sacolinha.png" style="width: 100px;">
						<span id="contador-sacolinha" class="badge badge-secondary"></span>
					</div>				
				</a>
			</div>
		</nav>

		<div style="height: 175px"></div>

		{{md5('admin')}}<br>
		{{md5('sc261291')}}

        @yield('content')
        
		<!-- Modal Delete -->
		<div class="modal fade" id="app-modal-delete" tabindex="-1" role="dialog" aria-labelledby="app-modal-delete" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header" id="app-modal-delete-header">
		        <h5 class="modal-title" id="app-modal-delete-title"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-footer" id="app-modal-delete-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="app-modal-delete-button">Sim</button>
		      </div>
		    </div>
		  </div>
		</div>

		{{-- Modal Success --}}
		<div class="modal fade" id="app-modal-success" tabindex="-1" role="dialog" aria-labelledby="app-modal-success" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header" id="app-modal-success-header">
		        <h5 class="modal-title" id="app-modal-success-title">
		        	<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
					  <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
					</svg>
		        	Sucesso
		        </h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body" id="app-modal-delete-body">
		        <p id="app-modal-success-text"></p>
		      </div>
		      <div class="modal-footer" id="app-modal-success-footer">
		        <button type="button" id="app-modal-success-btn" class="btn btn-primary" data-dismiss="modal">Ok</button>
		      </div>
		    </div>
		  </div>
		</div>

		{{-- Modal Error --}}
		<div class="modal fade" id="app-modal-error" tabindex="-1" role="dialog" aria-labelledby="app-modal-error" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
				<div class="row">
		      		<div class="col-12 text-center">
						<svg width="6em" height="6em" viewBox="0 0 16 16" class="bi bi-exclamation-circle text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
							<path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
						</svg>
						<h5 class="modal-title" id="app-modal-error-title">		        	
			        		Atenção
			        	</h5>
		      		</div>
		      	</div>
		      <div class="modal-header" id="app-modal-error-header"></div>
		      <div class="modal-body" id="app-modal-delete-body">
		        <p id="app-modal-error-text"></p>
		      </div>
		      <div class="modal-footer" id="app-modal-error-footer">
		        <button type="button" id="app-modal-error-btn" class="btn btn-primary" data-dismiss="modal">Ok</button>
		      </div>
		    </div>
		  </div>
		</div>

		{{-- modal sacolinha --}}
		@if(isset($item->id))
			<div class="modal fade" id="app-modal-sacolinha" tabindex="-1" role="dialog" aria-labelledby="app-modal-sacolinha" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" id="app-modal-sacolinha-header">
			        <h5 class="modal-title" id="app-modal-sacolinha-title">Adicionando item {{$item->nome}}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body" id="app-modal-delete-body">
			        <div id="app-modal-sacolinha-text">
			        	<h5>Selecione o(s) tamanho(s):</h5>
				  		@if(isset($tamanho->pequeno) && $tamanho->pequeno > 0)
				  			<div class="form-group">
								<label>Pequeno:</label>
								<select class="form-control" id="pequeno" nome="pequeno">
									@for($i = 0; $i <= $tamanho->pequeno; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
				  		@if(isset($tamanho->medio) && $tamanho->medio > 0)
				  			<div class="form-group">
								<label>Médio:</label>
								<select class="form-control" id="medio" nome="medio">
									@for($i = 0; $i <= $tamanho->medio; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
				  		@if(isset($tamanho->grande) && $tamanho->grande > 0)
				  			<div class="form-group">
								<label>Grande:</label>
								<select class="form-control" id="grande" nome="grande">
									@for($i = 0; $i <= $tamanho->grande; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
				  		@if(isset($tamanho->unico) && $tamanho->unico > 0)
				  			<div class="form-group">
								<label>Tamanho único:</label>
								<select class="form-control" id="unico" nome="unico">
									@for($i = 0; $i <= $tamanho->unico; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
			        </div>
			        <span id="app-modal-sacolinha-erro" class="alert alert-danger btn-block" style="display: none;">Selecione pelo menos um tamanho</span>
			      </div>
			      <div class="modal-footer" id="app-modal-sacolinha-footer">
			      	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
			        <button type="button" class="btn btn-success" onClick="adicionarSacolinha()">Confirmar</button>
			      </div>
			    </div>
			  </div>
			</div>
		@endif

		{{-- modal participa --}}
		@if(isset($item->id))
			<div class="modal fade" id="app-modal-participa" tabindex="-1" role="dialog" aria-labelledby="app-modal-participa" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" id="app-modal-participa-header">
			        <h5 class="modal-title" id="app-modal-participa-title">Adicionando item {{$item->nome}}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body" id="app-modal-delete-body">
			        <div id="app-modal-participa-text">
			        	<h5>Selecione o(s) tamanho(s):</h5>
				  		@if(isset($tamanho->pequeno) && $tamanho->pequeno > 0)
				  			<div class="form-group">
								<label>Pequeno:</label>
								<select class="form-control" id="pequeno" nome="pequeno">
									@for($i = 0; $i <= $tamanho->pequeno; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
				  		@if(isset($tamanho->medio) && $tamanho->medio > 0)
				  			<div class="form-group">
								<label>Médio:</label>
								<select class="form-control" id="medio" nome="medio">
									@for($i = 0; $i <= $tamanho->medio; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
				  		@if(isset($tamanho->grande) && $tamanho->grande > 0)
				  			<div class="form-group">
								<label>Grande:</label>
								<select class="form-control" id="grande" nome="grande">
									@for($i = 0; $i <= $tamanho->grande; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
				  		@if(isset($tamanho->unico) && $tamanho->unico > 0)
				  			<div class="form-group">
								<label>Tamanho único:</label>
								<select class="form-control" id="unico" nome="unico">
									@for($i = 0; $i <= $tamanho->unico; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
				  		@endif
			        </div>
			        <span id="app-modal-participa-erro" class="alert alert-danger btn-block" style="display: none;">Selecione pelo menos um tamanho</span>
			      </div>
			      <div class="modal-footer" id="app-modal-participa-footer">
			      	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
			        <button type="button" class="btn btn-success" onClick="adicionarParticipa()">Confirmar</button>
			      </div>
			    </div>
			  </div>
			</div>
		@endif

		{{-- modal loading --}}
		<div class="modal fade" id="app-modal-loading" tabindex="-1" role="dialog" aria-labelledby="app-modal-loading" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content" style="width: 10rem; height: 10rem; position: relative; left: calc(50% - 5rem); background: none; border: none;">
		    	<div class="text-center">
				  <div class="spinner-border" style="width: 5rem; height: 5rem; position: relative; top: 2.5rem; color: aqua;" role="status">
				    <span class="sr-only">Loading...</span>
				  </div>
				</div>
 			</div>
		  </div>
		</div>

    </div>

    <div id="token_csfr">
    	@csrf
    </div>
	{{-- Scripts --}}
	<script type="text/javascript" src="http://localhost/js/app.js"></script>	
	<script type="text/javascript" src="http://localhost/js/helper.js"></script>
	@yield('script')
</body>
</html>

