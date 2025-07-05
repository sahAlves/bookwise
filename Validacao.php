<?php

class Validacao {

    public $validacoes = [];

    public static function validar($regras, $dados) {
        $validacao = new self;
        // Nome do campo e regras[]
        foreach ($regras as $campo => $regrasCampo) {
            foreach ($regrasCampo as $regra) {
                $valorCampo = $dados[$campo];

                if ($regra == 'confirmed') {
                    $validacao->$regra($campo, $valorCampo, $dados["{$campo}_confirmacao"]);
                } elseif (str_contains($regra, ':')){
                    $temp = explode(':', $regra);
                    $regra = $temp[0];
                    $regraAr = $temp[1];
                    $validacao->$regra($regraAr, $campo, $valorCampo);
                } else {
                    $validacao->$regra($campo, $valorCampo);
                }
            }
        }
        return $validacao;
    }

    private function required($campo, $valor) {
        if(strlen($valor) == 0) {
            $this->validacoes[] = "$campo é obrigatório.";
        }
    }

    private function email($campo, $valor) {
        if(!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
            $this->validacoes[] = "O $campo deve ser um email válido.";
        }
    }

    private function confirmed($campo, $valor, $valorConfirmacao) {
        if($valor !== $valorConfirmacao) {
            $this->validacoes[] = "$campo de confirmação está diferente.";
        }
    }

    private function min($min, $campo, $valor) {
        if(strlen($valor) < $min) {
            $this->validacoes[] = "$campo deve ter no mínimo $min caracteres.";
        }
    }

    private function max($max, $campo, $valor) {
        if(strlen($valor) > $max) {
            $this->validacoes[] = "$campo deve ter no máximo $max caracteres.";
        }
    }

    private function strong($campo, $valor) {
        // A função strpbrk verifica se a string contém pelo menos um dos caracteres especificados
        if(! strpbrk($valor, '!@#$%^&*()_+{}|:<>?')) {
            $this->validacoes[] = "$campo precisa ter um caractere especial.";
        }
    }

    public function naoPassou() {
        $_SESSION['validacoes'] = $this->validacoes;
        return sizeof($this->validacoes) > 0;
    }
}