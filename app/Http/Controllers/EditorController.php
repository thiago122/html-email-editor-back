<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Workspace;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;

class EditorController extends Controller
{

    public function edit(Email $email){
        
        if(!auth()->check()){
            echo "not logged";
        }

        $workspace = Workspace::find($email->workspace_id);

        $userInWorkspace =  $workspace->users()->where('user_id', auth()->user()->id )->first();

        if(!$userInWorkspace){
            abort(401);
        }

        return view('editor/edit');
    }

    public function show(Email $email)
    {

        // @todo verificar se o usuário pode ler este e-mail
        return json_encode($email);
    }

    public function update(Request $request, Email $email)
    {
        // @todo verificar se o usuário está logado

        // verifica se o usuário pode editar o e-mail
        $workspace = Workspace::find($email->workspace_id);
        $userInWorkspace =  $workspace->users()->where('user_id', auth()->user()->id )->first();

        if(!$userInWorkspace){
            abort(401);
        }

        // @todo validar o formulário
        $email->html = $request->input('html');;
        $email->save();
        return json_encode([$email]);
    }

}
