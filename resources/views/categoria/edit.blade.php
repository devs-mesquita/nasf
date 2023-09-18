@extends('gentelella.layouts.app')

@section('content')

<div class="x_panel modal-content ">

	<div class="x_title">
	   <h2>Editar Categoria </h2>
	   <div class="clearfix"></div>
	</div>

	<div class="x_panel ">
	   <div class="x_content">
	   		<form id="formulario_user" class="form-horizontal form-label-left" method="post" action="{{url("categoria/$categoria->id")}}">
               {!! method_field('PUT') !!}
               {{ csrf_field() }}

				<div id="desabilita">
					<div class="form-group row">
						<div class=" form-group col-md-6 col-sm-6 col-xs-12">
							<label class="control-label" >Categoria</label>
							<input type="text" id="nome" class="form-control " name="nome" minlength="4" maxlength="100" value="{{$categoria->nome}}" required >	
						</div>
					</div>
				</div>
   	   
				{{-- BOTÕES --}}
				<div class="clearfix"></div>
				<div class="ln_solid"> </div>
					<div class="footer text-right"> {{-- col-md-3 col-md-offset-9 --}}
						<button id="btn_voltar" class="botoes-acao btn btn-round btn-primary" >
							<span class="icone-botoes-acao mdi mdi-backburger"></span>   
							<span class="texto-botoes-acao"> CANCELAR </span>
							<div class="ripple-container"></div>
						</button>
				
						<button type="submit" id="btn_salvar" class="botoes-acao btn btn-round btn-success ">
							<span class="icone-botoes-acao mdi mdi-send"></span>
							<span class="texto-botoes-acao"> SALVAR </span>
							<div class="ripple-container"></div>
						</button>
					</div>
			</form>
	   </div>
	</div>
@endsection

@push('scripts')
    {{-- Vanilla Masker --}}
    <script src="{{ asset('js/vanillaMasker.min.js')}}"></script>

    <script>
        VMasker ($("#cpf")).maskPattern("999.999.999-99");
		VMasker ($("#cep")).maskPattern("99999-999");
        VMasker ($("#telefone")).maskPattern("(99)99999-9999"); 
		// VMasker ($("#nascimento")).maskPattern("99/99/9999"); 
		// VMasker ($("#admissao")).maskPattern("99/99/9999");
        $(document).ready(function(){
            //botão de voltar
			$("#btn_voltar").click(function(){
				event.preventDefault();
				window.location.href = "{{ URL::route('categoria.index') }}"; 
			});
        });
    </script>
@endpush