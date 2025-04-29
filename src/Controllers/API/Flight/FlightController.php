<?php

namespace Hanafalah\ModuleFunding\Controllers\API\Flight;

use Hanafalah\ModuleFunding\Contracts\Schemas\Flight;
use Hanafalah\ModuleFunding\Controllers\API\ApiController;
use Hanafalah\ModuleFunding\Requests\API\Flight\{
    ViewRequest, StoreRequest, DeleteRequest
};

class FlightController extends ApiController{
    public function __construct(
        protected Flight $__flight_schema
    ){
        parent::__construct();
    }

    public function index(ViewRequest $request){
        return $this->__flight_schema->viewFlightList();
    }

    public function store(StoreRequest $request){
        return $this->__flight_schema->storeFlight();
    }

    public function destroy(DeleteRequest $request){
        return $this->__flight_schema->deleteFlight();
    }
}