<?php

function get_rules_login(){
    return array(
        array(
            'field' => 'rut',
            'label' => 'rut',
            'rules' => 'required|trim|min_length[11]',
            'errors' => array(
                'required' => 'El rut del usuario es requerido.',
                'min_length' => 'El campo rut necesita mínimo 8 dígitos.',
            ),
        ),
        array(
                'field' => 'passwd',
                'label' => 'Contraseña',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'La Contraseña es requerida.',
                ),
        ),
    );
}

function get_rules_recovery(){
    return array(
        array(
                'field' => 'email_rec',
                'label' => 'Correo electrónico',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'El correo electrónico es requerido.',
                    'valid_email' => 'La dirección de correo electrónico debe incluir el carácter @ (ejemplo@gmail.com)'
                ),
        ),
    );
}

function get_rules_new_password(){
    return array(
        array(
            'field' => 'passwd',
            'label' => 'Ingrese nueva contraseña',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'La nueva contraseña es requerida.',
            ),
        ),
        array(
            'field' => 'passwd_rep',
            'label' => 'Ingrese nueva contraseña',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'La nueva contraseña es requerida.',
            ),
        ),
    );
}