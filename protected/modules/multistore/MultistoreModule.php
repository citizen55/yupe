<?php
use yupe\components\WebModule;

class MultistoreModule extends WebModule
{
	public $uploadPath = 'multistore';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize;
    public $maxFiles = 1;
    public $assetsPath = 'application.modules.multistore.views.assets';
    public $defaultImage = '/images/nophoto.jpg';

	public function getDependencies()
    {
        return ['comment'];
    }

	 public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getModule(
            'yupe'
        )->uploadPath . '/' . $this->uploadPath;
    }

	 public function checkSelf()
    {
        $messages = [];

        return isset($messages[WebModule::CHECK_ERROR]) ? $messages : true;
    }

	public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir($this->getUploadPath(), 0755);
        }

        return true;
    }

	public function getEditableParams()
    {
        return [
            'uploadPath',
            'editor' => Yii::app()->getModule('yupe')->editors
        ];
    }

	public function getParamsLabels()
    {
        return [
            'uploadPath' => Yii::t(
                    'MultistoreModule.multistore',
                    'File uploads directory (relative to "{path}")', ['{path}' => Yii::getPathOfAlias('webroot').'/'.Yii::app()->getModule("yupe")->uploadPath]
                ),
            'editor' => Yii::t('MultistoreModule.multistore', 'Visual editor'),
            'defaultImage' => Yii::t('MultistoreModule.multistore', 'Default image')
        ];
    }

	public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('MultistoreModule.multistore', 'Images'),
                'items' => [
                    'uploadPath',
                    'defaultImage'
                ]
            ],
            '1.main' => [
                'label' => Yii::t('MultistoreModule.multistore', 'Visual editor settings'),
                'items' => [
                    'editor'
                ]
            ],
        ];
    }

	public function getNavigation()
    {
        return [
            ['label' => Yii::t('MultistoreModule.multistore', 'Multistore')],
			[
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MultistoreModule.multistore', 'Multistore list'),
                'url' => ['/multistore/orgBackend/index']
            ],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MultistoreModule.multistore', 'Create'),
                'url' => ['/multistore/orgBackend/create']
            ],
 [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MultistoreModule.multistore', 'Create type'),
                'url' => ['/multistore/TypeOrgBackend/create']
            ],
        ];
    }

    public function getIsShowInAdminMenu()
    {
        return true;
    }

	 public function getExtendedNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-shopping-cart',
                'label' => Yii::t('MultistoreModule.multistore', 'Catalog'),
                'items' => [
                    [
                        'icon' => 'fa fa-fw fa-shopping-cart',
                        'label' => Yii::t('MultistoreModule.multistore', 'Products'),
                        'url' => ['/multistore/productBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('MultistoreModule.multistore', 'Product list'),
                                'url' => ['/multistore/productBackend/index']
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('MultistoreModule.multistore', 'Create product'),
                                'url' => ['/multistore/productBackend/create']
                            ],
                            [
                                'icon' => 'fa fa-fw fa-link',
                                'label' => Yii::t('MultistoreModule.multistore', 'Link types'),
                                'url' => ['/multistore/linkBackend/typeIndex']
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-list-alt',
                        'label' => Yii::t('MultistoreModule.type', 'Types'),
                        'url' => ['/multistore/typeBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('MultistoreModule.type', 'Types list'),
                                'url' => ['/multistore/typeBackend/index']
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('MultistoreModule.type', 'Create type'),
                                'url' => ['/multistore/typeBackend/create']
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-pencil-square-o',
                        'label' => Yii::t('MultistoreModule.attr', 'Attributes'),
                        'url' => ['/multistore/attributeBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('MultistoreModule.attr', 'Attributes list'),
                                'url' => ['/multistore/attributeBackend/index']
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('MultistoreModule.attr', 'Create attribute'),
                                'url' => ['/multistore/attributeBackend/create']
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-folder-open',
                        'label' => Yii::t('MultistoreModule.category', 'Categories'),
                        'url' => ['/multistore/categoryBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('MultistoreModule.category', 'Categories list'),
                                'url' => ['/multistore/categoryBackend/index']
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('MultistoreModule.category', 'Create category'),
                                'url' => ['/multistore/categoryBackend/create']
                            ],
                        ],
                    ],
                    [
                        'icon' => 'fa fa-fw fa-plane',
                        'label' => Yii::t('MultistoreModule.producer', 'Producers'),
                        'url' => ['/multistore/producerBackend/index'],
                        'items' => [
                            [
                                'icon' => 'fa fa-fw fa-list-alt',
                                'label' => Yii::t('MultistoreModule.producer', 'Producers list'),
                                'url' => ['/multistore/producerBackend/index']
                            ],
                            [
                                'icon' => 'fa fa-fw fa-plus-square',
                                'label' => Yii::t('MultistoreModule.producer', 'Create producer'),
                                'url' => ['/multistore/producerBackend/create']
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getAdminPageLink()
    {
        return '/multistore/multistoreBackend/index';
    }

    //public function getVersion()
    //{
    //    return self::VERSION;
    //}

    public function getCategory()
    {
        return Yii::t('MultistoreModule.multistore', 'Multistore');
    }

    public function getName()
    {
        return Yii::t('MultistoreModule.multistore', 'Multistore');
    }

    public function getDescription()
    {
        return Yii::t('MultistoreModule.multistore', 'Multistore module');
    }

    public function getAuthor()
    {
        return Yii::t('MultistoreModule.multistore', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('MultistoreModule.multistore', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-shopping-cart';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'application.modules.multistore.models.*',
                'application.modules.multistore.forms.*',
                'application.modules.multistore.components.*',
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_ROLE,
                'name' => 'Multistore.Manager',
                'description' => Yii::t('MultistoreModule.multistore', 'Catalog manager'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Multistore.AttributeBackend.Management',
                        'description' => Yii::t('MultistoreModule.attr', 'Manage product attributes'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.AttributeBackend.Index',
                                'description' => Yii::t('MultistoreModule.attr', 'View attribute list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.AttributeBackend.Create',
                                'description' => Yii::t('MultistoreModule.attr', 'Create attribute'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.AttributeBackend.Update',
                                'description' => Yii::t('MultistoreModule.attr', 'Update attribute'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.AttributeBackend.View',
                                'description' => Yii::t('MultistoreModule.attr', 'View attribute'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.AttributeBackend.Delete',
                                'description' => Yii::t('MultistoreModule.attr', 'Delete attribute'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Multistore.CategoryBackend.Management',
                        'description' => Yii::t('MultistoreModule.category', 'Manage product categories'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.CategoryBackend.Index',
                                'description' => Yii::t('MultistoreModule.category', 'List of categories'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.CategoryBackend.Create',
                                'description' => Yii::t('MultistoreModule.category', 'Create category'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.CategoryBackend.Update',
                                'description' => Yii::t('MultistoreModule.category', 'Update category'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.CategoryBackend.View',
                                'description' => Yii::t('MultistoreModule.category', 'View category'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.CategoryBackend.Delete',
                                'description' => Yii::t('MultistoreModule.category', 'Delete category'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Multistore.ProducerBackend.Management',
                        'description' => Yii::t('MultistoreModule.producer', 'Manage producers'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProducerBackend.Index',
                                'description' => Yii::t('MultistoreModule.producer', 'View producer list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProducerBackend.Create',
                                'description' => Yii::t('MultistoreModule.producer', 'Create producer'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProducerBackend.Update',
                                'description' => Yii::t('MultistoreModule.producer', 'Update producer'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProducerBackend.View',
                                'description' => Yii::t('MultistoreModule.producer', 'View producer'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProducerBackend.Delete',
                                'description' => Yii::t('MultistoreModule.producer', 'Delete producer'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Multistore.ProductBackend.Management',
                        'description' => Yii::t('MultistoreModule.multistore', 'Manage products'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProductBackend.Index',
                                'description' => Yii::t('MultistoreModule.multistore', 'View product list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProductBackend.Create',
                                'description' => Yii::t('MultistoreModule.multistore', 'Create product'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProductBackend.Update',
                                'description' => Yii::t('MultistoreModule.multistore', 'Update product'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProductBackend.View',
                                'description' => Yii::t('MultistoreModule.multistore', 'View product'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.ProductBackend.Delete',
                                'description' => Yii::t('MultistoreModule.multistore', 'Delete product'),
                            ],
                        ],
                    ],
                    [
                        'type' => AuthItem::TYPE_TASK,
                        'name' => 'Multistore.TypeBackend.Management',
                        'description' => Yii::t('MultistoreModule.type', 'Manage product types'),
                        'items' => [
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.TypeBackend.Index',
                                'description' => Yii::t('MultistoreModule.type', 'Types list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.TypeBackend.Create',
                                'description' => Yii::t('MultistoreModule.type', 'Types list'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.TypeBackend.Update',
                                'description' => Yii::t('MultistoreModule.type', 'Update type'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.TypeBackend.View',
                                'description' => Yii::t('MultistoreModule.type', 'View type'),
                            ],
                            [
                                'type' => AuthItem::TYPE_OPERATION,
                                'name' => 'Multistore.TypeBackend.Delete',
                                'description' => Yii::t('MultistoreModule.type', 'Delete type'),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}











