<?php
return [
    'pagesize'=>10,  //分页默认10条
    'domain'=>'http://rbac2.com/',

    'redis'=>[
        'lockUserPrefix'=>'lock_user_',
        'ssoKey'=>'sso_user_id_'
    ],

    'email'=>[
        'host'=>'',
        'from'=>'',
        'password'=>''
    ]
];