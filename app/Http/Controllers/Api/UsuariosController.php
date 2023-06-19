<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuariosController extends Controller
{
   
    public function index()
    {
        $usuarios = Usuario::all();

       
    
       return $usuarios;
    }

   
    public function store(Request $request)
    {
       
        $cep = $request->cep;

        $client = new Client();
        $response = $client->get("https://viacep.com.br/ws/{$cep}/json/");
        $data = json_decode($response->getBody(), true);
    
        if (isset($data['uf']) && $data['uf'] === 'AM') {
            // Cria o usuário
            $usuario = new Usuario();
            $usuario->name = $request->name;
            $usuario->idade = $request->idade;
            $usuario->cep = $request->cep;
            $usuario->email = $request->email;
            $usuario->phone = $request->phone;
            $usuario->dataAniversario = $request->dataAniversario;
    
            if ($usuario->idade >= 18) {
                $usuario->save();
                return response()->json([
                    'message' => 'Usuário cadastrado com sucesso',
                    $usuario,
                    'cep' => $data['cep'],
                    'logradouro' => $data['logradouro'],
                    'bairro' => $data['bairro'],
                    'cidade' => $data['localidade'],
                    'uf' => $data['uf']
                ], 201);
            } else {
                return response()->json(['message' => 'Usuário menor de idade não cadastrado'], 200);
            }
        } else {
            return response()->json(['message' => 'CEP inválido'], 200);
        }
    
    }

   
    public function show(string $id)
    {   
        $usuarios = Usuario::find($id);

        if($usuarios){
            return $usuarios;
        }else{
            return response()->json(['message' => 'Usuario não encontrado'], 404);
        }
	    
    }

   
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);

        if ($usuario) {
            $usuario->name = $request->name;
            $usuario->idade = $request->idade;
            $usuario->cep = $request->cep;
            $usuario->email = $request->email;
            $usuario->phone = $request->phone;
            $usuario->dataAniversario = $request->dataAniversario;
            $usuario->save();
            return response()->json(['message' => 'Usuario atualizado com sucesso'], 200);
        } else {
            return response()->json(['message' => 'Usuario não encontrado'], 404);
        }
       
    }

   
    public function destroy(string $id)
    {
       
        $usuario = Usuario::destroy($id);
        
        if ($usuario) {
            return response()->json([ 'Usuario removido com sucesso'], 200);
        } else {
            return response()->json(['Usuario não encontrado'], 404);
        }

    }

}
