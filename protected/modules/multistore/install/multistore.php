
<?php
/**
 *
 * Файл конфигурации модуля client
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.client.install
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.7
 *
 */
return array(
    'module'   => array(
        'class'  => 'application.modules.multistore.MultistoreModule',
    ),
    'import'    => array(
        'application.modules.multistore.models.*',
    ),
    // обязательно явно прописываем все публичне урл-адреса, так как у нас CUrlManager::useStrictParsing === true
    'rules'     => array(
        '/multistore' => '/multistore/default/index',
    ),
    'component' => array()
);
