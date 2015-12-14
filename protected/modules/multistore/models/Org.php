<?php

/**
 * This is the model class for table "{{multistore_org}}".
 *
 * The followings are the available columns in table '{{multistore_org}}':
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $image
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $phone_1
 * @property integer $phone_2
 * @property integer $fax
 * @property string $location
 *
 * The followings are the available model relations:
 * @property MultistoreCategoryOrg[] $multistoreCategoryOrgs
 * @property UserUser $user
 * @property MultistoreTypeOrg $type
 */
class Org extends yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{multistore_org}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, slug, user_id, type_id', 'required'),
			array('user_id, type_id, phone_1, phone_2, fax', 'numerical', 'integerOnly'=>true),
			array('slug', 'length', 'max'=>150),
			array('name, image, location', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slug, name, image, user_id, type_id, phone_1, phone_2, fax, location', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'multistoreCategoryOrgs' => array(self::HAS_MANY, 'CategoryOrg', 'org_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			// @mytodo задача 2
			// исправить при выполнени задачи 2
			'type' => array(self::BELONGS_TO, 'TypeOrg', 'type_id'),
			'product' => array(self::HAS_MANY, 'Product', 'org_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'slug' => 'Slug',
			'image' => 'Image',
			'user_id' => 'User',
			'type_id' => 'Type',
			'phone_1' => 'Phone 1',
			'phone_2' => 'Phone 2',
			'fax' => 'Fax',
			'location' => 'Location',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('phone_1',$this->phone_1);
		$criteria->compare('phone_2',$this->phone_2);
		$criteria->compare('fax',$this->fax);
		$criteria->compare('location',$this->location,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Org the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
