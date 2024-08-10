<?php
return array(

    /* VOICE */
    'Soap_ipcc' => 'http://221.121.12.229:8090/ipcc/ipccagent/index.php?r=soap/ws',
    'url_keepAlive' => 'http://221.121.12.229:8090/ipcc/ipccagent/index.php?r=site/keepalive',
    'url_getIncommingCall' => 'http://221.121.12.229:8090/ipcc/ipccagent/index.php?r=site/getincommingcall',
    // 'Soap_ipcc' => '',
    // 'url_keepAlive' => '',
    // 'url_getIncommingCall' => '',

    'keepAlive' => 180000,   //ms
    'incommingCall' => 5000,
    'keepAlive_status'=>'offline', // online or offline


    //Set id agent of cs
    'id_agent' => '1',

    //Set id agent of cs
    'agent_no' => 'website_nhakhoa2000',

    //Set id agent of cs
    'agent_name' => 'Website Nha khoa 2000',

    //Key code of agent
    'key_pass_code'  =>  'b26c204f6634d',

    //Security code of agent
    'agent_sec_code' => 'c80fc4f4aa58e65277f3756f3b207806',

    // default password customer
    'pass'      =>  '123456',
    'default_password' =>'bookoke!@#$5',

	//Group User
    'id_group_admin' => 1,
    'id_group_subadmin' => 2,
    'id_group_dentist' => 3,
    'id_group_receptionist' => 4,
    'id_group_customer_service' => 5,
    'id_group_admin_support' => 8,
    'id_group_accountant' => 11,
    'id_group_assistant'=>12,
    'id_group_warehouse'=>13,
    'id_group_marketing'=>14,
    'id_group_maintenance'=>15,
    'id_group_operation'=>16,
    'id_group_nhapbenhan'=>17,
    'id_group_admin_website'=>18,
    'id_group_export'=>19,

    //Group services
    'id_service_exam' => 1,
    'id_service_exam' => '1',

    //Lines per page in clients
    'lpp_clients' => 10,

    'type' => array(
        'active' => 1,
        'gateway_faststart' => 1,
        'gateway_inactive' => 4,
        'recognize_login_ani' => 16,
        'pin_source' => 32,
        'gateway_SIP' =>64,
        'codec_audio' => 512,
        'charge_incoming' => 1024,
        'gateway_send_remote_id' => 4096,
        'codec_video' => 131072,
        'do_not_generate_ringback' => 262144,
        'record_call' => 524288,
        'codec_fax' => 1048576,
    ),
	'id_group_dentist' => '3',
    'id_branch' => 1,

    'member_unit_point' => 50000,
    
    //'url_base_http' => 'http://hhh.nhakhoa2000.com',
    'url_base_http' => '',
    'db_hhh' => array(
        'domain' => '221.121.12.229',
        'username' => 'c10nhakhoa2000',
        'password' => 'dgmFRw2eZdFQ#',
        'db_name' => 'db_hhh_nhakhoa2000',
    ),
    'db_ngt' => array(
        'domain' => '221.121.12.229',
        'username' => 'c10nhakhoa2000',
        'password' => 'dgmFRw2eZdFQ#',
        'db_name' => 'db_ngt_nhakhoa2000',
    ),
    'image_url' => 'https://hhh.lichhen.com',
    'upload_url' => 'https://s3.ap-southeast-1.amazonaws.com/hhh.nhakhoa2000',
);
?>