<?php

class SenderService {
	
	protected $fields = [];

	protected $withDefaults = true;

	protected $message = 'Message is sent!';

	protected $template = '
		<div class="form">
			{input}
		</div>
	';

	protected $textarea = '<textarea name="{name}" cols="4" rows="6" placeholder="{label}"></textarea>';

	protected $input = '<input placeholder="{label}" name="{name}" type="{type}" />';

	protected $button = '<button name="{name}">{label}</button>';

	protected $defaultFields = [
		'msg' => [
			'label' => 'Message',
			'type' => 'textarea'
		],

		'submit' => [
			'label' => 'Send',
			'type' => 'button'
		]
	];

	protected function isPost() {
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	protected function isAjax() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	protected function getPlugins() {
		$files = [];
		
		foreach (scandir(PLUGINS) as $file) {
			
			$file = pathinfo($file, PATHINFO_FILENAME);
			
			if(!$file || $file == '.') continue;
			
			$files[] = $file;
		}

		return $files;
	}

	protected function getFields() {
		$fields = $this->fields;
		
		if($this->withDefaults){
			$fields = array_merge( 
				array_intersect($this->fields, $this->defaultFields ),
				array_diff_key( $this->defaultFields, $this->fields ) 
			);
		}

		return $fields;
	}

	protected function sendMessage() {

		// check fillable post vars

		// mail() send message

		print $this->message;
	}

	private function generateHTML( $fields ) {
		$html = '';

		foreach ($fields as $name => $field) {
			
			switch ($field['type']) {
				case 'textarea':
					$input = $this->textarea;
				break;
				
				case 'button':
					$input = $this->button;
				break;

				default:
					$input = $this->input;
			}

			$html .= str_replace(
			
				['{label}', '{input}'], [$field['label'], 
			
				str_replace(['{name}', '{type}', '{label}'], [ $name, $field['type'], $field['label'] ], $input)
			
			], $this->template);			
		}

		return $html;
	}

	public function __construct($view){

		if( $this->isPost() ) {
			$this->sendMessage();
			$view('');
		}

		$plugins = $this->getPlugins();

		$plugin = __CLASS__ == get_called_class() ? '' : get_called_class() ;

		$fields_html = $this->generateHTML( $this->getFields() );

		$view('widget', compact('plugin', 'plugins', 'fields_html'), !$this->isAjax());

	}

}