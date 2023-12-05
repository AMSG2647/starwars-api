<?php

namespace App\Http\Controllers;

use App\Http\Requests\Starship\StarshipRequest;
use App\Models\Starship;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StarshipController extends Controller
{
    public $starship;

    /*
    Llamo al objeto en el contructor para no invocarlo
    todo el tiempo en las funciones
    */
    public function __construct(Starship $starship)
    {
        $this->starship = $starship;
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get  (
     *     path="/starships",
     *     tags={"Starship"},
     *     summary="Query all starship",
     *     operationId="indexStarship",
     *     security={{"bearerAuth":{}}},
     *   @OA\Response(response="200", description="returns the registered starships"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */

    public function index(): JsonResponse
    {
        try {
            $starship = $this->starship->with('vehicles')->get();
            $starshipCount = $starship->count();

            return response()->json(
                [
                    'count' => $starshipCount,
                    'data' => $starship,
                    'message' => 'Query Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('index starship fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ],
                500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    // Solo coloque 6 campos en la documentacion pero los 18 campos son registrables

    /**
     * @OA\Post (
     *     path="/starships",
     *     tags={"Starship"},
     *     summary="register starship, only place 6 fields but 18 can be registered, this is just an example",
     *     operationId="storeStarship",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *     @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="model",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="manufacturer",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="cost_in_credits",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="length",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="max_atmosphering_speed",
     *                     type="string"
     *                 ),
     *                 example={
     *                      "name": "Jedi Angel based",
     *                      "model": "Republic Assault ship",
     *                      "manufacturer": "Rendili StarDrive",
     *                      "cost_in_credits": "125000000",
     *                      "length": "1088",
     *                      "max_atmosphering_speed": 1050
     *                  }
     *             )
     *         ),
     *   @OA\Schema(ref="#/components/schemas/StarshipRequest")
     *   ),
     *   @OA\Response(response="200", description="returns the registered object"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function store(StarshipRequest $request)
    {
        try {
            DB::beginTransaction();
            $starship = $this->starship->store();
            DB::commit();
            return response()->json(
                [
                    'data' => $starship,
                    'message' => 'Registration Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('starship register fail:' . $e->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ]
                , 500);
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get (
     *     path="/starships/{id}",
     *     tags={"Starship"},
     *     summary="Return a query",
     *     operationId="showStarship",
     *     security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *  ),
     *   @OA\Response(response="200", description="returns a starship query"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function show(string $id)
    {
        try {
            $starship = $this->starship->getById($id);
            return response()->json(
                [
                    'data' => $starship,
                    'message' => 'Successful Found Starship'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('show starship fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ],
                500);
        }
    }

    /**
     * @OA\Put (
     *     path="/starships/{id}",
     *     tags={"Starship"},
     *     summary="updated starship, only place 6 fields but 18 can be updated, this is just an example",
     *     operationId="updateStarship",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *      ),
     *     @OA\RequestBody(
     *     @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="model",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="manufacturer",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="cost_in_credits",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="length",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="max_atmosphering_speed",
     *                     type="string"
     *                 ),
     *                 example={
     *                      "name": "Jedi Angel based",
     *                      "model": "Republic Assault ship",
     *                      "manufacturer": "Rendili StarDrive",
     *                      "cost_in_credits": "125000000",
     *                      "length": "1088",
     *                      "max_atmosphering_speed": 1050
     *                  }
     *             )
     *         ),
     *   @OA\Schema(ref="#/components/schemas/StarshipRequest")
     *   ),
     *   @OA\Response(response="200", description="returns the updated object"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function update(StarshipRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $starship = $this->starship->getById($id);
            $starship->update(request()->all());
            DB::commit();
            return response()->json(
                [
                    'data' => $starship,
                    'message' => 'Updated Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('update starship fail:' . $e->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ],
                500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete  (
     *     path="/starships/{id}",
     *     tags={"Starship"},
     *     summary="Delete to data",
     *     operationId="destroyStarship",
     *     security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *  ),
     *   @OA\Response(response="200", description="returns a delete query"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $starship = $this->starship->getById($id);
            $starship->delete();
            DB::commit();
            return response()->json(
                [
                    'data' => $starship,
                    'message' => 'Destroy Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug('destroy starship fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ],
                500);
        }
    }
}
