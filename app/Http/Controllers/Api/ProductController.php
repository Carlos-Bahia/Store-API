<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ProductException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Lista todos os produtos",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todos os produtos"
     *     )
     * )
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Cria um novo produto",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "min_sell_price", "cost_price", "barcode", "status"},
     *             @OA\Property(property="name", type="string", description="Nome do produto"),
     *             @OA\Property(property="description", type="string", description="Descrição do produto"),
     *             @OA\Property(property="min_sell_price", type="number", format="float", description="Preço mínimo de venda"),
     *             @OA\Property(property="cost_price", type="number", format="float", description="Preço de custo"),
     *             @OA\Property(property="barcode", type="string", description="Código de barras do produto"),
     *             @OA\Property(property="weight", type="number", format="float", description="Peso do produto"),
     *             @OA\Property(property="length", type="number", format="float", description="Comprimento do produto"),
     *             @OA\Property(property="width", type="number", format="float", description="Largura do produto"),
     *             @OA\Property(property="height", type="number", format="float", description="Altura do produto"),
     *             @OA\Property(property="status", type="string", description="Status do produto"),
     *             @OA\Property(property="color", type="string", description="Cor do produto"),
     *             @OA\Property(property="size", type="string", description="Tamanho do produto"),
     *             @OA\Property(property="material", type="string", description="Material do produto"),
     *             @OA\Property(property="img_path", type="string", description="Caminho da imagem do produto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     )
     * )
     *
     * @throws ProductException
     */
    public function store(Request $request)
    {
        try {
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
        } catch (\Exception $e){

            throw new ProductException($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Exibe um produto especificado",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     *
     * @throws ProductException
     */
    public function show($id)
    {
        try{

            $product = Product::findOrFail($id);
            return response()->json($product);

        } catch (ModelNotFoundException){

            throw new ProductException("Produto não encontrado no sistema");
        }
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Atualiza um produto especificado",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "min_sell_price", "cost_price", "status"},
     *             @OA\Property(property="name", type="string", description="Nome do produto"),
     *             @OA\Property(property="description", type="string", description="Descrição do produto"),
     *             @OA\Property(property="min_sell_price", type="number", format="float", description="Preço mínimo de venda"),
     *             @OA\Property(property="cost_price", type="number", format="float", description="Preço de custo"),
     *             @OA\Property(property="barcode", type="string", description="Código de barras do produto"),
     *             @OA\Property(property="weight", type="number", format="float", description="Peso do produto"),
     *             @OA\Property(property="length", type="number", format="float", description="Comprimento do produto"),
     *             @OA\Property(property="width", type="number", format="float", description="Largura do produto"),
     *             @OA\Property(property="height", type="number", format="float", description="Altura do produto"),
     *             @OA\Property(property="status", type="string", description="Status do produto"),
     *             @OA\Property(property="color", type="string", description="Cor do produto"),
     *             @OA\Property(property="size", type="string", description="Tamanho do produto"),
     *             @OA\Property(property="material", type="string", description="Material do produto"),
     *             @OA\Property(property="img_path", type="string", description="Caminho da imagem do produto")
     *
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     *
     * @throws ProductException
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

            throw new ProductException('Impossível atualizar, produto de id ' . $id . ' não encontrado.');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Remove um produto especificado",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto removido com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     *
     * @throws ProductException
     */
    public function destroy($id)
    {
        try{
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(null, 204);

        } catch (ModelNotFoundException){

            throw new ProductException('Impossível remover, produto de id ' . $id . ' não encontrado.');

        }
    }
}
