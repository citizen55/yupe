<?php
Yii::import('zii.behaviors.CTimestampBehavior');
Yii::import('application.modules.multistore.components.behaviors.AttributesBehavior');
Yii::import('application.modules.comment.components.ICommentable');

/**
 * @property string $id
 * @property integer $type_id
 * @property integer $producer_id
 * @property integer $category_id
 * @property integer $org_id
 * @property string $sku
 * @property string $name
 * @property string $slug
 * @property double $price
 * @property double $discount_price
 * @property double $discount
 * @property string $short_description
 * @property string $description
 * @property string $data
 * @property integer $is_special
 * @property double $length
 * @property double $height
 * @property double $width
 * @property double $weight
 * @property integer $quantity
 * @property integer $in_stock
 * @property integer $status
 * @property datetime $create_time
 * @property datetime $update_time
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $image
 * @property double $average_price
 * @property double $purchase_price
 * @property double $recommended_price
 * @property integer $position
 *
 * @method getImageUrl($width = 0, $height = 0, $options = [])
 *
 * The followings are the available model relations:
 * @property Type $type
 * @property Producer $producer
 * @property MultistoreCategory $mainCategory
 * //@mytodo пока я не могу получить переменную org
 * //@property Org $org
 * @property ProductImage $mainImage
 * @property ProductImage[] $images
 * @property ProductVariant[] $variants
 * @property Comment[] $comments
 * @property MultistoreCategory[] $categories
 *
 */
class Product extends yupe\models\YModel implements ICommentable
{
    const SPECIAL_NOT_ACTIVE = 0;
    const SPECIAL_ACTIVE = 1;

    const STATUS_ZERO = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 2;

    const STATUS_NOT_IN_STOCK = 0;
    const STATUS_IN_STOCK = 1;

    public $category;
    public $selectedVariants = [];
    private $_variants = [];
    private $_eavAttributes = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Good the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{multistore_product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, slug', 'required', 'except' => 'search'],
            [
                'name, description, short_description, slug, price, discount_price, discount, data, status, is_special',
                'filter',
                'filter' => 'trim'
            ],
            [
                'status, is_special, producer_id, type_id, quantity, in_stock, category_id, org_id',
                'numerical',
                'integerOnly' => true
            ],
            [
                'price, average_price, purchase_price, recommended_price, discount_price, discount, length, height, width, weight',
                'multistore\components\validators\NumberValidator'
            ],
            ['name, meta_keywords, meta_title, meta_description, image', 'length', 'max' => 250],
            ['discount_price, discount', 'default', 'value' => null],
            ['sku', 'length', 'max' => 100],
            ['slug', 'length', 'max' => 150],
            [
                'slug',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('MultistoreModule.multistore', 'Illegal characters in {attribute}')
            ],
            ['slug', 'unique'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['is_special', 'boolean'],
            ['length, height, width, weight', 'default', 'setOnEmpty' => true, 'value' => null],
            [
                'id, type_id, producer_id, sku, name, slug, price, discount_price, discount, short_description, description, data, is_special, length, height, width, weight, quantity, in_stock, status, create_time, update_time, meta_title, meta_description, meta_keywords, category_id, org_id',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'type' => [self::BELONGS_TO, 'Type', 'type_id'],
            'producer' => [self::BELONGS_TO, 'Producer', 'producer_id'],
            'categoryRelation' => [self::HAS_MANY, 'ProductCategory', 'product_id'],
            'categories' => [self::HAS_MANY, 'MultistoreCategory', ['category_id' => 'id'], 'through' => 'categoryRelation'],
            'mainCategory' => [self::BELONGS_TO, 'MultistoreCategory', ['category_id' => 'id']],
			'org' => [self::BELONGS_TO, 'Org', 'org_id'],
            'images' => [self::HAS_MANY, 'ProductImage', 'product_id'],
            'variants' => [
                self::HAS_MANY,
                'ProductVariant',
                ['product_id'],
                'with' => ['attribute'],
                'order' => 'variants.position ASC'
            ],
            'comments' => [
                self::HAS_MANY,
                'Comment',
                'model_id',
                'on' => 'model = :model AND comments.status = :status',
                'params' => [
                    ':model' => __CLASS__,
                    ':status' => Comment::STATUS_APPROVED
                ],
                'order' => 'comments.lft'
            ],
            'linkedProductsRelation' => [self::HAS_MANY, 'ProductLink', 'product_id', 'joinType' => 'INNER JOIN'],
            'linkedProducts' => [self::HAS_MANY, 'Product', ['linked_product_id' => 'id'], 'through' => 'linkedProductsRelation', 'joinType' => 'INNER JOIN'],
        ];
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.status = :status',
                'params' => [':status' => self::STATUS_ACTIVE],
            ],
            'specialOffer' => [
                'condition' => 't.is_special = :is_special',
                'params' => [':is_special' => self::SPECIAL_ACTIVE],
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('MultistoreModule.multistore', 'ID'),
            'category_id' => Yii::t('MultistoreModule.category', 'Category'),
            'type_id' => Yii::t('MultistoreModule.type', 'Type'),
			'org_id' => Yii::t('MultistoreModule.org','Org'),
            'name' => Yii::t('MultistoreModule.multistore', 'Title'),
            'price' => Yii::t('MultistoreModule.multistore', 'Price'),
            'discount_price' => Yii::t('MultistoreModule.multistore', 'Discount price'),
            'discount' => Yii::t('MultistoreModule.multistore', 'Discount, %'),
            'sku' => Yii::t('MultistoreModule.multistore', 'SKU'),
            'image' => Yii::t('MultistoreModule.multistore', 'Image'),
            'short_description' => Yii::t('MultistoreModule.multistore', 'Short description'),
            'description' => Yii::t('MultistoreModule.multistore', 'Description'),
            'slug' => Yii::t('MultistoreModule.multistore', 'Alias'),
            'data' => Yii::t('MultistoreModule.multistore', 'Data'),
            'status' => Yii::t('MultistoreModule.multistore', 'Status'),
            'create_time' => Yii::t('MultistoreModule.multistore', 'Added'),
            'update_time' => Yii::t('MultistoreModule.multistore', 'Updated'),
            'user_id' => Yii::t('MultistoreModule.multistore', 'User'),
            'change_user_id' => Yii::t('MultistoreModule.multistore', 'Editor'),
            'is_special' => Yii::t('MultistoreModule.multistore', 'Special'),
            'length' => Yii::t('MultistoreModule.multistore', 'Length, m.'),
            'height' => Yii::t('MultistoreModule.multistore', 'Height, m.'),
            'width' => Yii::t('MultistoreModule.multistore', 'Width, m.'),
            'weight' => Yii::t('MultistoreModule.multistore', 'Weight, kg.'),
            'quantity' => Yii::t('MultistoreModule.multistore', 'Quantity'),
            'producer_id' => Yii::t('MultistoreModule.producer', 'Producer'),
            'in_stock' => Yii::t('MultistoreModule.multistore', 'Stock status'),
            'category' => Yii::t('MultistoreModule.category', 'Category'),
            'meta_title' => Yii::t('MultistoreModule.multistore', 'Meta title'),
            'meta_keywords' => Yii::t('MultistoreModule.multistore', 'Meta keywords'),
            'meta_description' => Yii::t('MultistoreModule.multistore', 'Meta description'),
            'purchase_price' => Yii::t('MultistoreModule.multistore', 'Purchase price'),
            'average_price' => Yii::t('MultistoreModule.multistore', 'Average price'),
            'recommended_price' => Yii::t('MultistoreModule.multistore', 'Recommended price'),
            'position' => Yii::t('MultistoreModule.multistore', 'Position')
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('MultistoreModule.multistore', 'ID'),
            'category_id' => Yii::t('MultistoreModule.category', 'Category'),
            'name' => Yii::t('MultistoreModule.multistore', 'Title'),
			'org_id' => Yii::t('MultistoreModule.org','Org'),
            'price' => Yii::t('MultistoreModule.multistore', 'Price'),
            'sku' => Yii::t('MultistoreModule.multistore', 'SKU'),
            'image' => Yii::t('MultistoreModule.multistore', 'Image'),
            'short_description' => Yii::t('MultistoreModule.multistore', 'Short description'),
            'description' => Yii::t('MultistoreModule.multistore', 'Description'),
            'slug' => Yii::t('MultistoreModule.multistore', 'Alias'),
            'data' => Yii::t('MultistoreModule.multistore', 'Data'),
            'status' => Yii::t('MultistoreModule.multistore', 'Status'),
            'create_time' => Yii::t('MultistoreModule.multistore', 'Added'),
            'update_time' => Yii::t('MultistoreModule.multistore', 'Edited'),
            'user_id' => Yii::t('MultistoreModule.multistore', 'User'),
            'change_user_id' => Yii::t('MultistoreModule.multistore', 'Editor'),
            'is_special' => Yii::t('MultistoreModule.multistore', 'Special'),
            'length' => Yii::t('MultistoreModule.multistore', 'Length, m.'),
            'height' => Yii::t('MultistoreModule.multistore', 'Height, m.'),
            'width' => Yii::t('MultistoreModule.multistore', 'Width, m.'),
            'weight' => Yii::t('MultistoreModule.multistore', 'Weight, kg.'),
            'quantity' => Yii::t('MultistoreModule.multistore', 'Quantity'),
            'producer_id' => Yii::t('MultistoreModule.producer', 'Producer'),
            'purchase_price' => Yii::t('MultistoreModule.multistore', 'Purchase price'),
            'average_price' => Yii::t('MultistoreModule.multistore', 'Average price'),
            'recommended_price' => Yii::t('MultistoreModule.multistore', 'Recommended price'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('type_id', $this->type_id);
		$criteria->compare('org_id', $this->org_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('sku', $this->sku, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('is_special', $this->is_special, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('producer_id', $this->producer_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('purchase_price', $this->purchase_price);
        $criteria->compare('average_price', $this->average_price);
        $criteria->compare('recommended_price', $this->average_price);
        $criteria->compare('in_stock', $this->in_stock);

        if ($this->category) {
            $criteria->with = ['categoryRelation' => ['together' => true]];
            $criteria->addCondition('categoryRelation.category_id = :category_id OR t.category_id = :category_id');
            $criteria->params = CMap::mergeArray($criteria->params, [':category_id' => $this->category]);
        }

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort' => ['defaultOrder' => 't.position']
        ]);
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('multistore');

        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
            ],
            'eavAttr' => [
                'class' => 'application.modules.multistore.components.behaviors.AttributesBehavior',
                'tableName' => '{{multistore_product_attribute_eav}}',
                'entityField' => 'product_id',
                'preload' => false
            ],
            'imageUpload' => [
                'class' => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'minSize' => $module->minSize,
                'maxSize' => $module->maxSize,
                'types' => $module->allowedExtensions,
                'uploadPath' => $module->uploadPath . '/product',
                'resizeOnUpload' => true,
                'resizeOptions' => [
                    'maxWidth' => 900,
                    'maxHeight' => 900,
                ],
                'defaultImage' => Yii::app()->getTheme()->getAssetsUrl() . $module->defaultImage,
            ],
            'sortable' => [
                'class' => 'yupe\components\behaviors\SortableBehavior'
            ]
        ];
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->name);
        }

        foreach ((array)$this->_eavAttributes as $name => $value) {
            $model = Attribute::model()->getAttributeByName($name);
            if (!$model->isType(Attribute::TYPE_CHECKBOX) && $model->isRequired() && !$value) {
                $this->addError(
                    'eav.' . $name,
                    Yii::t("MultistoreModule.multistore", "{title} attribute is required", ['title' => $model->title])
                );
            }
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ZERO => Yii::t('MultistoreModule.multistore', 'Not available'),
            self::STATUS_ACTIVE => Yii::t('MultistoreModule.multistore', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('MultistoreModule.multistore', 'Not active'),
        ];
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('MultistoreModule.multistore', '*unknown*');
    }

    public function getSpecialList()
    {
        return [
            self::SPECIAL_NOT_ACTIVE => Yii::t('MultistoreModule.multistore', 'No'),
            self::STATUS_ACTIVE => Yii::t('MultistoreModule.multistore', 'Yes'),
        ];
    }

    public function getSpecial()
    {
        $data = $this->getSpecialList();

        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('MultistoreModule.multistore', '*unknown*');
    }

    public function getInStockList()
    {
        return [
            self::STATUS_IN_STOCK => Yii::t('MultistoreModule.multistore', 'In stock'),
            self::STATUS_NOT_IN_STOCK => Yii::t('MultistoreModule.multistore', 'Not in stock'),
        ];
    }

    /**
     * category link
     *
     * @return string html caregory link
     **/
    public function getCategoryLink()
    {
        return $this->mainCategory instanceof MultistoreCategory
            ? CHtml::link($this->mainCategory->name, ["/multistore/categoryBackend/view", "id" => $this->mainCategory->id])
            : '---';
    }

    public function getProducerLink()
    {
        return $this->producer instanceof Producer
            ? CHtml::link($this->producer->name_short, ["/multistore/producerBackend/view", "id" => $this->producer_id])
            : '---';
    }

	//@mytodo добавить получение ссылки на организацию ??? public function getOrgLink()

    /**
     * Устанавливает дополнительные категории товара
     *
     * @param array $categories - список id категорий
     * @return bool
     *
     */
    public function saveCategories(array $categoriesId)
    {
        $categoriesId = array_diff($categoriesId, (array)$this->category_id);

        $currentCategories = Yii::app()->getDb()->createCommand()
            ->select('category_id')
            ->from('{{multistore_product_category}}')
            ->where('product_id = :id', [':id' => $this->id])
            ->queryColumn();

        if ($categoriesId == $currentCategories) {
            return true;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            Yii::app()->getDb()->createCommand()
                ->delete('{{multistore_product_category}}', 'product_id = :id', [':id' => $this->id]);

            if (!empty($categoriesId)) {

                $data = [];

                foreach ($categoriesId as $id) {
                    $data[] = [
                        'product_id' => $this->id,
                        'category_id' => (int)$id
                    ];
                }

                Yii::app()->getDb()->getCommandBuilder()
                    ->createMultipleInsertCommand('{{multistore_product_category}}', $data)
                    ->execute();
            }

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    public function getCategoriesId()
    {
        return Yii::app()->getDb()->createCommand()
            ->select('category_id')
            ->from('{{multistore_product_category}}')
            ->where('product_id = :id', [':id' => $this->id])
            ->queryColumn();
    }

    public function setTypeAttributes(array $attributes)
    {
        $this->_eavAttributes = $attributes;
    }

    /**
     * @param $attributes
     */
    public function updateEavAttributes($attributes)
    {
        if (!is_array($attributes)) {
            return;
        }
        $this->deleteEavAttributes([], true);

        $attributes = array_filter($attributes, 'strlen');
        $this->setEavAttributes($attributes, true);
    }

    public function attribute($attribute)
    {
        if($this->getIsNewRecord()) {
            return null;
        }

        return isset($this->_eavAttributes[$attribute]) ? $this->_eavAttributes[$attribute] : $this->getEavAttribute(
            $attribute
        );
    }

    public function beforeDelete()
    {
        // чтобы удалились файлики
        foreach ((array)$this->images as $image) {
            $image->delete();
        }

        return parent::beforeDelete();
    }

    public function saveData(array $attributes, array $typeAttributes, array $variants, array $categories = [])
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $this->setAttributes($attributes);
            $this->setTypeAttributes($typeAttributes);
            $this->setProductVariants($variants);

            if ($this->save()) {

                $this->updateEavAttributes($this->_eavAttributes);
                $this->updateVariants($this->_variants);
                $this->saveCategories($categories);

                $transaction->commit();

                return true;
            }

            return false;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    public function setProductVariants(array $variants)
    {
        $this->_variants = $variants;
    }

    private function updateVariants(array $variants)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $productVariants = [];
            foreach ($variants as $var) {
                $variant = null;
                if (isset($var['id'])) {
                    $variant = ProductVariant::model()->findByPk($var['id']);
                }
                $variant = $variant ?: new ProductVariant();
                $variant->attributes = $var;
                $variant->product_id = $this->id;
                if ($variant->save()) {
                    $productVariants[] = $variant->id;
                }
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition('product_id = :product_id');
            $criteria->params = [':product_id' => $this->id];
            $criteria->addNotInCondition('id', $productVariants);
            ProductVariant::model()->deleteAll($criteria);
            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    public function getBasePrice()
    {
        return $this->price;
    }

    public function getResultPrice()
    {
        return (float)$this->discount_price ?: (float)$this->price * (1 - ((float)$this->discount ?: 0) / 100);
    }

    /**
     * @return mixed id
     */
    public function getId()
    {
        $variantIds = array_map(
            function ($var) {
                return $var->id;
            },
            $this->selectedVariants
        );
        sort($variantIds);

        return 'product_' . $this->id . '_' . join('_', $variantIds);
    }

    /**
     * @param array $variantsIds
     * @return float|mixed
     */
    public function getPrice(array $variantsIds = [])
    {
        $variants = [];
        if (!empty($variantsIds)) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition("id", $variantsIds);
            $variants = ProductVariant::model()->findAll($criteria);
        } else {
            $variants = $this->selectedVariants;
        }
        $basePrice = $this->getResultPrice();
        /* выбираем вариант, который меняет базовую цену максимально */
        /* @var $variants ProductVariant[] */

        $hasBasePriceVariant = false;
        foreach ($variants as $variant) {
            if ($variant->type == ProductVariant::TYPE_BASE_PRICE) {
                if (!$hasBasePriceVariant) {
                    $hasBasePriceVariant = true;
                    $basePrice = $variant->amount;
                } else {
                    if ($basePrice < $variant->amount) {
                        $basePrice = $variant->amount;
                    }
                }
            }
        }
        $newPrice = $basePrice;
        foreach ($variants as $variant) {
            switch ($variant->type) {
                case ProductVariant::TYPE_SUM:
                    $newPrice += $variant->amount;
                    break;
                case ProductVariant::TYPE_PERCENT:
                    $newPrice += $basePrice * ($variant->amount / 100);
                    break;
            }
        }

        return $newPrice;
    }

    public function getTitle()
    {
        return $this->name;
    }

    public function getLink()
    {
        return Yii::app()->createUrl('/multistore/catalog/show', ['name' => $this->slug]);
    }

    public function getMainCategoryId()
    {
        return is_object($this->mainCategory) ? $this->mainCategory->id : null;
    }

    public function getTypeAttributes()
    {
        if (empty($this->type)) {
            return [];
        }

        return (array)$this->type->typeAttributes;
    }

    public function getProducerName()
    {
        if (empty($this->producer)) {
            return null;
        }

        return $this->producer->name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isInStock()
    {
        return $this->in_stock;
    }

    public function getMetaTitle()
    {
        return $this->meta_title ?: $this->name;
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getAttributeGroups()
    {
        $attributeGroups = [];

        foreach ($this->getTypeAttributes() as $attribute) {
            if ($attribute->group) {
                $attributeGroups[$attribute->group->name][] = $attribute;
            } else {
                $attributeGroups[Yii::t('MultistoreModule.multistore', 'Without a group')][] = $attribute;
            }
        }

        return $attributeGroups;
    }


    public function getVariantsGroup()
    {
        $variantsGroups = [];

        foreach ((array)$this->variants as $variant) {
            $variantsGroups[$variant->attribute->title][] = $variant;
        }

        return $variantsGroups;
    }

    /**
     * @var array кеш getVariantsOptions
     */
    private $_variantsOptions = false;

    /**
     * Функция для подготовки специфичных настроек элементов option в select при выводе вариантов, которые будут использоваться в js при работе с вариантами
     * @return array
     */
    public function getVariantsOptions()
    {
        if ($this->_variantsOptions !== false) {
            return $this->_variantsOptions;
        }
        $options = [];

        foreach ((array)$this->variants as $variant) {
            $options[$variant->id] = array('data-type' => $variant->type, 'data-amount' => $variant->amount);
        }
        $this->_variantsOptions = $options;

        return $this->_variantsOptions;
    }

    public function getDiscountPrice()
    {
        return $this->discount_price;
    }

    /**
     * @return null|Product
     * @throws CDbException
     */
    public function copy()
    {
        $transaction = Yii::app()->getDb()->beginTransaction();
        $model = new Product();
        try {
            $model->setAttributes($this->getAttributes());
            $model->slug = null;

            $similarNamesCount = Yii::app()->getDb()->createCommand()
                ->select('count(*)')
                ->from($this->tableName())
                ->where("name like :name", [':name' => $this->name . ' [%]'])
                ->queryScalar();

            $model->name = $this->name . ' [' . ($similarNamesCount + 1) . ']';

            $attributes = $model->attributes;
            $typeAttributes =  $this->getEavAttributes();
            $variantAttributes = [];
            $categoriesIds = [];


            if ($variants = $this->variants) {
                foreach ($variants as $variant) {
                    $variantAttributes[] = $variant->getAttributes(
                        ['attribute_id', 'attribute_value', 'amount', 'type', 'sku']
                    );
                }
            }

            if ($categories = $this->categories) {
                foreach ($categories as $category) {
                    $categoriesIds[] = $category->id;
                }
            }

            if(!$model->saveData($attributes, $typeAttributes, $variantAttributes, $categoriesIds)) {
                throw new CDbException('Error copy product!');
            }

            $transaction->commit();

            return $model;
        } catch (Exception $e) {
            $transaction->rollback();
        }

        return null;
    }

    public function getUrl($absolute = false)
    {
        return $absolute ?
            Yii::app()->createAbsoluteUrl('/multistore/catalog/show', ['name' => $this->slug]) :
            Yii::app()->createUrl('/multistore/catalog/show', ['name' => $this->slug]);
    }

    /**
     * Связывает продукты
     * @param $product Product|int Ид продукта или продукт
     * @param null $type_id Тип связи
     * @return bool
     */
    public function link($product, $type_id = null)
    {
        $link = new ProductLink();
        $link->product_id = $this->id;
        $link->linked_product_id = ($product instanceof Product ? $product->id : $product);
        $link->type_id = $type_id;

        return $link->save();
    }

    /**
     * @param null|string $type_code
     * @return CDbCriteria
     */
    public function getLinkedProductsCriteria($type_code = null)
    {
        $criteria = new CDbCriteria();

        $criteria->join .= ' JOIN {{multistore_product_link}} linked ON t.id = linked.linked_product_id';
        $criteria->compare('linked.product_id', $this->id);
        if ($type_code) {
            $criteria->join .= ' JOIN {{multistore_product_link_type}} type ON type.id = linked.type_id';
            $criteria->compare('type.code', $type_code);
        }

        return $criteria;
    }

    /**
     * Список связанных с продуктом продуктов
     * @param null|string $typeCode
     * @return Product[]
     */
    public function getLinkedProducts($typeCode = null)
    {
        return Product::model()->findAll($this->getLinkedProductsCriteria($typeCode));
    }

    /**
     * @param null|string $typeCode
     * @return CActiveDataProvider
     */
    public function getLinkedProductsDataProvider($typeCode = null)
    {
        return new CActiveDataProvider(get_class($this), [
            'criteria' => $this->getLinkedProductsCriteria($typeCode),
        ]);
    }

    public function searchByName($name)
    {
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('name', $name);
        return $this->findAll($criteria);
    }
}
