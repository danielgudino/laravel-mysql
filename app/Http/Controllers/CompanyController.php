<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CompanyService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CompanyRequests\CreateCompanyRequest;
use App\Http\Requests\CompanyRequests\UpdateCompanyRequest;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/companies",
     *     summary="Companies list | index()",
     *     description="See all registered companies.",
     *     tags={"Company"},
     *     @OA\Response(
     *         response=200,
     *         description="list all companies."
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="An error has occurred."
     *     )
     * )
     */
    public function index()
    {
        try {
            $companies = CompanyService::getCompanies();
            return response()->json(array('data' => $companies), 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *   path="/api/companies",
     *   summary="Company Create | store()",
     *   description="Register a company simply by defining its name and description.",
     *   tags={"Company"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="Created company."
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response="default",
     *       description="An error has occurred."
     *   )
     * )
     */
    public function store(CreateCompanyRequest $request)
    {
        try {
            $newCompany = CompanyService::createCompany($request->all());
            Log::debug(__METHOD__ . ' - New company created ' . json_encode($newCompany));
            return response()->json(['data' => $newCompany]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage() . ' - req: ' . json_encode($request->all()));
            return response()->json(["message" => "Error creating Company"], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/api/companies/{id}",
     *     summary="Company Show | show()",
     *     description="See just a registered company.",
     *     tags={"Company"},
     *     security={{"passport": {"*"}}},
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *             type="string"
     *        )
     *     ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=200,
     *         description="Show a company."
     *     ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response="default",
     *         description="An error has occurred."
     *     )
     * )
     */
    public function show($id)
    {
        $company = CompanyService::getCompany($id);
        return response()->json(['data' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   path="/api/companies/{id}",
     *   summary="Company Update | update()",
     *   description="Update a company simply by defining its name and description and ID.",
     *   tags={"Company"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="Updated company."
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response="default",
     *       description="An error has occurred."
     *   )
     * )
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        try {
            $company = CompanyService::updateCompany($id, $request->all());
            Log::debug(__METHOD__ . ' - Company updated ' . json_encode($company));
            return response()->json(['data' => $company]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage() . ' - req: ' . json_encode($request->all()));
            return response()->json(["message" => "Error updating company"], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   path="/api/companies/{id}",
     *   summary="Company Delete | destroy()",
     *   description="Delete a company simply by defining an ID.",
     *   tags={"Company"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="Deleted company."
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response="default",
     *       description="An error has occurred."
     *   )
     * )
     */
    public function destroy($id)
    {
        try {
            $deleted = CompanyService::deleteCompany($id);
            Log::debug(__METHOD__ . ' - Company deleted id: ' . $id);
            return response()->json(['deleted' => $deleted]);
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . ' - ' . $th->getMessage() . ' - req: ' . $id);
            return response()->json(["message" => "Error deleting company"], 400);
        }
    }
}
