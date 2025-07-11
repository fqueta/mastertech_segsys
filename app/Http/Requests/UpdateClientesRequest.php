<?php

namespace App\Http\Requests;

use App\Qlib\Qlib;
use App\Rules\FullName;
use App\Rules\RightCpf;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $cpf = $this->route('cpf');
        $id = $this->route('id');
        if(!$id && $cpf){
            $id = Qlib::buscaValorDb0('users','cpf',$cpf,'id');
        }
        if($id){
            return [
                'name'=>['required',new FullName],
                'cpf' => [
                    'required',
                    'string',
                    new RightCpf,
                    Rule::unique('users', 'cpf')->ignore($id),
                ],
                // 'cpf'=>['required,cpf,'.$id,new RightCpf],
            ];
        }
    }
    public function messages()
    {
        return [
            'name.required' => 'O Nome é obrigatório',
            'cpf.unique' => 'Este CPF já está sendo utilizado',
            'cpf.required' => 'O CPF é obrigatório',
        ];
    }
}
