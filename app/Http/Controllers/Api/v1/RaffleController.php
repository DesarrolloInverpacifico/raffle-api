<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Raffle\CreateRaffleRequest;
use App\Http\Requests\Raffle\UpdateRaffleRequest;
use App\Http\Resources\Raffle\RaffleCollection;
use App\Http\Resources\Raffle\RaffleResource;
use App\Http\Resources\RaffleCriteria\RaffleCriteriaCollection;
use App\Http\Resources\RaffleCriteria\RaffleCriteriaResource;
use App\Http\Resources\RaffleParticipant\RaffleParticipantResource;
use App\Http\Resources\RafflePrize\RafflePrizeResource;
use App\Imports\RafflePartifipantImport;
use App\Models\Raffle;
use App\Models\RaffleCriteria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RaffleController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $raffle = $this->paginate(Raffle::search($request->q), $request, []);

        return $this->successResponse(RaffleCollection::make($raffle)->response()->getData(true), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRaffleRequest $request)
    {
        $raffle = Raffle::create($request->all());

        return $this->successResponse($raffle, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Raffle $raffle)
    {
        //Load relationship
        $raffle->load([]);

        return $this->successResponse(RaffleResource::make($raffle), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRaffleRequest $request, Raffle $raffle)
    {
        $raffle->update($request->all());

        return $this->successResponse([], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Raffle $raffle)
    {
        //
        $raffle->delete();

        return $this->successResponse([], Response::HTTP_CREATED);
    }

    /**
     * 
     */
    public function getParticipants(Request $request, Raffle $raffle)
    {
        $participants = $raffle->people;

        return $this->successResponse(RaffleParticipantResource::collection($participants), Response::HTTP_OK);
    }

    /**
     * 
     */
    public function storeParticipants(Request $request, Raffle $raffle)
    {
        Excel::import(new RafflePartifipantImport($raffle), request()->file('file'));

        return $this->successResponse([], Response::HTTP_OK);
    }

    /**
     * 
     */
    public function getPrizes(Request $request, Raffle $raffle)
    {
        $prizes = $raffle->rafflePrizes;

        return $this->successResponse(RafflePrizeResource::collection($prizes), Response::HTTP_OK);
    }

    /**
     * 
     */
    public function getCriterias(Request $request, Raffle $raffle)
    {
        $criterias = $raffle->raffleCriterias()->get()->load('raffle');

        // dd($criterias);
        return $this->successResponse(RaffleCriteriaResource::collection($criterias), Response::HTTP_OK);
    }

    /**
     * 
     */
    public function updateWinner(Request $request, Raffle $raffle)
    {
        $raffle->people()->updateExistingPivot($request->people_id, [
            'is_winner' => true
        ]);

        return $this->successResponse([], Response::HTTP_CREATED);
    }

    /**
     * 
     */
    public function resetParticipants(Request $request, Raffle $raffle)
    {
        $participantsIds = $raffle->people()->pluck('id')->toArray();

        $raffle->people()->updateExistingPivot($participantsIds, [
            'is_winner' => false,
            'is_active' => false
        ]);

        return $this->successResponse([], Response::HTTP_CREATED);
    }
}
