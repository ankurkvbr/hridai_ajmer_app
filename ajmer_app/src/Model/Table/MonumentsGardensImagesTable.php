<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonumentsGardensImages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MonumentsGardens
 *
 * @method \App\Model\Entity\MonumentsGardensImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\MonumentsGardensImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonumentsGardensImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensImage findOrCreate($search, callable $callback = null, $options = [])
 */
class MonumentsGardensImagesTable extends Table
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

        $this->table('monuments_gardens_images');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('MonumentsGardens', [
            'foreignKey' => 'monument_id',
            'joinType' => 'INNER'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

//        $validator
//            ->requirePresence('image', 'create')
//            ->notEmpty('image');

        $validator
            ->requirePresence('image', 'create')
            ->allowEmpty('image')
			->add('image','ExtNotAllowed',[
				'rule'=> function($value, $context){
					if(isset($value['_error']) && $value['_error'] == 'ExtNotAllowed'){
						return false;
					} 
					return true;
				},
				'message'=>'Please select valid file type',
			])
			->add('image','FileNotUpload',[
				'rule'=> function($value, $context){
					if(isset($value['_error']) && $value['_error'] == 'FileNotUpload'){
						return false;
					} 
					return true;
				},
				'message'=>'File not upload!',
			]);

                                
        $validator
            ->integer('is_default')
            ->requirePresence('is_default', 'create')
            ->notEmpty('is_default');

        $validator
            ->integer('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->allowEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->allowEmpty('updated_at');

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
        $rules->add($rules->existsIn(['monument_id'], 'MonumentsGardens'));

        return $rules;
    }
}
