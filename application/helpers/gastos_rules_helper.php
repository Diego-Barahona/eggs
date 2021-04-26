<?php

function get_rules_gastos_create(){
    return array(
        
        array(
                'field' => 'nomGastoGeneral',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre del Gasto es requerido.',
                ),
        ),

        array(
            'field' => 'costoMonetarioGeneral',
            'label' => 'costo del gasto',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'El costo es requerido.',
            ),
    ),
        
       
       
    );
}

function get_rules_gastos_edit(){
        return array(
            array(
                'field' => 'nomGastoGeneral',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre del Gasto es requerido.',
                ),
        ),

        array(
            'field' => 'costoMonetarioGeneral',
            'label' => 'costo del gasto',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'El costo es requerido.',
            ),
    ),
        );
    }