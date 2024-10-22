<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_sell_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'barcode' => 'required|string|unique:products',
            'weight' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'status' => 'required|string',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'material' => 'nullable|string',
            'img_path' => 'nullable|string'
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais que 255 caracteres.',

            'min_sell_price.required' => 'O campo preço mínimo de venda é obrigatório.',
            'min_sell_price.numeric' => 'O campo preço mínimo de venda deve ser numérico.',

            'cost_price.required' => 'O campo preço de custo é obrigatório.',
            'cost_price.numeric' => 'O campo preço de custo deve ser numérico.',

            'barcode.required' => 'O campo código de barras é obrigatório.',
            'barcode.string' => 'O campo código de barras deve ser uma string.',
            'barcode.unique' => 'O código de barras já está em uso.',

            'status.required' => 'O campo status é obrigatório.',
            'status.string' => 'O campo status deve ser uma string.',

            'weight.numeric' => 'O campo peso deve ser numérico.',
            'length.numeric' => 'O campo comprimento deve ser numérico.',
            'width.numeric' => 'O campo largura deve ser numérico.',
            'height.numeric' => 'O campo altura deve ser numérico.',

            'color.string' => 'O campo cor deve ser uma string.',
            'size.string' => 'O campo tamanho deve ser uma string.',
            'material.string' => 'O campo material deve ser uma string.',
            'img_path.string' => 'O campo caminho da imagem deve ser uma string.'
        ]);


        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{

            $product = Product::findOrFail($id);
            return response()->json($product);

        } catch (ModelNotFoundException){

            return response()->json([
                'message' => 'Produto não encontrado',
                'timestamp' => now(),
                'status' => 404
            ], 404);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'min_sell_price' => 'required|numeric',
                'cost_price' => 'required|numeric',
                // 'barcode' => 'required|string|unique:products', //Barcode não deve ser alterado
                'weight' => 'nullable|numeric',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'status' => 'required|string',
                'color' => 'nullable|string',
                'size' => 'nullable|string',
                'material' => 'nullable|string',
                'img_path' => 'nullable|string'
            ]);

            $product->update($validatedData);
            return response()->json($product);

        } catch (ModelNotFoundException){

            return response()->json([
                'message' => 'Produto não encontrado, impossível atualizar.',
                'timestamp' => now(),
                'status' => 404
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);

    } catch (ModelNotFoundException){

            return response()->json([
                'message' => 'Produto não encontrado, impossível remover.',
                'timestamp' => now(),
                'status' => 404
            ], 404);

        }
    }
}
