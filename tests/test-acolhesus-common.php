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

    // Adaptar teste sempre/quando estados entrarem/saírem
    private $CURRENT_ACTIVE_STATES = 16;
    private $TOTAL_FASES = 4;
    private $TOTAL_EIXOS = 5;

	public function test_get_acolhesus_title() {
		$this->assertEquals('Plataforma de Gestão AcolheSUS', $this->get_title() );
	}

	public function test_has_16_active_states() {
	    $this->assertCount($this->CURRENT_ACTIVE_STATES, $this->campos_completos);
    }

    public function test_has_4_phases() {
        $this->assertCount($this->TOTAL_FASES, $this->fases);
    }

    public function test_has_5_axes() {
        $this->assertCount($this->TOTAL_EIXOS, $this->eixos);
    }
}
