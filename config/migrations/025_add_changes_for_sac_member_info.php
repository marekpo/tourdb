<?php
class M4f536cf2c49c4f4eb2ab06241b2c2a9b extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'sac_sections' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				)
			),
			'create_field' => array(
				'profiles' => array(
					'sac_member' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'after' => 'emergencycontact2_email'),
					'sac_membership_number' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_member'),
					'sac_main_section_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_membership_number'),
					'sac_additional_section1_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_main_section_id'),
					'sac_additional_section2_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_additional_section1_id'),
					'sac_additional_section3_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_additional_section2_id')
				)
			)
		),
		'down' => array(
			'drop_table' => array(
				'sac_sections'
			),
			'drop_field' => array(
				'profiles' => array('sac_member', 'sac_membership_number', 'sac_main_section_id', 'sac_additional_section1_id', 'sac_additional_section2_id', 'sac_additional_section3_id')
			)
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction)
	{
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction)
	{
		if($direction == 'up')
		{
			$SacSection = $this->generateModel('SacSection');
			$sacSections = array(
				array('SacSection' => array('id' => '1050', 'title' => 'SAC Aarau')),
				array('SacSection' => array('id' => '1100', 'title' => 'SAC Am Albis')),
				array('SacSection' => array('id' => '1150', 'title' => 'SAC Altels')),
				array('SacSection' => array('id' => '1200', 'title' => 'SAC Angenstein')),
				array('SacSection' => array('id' => '1250', 'title' => 'CAS Argentine')),
				array('SacSection' => array('id' => '1300', 'title' => 'SAC Arosa')),
				array('SacSection' => array('id' => '1350', 'title' => 'SAC Bachtel')),
				array('SacSection' => array('id' => '1380', 'title' => 'SAC Baldern')),
				array('SacSection' => array('id' => '1400', 'title' => 'SAC Basel')),
				array('SacSection' => array('id' => '1450', 'title' => 'SAC Baselland')),
				array('SacSection' => array('id' => '1500', 'title' => 'SAC Bern')),
				array('SacSection' => array('id' => '1501', 'title' => 'SAC Bern Schwarzenburg')),
				array('SacSection' => array('id' => '1550', 'title' => 'SAC Bernina')),
				array('SacSection' => array('id' => '1600', 'title' => 'SAC Biel')),
				array('SacSection' => array('id' => '1601', 'title' => 'SAC Biel Murten')),
				array('SacSection' => array('id' => '1602', 'title' => 'CAS La Neuveville')),
				array('SacSection' => array('id' => '1603', 'title' => 'SAC Biel Büren a/A')),
				array('SacSection' => array('id' => '1650', 'title' => 'SAC Blümlisalp')),
				array('SacSection' => array('id' => '1651', 'title' => 'SAC Blümlisalp Ausserberg')),
				array('SacSection' => array('id' => '1700', 'title' => 'SAC Bodan')),
				array('SacSection' => array('id' => '1750', 'title' => 'SAC Bregaglia')),
				array('SacSection' => array('id' => '1800', 'title' => 'SAC Brugg')),
				array('SacSection' => array('id' => '1850', 'title' => 'SAC Burgdorf')),
				array('SacSection' => array('id' => '1851', 'title' => 'SAC Brandis')),
				array('SacSection' => array('id' => '1852', 'title' => 'SAC Huttwil')),
				array('SacSection' => array('id' => '1853', 'title' => 'SAC Burgdorf Damen')),
				array('SacSection' => array('id' => '1880', 'title' => 'CAS Carougeoise')),
				array('SacSection' => array('id' => '1900', 'title' => 'CAS Chasseral')),
				array('SacSection' => array('id' => '1950', 'title' => 'CAS Chasseron')),
				array('SacSection' => array('id' => '2000', 'title' => 'CAS Chaussy')),
				array('SacSection' => array('id' => '2050', 'title' => 'CAS Chaux-de-Fonds')),
				array('SacSection' => array('id' => '2100', 'title' => 'SAC Davos')),
				array('SacSection' => array('id' => '2150', 'title' => 'CAS Delémont')),
				array('SacSection' => array('id' => '2200', 'title' => 'CAS Dent-De-Lys')),
				array('SacSection' => array('id' => '2250', 'title' => 'CAS Diablerets Lausanne')),
				array('SacSection' => array('id' => '2251', 'title' => 'CAS Diablerets Morges')),
				array('SacSection' => array('id' => '2252', 'title' => 'CAS Diablerets Payerne')),
				array('SacSection' => array('id' => '2253', 'title' => 'CAS Diablerets Vallorbe')),
				array('SacSection' => array('id' => '2254', 'title' => 'CAS Diabl. Château d\'Oex')),
				array('SacSection' => array('id' => '2300', 'title' => 'CAS La Dôle')),
				array('SacSection' => array('id' => '2330', 'title' => 'SAC Drei Tannen')),
				array('SacSection' => array('id' => '2350', 'title' => 'SAC Einsiedeln')),
				array('SacSection' => array('id' => '2400', 'title' => 'SAC Emmental')),
				array('SacSection' => array('id' => '2401', 'title' => 'SAC Grosshöchstetten')),
				array('SacSection' => array('id' => '2450', 'title' => 'SAC Engelberg')),
				array('SacSection' => array('id' => '2500', 'title' => 'SAC Engiadina Bassa')),
				array('SacSection' => array('id' => '2530', 'title' => 'SAC Entlebuch')),
				array('SacSection' => array('id' => '2550', 'title' => 'CAS Genevoise')),
				array('SacSection' => array('id' => '2600', 'title' => 'SAC Gotthard')),
				array('SacSection' => array('id' => '2650', 'title' => 'SAC Grenchen')),
				array('SacSection' => array('id' => '2700', 'title' => 'SAC Grindelwald')),
				array('SacSection' => array('id' => '2750', 'title' => 'CAS Gruyère')),
				array('SacSection' => array('id' => '2800', 'title' => 'SAC Piz Platta')),
				array('SacSection' => array('id' => '2830', 'title' => 'SAC Hohe Winde')),
				array('SacSection' => array('id' => '2850', 'title' => 'SAC Hoher Rohn')),
				array('SacSection' => array('id' => '2900', 'title' => 'SAC Homberg')),
				array('SacSection' => array('id' => '2930', 'title' => 'SAC Hörnli')),
				array('SacSection' => array('id' => '2950', 'title' => 'SAC Interlaken')),
				array('SacSection' => array('id' => '3000', 'title' => 'CAS Jaman')),
				array('SacSection' => array('id' => '3030', 'title' => 'CAS Jorat (Frauen-Biel)')),
				array('SacSection' => array('id' => '3050', 'title' => 'CAS Jura')),
				array('SacSection' => array('id' => '3100', 'title' => 'SAC Kaiseregg')),
				array('SacSection' => array('id' => '3150', 'title' => 'SAC Kamor')),
				array('SacSection' => array('id' => '3200', 'title' => 'SAC Kirchberg')),
				array('SacSection' => array('id' => '3250', 'title' => 'SAC Lägern')),
				array('SacSection' => array('id' => '3251', 'title' => 'SAC Laegern Zurzach')),
				array('SacSection' => array('id' => '3300', 'title' => 'SAC Lauterbrunnen')),
				array('SacSection' => array('id' => '3350', 'title' => 'SAC Ledifluh')),
				array('SacSection' => array('id' => '3400', 'title' => 'SAC Bellinzona e Valli')),
				array('SacSection' => array('id' => '3450', 'title' => 'SAC Lindenberg')),
				array('SacSection' => array('id' => '3500', 'title' => 'SAC Locarno')),
				array('SacSection' => array('id' => '3550', 'title' => 'SAC Manegg')),
				array('SacSection' => array('id' => '3600', 'title' => 'CAS Moléson')),
				array('SacSection' => array('id' => '3650', 'title' => 'CAS Montana-Vermala')),
				array('SacSection' => array('id' => '3700', 'title' => 'CAS Monte Rosa')),
				array('SacSection' => array('id' => '3701', 'title' => 'CAS Monte Rosa Monthey')),
				array('SacSection' => array('id' => '3702', 'title' => 'CAS Monte Rosa St-Maurice')),
				array('SacSection' => array('id' => '3703', 'title' => 'CAS Monte Rosa Martigny')),
				array('SacSection' => array('id' => '3704', 'title' => 'CAS Monte Rosa Sion')),
				array('SacSection' => array('id' => '3705', 'title' => 'CAS Monte Rosa Sierre')),
				array('SacSection' => array('id' => '3706', 'title' => 'SAC Monte Rosa Visp')),
				array('SacSection' => array('id' => '3707', 'title' => 'SAC Monte Rosa St.Niklaus')),
				array('SacSection' => array('id' => '3708', 'title' => 'SAC Monte Rosa Brig')),
				array('SacSection' => array('id' => '3730', 'title' => 'CAS Mont-Soleil')),
				array('SacSection' => array('id' => '3750', 'title' => 'CAS Montreux')),
				array('SacSection' => array('id' => '3800', 'title' => 'SAC Mythen')),
				array('SacSection' => array('id' => '3850', 'title' => 'CAS Neuchâteloise')),
				array('SacSection' => array('id' => '3900', 'title' => 'SAC Niesen')),
				array('SacSection' => array('id' => '3950', 'title' => 'SAC Oberaargau')),
				array('SacSection' => array('id' => '3951', 'title' => 'SAC Oberaargau')),
				array('SacSection' => array('id' => '4000', 'title' => 'SAC Oberhasli')),
				array('SacSection' => array('id' => '4050', 'title' => 'SAC Oldenhorn')),
				array('SacSection' => array('id' => '4100', 'title' => 'SAC Olten')),
				array('SacSection' => array('id' => '4150', 'title' => 'SAC Pfannenstiel')),
				array('SacSection' => array('id' => '4200', 'title' => 'CAS Pierre-Pertuis')),
				array('SacSection' => array('id' => '4250', 'title' => 'SAC Pilatus')),
				array('SacSection' => array('id' => '4251', 'title' => 'SAC Pilatus Surental')),
				array('SacSection' => array('id' => '4252', 'title' => 'SAC Pilatus Napf')),
				array('SacSection' => array('id' => '4253', 'title' => 'SAC Pilatus Hochdorf')),
				array('SacSection' => array('id' => '4254', 'title' => 'SAC Pilatus Rigi')),
				array('SacSection' => array('id' => '4300', 'title' => 'SAC Piz Lucendro')),
				array('SacSection' => array('id' => '4350', 'title' => 'SAC Piz Sol')),
				array('SacSection' => array('id' => '4400', 'title' => 'SAC Piz Terri')),
				array('SacSection' => array('id' => '4450', 'title' => 'SAC Prättigau')),
				array('SacSection' => array('id' => '4451', 'title' => 'SAC Prättigau Baslerkam')),
				array('SacSection' => array('id' => '4500', 'title' => 'CAS Prévôtoise')),
				array('SacSection' => array('id' => '4530', 'title' => 'CAS Raimeux')),
				array('SacSection' => array('id' => '4550', 'title' => 'SAC Randen')),
				array('SacSection' => array('id' => '4600', 'title' => 'SAC Rätia')),
				array('SacSection' => array('id' => '4650', 'title' => 'SAC Rhein')),
				array('SacSection' => array('id' => '4680', 'title' => 'SAC Rinsberg')),
				array('SacSection' => array('id' => '4700', 'title' => 'SAC Rorschach')),
				array('SacSection' => array('id' => '4750', 'title' => 'SAC Rossberg')),
				array('SacSection' => array('id' => '4780', 'title' => 'SAC Saas')),
				array('SacSection' => array('id' => '4800', 'title' => 'SAC Säntis')),
				array('SacSection' => array('id' => '4850', 'title' => 'SAC Seeland')),
				array('SacSection' => array('id' => '4851', 'title' => 'SAC Seeland Erlach')),
				array('SacSection' => array('id' => '4900', 'title' => 'CAS Sommartel')),
				array('SacSection' => array('id' => '4950', 'title' => 'SAC St. Gallen')),
				array('SacSection' => array('id' => '5000', 'title' => 'SAC Stockhorn')),
				array('SacSection' => array('id' => '5050', 'title' => 'SAC Thurgau')),
				array('SacSection' => array('id' => '5100', 'title' => 'SAC Ticino')),
				array('SacSection' => array('id' => '5150', 'title' => 'SAC Titlis')),
				array('SacSection' => array('id' => '5200', 'title' => 'SAC Tödi')),
				array('SacSection' => array('id' => '5250', 'title' => 'SAC Toggenburg')),
				array('SacSection' => array('id' => '5300', 'title' => 'SAC Uto')),
				array('SacSection' => array('id' => '5350', 'title' => 'SAC Uzwil')),
				array('SacSection' => array('id' => '5400', 'title' => 'CAS Val-De-Joux')),
				array('SacSection' => array('id' => '5401', 'title' => 'CAS Val-De-Joux dames')),
				array('SacSection' => array('id' => '5450', 'title' => 'SAC Weissenstein')),
				array('SacSection' => array('id' => '5500', 'title' => 'SAC Wildhorn')),
				array('SacSection' => array('id' => '5550', 'title' => 'SAC Wildstrubel')),
				array('SacSection' => array('id' => '5600', 'title' => 'SAC Winterthur')),
				array('SacSection' => array('id' => '5650', 'title' => 'CAS Yverdon')),
				array('SacSection' => array('id' => '5700', 'title' => 'SAC Zermatt')),
				array('SacSection' => array('id' => '5750', 'title' => 'SAC Zimmerberg')),
				array('SacSection' => array('id' => '5800', 'title' => 'SAC Zindelspitz')),
				array('SacSection' => array('id' => '5850', 'title' => 'SAC Zofingen')),
			);

			$SacSection->saveAll($sacSections);
		}

		return true;
	}
}
?>