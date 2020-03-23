<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonumentsGardensTranslation Model
 *
 * @method \App\Model\Entity\MonumentsGardensTranslation get($primaryKey, $options = [])
 * @method \App\Model\Entity\MonumentsGardensTranslation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensTranslation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensTranslation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonumentsGardensTranslation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensTranslation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGardensTranslation findOrCreate($search, callable $callback = null, $options = [])
 */
class MonumentsGardensTranslationTable extends Table
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

        $this->table('monuments_gardens_translation');
        $this->displayField('id');
        $this->primaryKey('id');
		
		$this->belongsTo('MonumentsGardens', [
            'foreignKey' => 'foreign_key',
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
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        return $validator;
    }
}
