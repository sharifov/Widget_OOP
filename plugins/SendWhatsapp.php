<?php

class SendWhatsapp extends SenderService {
	
	public $fields = [
		'phone' => [
			'label' => 'Telephone',
			'type' => 'tel'
		]
	];

	public $message = 'Whatsapp Message is send!';

	public function __construct($view){
		parent::__construct( $view );
	}

}