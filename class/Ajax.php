<?php

namespace UDK;


class Ajax{
    public static function addAction($actionName, $callback, $nonceAction = '', $types = ['priv' => true, 'nopriv' => true] ){
		
		$actions = [
			'priv' => "wp_ajax_$actionName",
			'nopriv' => "wp_ajax_nopriv_$actionName"
		];


		foreach($types as $typeName => $typeValue ){
			
			if($typeValue){
				add_action( $actions[$typeName], function() use ($nonceAction, $callback){					
					if ( wp_verify_nonce( $_POST['ajaxNonce'], $nonceAction) === 1){
						$callback();
					}					
				});
			}
			else{

			}
		}
	}
}

?>