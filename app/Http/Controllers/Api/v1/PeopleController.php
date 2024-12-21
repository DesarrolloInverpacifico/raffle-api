<?php

namespace App\Http\Controllers\Api\v1;

use App\Exports\PeopleExport;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\People\CreatePeopleRequest;
use App\Http\Requests\People\UpdatePeopleRequest;
use App\Http\Resources\People\PeopleCollection;
use App\Http\Resources\People\PeopleResource;
use App\Imports\PeopleImport;
use App\Models\People;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PeopleController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $people = $this->paginate(People::search($request->q), $request, []);

        return $this->successResponse(PeopleCollection::make($people)->response()->getData(true), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePeopleRequest $request)
    {
        People::create($request->all());

        return $this->successResponse([], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(People $people)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(People $people)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeopleRequest $request, People $people)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(People $people)
    {
        //
    }

    /**
     * 
     */
    public function upload(Request $request)
    {
        Excel::import(new PeopleImport, request()->file('file'));

        return $this->successResponse([], Response::HTTP_OK);
    }

    /**
     * 
     */
    public function export()
    {
        // return $this->successResponse('dadadad', Response::HTTP_OK);
        return Excel::download(new PeopleExport, 'personas.xlsx');
    }

    /**
     * 
     */
    public function checkAssistance(Request $request)
    {
        $people = People::where('identification_number', '=', $request->identification)->first();

        if (is_null($people)) {
            throw ValidationException::withMessages([
                'identification'    =>  ['El usuario no esta registrado']
            ]);
        }

        $raffles = $people->raffles->pluck('id');

        $people->raffles()->syncWithPivotValues($raffles, ['is_active' => true]);
        FacadesStorage::append('raffles.json', json_encode($raffles, JSON_PRETTY_PRINT));

        return $this->successResponse(PeopleResource::make($people), Response::HTTP_OK);
    }
}
