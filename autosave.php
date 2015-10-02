<?php

// replace with file to your own project bootstrap
require_once 'bootstrap.php';

use Entities\Product;
use Entities\Bug;
use Entities\User;

echo '<pre>';


$json = json_decode('{"id":14, "description":"Descasdasdasdasd", "created":1443739261255, "status":"OPEN", "products":[{"id":1, "remove":true}, {"id":2}, {"id":3}], "engineer":2, "reporter":3}');

try {
	$metadata = $entityManager->getClassMetadata('Entities\Bug');

	$fields = $metadata->getFieldNames();

	/* verifica se existe um registro existente com os identificadores */
	$ids = $metadata->getIdentifier();
	$find = array();
	$exists = true;

	foreach( $ids as $id ) {
		if( !isset($json->$id) ) {
			$find = array();
			break;
		}

		$find[$id] = $json->$id;
	}

	if( count($find) ) {
		$instance = $entityManager->find('Entities\Bug', $find);
	}

	/* se não achou cria uma nova instancia */
	if( empty($instance) ) {
		$exists = false;
		$instance = new Bug();
	}

	/* seta os novos valores */
	foreach( $fields as $field ) {
		if( !isset($json->$field) )
			continue;

		if( $field === "created" )
			$json->$field = new DateTime("now");

		$instance->set($field, $json->$field);
	}

	/* seta as associations */

	$assocs = $metadata->getAssociationMappings();

	foreach($assocs as $assoc) {
		if( !isset($json->{$assoc['fieldName']}) )
			continue;

		switch( $assoc['type'] ) {
			case Doctrine\ORM\Mapping\ClassMetadataInfo::ONE_TO_ONE:
			case Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_ONE:
				$entity = $entityManager->getRepository($assoc['targetEntity'])->find($json->{$assoc['fieldName']});
				$instance->set($assoc['fieldName'], $entity);
				break;
			case Doctrine\ORM\Mapping\ClassMetadataInfo::ONE_TO_MANY:
				break;
			case Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY:
				$entities = $json->{$assoc['fieldName']};

				if( !is_array($entities) )
					continue;

				$ids = array();

				foreach( $entities as $entityData ) {
					if( !isset($entityData->remove) )
						$ids[] = $entityData->id;
				}

				$finder = $entityManager->getRepository($assoc['targetEntity'])->findBy(array('id' => $ids));

				$collection = new \Doctrine\Common\Collections\ArrayCollection($finder);
				$instance->set($assoc['fieldName'], $collection);
				break;
		}
	}

	if( $exists )
		$entityManager->merge($instance);
	else
		$entityManager->persist($instance);

	$entityManager->flush();

	echo json_encode($instance->getId());

} catch( \Exception $e ) {
	echo json_encode([ $e->getMessage(), $e->getTrace() ]);
}