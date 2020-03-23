<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventImages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Event
 *
 * @method \App\Model\Entity\EventImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventImage findOrCreate($search, callable $callback = null, $options = [])
 */
class EventImagesTable extends Table
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

        $this->table('event_images');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Event', [
            'foreignKey' => 'event_id',
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

        $validator
            ->requirePresence('image', 'create')
            ->notEmpty('image')
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
            ->allowEmpty('default');

        $validator
            ->integer('is_active')
            ->allowEmpty('is_active');

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
        $rules->add($rules->existsIn(['event_id'], 'Event'));

        return $rules;
    }
}
