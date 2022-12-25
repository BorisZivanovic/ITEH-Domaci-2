<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProizvodjacR;
use App\Models\Proizvodjac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProizvodjacController extends BaseController
{
    public function index()
    {
        $proizvodjaci = Proizvodjac::all();
        return $this->porukaOUspehu(ProizvodjacR::collection($proizvodjaci), 'Prikazani su svi proizvodjaci.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'proizvodjac' => 'required',
        ]);

        if($validator->fails()){
            return $this->porukaOGresci($validator->errors());
        }

        $proizvodjac = Proizvodjac::create($input);

        return $this->porukaOUspehu(new ProizvodjacR($proizvodjac), 'Kreiran je novi proizvodjac.');
    }


    public function show($ID)
    {
        $proizvodjac = Proizvodjac::find($ID);

        if (is_null($proizvodjac)) {
            return $this->porukaOGresci('Proizvodjac sa zadatim id-em ne postoji.');
        }

        return $this->porukaOUspehu(new ProizvodjacR($proizvodjac), 'Proizvodjac sa zadatim id-em je prikazan.');
    }


    public function update(Request $request, $ID)
    {
        $proizvodjac = Proizvodjac::find($ID);
        if (is_null($proizvodjac)) {
            return $this->porukaOGresci('Proizvodjac sa zadatim id-em ne postoji.');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'proizvodjac' => 'required',
        ]);

        if($validator->fails()){
            return $this->porukaOGresci($validator->errors());
        }

        $proizvodjac->proizvodjac = $input['proizvodjac'];
        $proizvodjac->save();

        return $this->porukaOUspehu(new ProizvodjacR($proizvodjac), 'Podaci o proizvodjacu su azurirani.');
    }

    public function destroy($ID)
    {
        $proizvodjac = Proizvodjac::find($ID);
        
        if (is_null($proizvodjac)) {
            return $this->porukaOGresci('Proizvodjac sa zadatim id-em ne postoji.');
        }

        $proizvodjac->delete();
        return $this->porukaOUspehu([], 'Proizvodjac je obrisan.');
    }
}
