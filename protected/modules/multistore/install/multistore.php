<?php

return array(
    'module'   => array(
        'class'  => 'application.modules.multistore.MultistoreModule',
    ),
    'import'    => array(
        'application.modules.multistore.models.*',
    ),
    
  
    'component' => [
        'money' => [
            'class' => 'application.modules.multistore.components.Money',
        ],
        'productRepository' => [
            'class' => 'application.modules.multistore.components.ProductRepository'
        ],
        'attributesFilter' => [
            'class' => 'application.modules.multistore.components.AttributeFilter'
        ],
        'session' => [
            'class'   => 'CHttpSession',
            'timeout' => 86400,
            'cookieParams' => ['httponly' => true]
        ]
    ],
	// обязательно явно прописываем все публичне урл-адреса, так как у нас CUrlManager::useStrictParsing === true
	'rules'     => array(
        '/multistore' => 'multistore/catalog/index',
        '/multistore/search' => 'multistore/catalog/search',
        '/multistore/show/<name:[\w_\/-]+>' => 'multistore/catalog/show',
        '/multistore/<path:[\w_\/-]+>' => 'multistore/catalog/category',
        '/multistore/catalog/autocomplete' => 'multistore/catalog/autocomplete'
    ),
);

