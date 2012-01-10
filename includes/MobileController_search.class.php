<?php

class MobileController_search extends PSUController {
	// redefine delegate so parent knows which controller to use as default.
	// placeholder until php 5.3 "static" keyword.
	public static function delegate( $path = null, $controller_class = __CLASS__ ) {
		parent::delegate( $path, $controller_class );
	}

	public function query( $search, $command, $type ) {
		header('Content-type: application/json');

		$args = array(
			'search_phrase' => $search,
			'empstu' => TRUE,
			'count' => 100,
		);

		$results = PSU::searchPhonebook( $args );	

		$data = array(
			'status' => 'ok',
			'entries' => array(),
		);

		foreach( $results as $row ) {
			$phone = new \PSU\Phone( $row['phone_of'] ?: $row['phone_vm'] );
			
			$record = array(
				'name' => $row['name_full'],
				'lastName' => PSU::get('idmobject')->getIdentifier($row['psu_id'], 'psu_id', 'last_name'),
				'firstName' => PSU::get('idmobject')->getIdentifier($row['psu_id'], 'psu_id', 'first_name'),
				'phone' => array(
					array(
						'area' => $phone->area,
						'number' => $phone->number,
					),
				),
				'address' => array(
					array(
						'streetOne' => $row['title'],
						'streetTwo' => $row['dept'],
						'streetThree' => $row['msc'] ?: '',
						'city' => 'Plymouth, NH',
					),
				),
				'email' => $row['email'].'@plymouth.edu',
			);

			$record['prefFirstName'] = $record['firstName'];

			$data['entries'][] = $record;
		}//end foreach

		die( json_encode( $data ) );
	}//end query
}//end class MobileController_search
