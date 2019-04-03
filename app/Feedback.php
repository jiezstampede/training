<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Feedback extends BaseModel
{

  protected $fillable = [
    'name',
    'email',
    'phone',
    'subject',
    'message',
    'ip',
    'sent',
  ];
}
