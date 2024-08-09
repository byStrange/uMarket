<?php

namespace app\models;

use yii\base\Model;

class OrderForm extends Model
{
  public $city;
  public $deliveryOption;
  public $submitPoint;
  public $firstName;
  public $lastName;
  public $phoneNumber;
  public $streetAddress;
  public $apartment;
  public $postalCode;
  public $commentForCourier;
  public $paymentType;
  public $selectedAddressId; // New field for selected address

  public function rules()
  {
    return [
      [['city', 'deliveryOption', 'firstName', 'lastName', 'phoneNumber', 'streetAddress', 'apartment', 'commentForCourier', 'paymentType'], 'string'],
      [['postalCode'], 'number'],
      [['selectedAddressId'], 'integer'], // Rule for the new field
      [
        ['streetAddress', 'apartment', 'postalCode', 'city', 'firstName', 'lastName', 'phoneNumber'],
        'required',
        'whenClient' => "function (attribute, value) { 
                    return $('[name=\"OrderForm[deliveryOption]\"]:checked').val() === 'courier' 
                        && !$('#orderform-selectedaddressid').val(); 
                }",
        'when' => function ($model) {
          return $model->deliveryOption == 'courier' && !$model->selectedAddressId;
        },
        'skipOnError' => true,
        'skipOnEmpty' => true,
      ],
      [['deliveryOption', 'paymentType'], 'required'],
      [
        ['submitPoint'],
        "exist",
        "skipOnError" => true,
        "targetClass" => DeliveryPoint::class,
        "targetAttribute" => ['submitPoint' => 'id']
      ]
    ];
  }
}
