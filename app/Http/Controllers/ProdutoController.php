<?php namespace estoque\Http\Controllers;

use Illuminate\Support\Facades\DB;
use estoque\Produto;
use Request;
use estoque\Http\Requests\ProdutosRequest;

class ProdutoController extends Controller {

    public function __construct()
    {
        $this->middleware('auth',
            ['only' => ['adiciona', 'remove']]);
    }

    public function lista(){
        $produtos = Produto::all();
        return view('produto/listagem')->withProdutos($produtos);
    }

    public function mostra($id){
        $resposta = Produto::find($id);
        if(empty($resposta)) {
            return "Esse produto não existe";
        }
        return view('produto/detalhes')->withP($resposta);
    }

    public function novo(){
        return view('produto/formulario');
    }

    public function adiciona(ProdutosRequest $request){

        Produto::create($request::all());

        /*$params = Request::all();
        $produto = new Produto($params);
        $produto->save();*/

        // Repassa todos os parametros
        //return redirect('/produtos')->withInput();

        return redirect('/produtos')->withInput(Request::only('nome'));
    }

    public function salva(){
        $produtoNew = Request::all();
        $produtoOld = Produto::find($produtoNew['id']);
        $produtoOld->nome = $produtoNew['nome'];
        $produtoOld->descricao = $produtoNew['descricao'];
        $produtoOld->quantidade = $produtoNew['quantidade'];
        $produtoOld->valor = $produtoNew['valor'];
        $produtoOld->save();

        return redirect('/produtos');
    }

    public function altera($id){
        $produto = Produto::find($id);
        return view('produto/alteracao')->withP($produto);
    }

    public function listaJson(){
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    public function remove($id){
        $produto = Produto::find($id);
        $produto->delete();
        return redirect()->action('ProdutoController@lista');
    }

}
