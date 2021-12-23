<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterRequest;
use App\Models\Disaster;
use Exception;
use Api;

class DisasterController extends Controller
{
    private $response, $code;

    public function __construct()
    {
        $this->code = 200;
        $this->response = [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $response = Disaster::query();

            if(request()->has('search')){
                $response = Disaster::where('name', 'LIKE', '%'. request()->query('search') .'%');
            }

            $this->response = Api::pagination($response);
        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }

        return Api::apiRespond($this->code, $this->response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DisasterRequest $request
     * @return void
     */
    public function store(DisasterRequest $request)
    {
        try{
            $data = $request->validated();
            $this->response = Disaster::create($data);
        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }

        return Api::apiRespond($this->code, $this->response);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $this->response = Disaster::where('id', $id)->first();
        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }
        return Api::apiRespond($this->code, $this->response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DisasterRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(DisasterRequest $request, $id)
    {
        try {
            $this->response = Disaster::findOrFail($id)->update($request->validated());
        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }
        return Api::apiRespond($this->code, $this->response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->response = Disaster::findOrFail($id)->delete();
        } catch (Exception $e) {
            $this->code = 500;
            $this->response = $e->getMessage();
        }
        return Api::apiRespond($this->code, $this->response);
    }
}
