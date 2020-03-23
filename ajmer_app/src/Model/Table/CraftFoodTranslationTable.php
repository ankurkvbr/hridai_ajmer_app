<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CraftFoodTranslation Model
 *
 * @method \App\Model\Entity\CraftFoodTranslation get($primaryKey, $options = [])
 * @method \App\Model\Entity\CraftFoodTranslation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CraftFoodTranslation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CraftFoodTranslation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CraftFoodTranslation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CraftFoodTranslation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CraftFoodTranslation findOrCreate($search, callable $callback = null, $options = [])
 */
class CraftFoodTranslationTable extends Table
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

        $this->table('craft_food_translation');
        $this->displayField('id');
        $this->primaryKey('id');
		
		$this->belongsTo('CraftFood', [
            'foreignKey' => 'craft_food_id',
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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
