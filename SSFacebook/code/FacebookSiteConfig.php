<?php
 
class FacebookSiteConfig extends DataObjectDecorator {
     
    function extraStatics() {
        return array(
            'db' => array(
                'apiKey' => 'Text',
                'secretKey' => 'Text',
                'domain' => 'Text',
                'accessToken' => 'Text'
            )
        );
    }
 
    public function updateCMSFields(FieldSet $fields) {
       $fields->addFieldToTab('Root.Facebook', new TextField('apiKey'), 'App ID/API Key');
	   $fields->addFieldToTab('Root.Facebook', new TextField('secretKey'), 'Código secreto de la aplicación');
	   $fields->addFieldToTab('Root.Facebook', new TextField('domain'), 'Site Domain');
	   $fields->addFieldToTab('Root.Facebook', new TextField('accessToken'), 'Clave de acceso');
    }
}