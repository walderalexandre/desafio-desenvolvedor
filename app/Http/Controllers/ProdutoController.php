<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\PedidoProduto;
class ProdutoController extends Controller
{

    //Lista com os produtos
    public function index()
    {
        $produtos = Produto::simplePaginate(5);

        return view('produtos.index', compact('produtos'));
    }

    //Tela para criação de produto
    public function create()
    {
        return view('produtos.create');
    }

    //Salva o registro de produto
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required',
            'quantidade' => 'required'
        ]);

        Produto::create(['descricao' => $request->descricao,
                        'valor' => str_replace(',','.',str_replace('.','',$request->valor)),
                        'quantidade' => $request->quantidade]);

        return redirect()->route('produto_index')
            ->with('success', 'Produto salvo com sucesso');
    }

    //Tela para edição de produto
    public function edit(int $id)
    {
        $produto = Produto::find($id);
        
        return view('produtos.edit',compact('produto'));
    }

    public function update(int $id, Request $request, Produto $produto)
    {
        $request->validate([
            'descricao' => 'required',
            'valor' => 'required',
            'quantidade' => 'required'
        ]);

        $produto->find($id)->update(['descricao' => $request->descricao,
                                    'valor' => str_replace(',','.',str_replace('.','',$request->valor)),
                                    'quantidade' => $request->quantidade]);

        return redirect()->route('produto_index')
            ->with('success', 'Produto salvo com sucesso');
    }

    public function destroy(int $id, Produto $produto)
    {
        if (PedidoProduto::where(['produto_id' => $id])->exists()) 
        {
            return redirect()->route('produto_index')->with('error', 'Não é possível excluir un produto associado a um pedido');
        }

        $produto->find($id)->delete();

        return redirect()->route('produto_index')
            ->with('success', 'Produto excluído');
    }
}
