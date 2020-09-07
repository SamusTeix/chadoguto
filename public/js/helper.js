Array.prototype.find = function(value)
{
	return this.filter(function(index) {
		return index === value;
	})
}

Array.prototype.delete = function(value)
{
	return this.filter(function(index) {
		return index !== value;
	})
}

var App = {};

App.url = function()
{
	return window.location.href;
}

App.host = function()
{
	return window.location.hostname;
}

App.rand = function()
{
	return Math.random();
}

App.http = function()
{
	return App.url().split('/')[0];
}

App.normalize_path = function(path)
{
	return App.http() + '//' + App.host() + path;
}

App.include = function(path)
{
	return App.normalize_path(path) + '?version=' + App.rand();
}

App.url_value = function()
{
	let numbers = App.url().match(/\d+/g);
	if (numbers)
	{
		return numbers.map(Number).join();
	}
	return '';
	
}

App.get = function(path, callback)
{
	var callbacks = $.Callbacks("once");
	callbacks.add(callback);

	App.loading();
	$.ajax({
		url: App.normalize_path(path),
	}).done(
		function(ret)
		{
			var json = JSON.parse(ret);
			callbacks.fire(json);
			App.loading(0);
			setTimeout(function(){
				App.loading(0);
			}, 500);
		}
	);
}

App.post = function(path, data, callback)
{
	var callbacks = $.Callbacks("once").add(callback);

	var formData = new FormData();
	formData.append('_token', $('#token_csfr').find('input[type=hidden]')[0].value);
	$(Object.entries(data)).each(function(i, item) {
		if ((typeof item[1] == 'array' || typeof item[1] == 'object') && item[0] != 'imagem')
		{
			item[1] = JSON.stringify(item[1]);
		}
		formData.append(item[0], item[1]);
	})

	App.loading();
	$.ajax({
		url: App.normalize_path(path),
		data: formData,
		type: "POST",
		contentType: false,
		processData: false,
		success: function(ret)
		{
			var json = JSON.parse(ret);
			callbacks.fire(json);
			App.loading(0);
			setTimeout(function(){
				App.loading(0);
			}, 500)
		},
	});
}

function log(value)
{
	return console.log(value);
}

function dd(value)
{
	log(value);
	return false;
}

App.loading = function(show = 1)
{
	if (show == 0) {
		$('#app-modal-loading').modal('hide');
	} else {
		$('#app-modal-loading').modal('show');
	}	
}

function modalDelete(nome, id, mensagem = null)
{
	if (! mensagem)
	{
		mensagem = nome;
	}

	nome_funcao = 'delete' + uc_first(nome) + '(' + id + ')';
	$('#app-modal-delete-title').text('Você deseja excluir o ' + mensagem + ' ' + id + '?');
	$('#app-modal-delete-button').attr('onClick', nome_funcao);
	$('#app-modal-delete').modal('toggle');
}

function deleteItem(id)
{
	App.get('/admin/item/delete/' + id, function(json) {
		if (json.info == 1)
		{
			App.modalSuccess(json.msg, true);
		}

	});
}

function deleteTipo(id)
{
	App.get('/admin/tipo/delete/' + id, function(json) {
		if (json.info == 1)
		{
			App.modalSuccess(json.msg, true);
		}

	});
}

function deleteDoacaoTipo(id)
{
	App.get('/admin/doacao-tipo/delete/' + id, function(json) {
		if (json.info == 1)
		{
			App.modalSuccess(json.msg, true);
		}

	});
}

function adicionarSacolinha()
{
	var selected = false;
	let item_id  = App.url_value();
	let tamanhos = $('#app-modal-sacolinha-text').find('.form-group').find('.form-control');

	var lista_tamanhos = [];
	tamanhos.each(function(index, tamanho) {
		if ($(tamanho)[0].selectedIndex > 0)
		{
			selected = true;
		}
		lista_tamanhos.push({nome: $(tamanho)[0].id, quantidade: $(tamanho)[0].selectedIndex});
	})

	if (selected)
	{
		$('#app-modal-sacolinha').modal('hide');

		let data = {item_id: item_id, tamanhos: lista_tamanhos};
		App.post('/sacolinha/adicionar/', data, function(json) {
			if (json.info == 1)
			{
				App.modalSuccess(json.msg);	
			}

		})
	}
	else
	{
		$('#app-modal-sacolinha-erro').slideDown();
		setTimeout(function()
		{
			$('#app-modal-sacolinha-erro').slideUp();
		}, 10000);	
	}
}

function adicionarParticipa()
{
	var selected = false;
	let item_id  = App.url_value();
	let tamanhos = $('#app-modal-participa-text').find('.form-group').find('.form-control');

	var lista_tamanhos = [];
	tamanhos.each(function(index, tamanho) {
		if ($(tamanho)[0].selectedIndex > 0)
		{
			selected = true;
		}
		lista_tamanhos.push({nome: $(tamanho)[0].id, quantidade: $(tamanho)[0].selectedIndex});
	})

	if (selected)
	{
		$('#app-modal-participa').modal('hide');

		let data = {item_id: item_id, tamanhos: lista_tamanhos};
		App.post('/sacolinha/adicionar/', data, function(json) {
			if (json.info == 1)
			{
				window.location.href = '/sacolinha';
			}
		})
	}
	else
	{
		$('#app-modal-participa-erro').slideDown();
		setTimeout(function()
		{
			$('#app-modal-participa-erro').slideUp();
		}, 10000);	
	}
}

function uc_first(string)
{
	return string.charAt(0).toUpperCase() + string.slice(1);
}

function excluiSacolinhaItem(id_item, tamanho)
{
	let doacao_id = $('#doacao_id').attr('value');

	id            = '"id_doacao:' + doacao_id + '|id_item:' + id_item + '|tamanho:' + tamanho  + '"';
	funcao        = 'sacolinhaItem';
	mensagem      = $('#nome_item_' + id_item + '_tamanho_' + tamanho).text() + ' - ' + uc_first(tamanho);
	
	modalDelete(funcao, id, mensagem);
}

function alteraSacolinhaQuantidade(campo)
{
	let doacao_id   = $('#doacao_id').attr('value');
	let nome_campo  = campo.name.split('_');
	let valor_campo = campo.selectedIndex;

	if (valor_campo < 1)
	{
		campo.selectedIndex = $(campo).attr('valueOnLoad');

		nome_campo.shift();
		nome_campo.unshift('nome');
		nome_item = nome_campo.join('_');

		id       = '"id_doacao:' + doacao_id + '|id_item:' + nome_campo[2] + '|tamanho:' + nome_campo[4]  + '"';
		funcao   = 'sacolinhaItem';
		mensagem = $('#' + nome_item).text() + ' - ' + uc_first(nome_campo[4]);
		
		modalDelete(funcao, id, mensagem);
	} 
	else
	{
		App.post('/sacolinha/editar', {id: doacao_id, id_item: nome_campo[2], tamanho: nome_campo[4], quantidade: valor_campo}, function(json) {
			console.log(json);
		});	
	}	
}

function deleteSacolinhaItem(valores)
{
	valores = valores.split('|');
	data    = {};
	$(valores).each(function(index, item){
		item = item.split(':');
		data[item[0]] = item[1];
	})

	App.post('/sacolinha/remover', data, function(json) {
		if (json.info == 1)
		{
			App.modalSuccess(json.msg, true);
		}
	});
}

App.modalSuccess = function(msg, reload = false)
{
	modalSuccess(msg, reload);
}

function modalSuccess(msg, reload = false)
{
	$('#app-modal-success-text').text(msg);
	if (reload)
	{
		$('#app-modal-success-btn').attr('onclick', 'window.location.reload()');
	}
	$('#app-modal-success').modal('toggle');
}

App.modalError = function(msg, reload = false)
{
	modalError(msg, reload);
}

function modalError(msg, reload = false)
{
	$('#app-modal-error-text').text(msg);
	if (reload)
	{
		$('#app-modal-error-btn').attr('onclick', 'window.location.reload()');
	}
	$('#app-modal-error').modal('toggle');
}

$('#btn-acessar').click(function(){
	if (App.validate([{ field: 'login', name: 'Email' }])) 
	{
		App.post('/usuario/verificar', { login: $('#login').val() }, function(json)
		{
			if (json.info == 1)
			{
				window.location.href = '/list';
			}
			else
			{
				App.modalError(json.msg);
			}
		})
	}	
})

$('#btn-enviar').click(function() {
	var fields = [
		{ field: 'nome'     , name: 'Nome' },
		{ field: 'sobrenome', name: 'Sobrenome' },
		{ field: 'email'    , name: 'Email' }
	];

	if (App.validate(fields))
	{
		var data = {
			nome:      $('#nome').val(),
			sobrenome: $('#sobrenome').val(),
			email:     $('#email').val()
		};

		App.post('/usuario/cadastrar', data, function(json)
		{
			if (json.info == 1)
			{
				window.location.href = '/list';
			}
			else
			{
				App.modalError(json.msg, true);
			}
		})	
	}
})

App.validate = function(data_list)
{
	var errors = [];
	$(data_list).each(function(i, item)
	{
		if ($('#' + item.field).val().length < 1)
		{
			errors.push(item.name);
		}
	})

	if (errors.length > 0)
	{
		var msg = '';

		msg += errors.length == 1 ? 'O campo "' : 'Os campos "';
		msg += errors.join('", "');
		msg = msg.replace(/,([^,]*)$/, ' e' + '$1')
		msg += errors.length == 1 ? '" é obrigatório' : '" são obrigatórios';

		App.modalError(msg);
		return false;
	}
	return true;
}

// SISTEMA DE ABAS PROPRIETARIO - INI

// HTML

// <div class="tab-main">
// 	<div class="tab-content show" pos="1">
// 		<a href="#" direction="next">Próximo</a>
// 	</div>
// 	<div class="tab-content hide" pos="2">
// 		<a href="#" direction="next">Próximo</a>
// 		<a href="#" direction="prev">Anterior</a>
// 	</div>
// 	<div class="tab-content hide" pos="3">
// 		<a href="#" direction="prev">Anterior</a>
// 	</div>
// </div>

// SCRIPT
$('.tab-main').find('.tab-content a').click(function() {
	var direction = $(this).attr('direction');
	var position  = $(this).closest('.tab-content').attr('pos') * 1;
	var tabList   = $(this).closest('.tab-main').find('.tab-content');

	if (direction == 'next')
	{
		position = position + 1;
	} 
	else if (direction == 'prev')
	{
		position = position - 1;
	} 
	else
	{
		return false;
	}

	$(tabList).each(function(i, tab){
		$(tab).removeClass('show').addClass('hide');
		if ($(tab).attr('pos') * 1 == position)
		{
			$(tab).removeClass('hide').addClass('show');
		}
	})
})

// SISTEMA DE ABAS PROPRIETARIO - FIM

function selectTipo(div, tipo)
{
	$('#tipo_doacao').val(tipo);
	$('.card_tipo').css('background-color', 'white');
	$(div).css('background-color', '#38c172');
	$(div).closest('.tab-content').find('.disabled').removeClass('disabled');

	if (tipo == 1)
	{
		$('.btn-tipo-doacao').text('Finalizar');
	}
	else
	{
		$('.btn-tipo-doacao').text('Continuar');	
	}
}

function selectCanal(div, tipo)
{
	$('#canal_doacao').val(tipo);
	$('.card_canal').css('background-color', 'white');
	$(div).css('background-color', '#38c172');
	$(div).closest('.tab-content').find('.disabled').removeClass('disabled');
}

function atualizarStatusDoacao(doacao, status)
{
	var msg = "";
	switch (status) {
		case 2:
			msg = 'Você deseja setar o status da doação ' + doacao + ' para "Aguardando Entrega"?';
			break;
		case 3:
			msg = 'Você deseja setar o status da doação ' + doacao + ' para "Entregue"?';
			break;
		case 4:
			msg = 'Você deseja CANCELAR a doacao ' + doacao + '?';
			break;
	}

	if (window.confirm(msg)) {
		App.get('/admin/doacao/' + doacao + '/atualizar-status/' + status, function(json) {
			if (json.info == 1)
			{
				App.modalSuccess(json.msg, true);
			}
			else 
			{
				App.modalError(json.msg);
			}
		})
	}
}

$('.btn-tipo-doacao').click(function(){
	if ($('#tipo_doacao').val() == 1)
	{
		App.post('/sacolinha/finalizar', { tipo_doacao: 1 }, function(json) {
			if (json.info == 1)
			{
				App.modalSuccess(json.msg, true);
			}
			else
			{
				App.modelError(json.msg);
			}
		});
	}
	else
	{
		$('.tab-main').find('.tab-content').removeClass('show').addClass('hide');
		$($('.tab-main').find('.tab-content')).each(function(i, div) {
			if ($(div).attr('pos') == 3)
			{
				$(div).removeClass('hide').addClass('show');
			}
		})
	}
});

$('.btn-canal-doacao').click(function(){
	App.post('/sacolinha/finalizar', { tipo_doacao: 2, canal_doacao: $('#canal_doacao').val() }, function(json) {
		if (json.info == 1)
		{
			App.modalSuccess(json.msg, true);
		}
		else
		{
			App.modelError(json.msg);
		}
	})
});