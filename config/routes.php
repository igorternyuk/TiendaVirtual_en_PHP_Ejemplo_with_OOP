<?php

return [
    'product/([0-9]+)' => 'product/view/$1',
    'catalog/([0-9])+/page-([0-9]+)' => 'catalog/category/$1/$2',
    'catalog/([0-9])+' => 'catalog/category/$1',
    'catalog' => 'catalog/index',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'user/register' => 'user/register',    
    'cabinet/edit' => 'cabinet/edit',    
    'cabinet' => 'cabinet/index',
    '' => 'site/index'
];