<?php
/**
 * Created by PhpStorm.
 * Utilizadores: João
 * Date: 02/04/2019
 * Time: 12:07
 */

class DossierEmprestimo
{
    public $data;
    public $nome;
    public $despesas;
    public $credito;
    public $numPrest;
    public $planoPagamentos;


    public function DossierEmprestimo($data, $nome, $despesas, $credito, $numPrest, $planoPagamentos)
    {
        $this->data = $data;
        $this->nome = $nome;
        $this->despesas = $despesas;
        $this->credito = $credito;
        $this->numPrest = $numPrest;
        $this->planoPagamentos = $planoPagamentos;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getDespesas()
    {
        return $this->despesas;
    }

    /**
     * @return mixed
     */
    public function getCredito()
    {
        return $this->credito;
    }

    /**
     * @return mixed
     */
    public function getNumPrest()
    {
        return $this->numPrest;
    }

    /**
     * @return mixed
     */
    public function getPlanoPagamentos()
    {
        return $this->planoPagamentos;
    }

}