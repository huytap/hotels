<?php
return array(
	'ldap_server' => '192.254.161.151',
	'ldap_admin_user'  => 'no_reply@silverlandhotels.com',
	'ldap_admin_pass' => 'MGdC7gCuB9DX2r',
	'ldap_dn' => 'dc=jvpc,dc=com,dc=vn',
	'ldap_fields' => 'userprincipalname,displayname,givenname,sn,name,title,department,telephonenumber,mail,mobile,manager,whenchanged,distinguishedname',
	'letters_ignore' => array('{', '!'),
	'phrase_ignore' => array('SERVICE_ACC', 'RESOURCE_ACC', 'OU=GUESTS', 'CN=Users', /* 'OU=TEMP', */ ),
);
?>
