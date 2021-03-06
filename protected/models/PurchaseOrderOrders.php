<?php

/**
 * This is the model class for table "purchaseorderorders".
 *
 * The followings are the available columns in table 'purchaseorderorders':
 * @property integer $id
 * @property integer $purchaseOrderId
 * @property integer $orderId
 * @property string $dateCreated
 * @property string $dateLastModified
 *
 * The followings are the available model relations:
 * @property Orders $order
 * @property Purchaseorders $purchaseOrder
 */
class PurchaseOrderOrders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchaseorderorders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchaseOrderId, orderId', 'required'),
			array('purchaseOrderId, orderId', 'numerical', 'integerOnly'=>true),
			array('dateCreated, dateLastModified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchaseOrderId, orderId, dateCreated, dateLastModified', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Orders', 'orderId'),
			'purchaseOrder' => array(self::BELONGS_TO, 'Purchaseorders', 'purchaseOrderId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchaseOrderId' => 'Purchase Order',
			'orderId' => 'Order',
			'dateCreated' => 'Date Created',
			'dateLastModified' => 'Date Last Modified',
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
		$criteria->compare('purchaseOrderId',$this->purchaseOrderId);
		$criteria->compare('orderId',$this->orderId);
		$criteria->compare('dateCreated',$this->dateCreated,true);
		$criteria->compare('dateLastModified',$this->dateLastModified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PurchaseOrderOrders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() 
	{
		if ($this->isNewRecord)
		{
			// var_dump($this->dateCreated); exit;
			if(!isset($this->dateCreated))
			{
				$this->dateCreated = new CDbExpression('NOW()');
			}
			else
			{
				$this->dateCreated .= date(' H:i:s');
			}
		}

		$this->dateLastModified = new CDbExpression('NOW()');
		
		return parent::beforeSave();
	}	
}
