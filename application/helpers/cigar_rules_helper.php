<?php

function getRulesCreateCigar(){
    return array(
        array(
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'El nombre del cigarro es requerido.',
                ),
        ),
        array(
                'field' => 'price',
                'label' => 'price',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El precio de venta del cigarro es requerido.',
                ),
        ),
        array(
                'field' => 'stock',
                'label' => 'stock',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'El stock del nuevo cigarro es requerido.',
                ),
        ),
    );
}