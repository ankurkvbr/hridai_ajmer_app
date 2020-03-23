<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CmsPageTranslation Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CmsPage
 *
 * @method \App\Model\Entity\CmsPageTranslation get($primaryKey, $options = [])
 * @method \App\Model\Entity\CmsPageTranslation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CmsPageTranslation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CmsPageTranslation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CmsPageTranslation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CmsPageTranslation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CmsPageTranslation findOrCreate($search, callable $callback = null, $options = [])
 */
class CmsPageTranslationTable extends Table
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

        $this->table('cms_page_translation');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('CmsPage', [
            'foreignKey' => 'cms_page_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('meta_title', 'create')
            ->notEmpty('meta_title');

        $validator
            ->requirePresence('meta_keywords', 'create')
            ->notEmpty('meta_keywords');

        $validator
            ->requirePresence('meta_description', 'create')
            ->notEmpty('meta_description');

        $validator
            ->requirePresence('lang', 'create')
            ->notEmpty('lang');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

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
        $rules->add($rules->existsIn(['cms_page_id'], 'CmsPage'));

        return $rules;
    }
}
