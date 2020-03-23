<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CraftFood Model
 *
 * @property \Cake\ORM\Association\HasMany $CraftFoodImages
 *
 * @method \App\Model\Entity\CraftFood get($primaryKey, $options = [])
 * @method \App\Model\Entity\CraftFood newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CraftFood[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CraftFood|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CraftFood patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CraftFood[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CraftFood findOrCreate($search, callable $callback = null, $options = [])
 */
class CraftFoodTable extends Table
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

        $this->table('craft_food');
        $this->displayField('title');
        $this->primaryKey('id');
		
		$this->addBehavior('Translate', [
        'fields' => ['title', 'description', 'short_description','address','sort_order'],
        'translationTable' => 'craft_food_translation'
        ]);
        $this->hasMany('CraftFoodImages', [
            'foreignKey' => 'craft_food_id'
        ]);
		$this->hasMany('CraftFoodTranslation', [
            'foreignKey' => 'foreign_key'
        ]);

		$this->belongsTo('innerTranslation',[
			'foreignKey' => 'id',
			'bindingKey' => 'foreign_key',
			'joinType' => 'LEFT',
			'className' => 'CraftFoodTranslation'
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->integer('category')
            ->requirePresence('category', 'create')
            ->notEmpty('category');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('short_description', 'create')
            ->notEmpty('short_description');

        $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');
			
		/*$validator
            ->requirePresence('sort_order', 'create')
            ->notEmpty('sort_order');*/
			
        return $validator;
    }
}
