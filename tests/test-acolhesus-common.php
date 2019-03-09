<?php
/**
 * Class AcolheSUSCommonTest
 *
 * @package Acolhesus_Forms
 */

/**
 * AcolheSUSCommon trait test case.
 */
class AcolheSUSCommonTest extends WP_UnitTestCase {
    use AcolheSUSCommon;

	public function test_get_acolhesus_title() {
		$this->assertEquals('Plataforma de Gestão AcolheSUS', $this->get_title() );
	}
}
