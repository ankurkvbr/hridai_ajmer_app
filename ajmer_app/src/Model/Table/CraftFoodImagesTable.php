<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CraftFoodImages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CraftFoods
 *
 * @method \App\Model\Entity\CraftFoodImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\CraftFoodImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CraftFoodImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CraftFoodImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CraftFoodImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CraftFoodImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CraftFoodImage findOrCreate($search, callable $callback = null, $options = [])
 */
class CraftFoodImagesTable extends Table
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

        $this->table('craft_food_images');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('image', 'create')
            ->notEmpty('image');

        $validator
            ->integer('shorting_order')
            ->allowEmpty('shorting_order');

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
            ->notEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');

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
        $rules->add($rules->existsIn(['craft_food_id'], 'CraftFood'));

        return $rules;
    }
}
