var url = '/admin/item/edit/' + App.url_value();
App.get(url, function(json) {
	new Vue({
		el: '#content_item-form',
		data: function() {
			return {
				item:     json.item,
				links:    json.links,
				tipos:    json.tipos,
				imagens:  json.imagens,
				tamanhos: json.tamanhos,
				
				link:     null,
			}
		},
		methods: {
			deleteRow: function(value)
			{
				this.links = this.links.delete(value);
			},
			saveRow: function()
			{
				this.links.push({ link: this.link, edit: false });
				this.link = '';
			},
			save: function()
			{
				
			},
			saveImage: function()
			{
				var self = this;
				var data = {imagem: $('#imagem')[0].files[0]}

				App.post('/admin/imagem/store', data, function(json) {
					if (json.info == 1)
					{
						self.imagens.push({ link: json.msg[0] });
					}
				})
			},
			deleteImage: function(value)
			{
				this.imagens = this.imagens.delete(value);
			},
			saveForm: function()
			{
				console.log(this.links);
				console.log(this.imagens);

				var self = this;
				var data = {
					id:        typeof self.item.id          == 'undefined' ? null : self.item.id,
					nome:      self.item.nome,
					descricao: self.item.descricao,
					tipo_id:   self.item.tipo_id,
					lista:     self.item.lista,
					preco:     typeof self.item.preco       == 'undefined' ?    0 : self.item.preco,
					pequeno:   typeof self.tamanhos.pequeno == 'undefined' ?    0 : self.tamanhos.pequeno,
					medio:     typeof self.tamanhos.medio   == 'undefined' ?    0 : self.tamanhos.medio,
					grande:    typeof self.tamanhos.grande  == 'undefined' ?    0 : self.tamanhos.grande,
					unico:     typeof self.tamanhos.unico   == 'undefined' ?    0 : self.tamanhos.unico,
					links:     JSON.stringify(self.links),
					imagens:   JSON.stringify(self.imagens)
				}				

				App.post('/admin/item/save', data, function(json) {
					if (json.info == 1)
					{
						$('#app-modal-success-text').text(json.msg);
						$('#app-modal-success').modal('toggle');
					}
				});

			}
		},
		template: `
		<div>
			<div class="row">
				<div class="col-12">
					<input type="hidden" v-model="item.id">
					<div class="form-group">
						<label for="nome">Nome:</label>
						<input type="text" class="form-control" v-model="item.nome" id="nome" name="nome" required>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="descricao">Descrição:</label>
						<input type="text" class="form-control" v-model="item.descricao" required>
					</div>	
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="lista">Lista:</label>
						<select class="form-control" v-model="item.lista">
							<option value="1">Lista 1</option>
							<option value="2">Lista 2</option>
						</select>
					</div>	
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="tipo">Tipo:</label>
						<select class="form-control" v-model="item.tipo_id">
							<option v-for="(tipo, i) in tipos" :value="tipo.id" :selected="item.tipo_id == tipo.id" required>
								{{tipo.nome}}
							</option>
						</select>
					</div>	
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="preco">Preço Recomendado:</label>
						<input type="number" class="form-control" v-model="item.preco">
					</div>	
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="tamanho">Quantidade:</label>
						<div class="row">
							<div class="col-3">
								<div class="form-group">
									<label for="pequeno">Pequeno:</label>
									<input type="number" class="form-control" v-model="tamanhos.pequeno">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label for="medio">Médio:</label>
									<input type="number" class="form-control" v-model="tamanhos.medio">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label for="grande">Grande:</label>
									<input type="number" class="form-control" v-model="tamanhos.grande">
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label for="unico">Tamanho Único:</label>
									<input type="number" class="form-control" v-model="tamanhos.unico">
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>Links:</label>
						<div class="row" v-for="(link, i) in links">
							<div class="col-10">
								<input type="text" class="form-control" v-model="link.link" :disabled="! link.edit">
							</div>
							<div class="col-1" v-if="link.edit">
								<input type="button" class="btn btn-success" @click="link.edit = ! link.edit" value="Salvar">
							</div>
							<div class="col-1" v-else>
								<input type="button" class="btn btn-primary" @click="link.edit = ! link.edit" value="Editar">
							</div>
							<div class="col-1">
								<input type="button" class="btn btn-danger" @click="deleteRow(link)" value="Excluir">
							</div>
						</div>
						<div class="row">
							<div class="col-11">
								<input type="text" v-model="link" class="form-control">
							</div>
							<div class="col-1">
								<input type="button" class="btn btn-success" @click="saveRow" value="Salvar">
							</div>
						</div>
					</div>	
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>Imagens:</label>
						<div class="row">
							<div v-for="(imagem, i) in imagens" class="col-3">		
								<div class="row">
									<img class="col-12" :src="imagem.link">
									<input class="col-12 btn btn-danger" type="button" value="Excluir" @click="deleteImage(imagem)">
								</div>								
							</div>
							<div class="col-3">
								<div class="row">
									<input class="col-12 btn btn-primary" type="file" id="imagem" name="imagem">
									<input class="col-12 btn btn-success" type="button" value="Enviar" @click="saveImage">
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div class="col-12">
					<div class="row">
						<div class="col-12 text-right">
							<a href="/admin" class="btn btn-primary">Voltar</a>
							<button type="button" class="btn btn-success" @click="saveForm">Salvar</button>
						</div>
					</div>
				</div>
			</div>	
		</div>	
		`,
	})
});
