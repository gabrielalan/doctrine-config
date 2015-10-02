<?php

namespace Entities;

class Entity
{
    public function get( $name ) {
		if( !isset($this->$name ) )
			throw new \ErrorException("The field {$name} does not exists");

		return $this->$name;
	}

	public function set( $name, $value ) {
		$this->$name = $value;
	}
}