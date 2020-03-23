<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Feedback Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $FeedbackFors
 * @property \Cake\ORM\Association\BelongsTo $FeedbackCategories
 *
 * @method \App\Model\Entity\Feedback get($primaryKey, $options = [])
 * @method \App\Model\Entity\Feedback newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Feedback[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Feedback|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feedback patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Feedback[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Feedback findOrCreate($search, callable $callback = null, $options = [])
 */
class FeedbackTable extends Table
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

        $this->table('feedback');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
//        $this->belongsTo('FeedbackFors', [
//            'foreignKey' => 'feedback_for_id',
//            'joinType' => 'INNER'
//        ]);
//        $this->belongsTo('FeedbackCategories', [
//            'foreignKey' => 'feedback_category_id',
//            'joinType' => 'INNER'
//        ]);
        $this->belongsTo('innerTranslation',[
			'foreignKey' => 'id',
			'bindingKey' => 'user_id',
			'joinType' => 'INNER',
			'className' => 'Users'
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
            ->numeric('rating')
            ->requirePresence('rating', 'create')
            ->notEmpty('rating');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
    //    $rules->add($rules->existsIn(['feedback_for_id'], 'FeedbackFors'));
    //    $rules->add($rules->existsIn(['feedback_category_id'], 'FeedbackCategories'));

        return $rules;
    }
}
