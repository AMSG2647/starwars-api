<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VehiclesController extends Controller
{
    public $vehicle;

    /*
    Llamo al objeto en el contructor para no invocarlo
    todo el tiempo en las funciones
    */
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get  (
     *     path="/vehicles",
     *     tags={"Vehicles"},
     *     summary="Query all vehicles",
     *     operationId="indexVehicles",
     *     security={{"bearerAuth":{}}},
     *   @OA\Response(response="200", description="returns the registered vehicles"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function index(): JsonResponse
    {
        try {
            $vehicle = $this->vehicle->with('starships')->get();
            $vehicleCount = $vehicle->count();
            return response()->json(
                [
                    'count' => $vehicleCount,
                    'data' => $vehicle,
                    'message' => 'Query Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('index vehicle fail:' . $e->getMessage());
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

    /**
     * @OA\Post (
     *     path="/vehicles",
     *     tags={"Vehicles"},
     *     summary="register vehicle",
     *     operationId="storeVehicle",
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
     *                  @OA\Property(
     *                     property="crew",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="passengers",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="cargo_capacity",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="consumables",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="vehicle_class",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="pilots",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="films",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="url",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="created",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="edited",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="starship_id",
     *                     type="integer"
     *                 ),
     *                 example={
     *                      "name": "Sand Angel",
     *                      "model": "Digger Crawler",
     *                      "manufacturer": "Corellia Mining Corporation",
     *                      "cost_in_credits": "75000",
     *                      "length": "7",
     *                      "max_atmosphering_speed": 1500,
     *                      "crew": "1",
     *                      "passengers": "100",
     *                      "cargo_capacity": "1000",
     *                      "consumables": "5 days",
     *                      "vehicle_class": "1.0",
     *                      "pilots": "[]",
     *                      "films": "[]",
     *                      "url": null,
     *                      "created": "2023-12-04 21:30:21",
     *                      "edited": "2023-12-04 21:30:21" ,
     *                      "starship_id": 5
     *                  }
     *             )
     *         ),
     *   @OA\Schema(ref="#/components/schemas/VehicleRequest")
     *   ),
     *   @OA\Response(response="200", description="returns the registered object"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function store(VehicleRequest $request)
    {
        try {
            DB::beginTransaction();
            $vehicle = $this->vehicle->store();
            DB::commit();
            return response()->json(
                [
                    'data' => $vehicle,
                    'message' => 'Registration Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('vehicle register fail:' . $e->getMessage());
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
     * Display the specified resource.
     */

    /**
     * @OA\Get (
     *     path="/vehicles/{id}",
     *     tags={"Vehicles"},
     *     summary="Return a query",
     *     operationId="showVehicle",
     *     security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *  ),
     *   @OA\Response(response="200", description="returns a query query"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function show(string $id)
    {
        try {
            $vehicle = $this->vehicle->getById($id);
            return response()->json(
                [
                    'data' => $vehicle,
                    'message' => 'Successful Found Vehicle'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('show vehicle fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ],
                500);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put (
     *     path="/vehicles/{id}",
     *     tags={"Vehicles"},
     *     summary="update vehicle",
     *     operationId="updateVehicle",
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
     *                  @OA\Property(
     *                     property="crew",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="passengers",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="cargo_capacity",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="consumables",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="vehicle_class",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="pilots",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="films",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="url",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="created",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="edited",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="starship_id",
     *                     type="integer"
     *                 ),
     *                 example={
     *                      "name": "Sand Angel",
     *                      "model": "Digger Crawler",
     *                      "manufacturer": "Corellia Mining Corporation",
     *                      "cost_in_credits": "75000",
     *                      "length": "7",
     *                      "max_atmosphering_speed": 1500,
     *                      "crew": "1",
     *                      "passengers": "100",
     *                      "cargo_capacity": "1000",
     *                      "consumables": "5 days",
     *                      "vehicle_class": "1.0",
     *                      "pilots": "[]",
     *                      "films": "[]",
     *                      "url": null,
     *                      "created": "2023-12-04 21:30:21",
     *                      "edited": "2023-12-04 21:30:21" ,
     *                      "starship_id": 5
     *                  }
     *             )
     *         ),
     *   @OA\Schema(ref="#/components/schemas/VehicleRequest")
     *   ),
     *   @OA\Response(response="200", description="returns the update object"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */
    public function update(VehicleRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $vehicle = $this->vehicle->getById($id);
            $vehicle->update(request()->all());
            DB::commit();
            return response()->json(
                [
                    'data' => $vehicle,
                    'message' => 'Updated Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('update vehicle fail:' . $e->getMessage());
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
     *     path="/vehicles/{id}",
     *     tags={"Vehicles"},
     *     summary="Delete to data",
     *     operationId="destroyVehicles",
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
            $vehicle = $this->vehicle->getById($id);
            $vehicle->delete();
            DB::commit();
            return response()->json(
                [
                    'data' => $vehicle,
                    'message' => 'Destroy Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug('destroy vehicle fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ],
                500);
        }
    }
}
