<?php

return [

    'account' => [
        'btn' => [
            'show'   => 'Ver Cuenta',
            'add'    => 'Agregar Cuenta',
            'create' => 'Crear Cuenta',
            'edit'   => 'Editar Cuenta',
            'update' => 'Actualizar Cuenta',
            'remove' => 'Eliminar Cuenta',
            'allow'  => 'Admitir Usuario',
        ],
        'title' => [
            'create' => 'Create Cuenta',
            'edit'   => 'Editar Cuenta',
            'allow'  => 'Admitir Usuario',
        ],
        'label' => [
            'name'    => 'Nombre de la cuenta',
            'email'   => 'Email',
        ],
        'msg' => [
            'allow' => [
                'success'        => 'El usuario indicado fue admitido',
                'user_not_found' => 'Disculpas, no identificamos el usuario indicado en nuestros registros',
            ],
            'store' => [
                'success'        => 'Tu cuenta fue creada exitosamente',
            ],
            'update' => [
                'success'        => 'Tu cuenta fue actualizada exitosamente',
            ],
            'destroy' => [
                'success'        => 'Tu cuenta fue eliminada exitosamente',
            ],
        ],
    ],

    'board' => [
        'btn' => [
            'show'   => 'Ver',
            'add'    => 'Agregar',
            'create' => 'Crear',
            'edit'   => 'Editar',
            'update' => 'Actualizar',
            'remove' => 'Quitar',
            'purge'  => 'Purgar Lecturas',
        ],
        'title' => [
            'create' => 'Crear tablero',
            'edit'   => 'Editar tablero',
        ],
        'label' => [
            'name'    => 'Nombre del tablero',
            'account' => 'Cuenta',
        ],
        'feeds_count' => ':count fuentes',
        'msg' => [
            'store' => [
                'success'        => 'Tu panel fue creado exitosamente',
            ],
            'update' => [
                'success'        => 'Tu panel fue actualizado exitosamente',
            ],
            'destroy' => [
                'success'        => 'Tu panel fue eliminado exitosamente',
            ],
        ],
    ],

    'feed' => [
        'btn' => [
            'show'   => 'Ver fuente',
            'add'    => 'Agregar fuente',
            'create' => 'Crear fuente',
            'edit'   => 'Editar fuente',
            'update' => 'Actualizar fuente',
            'remove' => 'Quitar fuente',
        ],
        'title' => [
            'create' => 'Crear fuente',
            'edit'   => 'Editar fuente',
        ],
        'label' => [
            'name'    => 'Nombre de la fuente',
            'apikey'  => 'API Key',
            'params'  => 'Parámetros',
            'account' => 'Cuenta',
        ],
        'msg' => [
            'store' => [
                'success'        => 'Tu fuente fue creada exitosamente',
            ],
            'update' => [
                'success'        => 'Tu fuente fue actualizada exitosamente',
            ],
            'destroy' => [
                'success'        => 'Tu fuente fue eliminada exitosamente',
            ],
        ],
    ],

];
