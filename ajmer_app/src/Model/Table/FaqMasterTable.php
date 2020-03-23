<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaqMaster Model
 *
 * @property \Cake\ORM\Association\HasMany $FaqMasterTranslation
 *
 * @method \App\Model\Entity\FaqMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\FaqMaster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FaqMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FaqMaster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FaqMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FaqMaster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FaqMaster findOrCreate($search, callable $callback = null, $options = [])
 */
class FaqMasterTable extends Table
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

        $this->table('faq_master');
        $this->displayField('faq_title');
        $this->primaryKey('id');
		  $this->addBehavior('Translate', [
            'fields' => ['faq_title', 'faq_description'],
            'translationTable' => 'faq_master_translation'
        ]);
		$this->belongsTo('innerTranslation',[
			'foreignKey' => 'id',
			'bindingKey' => 'foreign_key',
			'joinType' => 'LEFT',
			'className' => 'FaqMasterTranslation'
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
			->requirePresence('faq_title')
			->notEmpty('faq_title', 'Please Enter Title')
			->add('faq_title', [
				'length' => [
				'rule' => ['maxLength', 255],
				'message' => 'Titles required only 50 characters long',
				]
			]);
		$validator	
			->requirePresence('faq_description');
			
		
        $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

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
