<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CmsPage Model
 *
 * @property \Cake\ORM\Association\HasMany $CmsPageTranslation
 *
 * @method \App\Model\Entity\CmsPage get($primaryKey, $options = [])
 * @method \App\Model\Entity\CmsPage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CmsPage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CmsPage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CmsPage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CmsPage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CmsPage findOrCreate($search, callable $callback = null, $options = [])
 */
class CmsPageTable extends Table
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

        $this->table('cms_page');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->addBehavior('Translate', [
            'fields' => ['name', 'description','meta_title','meta_keywords','meta_description','created_by'],
            'translationTable' => 'cms_page_translation'
        ]);
		 $this->belongsTo('innerTranslation',[
			'foreignKey' => 'id',
			'bindingKey' => 'foreign_key',
			'joinType' => 'LEFT',
			'className' => 'CmsPageTranslation'
		]);
        /* $this->hasMany('CmsPageTranslation', [
            'foreignKey' => 'cms_page_id'
        ]); */
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
			->requirePresence('name','create')
			->notEmpty('name', 'Please Enter Name');
		 	
			
		 /* $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name'); */

          /* $validator
            ->requirePresence('description','create')
            ->notEmpty('description','Please Enter Description');  */ 
 
       /* $validator
            ->requirePresence('meta_title', 'create')
            ->notEmpty('meta_title');

        $validator
            ->requirePresence('meta_keywords', 'create')
            ->notEmpty('meta_keywords');

        $validator
            ->requirePresence('meta_description', 'create')
            ->notEmpty('meta_description'); */
			
       /*  $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active'); */ 

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
}
