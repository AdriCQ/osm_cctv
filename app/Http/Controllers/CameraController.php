<?php

namespace App\Http\Controllers;

use App\Http\Resources\CameraResource;
use App\Models\Camera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CameraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CameraResource::collection(Camera::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'comments' =>  ['nullable', 'string'],
            'ip' =>  ['required', 'string'],
            'model' =>  ['nullable', 'string'],
            'brand' =>  ['required', 'string'],
            'dome' =>  ['required', 'boolean'],
            'works' =>  ['required', 'boolean'],
            'position' =>  ['required', 'array'],
            'position.lat' =>  ['required', 'numeric'],
            'position.lng' =>  ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        $model = new Camera($validator);
        return $model->save()
            ? new CameraResource($model)
            : response()->json(['No se pudo guardar'], 502, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CameraResource(Camera::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request,)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['nullable', 'string'],
            'comments' =>  ['nullable', 'string'],
            'model' =>  ['nullable', 'string'],
            'ip' =>  ['nullable', 'string'],
            'brand' =>  ['nullable', 'string'],
            'dome' =>  ['nullable', 'boolean'],
            'works' =>  ['nullable', 'boolean'],
            'position' =>  ['nullable', 'array'],
            'position.lat' =>  ['sometimes', 'numeric'],
            'position.lng' =>  ['sometimes', 'numeric'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        $model = Camera::find($id);
        return $model->update($validator)
            ? new CameraResource(Camera::find($id))
            : response()->json(['No se pudo guardar'], 502, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Camera::find($id)->delete()
            ? response()->json()
            : response()->json(['no se pudo eliminar'], 502, [], JSON_NUMERIC_CHECK);
    }
}
