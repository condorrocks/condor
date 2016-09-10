<?php

return [

    'account' => [
        'btn' => [
            'show'   => 'Show Account',
            'add'    => 'Add Account',
            'create' => 'Create Account',
            'edit'   => 'Edit Account',
            'update' => 'Update Account',
            'remove' => 'Remove Account',
            'allow'  => 'Allow User',
        ],
        'title' => [
            'create' => 'Create account',
            'edit'   => 'Edit account',
            'allow'  => 'Allow user into account',
        ],
        'label' => [
            'name'    => 'Account name',
            'email'   => 'Email',
        ],
        'msg' => [
            'allow' => [
                'success'        => 'User was allowed',
                'user_not_found' => 'Sorry, no valid user found to allow account access',
            ],
            'store' => [
                'success'        => 'Your account was successfully created',
            ],
            'update' => [
                'success'        => 'Your account was successfully updated',
            ],
            'destroy' => [
                'success'        => 'Your account was successfully deleted',
            ],
        ],
    ],

    'board' => [
        'btn' => [
            'show'   => 'Show',
            'add'    => 'Add',
            'create' => 'Create',
            'edit'   => 'Edit',
            'update' => 'Update',
            'remove' => 'Remove',
            'purge'  => 'Purge Snapshots',
        ],
        'title' => [
            'create' => 'Create board',
            'edit'   => 'Edit board',
        ],
        'label' => [
            'name'    => 'Board name',
            'alert_to'=> 'Alert to email',
            'account' => 'Account',
        ],
        'feeds_count' => ':count feeds',
        'msg' => [
            'store' => [
                'success'        => 'Your new board was created',
            ],
            'update' => [
                'success'        => 'Your board was successfully updated',
            ],
            'destroy' => [
                'success'        => 'Your board was successfully deleted',
            ],
        ],
    ],

    'feed' => [
        'btn' => [
            'show'   => 'Show Feed',
            'add'    => 'Add Feed',
            'create' => 'Create Feed',
            'edit'   => 'Edit Feed',
            'update' => 'Update Feed',
            'remove' => 'Remove Feed',
        ],
        'title' => [
            'create' => 'Create feed',
            'edit'   => 'Edit feed',
        ],
        'label' => [
            'name'    => 'Feed name',
            'apikey'  => 'API Key',
            'params'  => 'Parameters',
            'account' => 'Account',
        ],
        'msg' => [
            'store' => [
                'success'        => 'Your feed was created',
            ],
            'update' => [
                'success'        => 'Your feed was successfully updated',
            ],
            'destroy' => [
                'success'        => 'Your feed was successfully deleted',
            ],
        ],
    ],

];
