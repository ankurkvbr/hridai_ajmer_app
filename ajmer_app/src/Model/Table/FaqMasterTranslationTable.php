<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaqMasterTranslation Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FaqMaster
 *
 * @method \App\Model\Entity\FaqMasterTranslation get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaqMasterTranslation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaqMasterTranslation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaqMasterTranslation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaqMasterTranslation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaqMasterTranslation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaqMasterTranslation findOrCreate($search, callable $callback = null, $options = [])
 */
class FaqMasterTranslationTable extends Table
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

        $this->table('faq_master_translation');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('FaqMaster', [
            'foreignKey' => 'faq_master_id',
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
            ->requirePresence('faq_title', 'create')
            ->notEmpty('faq_title');

        $validator
            ->requirePresence('faq_description', 'create')
            ->notEmpty('faq_description');

        $validator
            ->requirePresence('lang', 'create')
            ->notEmpty('lang');

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
        $rules->add($rules->existsIn(['faq_master_id'], 'FaqMaster'));

        return $rules;
    }
}
