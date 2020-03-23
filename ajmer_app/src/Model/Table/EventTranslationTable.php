<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventTranslation Model
 *
 * @method \App\Model\Entity\EventTranslation get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventTranslation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventTranslation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventTranslation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventTranslation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventTranslation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventTranslation findOrCreate($search, callable $callback = null, $options = [])
 */
class EventTranslationTable extends Table
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

        $this->table('event_translation');
        $this->displayField('id');
        $this->primaryKey('id');
		
		 $this->belongsTo('Event', [
            'foreignKey' => 'Event_id',
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('locale', 'create')
            ->notEmpty('locale');

        $validator
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->integer('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->notEmpty('foreign_key');

        $validator
            ->requirePresence('field', 'create')
            ->notEmpty('field');

        $validator
            ->allowEmpty('content');

        return $validator;
    }
}
