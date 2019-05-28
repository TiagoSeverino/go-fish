<?php

    require '..\vendor\autoload.php';
    use Carbon\Carbon;

    class CalculadoraPlano{

        public function calculaPlano($credito, $numPrest)
        {
            $valor_prestacao_mensal = $credito / $numPrest;
            $valor_divida = $credito;
            // $pagamentos = array();
            for ($i = 0; $i < $numPrest; $i++) {

                $valor_divida -= $valor_prestacao_mensal;

                $pagamentos [$i][0] = Carbon:: NOW()->addMonth($i)->toDateString();
                $pagamentos [$i][1] = round($valor_prestacao_mensal, 2);
                $pagamentos [$i][2] = round($valor_divida, 2);
            }
            return $pagamentos;
        }
    }

?>