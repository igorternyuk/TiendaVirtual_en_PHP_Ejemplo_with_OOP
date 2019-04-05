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
    'cart/changecount/([0-9]+)/([0-9]+)' => 'cart/changecount/$1/$2',
    'cart/add/([0-9]+)' => 'cart/add/$1',
    'cart/remove/([0-9]+)' => 'cart/remove/$1',
    'cart/checkout' => 'cart/checkout',
    'cart' => 'cart/view',
    '' => 'site/index'
];