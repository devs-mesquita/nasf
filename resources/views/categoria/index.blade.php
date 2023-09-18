@extends('gentelella.layouts.app')

@section('content')
    <div class="x_panel modal-content ">
		<div class="x_title">
			<h2>Categoria</h2>
			<ul class="nav navbar-right panel_toolbox">
			    <a href="{{url('categoria/create')}}" class="btn-circulo btn  btn-success btn-md  pull-right " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Nova Categoria"> Nova Categoria </a>
			</ul>
			<div class="clearfix"></div>
		</div>
        <div class="x_panel ">
			<div class="x_content">
				<table id="tb_user" class="table table-hover table-striped compact">
					<thead>
						<tr>
							<th>Categoria</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
							    <td>{{$categoria->nome}}</td>
                                <td class="actions">
									<a
										href="{{url("categoria/$categoria->id/edit")}}"
										class="btn btn-warning btn-xs action botao_acao btn_editar" 
										data-toggle="tooltip" 
										data-placement="bottom" 
										title="Editar Usuario">  
										<i class="glyphicon glyphicon-pencil "></i>
									</a>
									<a
									id="btn_exclui_funcionario"
									class="btn btn-danger btn-xs action botao_acao btn_excluir"
									data-voluntario = {{$categoria->id}}
									title="Apagar Usuario">
									<i class="glyphicon glyphicon-remove "></i>
								 </a>
                                </td>
							</tr>
                        @endforeach	
					</tbody>
				</table>
			</div>
		</div>
    </div>
@endsection

@push('scripts')
	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/date-uk.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
 $("table#tb_user").on("click", "#btn_exclui_funcionario" ,function(){
		let id = $(this).data('voluntario');
				// console.log(id);
				let btn = $(this);
               Swal.fire({
                           title: 'Você tem certeza?',
                           text: "Você não poderá reverter isso!",
                           icon: 'warning',
                           showCancelButton: true,
                           confirmButtonColor: '#3085d6',
                           cancelButtonColor: '#d33',
                           confirmButtonText: 'Sim, delete isso!'
                           }).then((result) => {
                           if (result.isConfirmed) {
                              $.post("{{ url('/categoria') }}/" + id, {
								      id: id,
								      _method: "DELETE",
                              _token: "{{ csrf_token() }}"
								     
							         }).done(function() {
								      location.reload();
							         });
                        
                           }
                        })
                     

  });
	</script>
    <script>
        $(document).ready(function(){
            var tb_user = $("#tb_user").DataTable({
                language: {
                    'url' : '{{ asset('js/portugues.json') }}',
					"decimal": ",",
					"thousands": "."
                },
                stateSave: true,
                stateDuration: -1,
                responsive: true,
            })
        });
    </script>
@endpush