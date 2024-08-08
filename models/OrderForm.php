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


  public  function  rules()
  {
    return [
      [['city', 'deliveryOption', 'firstName', 'lastName', 'phoneNumber', 'streetAddress', 'apartment', 'commentForCourier', 'paymentType'], 'string'],
      [['postalCode'], 'number'],
      [
        ['streetAddress', 'apartment', 'postalCode'],
        'required',
        'whenClient' => "function (attribute, value) { return $('[name=\"OrderForm[deliveryOption]\"]:checked').val() === 'courier'; }",
        'when' => function ($model) {
          return $model->deliveryOption == 'courier';
        },
        'skipOnError' => true,
        'skipOnEmpty' => true,
      ],
      [['city', 'deliveryOption', 'paymentType', 'firstName', 'phoneNumber'], 'required',],
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
