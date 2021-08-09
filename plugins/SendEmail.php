<?php

class SendEmail extends SenderService {
	
	public $fields = [
		'email' => [
			'label' => 'Email',
			'type' => 'email'
		]
	];

	public $message = 'Email Message is send!';

	public function __construct($view){
		parent::__construct( $view );
	}

}