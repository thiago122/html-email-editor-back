<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pattern;
use App\Models\Email;
use Illuminate\Support\Facades\Auth;

class PatternController extends Controller
{

    public function index(Request $request)
    {
        // @todo validacao
        // verificar se o usuário pode acessar a news(está no workspace ou é dono do workspace)

        $idEmail = $request->input('id_email');

        if(!$idEmail){
            return ['falaaase'];
        }

        $email = Email::find($idEmail);

        if(!$email){
            return [false];
        }

        $patterns = Pattern::where('workspace_id', $email->workspace_id)->get();
        
        return json_encode(['patterns' => $patterns]);
    }

    public function store(Request $request)
    {

        // @todo validacao
        // verificar se o usuário pode editar a news(está no workspace ou é dono do workspace)

        $userId = env("APP_FAKE_USER_ID", Auth::id());
        $idEmail = $request->input('id_email');

        if(!$idEmail){
            return ['falaaase'];
        }

        $email = Email::find($idEmail);

        if(!$email){
            return [false];
        }

        $data = [
            'name_pattern'=> $request->input('name_pattern'),
            'html_pattern'=> $request->input('html_pattern'),
            'user_id'=> $userId,
            'workspace_id'=> $email->workspace_id,
        ];

        $pattern = Pattern::create($data);
        
        return json_encode(['pattern' => $pattern]);
    }


    public function show()
    {
        $user = auth()->user()->id;
        return $user;
    }

    public function update(Request $request, string $id)
    {

    }


    public function destroy(string $id)
    {
        //
    }
}
