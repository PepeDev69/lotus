<?php

final class Post_Language_Manager {
	private $manager;

	public function __construct(Language_Manager $manager){
		$this->manager = $manager;
	}
}