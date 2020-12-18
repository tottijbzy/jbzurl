<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class WithdrawsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Users');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('amount')
            ->notEmpty('amount', __('You must have a balance.'));

        return $validator;
    }
}
