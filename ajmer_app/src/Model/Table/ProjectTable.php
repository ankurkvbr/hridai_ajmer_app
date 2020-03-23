<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Project Model
 *
 * @property \Cake\ORM\Association\BelongsTo $States
 * @property \Cake\ORM\Association\BelongsTo $Cities
 * @property \Cake\ORM\Association\HasMany $ProjectImages
 *
 * @method \App\Model\Entity\Project get($primaryKey, $options = [])
 * @method \App\Model\Entity\Project newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Project[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Project|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Project patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Project[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Project findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectTable extends Table
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

        $this->table('project');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->addBehavior('Translate', [
            'fields' => ['project_name', 'project_description','address','created_at'],
            'translationTable' => 'project_translation'
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'cities_id',
            'joinType' => 'INNER'
        ]);
		         
        $this->belongsTo('innerTranslation',[
			'foreignKey' => 'id',
			'bindingKey' => 'foreign_key',
			'joinType' => 'LEFT',
			'className' => 'ProjectTranslation'
		]);
		
        $this->hasMany('ProjectImages', [
            'foreignKey' => 'project_id'
        ]);
		
        $this->hasMany('ProjectTranslation', [
            'foreignKey' => 'foreign_key'
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
            ->requirePresence('project_name', 'create')
            ->notEmpty('project_name');

        $validator
            ->requirePresence('project_description', 'create')
            ->notEmpty('project_description');
			
		$validator
           ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

        $validator
            ->allowEmpty('latitude');

        $validator
            ->allowEmpty('longitude');

        $validator
            ->allowEmpty('url');

//        $validator
//            ->requirePresence('url', 'create')
//            ->notEmpty('url');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create');

        $validator
            ->dateTime('updated_at');

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
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['cities_id'], 'Cities'));

        return $rules;
    }
}
