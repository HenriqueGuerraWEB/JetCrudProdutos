<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;

class Products extends Component
{
    // Upload Livewire
    use WithFileUploads;
 
    public $imagem;
 
    public function save()
    {
        $this->validate([
            'imagem' => 'image|max:1024', // 1MB Max
        ]);
 
        $this->imagem->store('imagens');
    }

    // controller LiveWire

    public $products, $nome, $detalhes, $valor, $product_id;
    public $isOpen = 0;    
    public function render()
    {
        $this->products = Product::all();
        return view('livewire.products');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->nome = '';
        $this->detalhes = '';
        $this->valor = '';
        $this->imagem = '';
        $this->product_id = '';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'nome' => 'required',
            'detalhes' => 'required',
            'valor' => 'required',
            'imagem' => ''
        ]);
   
        Product::updateOrCreate(['id' => $this->product_id], [
            'nome' => $this->nome,
            'detalhes' => $this->detalhes,
            'valor' => $this->valor,
            'imagem' => $this->imagem
        ]);
  
        session()->flash('message', 
            $this->product_id ? 'Produto atualizado com sucesso.' : 'Produto criardo com sucesso.');
  
        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->nome = $product->nome;
        $this->detalhes = $product->detalhes;
        $this->valor = $product->valor;
        $this->imagem = $product->imagem;
    
        $this->openModal();
    }
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Produto excluido com sucesso.');
    }    
}
