<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonumentReview Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MonumentsGardens
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\MonumentReview get($primaryKey, $options = [])
 * @method \App\Model\Entity\MonumentReview newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MonumentReview[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonumentReview|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonumentReview patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentReview[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentReview findOrCreate($search, callable $callback = null, $options = [])
 */
class MonumentReviewTable extends Table
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

        $this->table('monument_review');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('MonumentsGardens', [
            'foreignKey' => 'monument_id',
            'joinType' => 'INNER'
        ]);
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('review', 'create')
            ->notEmpty('review');

        $validator
            ->requirePresence('rating', 'create')
            ->notEmpty('rating');

        $validator
            ->boolean('is_publish')
            ->requirePresence('is_publish', 'create')
            ->notEmpty('is_publish');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
