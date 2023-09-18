@extends('gentelella.layouts.app')

@section('content')


<div class="x_panel modal-content">
    <div class="x_title">
       <h2>Solicitações</h2>
       <ul class="nav navbar-right panel_toolbox">
         @if (Auth::user()->nivel == 'Medico')
            <a href="{{url('solicitacao/create')}}" class="btn-circulo btn  btn-success btn-md  pull-right " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Nova Sala"> Nova Solicitação </a> 
         @endif         
         </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_panel">
       <div class="x_content">
         <table id="tb_solicitacao" class="table table-hover table-striped compact">
            <thead>
                <tr>
                    <th>Unidade</th>
                    <th>Categoria</th>
                    <th>Equipe</th>  
                    <th>Data de Solicitacao</th>    
                     <th>Situação</th>            
                    <th>Ações</th>
                 </tr>
            </thead>
            <tbody>
               @foreach ($solicitacoes as $solicitacao)
                  <tr>
                     <td>{{$solicitacao->unidade}}</td>

                     <td>
                        @foreach ($solicitacao->categorias as $categoria)
                           {{$categoria->nome}}
                           <br>
                        @endforeach
                     </td>

                     <td>{{$solicitacao->equipe}}</td>

                     <td>
                        @if ($solicitacao->enviado == 1)
                           {{ date('d/m/y', strtotime($solicitacao->data_enviado)) }}
                        @endif
                     </td>

                     <td>
                        @if ($solicitacao->comentario_enviado == 1)
                           
                             <p style="color: green;">Respondido</p>
                           
                        @elseif ($solicitacao->enviado == 1)
                            
                              <p style="color: rgb(17, 17, 187);">Aguardando Resposta...</p>
                        
                        @else      
                              <p style="color: grey">Aguardando Envio...</p>
                        @endif
                     </td>

                     <td> 
                     
                        <a
                           id="btn_show"
                           class="btn btn-primary btn-xs action botao_acao btn_vizualiza" 
                           href="{{action('SolicitacaoController@show', $solicitacao->id)}}"
                           title="Vizualizar ">  
                           <i class="glyphicon glyphicon-eye-open "></i>
                        </a>

                        @if (Auth::user()->nivel == 'Medico')
                           @if ($solicitacao->enviado == 0) 
                              <a
                                 id="btn_edit"
                                 class="btn btn-warning btn-xs action botao_acao btn_editar" 
                                 href="{{action('SolicitacaoController@edit', $solicitacao->id)}}"
                                 title="Editar ">  
                                 <i class="glyphicon glyphicon-pencil "></i>
                              </a>
         
                              <a
                                 id="btn_send"                     
                                 class="btn btn-success btn-xs action botao_acao btn_send" 
                                 href="{{route('send', $solicitacao->id)}}"
                                 title="Enviar">  
                                 <i class="glyphicon glyphicon-send "></i>
                              </a>
                              
                              <a
                                 id="btn_exclui_solicitacao"
                                 class="btn btn-danger btn-xs action botao_acao btn_excluir"
                                 data-voluntario = {{$solicitacao->id}}
                                 title="Apagar Solicitação">
                                 <i class="glyphicon glyphicon-remove "></i>
                              </a>
                           @endif
                        @endif
                        <a
                           id="btn_pdf"                     
                           class="btn btn-info btn-xs action botao_acao btn_pdf" 
                           href="{{route('pdf', $solicitacao->id)}}"
                           title="Imprimir">  
                           <i class='glyphicon glyphicon-print'></i>
                        </a>
                  
                     @if (Auth::user()->nivel == 'Nasf' )
                        @if ($solicitacao->comentario_enviado == 0)
                           <a
                              id="btn_send"                     
                              class="btn btn-warning btn-xs action botao_acao btn_coment" 
                              href="{{route('solcreate', $solicitacao->id)}}"
                              title="Respoder">  
                              <i class="glyphicon glyphicon-comment "></i>
                           </a>
                        @endif
                     @endif
                  </td>
                  </tr>
               @endforeach
            </tbody>
        </table>
       </div>
    </div>
 </div> 





{{-- <div class="x_panel modal-content">
    <div class="x_title">
       <h2>Solicitações</h2>
       <ul class="nav navbar-right panel_toolbox">
         @if (Auth::user()->nivel != $nasf && Auth::user()->nivel != $admin)
          <a href="{{url('solicitacao/create')}}" class="btn-circulo btn  btn-success btn-md  pull-right " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Nova Sala"> Nova Solicitação </a>
         @endif
         </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_panel">
       <div class="x_content">
         <table id="tb_solicitacao" class="table table-hover table-striped compact">
           


            <thead>
                <tr>
                    <th>Unidade</th>
                    <th>Categoria</th>
                    <th>Equipe</th>  
                    <th>Data de Solicitacao</th>    
                    
                     <th>Situação</th>            
                    
                    <th>Ações</th>
                    
  
                 </tr>
           
            </thead>
            <tbody>
               @foreach ($solicitacoes as $solicitacao)
                   <tr>
                     <td>{{$solicitacao->unidade}}</td>
                     
                     <td>@foreach ($solicitacao->categorias as $categoria)
                        {{$categoria->nome}}
                        <br>
                    @endforeach
                      </td>
                      <td>
                        {{$solicitacao->equipe}}
                        <br>
                    
                      </td>
                   <td>
                     @if ($solicitacao->enviado == 1)
                     {{ date('d/m/y', strtotime($solicitacao->data_enviado)) }}
                     @endif
                   
                   </td>
                   
                      <td>
                        
                        @if ($solicitacao->comentario_enviado == 1)
                           
                             <p style="color: green;">Respondido</p>
                           
                        @elseif ($solicitacao->enviado == 1)
                            
                              <p style="color: rgb(17, 17, 187);">Aguardando Resposta...</p>
                        
                        @else      
                              <p style="color: grey">Aguardando Envio...</p>
                        @endif
                        
                      </td>
                   
                   
                     <td> <a
                        id="btn_show"
                        class="btn btn-primary btn-xs action botao_acao btn_vizualiza" 
                        href="{{action('SolicitacaoController@show', $solicitacao->id)}}"
                        title="Vizualizar ">  
                       <i class="glyphicon glyphicon-eye-open "></i>
                     </a>
                     
                     @if ($solicitacao->enviado == 0)
                        <a
                           id="btn_edit"
                           class="btn btn-warning btn-xs action botao_acao btn_editar" 
                           href="{{action('SolicitacaoController@edit', $solicitacao->id)}}"
                           title="Editar ">  
                           <i class="glyphicon glyphicon-pencil "></i>
                        </a>
      
                        <a
                           id="btn_send"                     
                           class="btn btn-success btn-xs action botao_acao btn_send" 
                           href="{{route('send', $solicitacao->id)}}"
                           title="Enviar">  
                           <i class="glyphicon glyphicon-send "></i>
                        </a>
                        	<a
									id="btn_exclui_solicitacao"
									class="btn btn-danger btn-xs action botao_acao btn_excluir"
									data-voluntario = {{$solicitacao->id}}
									title="Apagar Solicitação">
									<i class="glyphicon glyphicon-remove "></i>
								 </a>
                     @endif
                     		    
                     <a
                     id="btn_pdf"                     
                     class="btn btn-info btn-xs action botao_acao btn_pdf" 
                     href="{{route('pdf', $solicitacao->id)}}"
                     title="Imprimir">  
                     <i class='glyphicon glyphicon-print'></i>
                  </a>
              </a>              
              @if (Auth::user()->nivel == $nasf )
               @if ($solicitacao->comentario_enviado == 0)
                  <a
                     id="btn_send"                     
                     class="btn btn-warning btn-xs action botao_acao btn_coment" 
                     href="{{route('solcreate', $solicitacao->id)}}"
                     title="Respoder">  
                     <i class="glyphicon glyphicon-comment "></i>
                  </a>
                  @endif
                @endif
                  </td>
                   </tr>
                 
                  
                   
               @endforeach
            </tbody>
        </table>
       </div>
    </div>
 </div> --}}



@endsection








@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    var tb_solicitacao = $("#tb_solicitacao").DataTable({
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$("table#tb_solicitacao").on("click", "#btn_exclui_solicitacao" ,function(){
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
                           $.post("{{ url('/solicitacao') }}/" + id, {
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

@endpush