<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Services\TagService;


 /**
  * @OA\Tag(
    *     name="Tags",
    *     description="Facilitam a categorização das postagens, permitindo uma organização e busca mais eficiente."
    * )
    */

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    
   /**
    *  @OA\Get(
     *     path="/api/tags",
     *     summary="Listar todas as tags.",
     *     tags={"Tags"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tags retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
     *                 @OA\Property(property="name", type="string", example="Inspirador", description="Nome da tag")
     *             )
     *         )
     *     )
     * )
     */
 
    public function index()
    {
        return response()->json($this->tagService->getAllTags());
    }

   /**
    *  @OA\Post(
        *     path="/api/tags",
        *     summary="Cadastrar uma nova tag.",
        *     tags={"Tags"},
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             type="object",
        *             required={"name"},
        *             @OA\Property(property="name", type="string", example="Inspirador", description="Nome da tag")
        *         )
        *     ),
        *     @OA\Response(
        *         response=201,
        *         description="Tag criada com sucesso",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
        *             @OA\Property(property="name", type="string", example="Inspirador", description="Nome da tag")
        *         )
        *     ),
        *     @OA\Response(
        *         response=400,
        *         description="Dados inválidos ou faltando parâmetros",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="error", type="string", example="Erro ao criar a tag.")
        *         )
        *     )
        * )
        */
    public function store(TagRequest $request)
    {
        $data = $request->validated();
        $tag = $this->tagService->createTag($data);
        return response()->json($tag, 201);
    }

   /**
    *  @OA\Get(
        *     path="/api/tags/{tag}",
        *     summary="Exibir os dados de uma tag específica.",
        *     tags={"Tags"},
        *     @OA\Parameter(
        *         name="tag",
        *         in="path",
        *         required=true,
        *         @OA\Schema(type="integer"),
        *         description="ID da tag"
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="Tag encontrada com sucesso",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
        *             @OA\Property(property="name", type="string", example="Inspirador", description="Nome da tag")
        *         )
        *     ),
        *     @OA\Response(
        *         response=404,
        *         description="Tag não encontrada",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="error", type="string", example="Tag não encontrada.")
        *         )
        *     )
        * )
        */
    public function show($id)
    {
        $tag = $this->tagService->getTagById($id);
        return response()->json($tag);
    }

   /**
    * @OA\Put(
        *     path="/api/tags/{tag}",
        *     summary="Atualizar os dados de uma tag específica.",
        *     tags={"Tags"},
        *     @OA\Parameter(
        *         name="tag",
        *         in="path",
        *         required=true,
        *         @OA\Schema(type="integer"),
        *         description="ID da tag"
        *     ),
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="name", type="string", example="Inspirador", description="Nome da tag")
        *         )
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="Tag atualizada com sucesso",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="id", type="integer", example=1, description="ID da tag"),
        *             @OA\Property(property="name", type="string", example="Inspirador", description="Nome da tag")
        *         )
        *     ),
        *     @OA\Response(
        *         response=400,
        *         description="Dados inválidos ou faltando parâmetros",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="error", type="string", example="Erro ao atualizar a tag.")
        *         )
        *     )
        * )
        */
    public function update(TagRequest $request, $id)
    {
        $data = $request->validated();
        $tag = $this->tagService->updateTag($id, $data);
        return response()->json($tag);
    }

    /**
     * @OA\Delete(
        *     path="/api/tags/{tag}",
        *     summary="Deletar uma tag específica.",
        *     tags={"Tags"},
        *     @OA\Parameter(
        *         name="tag",
        *         in="path",
        *         required=true,
        *         @OA\Schema(type="integer"),
        *         description="ID da tag"
        *     ),
        *     @OA\Response(
        *         response=204,
        *         description="Tag deletada com sucesso"
        *     ),
        *     @OA\Response(
        *         response=404,
        *         description="Tag não encontrada",
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="error", type="string", example="Tag não encontrada.")
        *         )
        *     )
        * )
        */
    public function destroy($id)
    {
        $msg = 'Tag deletada com sucesso.';
        $deleted = $this->tagService->deleteTag($id);
        return response()->json([ $msg => $deleted ], 204);
    }
}

