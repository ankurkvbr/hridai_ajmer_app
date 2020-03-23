<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MonumentsGardens Model
 *
 * @property \Cake\ORM\Association\BelongsTo $States
 * @property \Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\MonumentsGarden get($primaryKey, $options = [])
 * @method \App\Model\Entity\MonumentsGarden newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MonumentsGarden[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGarden|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MonumentsGarden patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGarden[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MonumentsGarden findOrCreate($search, callable $callback = null, $options = [])
 */
class MonumentsGardensTable extends Table
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

        $this->table('monuments_gardens');
        $this->displayField('title');
        $this->displayField('created_at');
        $this->primaryKey('id');
        
        $this->addBehavior('Translate', [
            'fields' => ['title', 'description','tour_title','address','sort_order'],
            'translationTable' => 'monuments_gardens_translation'
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
			'className' => 'MonumentsGardensTranslation'
		]);

        /*$this->belongsTo('LeftJoinMonumentsGardensImages', [
            'foreignKey' => 'id',
			'bindingKey' => 'monument_id',
			'className' => 'MonumentsGardensImages',
			'joinType' => 'LEFT'
        ]); */

		$this->hasMany('MonumentsGardensImages', [
            'foreignKey' => 'monument_id'
        ]);
        
        
		 $this->hasMany('MonumentsGardensTranslation', [
            'foreignKey' => 'foreign_key'
        ]);
		
//		$this->hasMany('MonumentRating', [
//            'foreignKey' => 'monument_id'
//        ]);
		
		$this->hasMany('MonumentReview', [
            'foreignKey' => 'monument_id',
		]);
		
		$this->belongsTo('monument_review', [
            'foreignKey' => 'id',
			'bindingKey' => 'monument_id',
			'className' => 'MonumentReview',
			'joinType' => 'LEFT'
        ]);
		
		/*$this->belongsTo('LeftJoinMonumentRating', [
            'foreignKey' => 'id',
			'bindingKey' => 'monument_id',
			'className' => 'MonumentRating',
			'joinType' => 'LEFT'
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        /*$validator
            ->boolean('category')
            ->requirePresence('category', 'create')
            ->notEmpty('category');*/

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');
			
		  $validator
            ->requirePresence('tour_title', 'create')
            ->notEmpty('tour_title');
			
		  /*$validator
            ->requirePresence('tour_video', 'create')
            ->notEmpty('tour_video');*/
                  
//            $validator
//                ->requirePresence('audio', 'create')
//                ->notEmpty('audio');
//
//            $validator
//                ->requirePresence('audio_cover_image', 'create')
//                ->notEmpty('audio_cover_image');

        /*$validator
            ->requirePresence('audio', 'create')
            ->notEmpty('audio')
			->add('audio','ExtNotAllowed',[
				'rule'=> function($value, $context){
					if(isset($value['_error']) && $value['_error'] == 'ExtNotAllowed'){
						return false;
					} 
					return true;
				},
				'message'=>'Please select valid file type',
			])
			->add('audio','FileNotUpload',[
				'rule'=> function($value, $context){
					if(isset($value['_error']) && $value['_error'] == 'FileNotUpload'){
						return false;
					} 
					return true;
				},
				'message'=>'File not upload!',
			]);*/

        /*$validator
            ->requirePresence('audio_cover_image', 'create')
            ->notEmpty('audio_cover_image')
			->add('audio_cover_image','ExtNotAllowed',[
				'rule'=> function($value, $context){
					if(isset($value['_error']) && $value['_error'] == 'ExtNotAllowed'){
						return false;
					} 
					return true;
				},
				'message'=>'Please select valid file type',
			])
			->add('audio_cover_image','FileNotUpload',[
				'rule'=> function($value, $context){
					if(isset($value['_error']) && $value['_error'] == 'FileNotUpload'){
						return false;
					} 
					return true;
				},
				'message'=>'File not upload!',
			]);*/

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');
			
		/*$validator
            ->requirePresence('sort_order', 'create')
            ->notEmpty('sort_order');*/
			
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
