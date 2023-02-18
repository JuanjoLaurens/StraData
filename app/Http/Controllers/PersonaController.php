<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PersonaController extends Controller
{
    public function buscar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'porcentaje' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Parámetros inválidos',
            ], 400);
        }

        // Limpiamos el nombre y lo llevamos a mayúsculas para comparar con la BD
        $nombre = strtoupper(trim($request->input('nombre')));

        $personas = Persona::all();

        $resultados = array();

        foreach ($personas as $persona) {
            // Limpiamos el nombre de la persona y lo llevamos a mayúsculas para comparar
            $nombrePersona = strtoupper(trim($persona->nombre));

            // Calculamos el porcentaje de coincidencia usando la función levenshtein
            $porcentajeCoincidencia = round((1 - (levenshtein($nombre, $nombrePersona) / max(strlen($nombre), strlen($nombrePersona)))) * 100);

            if ($porcentajeCoincidencia >= $request->input('porcentaje')) {
                $resultado = [
                    'uuid' => $persona->uuid,
                    'nombre_encontrado' => $persona->nombre,
                    'porcentaje_encontrado' => $porcentajeCoincidencia,
                    'departamento' => $persona->departamento,
                    'localidad' => $persona->localidad,
                    'municipio' => $persona->municipio,
                    'años_activo' => $persona->años_activo,
                    'tipo_persona' => $persona->tipo_persona,
                    'tipo_cargo' => $persona->tipo_cargo,
                ];

                array_push($resultados, $resultado);
            }
        }

        if (count($resultados) == 0) {
            return response()->json([
                'estado_ejecucion' => 'sin coincidencias',
            ]);
        }

        return response()->json($resultados);
    }
    
}
