@extends('gentelella.layouts.app')
@section('content')
<link href="{{ asset('css/tom-select.bootstrap5.min.css') }}" rel="stylesheet" />

<div class="x_panel modal-content">
	<div class="x-title">
		<h2>Conduta Conjunta, após avaliação compartilhada:</h2>
	</div>
    
    <form action="{{action('SolicitacaoController@enviaresposta', $solicitacao->id)}}" method="POST">
        {{ csrf_field() }}
        @method('PUT')
        
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="form-label fw-normal" for="comentario">Conduta conjunta, após avaliação compartilhada:
                </label>   
                <textarea class="form-control" id="comentario" rows="3" required name="comentario"></textarea>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="control-label" for="ts">Avaliação:</label>
                <select id="avaliacao" name="avaliacao"  class="form-control" required>
                    <option value="" selected> Escolha uma opção</option>
                    <option>Retono programado para o NASF</option>
                    <option>Alta de episódio, seguir acompanhado pela ESF</option>
                    <option>Seguimento de atendimento em grupo</option>
                    <option>Indicação de atenção ambulatorial especializada</option>
                    <option>Compartilhamento com a rede intersetoria</option>
                    <option>Outros - Descreva</option>
                </select>
            </div>
            

            <div id="outros" class=" form-group col-md-12 col-sm-12 col-xs-12" style="display: none;">
                <label class="control-label" >Outros:</label>
                <input type="text" id="outro" class="form-control"   name="outros">	
            </div>
            <div class="card-footer text-center" >
                <button type="update" id="btn_salvar" class="btn btn-primary" >Salvar</button>
            </div>
        </div>	
        
    </form>
<div class="x_panel modal-content">
	<div class="x-title">
		<h2>Solicitação</h2>
	</div>

            
        <div class="row">
            <div class=" form-group col-md-12 col-sm-12 col-xs-12">
                <label class="control-label" >Categorias:</label>
                <select name="categorias_id[]" id="categorias_id" disabled multiple class="form-control">
                    @foreach ($solicitacao->categorias as $categoria)
                        <option value="{{$categoria->id}}" selected>{{$categoria->nome}}</option> 
                    @endforeach
                </select>
            </div>
        </div>   
    
        <div class=" form-group col-md-4 col-sm-4 col-xs-4">
            <label class="control-label" >Unidade:</label>
            <input type="text" id="unidade" class="form-control" disabled value="{{$solicitacao->unidade}}" name="unidade" minlength="4" maxlength="100"
           required >	
        </div>
        <div class=" form-group col-md-4 col-sm-4 col-xs-4">
            <label class="control-label" >Equipe:</label>
            <input type="text" id="equipe" class="form-control" disabled value="{{$solicitacao->equipe}}" name="equipe" minlength="4" maxlength="100"
           required >	
        </div>
        <div class=" form-group col-md-4 col-sm-4 col-xs-4">
            <label class="control-label" >ACS:</label>
            <input type="text" id="acs" class="form-control" disabled value="{{$solicitacao->acs}}" name="acs" minlength="4" maxlength="100"
           required >	
        </div>
        <div class=" form-group col-md-9 col-sm-9 col-xs-12">
            <label class="control-label" >Usuário:</label>
            <input type="text" id="usuario" class="form-control" disabled value="{{$solicitacao->usuario}}" name="usuario" minlength="4" maxlength="100"
           required >	
        </div>
        <div class="form-group col-md-3 col-sm-3 col-xs-12 ">
            <label class="control-label" for="nascimento">D.N:</label>
            <input required class="form-control datepicker" name="dn" id="dn" disabled type="date" value="{{$solicitacao->dn}}">
        </div>
        <div class=" form-group col-md-9 col-sm-9 col-xs-12">
            <label class="control-label" >Endereço:</label>
            <input type="text" id="endereco" class="form-control" disabled value="{{$solicitacao->endereco}}" name="endereco" minlength="4" maxlength="100"
           required >	
        </div>
        <div class=" form-group col-md-3 col-sm-3 col-xs-12">
            <label class="control-label" >Telefone:</label>
            <input type="text" id="telefone" class="form-control" disabled value="{{$solicitacao->telefone}}" name="telefone" minlength="4" maxlength="100"
           required >	
        </div>
        <div class=" form-group col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" >Motivo da Solicitação:</label>
            <input type="text" id="mv_solicitacao" class="form-control" disabled value="{{$solicitacao->mv_solicitacao}}" name="mv_solicitacao" minlength="4" maxlength="100"
            >	
        </div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="form-label fw-normal" for="nomeCompleto">Breve relato do caso:</label>   
                <textarea class="form-control" id="relato" rows="3" disabled  name="relacao_caso">{{$solicitacao->relacao_caso}}</textarea>
        </div>
    
   
	
	
</div>	

@endsection

@push('scripts')
<script src="{{ asset('js/tom-select.complete.min.js') }}"></script>
<script type="text/javascript">
	new TomSelect('#categorias_id',{
		maxOptions: 150,
		sortField: {
			field: 'text',
			direction: 'asc'
		}
	});

	
</script>

<script>
    const textareaEle = document.querySelector('#outros');

document.querySelector('select').addEventListener('change', function() {
  textareaEle.style.display = (this.value == 'Outros - Descreva') ? 'block' : 'none';
});

</script>
@endpush