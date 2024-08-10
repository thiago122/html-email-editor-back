<?php

namespace App\Http\Controllers;

use App\Models\Email;
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

        if(auth()->user()->id != $email->created_by){
            echo "não te pertence";
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
        // @todo verificar se o usuário pode salvar este e-mail
        // @todo validar o formulário
        $email->html = $request->input('html');;
        $email->save();
        return json_encode([$email]);
    }

}
