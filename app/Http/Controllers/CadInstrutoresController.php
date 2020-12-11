<?php

namespace App\Http\Controllers;

use App\Models\instrutore;
use App\Models\usuario;
use Illuminate\Http\Request;

class CadInstrutoresController extends Controller
{
    public function index(){
        $tabela = instrutore::orderby('id', 'desc')->paginate();
        return view('painel-admin.instrutores.index', ['itens' => $tabela]);
    }

    public function create(){
        return view('painel-admin.instrutores.create');
    }


    public function insert(Request $request){
        $tabela = new instrutore();
        $tabela->nome = $request->nome;
        $tabela->email = $request->email;
        $tabela->cpf = $request->cpf;
        $tabela->telefone = $request->telefone;
        $tabela->endereco = $request->endereco;
        $tabela->credencial = $request->credencial;
        $tabela->data_venc = $request->data;

        $tabela2 = new usuario();
        $tabela2->nome = $request->nome;
        $tabela2->usuario = $request->email;
        $tabela2->cpf = $request->cpf;
        $tabela2->senha = '1234';
        $tabela2->nivel = 'instrutor';

        $itens = instrutore::where('cpf', '=', $request->cpf)->orwhere('credencial', '=', $request->credencial)->orwhere('email', '=', $request->email)->count();
        if($itens > 0){
            echo "<script language='javascript'> window.alert('Registro já Cadastrado!') </script>";
            return view('painel-admin.instrutores.create');
            
            
        }

        $tabela->save();
        $tabela2->save();
        return redirect()->route('instrutores.index');

    }


    public function edit(instrutore $item){
        return view('painel-admin.instrutores.edit', ['item' => $item]);   
     }
 
 
     public function editar(Request $request, instrutore $item){
         
        $item->nome = $request->nome;
        $item->email = $request->email;
        $item->cpf = $request->cpf;
        $item->telefone = $request->telefone;
        $item->endereco = $request->endereco;
        $item->credencial = $request->credencial;
        $item->data_venc = $request->data;
       
        // verifica item por item
        $oldcpf = $request->oldcpf;
        $oldemail = $request->oldemail;
        $oldcredencial = $request->oldcredencial;
         // condição pra impedir duplicidade de cadastro
        if($oldcpf != $request->cpf){ // se o cpf for duplicado, não insere!
            $itens = instrutore::where('cpf', '=', $request->cpf)->count();
            if($itens > 0){
                echo "<script language='javascript'> window.alert('CPF já Cadastrado!') </script>";
                return view('painel-admin.instrutores.edit', ['item' => $item]);   
                
            }
        }

        if($oldcredencial != $request->credencial){ // se a credencial for duplicada, não insere!
            $itens = instrutore::where('credencial', '=', $request->credencial)->count();
            if($itens > 0){
                echo "<script language='javascript'> window.alert('Credencial já Cadastrada!') </script>";
                return view('painel-admin.instrutores.edit', ['item' => $item]);   
                
            }
        }


        if($oldemail != $request->email){ // se o email for duplicado, não insere!
            $itens = instrutore::where('email', '=', $request->email)->count();
            if($itens > 0){
                echo "<script language='javascript'> window.alert('Email já Cadastrado!') </script>";
                return view('painel-admin.instrutores.edit', ['item' => $item]);   
                
            }
        }
       

        $item->save();
         return redirect()->route('instrutores.index');
 
     }


     public function delete(instrutore $item){
        $item->delete();
        return redirect()->route('instrutores.index');
     }

     public function modal($id){
        $item = instrutore::orderby('id', 'desc')->paginate();
        return view('painel-admin.instrutores.index', ['itens' => $item, 'id' => $id]);

     }


}
