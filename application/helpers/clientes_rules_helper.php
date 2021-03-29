<?php

function get_rules_clientes_create(){
    return array(
        array(
                'field' => 'rutCliente',
                'label' => 'rutCliente',
                'rules' => 'required|trim|min_length[11]',
                'errors' => array(
                    'required' => 'El rut del cliente es requerido.',
                    'min_length' => 'El campo rut necesita mínimo 8 dígitos.',
                ),
        ),
        array(
                'field' => 'nomCliente',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre del cliente es requerido.',
                ),
        ),

        array(
            'field' => 'sector',
            'label' => 'sector',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'El sector del cliente es requerido.',
            ),
    ),
        array(
                'field' => 'nombreCalle',
                'label' => 'Nombre de la calle',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'El nombre de la calle es requerido.',
                    
                ),
        ),
       
        array(
                'field' => 'numCalle',
                'label' => 'numero de la calle',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El numero de la calle  es requerido.',
                ),
        ),
    );
}

function get_rules_clientes_edit(){
        return array(
             array(
                'field' => 'rutCliente',
                'label' => 'rut Cliente',
                'rules' => 'required|trim|min_length[11]',
                'errors' => array(
                        'required' => 'El rut del cliente es requerido.',
                        'min_length' => 'El campo rut necesita mínimo 8 dígitos.',
                ),
             ),

            
            array(
                    'field' => 'nomCliente',
                    'label' => 'Nombre',
                    'rules' => 'required|trim',
                    'errors' => array(
                            'required' => 'El nombre del cliente es requerido.',
                    ),
            ),
            array(
                    'field' => 'sector',
                    'label' => 'sector',
                    'rules' => 'required|trim',
                    'errors' => array(
                        'required' => 'El sector es requerido.',
                        
                    ),
            ),
            array(
                'field' => 'nombreCalle',
                'label' => 'Nombre de la calle',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'El nombre de la calle es requerido.',
                    
                ),
        ),
            
            array(
                    'field' => 'numCalle',
                    'label' => 'numero de calle',
                    'rules' => 'required|trim',
                    'errors' => array(
                            'required' => 'El numero de calle es requerido.',
                    ),
            ),
        );
    }