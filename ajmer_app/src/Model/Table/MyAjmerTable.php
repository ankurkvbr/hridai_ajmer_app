<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MyAjmer Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\MyAjmer get($primaryKey, $options = [])
 * @method \App\Model\Entity\MyAjmer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MyAjmer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MyAjmer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyAjmer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MyAjmer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MyAjmer findOrCreate($search, callable $callback = null, $options = [])
 */
class MyAjmerTable extends Table
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

        $this->table('my_ajmer');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('ajmer_type')
            ->requirePresence('ajmer_type', 'create')
            ->notEmpty('ajmer_type');

        $validator
            ->integer('favourite_type_ids')
            ->requirePresence('favourite_type_ids', 'create')
            ->notEmpty('favourite_type_ids');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
