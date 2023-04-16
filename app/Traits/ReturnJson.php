<?php

namespace App\Traits;

trait ReturnJson{

    /**
     * Repuestas json
     * 200 Todo bien
     * 201 Creado
     * 204 Sin contenido
     * 202 Aceptado
     * 404 No encontrado
     * 401 No autorizado
     * 400 Datos incorrectos
     */

     public function return_error(): \Illuminate\Http\JsonResponse{
        return response()->json([
            "error"=>"Error en el servidor"
        ],500);
    }

    public function return_success_data($data): \Illuminate\Http\JsonResponse{
        return response()->json($data,200);
    }

    public function return_created($data): \Illuminate\Http\JsonResponse{
        return response()->json($data,201);
    }

    public function return_accepted($data): \Illuminate\Http\JsonResponse{
        return response()->json($data,202);
    }

    public function return_no_content(): \Illuminate\Http\JsonResponse{
        return response()->json([],204);
    }

    public function return_bad_request(\Illuminate\Validation\Validator $validator): \Illuminate\Http\JsonResponse{
        return response()->json([
            "error"=>"Datos incorrectos",
            "data"=>$validator->errors()
        ],400);
    }

    public function return_not_auth(): \Illuminate\Http\JsonResponse{
        return response()->json([
            "error"=>"No autorizado"
        ],401);
    }

    public function return_not_found(): \Illuminate\Http\JsonResponse{
        return response()->json([
            "error"=>"No encontrado"
        ],404);
    }

}

?>