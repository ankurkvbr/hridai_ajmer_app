<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $States
 * @property \Cake\ORM\Association\BelongsTo $Cities
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $MonumentReview
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
        $this->hasMany('MonumentReview', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->allowEmpty('password');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('address');

        $validator
            ->integer('mobile_no')
            ->requirePresence('mobile_no', 'create')
            ->notEmpty('mobile_no');

      /*  $validator
            ->date('dob')
            ->allowEmpty('dob'); */

        $validator
            ->integer('postal_code')
            //->requirePresence('postal_code', 'create')
            ->allowEmpty('postal_code');

        $validator
            ->dateTime('registration_date')
            ->allowEmpty('registration_date');

        $validator
            ->allowEmpty('updated_by');

        $validator
            ->dateTime('updated_date')
            ->allowEmpty('updated_date');

        $validator
            ->allowEmpty('device_type');

        $validator
            ->allowEmpty('device_token');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('fp_token');

        $validator
            ->dateTime('fp_token_at')
            ->allowEmpty('fp_token_at');

       
        return $validator;
    }
	
	public function validationResetPassword(Validator $validator ) { 
	
		$validator 
			->add('password', [
				'length' => [
					'rule' => ['minLength', 8],
					'message' => 'The password have to be at least 8 characters!', ] 
			]) 
			->add('password',[
				'match'=>[
					'rule'=> ['compareWith','confirm_password'],
					'message'=>'The passwords does not match!', ] 
			])
			->notEmpty('password');
		$validator 
			->add('confirm_password', [
				'length' => [
					'rule' => ['minLength', 8],
					'message' => 'The password have to be at least 8 characters!', ] 
			]) 
			->add('confirm_password',[
				'match'=>[
					'rule'=> ['compareWith','password'],
					'message'=>'The passwords does not match!', ] 
			])
			->notEmpty('confirm_password');	
		return $validator;	
	}
	
	public function validationChangePassword(Validator $validator ) { 
	
		$validator 
			->add('password', [
				'length' => [
					'rule' => ['minLength', 8],
					'message' => 'The password have to be at least 8 characters!', ] 
			]) 
			->add('password',[
				'match'=>[
					'rule'=> ['compareWith','confirm_password'],
					'message'=>'The passwords does not match!', ] 
			])
			->notEmpty('password');
		$validator 
			->add('confirm_password', [
				'length' => [
					'rule' => ['minLength', 8],
					'message' => 'The password have to be at least 8 characters!', ] 
			]) 
			->add('confirm_password',[
				'match'=>[
					'rule'=> ['compareWith','password'],
					'message'=>'The passwords does not match!', ] 
			])
			->notEmpty('confirm_password');	
		return $validator;	
	}

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
