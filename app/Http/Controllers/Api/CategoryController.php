<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CategoryException;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Lista todos as categorias",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todos as categorias"
     *     )
     * )
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * @OA\Post (
     *     path="/api/categories",
     *     summary="Cria uma nova categoria",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", description="Nome da categoria"),
     *             @OA\Property(property="description", type="string", description="Descrição da categoria"),
     *             @OA\Property(property="img_path", type="string", description="Caminho da imagem da categoria")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description = "Categoria criada"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description = "Erro de validação"
     *     )
     * )
     *
     *
     * @throws CategoryException
     */
    public function store(Request $request)
    {
        try{

            $validatedData = $request->validate([
               'name' => 'required|max:255',
               'description' => 'required',
               'img_path' => 'nullable|url'
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'name.max' => 'O campo nome não pode ter mais que 255 caracteres.',

                'description.required' => 'O campo descrição é obrigatória.',

                'img_path.url' => 'O campo img_path deve ser uma URL.'
            ]);

            $category = Category::create($validatedData);
            return response()->json($category, 201);

        } catch (Exception $e){

            throw new CategoryException($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Exibe uma categoria especificada",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     )
     * )
     *
     * @throws CategoryException
     */
    public function show($id)
    {
        try{

            $category = Category::findOrFail($id);
            return response()->json($category, 200);

        } catch (\Exception $e){

            throw new CategoryException("A categoria informada não foi encontrada.");
        }
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Atualiza uma categoria especificada",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", description="Nome da categoria"),
     *              @OA\Property(property="description", type="string", description="Descrição da categoria"),
     *              @OA\Property(property="img_path", type="string", description="Caminho da imagem da categoria")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     )
     * )
     *
     * @throws CategoryException
     */
    public function update(Request $request, $id)
    {
        try{

            $category = Category::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
                'img_path' => 'nullable|url'
            ]);

            $category->update($validatedData);
            return response()->json($category, 200);

        } catch (ModelNotFoundException $e) {

            throw new CategoryException('Impossível atualizar, categoria de id ' . $id . ' não encontrado.');

        } catch (Exception $e){

            throw new CategoryException($e->getMessage());

        }
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Remove uma categoria especifica",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Categoria removida com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     )
     * )
     *
     * @throws CategoryException
     */
    public function destroy($id)
    {
        try{

            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(null, 204);

        } catch (ModelNotFoundException $e) {

            throw new CategoryException('Impossível remover, categoria de id ' . $id . ' não encontrado.');

        } catch (\Exception $e){

            throw new CategoryException($e->getMessage());
        }
    }
}
