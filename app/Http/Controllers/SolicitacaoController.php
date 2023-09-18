<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\tb_cbo;
use App\Models\tb_prof;
use App\Models\tb_equipe;
use App\Models\tb_lotacao;
use App\Models\tb_unidade_saude;

use App\Models\Solicitacao;
use App\Models\Categoria;
use App\Models\Solicitacao_Categoria;
use Auth;
use PDF;

class SolicitacaoController extends Controller
{
    public function index()
    {
        $usuario_logado = Auth::user();
      
        if($usuario_logado->nivel == 'Nasf'){
            $solicitacoes = Solicitacao::with('categorias')->where('enviado',1)->get();
        }elseif($usuario_logado->nivel == 'Medico'){
            $solicitacoes = Solicitacao::with('categorias')->where('usuario_id',$usuario_logado->id)->get(); 
        }else{
            $solicitacoes = Solicitacao::with('categorias')->get();
        }

        return view('solicitacao.index',compact('solicitacoes'));
    }

    public function create()
    {
        $categorias = Categoria::all();

        $unidades = DB::connection('pgsql')->table('tb_unidade_saude')->select('no_unidade_saude','co_seq_unidade_saude')->where('no_unidade_saude','like','%Clinica da Familia%')->get();

        return view('solicitacao.create', compact('categorias','unidades'));
    }

    
    public function store(Request $request)
    {
        $usuario_logado = Auth::user();

        $solicitacao = new Solicitacao;

        $solicitacao->usuario_id      = $usuario_logado->id;
        $solicitacao->prof_sol        = $usuario_logado->name;
        $solicitacao->unidade         = $request->unidade;
        $solicitacao->equipe          = $request->equipe;
        $solicitacao->acs             = $request->acs;
        $solicitacao->usuario         = $request->usuario;
        $solicitacao->dn              = $request->dn;
        $solicitacao->endereco        = $request->endereco;
        $solicitacao->telefone        = $request->telefone;
        $solicitacao->mv_solicitacao  = $request->mv_solicitacao;
        $solicitacao->relacao_caso    = $request->relacao_caso;

        $solicitacao->save();

        $arr = $request->categoria_id;
        
        foreach($arr as $categoria)
        {
            Solicitacao_Categoria::create([
                'categoria_id'  => $categoria,
                'solicitacao_id'=> $solicitacao->id
            ]);
        }

        return redirect('/solicitacao');
    }

    public function edit($id)
    {

        $solicitacao = Solicitacao::with('categorias')->find($id);
        $categorias = Categoria::all();

        $unidades = DB::connection('pgsql')->table('tb_unidade_saude')->select('no_unidade_saude','co_seq_unidade_saude')->where('no_unidade_saude','like','%Clinica da Familia%')->get();

        return view('solicitacao.edit', compact('solicitacao','unidades','categorias'));

    }

    public function update(Request $request, $id)
    {
        $solicitacao = Solicitacao::with('categorias')->find($id);   
       
        $solicitacao->unidade         = $request->unidade;
        $solicitacao->equipe          = $request->equipe;
        $solicitacao->acs             = $request->acs;
        $solicitacao->usuario         = $request->usuario;
        $solicitacao->dn              = $request->dn;
        $solicitacao->endereco        = $request->endereco;
        $solicitacao->telefone        = $request->telefone;
        $solicitacao->mv_solicitacao  = $request->mv_solicitacao;
        $solicitacao->relacao_caso    = $request->relacao_caso;
       
        $solicitacao->fill($request->all());
        $solicitacao->save(); 
       
        $arr_cat = $request->categorias_id;
        $solicitacao->categorias()->sync($arr_cat);

        return redirect()->route('solicitacao.index');
    }

    public function show($id)
    {
        $solicitacao = Solicitacao::with('categorias')->find($id);

        return view('solicitacao.show', compact('solicitacao'));
    }

    public function destroy($id)
    {
        $solicitacao = Solicitacao::find($id);

        $solicitacao->delete();
    }


    public function getEquipes(Request $request)
    {
        $unidade = DB::connection('pgsql')->table('tb_unidade_saude')->select('co_seq_unidade_saude')->where('no_unidade_saude','=',$request->unidade_nome)->get();

        $equipes = DB::connection('pgsql')->table('tb_equipe')->select('no_equipe')->where('co_unidade_saude','=',$unidade[0]->co_seq_unidade_saude)->get();
      
        return $equipes;
    }

    public function getAcss(Request $request)
    {
        
        $equipe = $request->equipe_nome;
        
        
        $acss = DB::connection('pgsql')->table('tb_lotacao')
                            ->join('tb_equipe','tb_equipe.co_seq_equipe','=','tb_lotacao.co_equipe')
                                ->join('tb_prof','tb_prof.co_seq_prof','=','tb_lotacao.co_prof')
                                    ->join('tb_cbo','tb_cbo.co_cbo','=','tb_lotacao.co_cbo')
                                        ->select('tb_prof.no_profissional')
                                            ->where('tb_cbo.no_cbo','=','AGENTE COMUNITÁRIO DE SAÚDE')
                                                ->where('tb_equipe.no_equipe','=',$equipe)
                                                    ->get();    
        return $acss;
    }

    public function send($id)
    {
        $send = Solicitacao::find($id);

        $send->enviado = 1;
        $send->data_enviado = date('Y/m/d');

        $send->save();

        return redirect()->route('solicitacao.index');
    }

    public function solcreate($id)
    {
        $solicitacao = Solicitacao::with('categorias')->find($id);
        
        return view('solicitacao.resposta',compact('solicitacao'));
    }

    public function enviaresposta(Request $request, $id)
    {
        $user_logado = Auth::user();

        $solicitacao = Solicitacao::with('categorias')->find($id);   

        $solicitacao->comentario           = $request->comentario;
        $solicitacao->avaliacao            = $request->avaliacao; 
        $solicitacao->outros               = $request->outros;
        $solicitacao->comentario_enviado   = '1';
        $solicitacao->data_coment          = date('Y/m/d');
        $solicitacao->nasf_id              = $user_logado->id;
        $solicitacao->nasf_nome            = $user_logado->name;
        
        $solicitacao->save();

        return redirect('/solicitacao');
    }

    public function pdf($id)
    {
        $solicitacao = Solicitacao::with('categorias')->find($id);

       // dd($imagens);
       $pdf = PDF::loadView('solicitacao/pdf',compact('solicitacao'));
       
       return $pdf->stream('Solicitacao.pdf');
    }

}
