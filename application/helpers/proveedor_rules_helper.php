<?php

function get_rules_proveedor_create(){
    return array(
        array(
                'field' => 'rutProveedor',
                'label' => 'rut',
                'rules' => 'required|trim|min_length[11]',
                'errors' => array(
                    'required' => 'El rut del Proveedor es requerido.',
                    'min_length' => 'El campo rut necesita mínimo 8 dígitos.',
                ),
        ),
        array(
                'field' => 'nomProveedor',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre del proveedor es requerido.',
                ),
        ),

        array(
            'field' => 'telefono',
            'label' => 'telefono',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'El telefono del proveedor es requerido.',
            ),
    ),
        array(
                'field' => 'correoProveedor',
                'label' => 'correo proveedor',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'El correo electrónico es requerido.',
                    'valid_email' => 'La dirección de correo electrónico debe seguir el formato ejemplo@gmail.com'
                ),
        ),
       
        array(
                'field' => 'codProducto',
                'label' => 'codigo del producto',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El producto es requerido.',
                ),
        ),
    );
}

function get_rules_proveedor_edit(){
    return array(
        array(
                'field' => 'rutProveedor',
                'label' => 'rut',
                'rules' => 'required|trim|min_length[11]',
                'errors' => array(
                    'required' => 'El rut del Proveedor es requerido.',
                    'min_length' => 'El campo rut necesita mínimo 8 dígitos.',
                ),
        ),
        array(
                'field' => 'nomProveedor',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre del proveedor es requerido.',
                ),
        ),

        array(
            'field' => 'telefono',
            'label' => 'telefono',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'El telefono del proveedor es requerido.',
            ),
    ),
        array(
                'field' => 'correoProveedor',
                'label' => 'correo proveedor',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'El correo electrónico es requerido.',
                    'valid_email' => 'La dirección de correo electrónico debe seguir el formato ejemplo@gmail.com'
                    
                ),
        ),
       
        array(
                'field' => 'codProducto',
                'label' => 'codigo del producto',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El producto es requerido.',
                ),
        ),
    );
    }