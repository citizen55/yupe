<?php

/**
 * This is the model class for table "{{multistore_type_org}}".
 *
 * The followings are the available columns in table '{{multistore_type_org}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property string $name
 * @property string $image
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $status
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property MultistoreOrg[] $multistoreOrgs
 * @property TypeOrg $parent
 * @property TypeOrg[] $multistoreTypeOrgs
 */
class TypeOrg extends yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{multistore_type_org}}';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TypeOrg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{	
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('slug, name', 'required'),
			array('parent_id, status, sort', 'numerical', 'integerOnly'=>true),
			array('slug', 'length', 'max'=>150),
			array('name, image, meta_title, meta_description, meta_keywords', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, parent_id, slug, name, image, meta_title, meta_description, meta_keywords, status, sort', 'safe', 'on'=>'search'),
			array('id, parent_id, slug, name,status, sort', 'safe', 'on'=>'search'),
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
			'multistoreOrgs' => array(self::HAS_MANY, 'MultistoreOrg', 'type_id'),
			'parent' => array(self::BELONGS_TO, 'TypeOrg', 'parent_id'),
			'multistoreTypeOrgs' => array(self::HAS_MANY, 'TypeOrg', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'slug' => 'Slug',
			'name' => 'Name',
			'image' => 'Image',
			'meta_title' => 'Meta Title',
			'meta_description' => 'Meta Description',
			'meta_keywords' => 'Meta Keywords',
			'status' => 'Status',
			'sort' => 'Sort',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('name',$this->name,true);
		//$criteria->compare('image',$this->image,true);
		//$criteria->compare('meta_title',$this->meta_title,true);
		//$criteria->compare('meta_description',$this->meta_description,true);
		//$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
