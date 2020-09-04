var ItemForm = Vue.component('item-form', {
	props: ['prop_id','prop_nome', 'prop_descricao', 'prop_tamanho', 'prop_tamanho_extenso', 'prop_quantidade', 'prop_links', 'prop_imagens'],
	data: function() {
		return {
			id:              this.prop_id,
			nome:            this.prop_nome,
			descricao:       this.prop_descricao,
			tamanho:         this.prop_tamanho,
			tamanho_extenso: JSON.parse(this.prop_tamanho_extenso),
			quantidade:      this.prop_quantidade,
			link:            null,
			links:           JSON.parse(this.prop_links),
			imagens:         JSON.parse(this.prop_imagens),
		}
	},
	template: `
	<form method="POST" action="/admin/item/save">
		@csrf
		{{-- Formulário --}}
		<div class="row">
			<div class="col-12">
				<input type="hidden" v-model="id">
				<div class="form-group">
					<label for="nome">Nome:</label>
					<input type="text" class="form-control" v-model="nome"
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<label for="descricao">Descrição:</label>
					<input type="text" class="form-control" v-model="descricao">
				</div>	
			</div>
			<div class="col-12">
				<div class="form-group">
					<label for="quantidade">Quantidade:</label>
					<input type="text" class="form-control" v-model="quantidade">
				</div>	
			</div>
			<div class="col-12">
				<div class="form-group">
					<label for="tamanho">Tamanho:</label>
					<select class="form-control" v-model="tamanho">
						<option> -- Selecione -- </option>
						<option v-for="var_tamanho in tamanho_extenso" :value="var_tamanho[0]" :selected="tamanho == var_tamanho[0]">{{var_tamanho[1]}}</option>
					</select>
				</div>	
			</div>
		</div>
		{{-- Links --}}
		<div class="row">			
			<div class="form-group">
				<label>Links:</label>
				<div v-for="link in links">
					<div class="col-8">
						<input class="form-control" v-model="link">
					</div>
					<div class="col-2">
						<input type="button" class="btn btn-primary" @click="editRow" value="Editar">
					</div>
					<div class="col-2">
						<input type="button" class="btn btn-danger" @click="deleteRow" value="Excluir">
					</div>
				</div>
				<div class="col-10">
					<input class="form-control" v-model="link">
				</div>
				<div class="col-2">
					<input type="button" class="btn btn-success" @click="saveRow" value="Salvar">
				</div>
			</div>
		</div>
		{{-- Imagens --}}
		<div>
			
		</div>
		<button type="submit" class="btn btn-primary">Salvar</button>
	</form>
	`,
})