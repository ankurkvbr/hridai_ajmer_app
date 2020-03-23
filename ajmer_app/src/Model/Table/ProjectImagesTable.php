<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectImages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Project
 *
 * @method \App\Model\Entity\ProjectImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectImage findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectImagesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('project_images');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Project', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('image', 'create')
                ->notEmpty('image')
                ->add('image', 'ExtNotAllowed', [
                    'rule' => function($value, $context) {
                        if (isset($value['_error']) && $value['_error'] == 'ExtNotAllowed') {
                            return false;
                        }
                        return true;
                    },
                    'message' => 'Please select valid file type',
                ])
                ->add('image', 'FileNotUpload', [
                    'rule' => function($value, $context) {
                        if (isset($value['_error']) && $value['_error'] == 'FileNotUpload') {
                            return false;
                        }
                        return true;
                    },
                    'message' => 'File not upload!',
        ]);

        $validator
                ->allowEmpty('default');

        $validator
                ->integer('is_active')
                ->allowEmpty('is_active');

        /* $validator
          ->requirePresence('default', 'create')
          ->notEmpty('default'); */

        /* $validator
          ->boolean('is_active')
          ->requirePresence('is_active', 'create')
          ->notEmpty('is_active'); */

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['project_id'], 'Project'));

        return $rules;
    }

}
