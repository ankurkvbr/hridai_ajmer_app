<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonumentRating Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MonumentsGardens
 *
 * @method \App\Model\Entity\MonumentRating get($primaryKey, $options = [])
 * @method \App\Model\Entity\MonumentRating newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MonumentRating[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonumentRating|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonumentRating patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentRating[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentRating findOrCreate($search, callable $callback = null, $options = [])
 */
class MonumentRatingTable extends Table
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

        $this->table('monument_rating');
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

        $validator
            ->requirePresence('rating', 'create')
            ->notEmpty('rating');

        $validator
            ->integer('is_publish')
            ->requirePresence('is_publish', 'create')
            ->notEmpty('is_publish');

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
