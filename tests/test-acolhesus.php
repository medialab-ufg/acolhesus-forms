<?php
/**
 * Class AcolheSUSTest
 *
 * @package Acolhesus_Forms
 */

/**
 * AcolheSUS' core class test case.
 */

class AcolheSUSTest extends WP_UnitTestCase {
    const TOTAL_FORMS = 15;
    const EMAIL_AILANA = 'ailana.lira@saude.gov.br';
    const EMAIL_DANYELLE = 'danyelle.cavalcante@saude.gov.br';

    public function test_has_15_different_form_types() {
        global $AcolheSUS;
        self::assertCount(self::TOTAL_FORMS, $AcolheSUS->forms);
    }

    public function test_get_mail_by_responsible() {
        global $AcolheSUS;

        $this->assertEquals(self::EMAIL_AILANA, $AcolheSUS->get_email_by_responsible('ailana'));
        $this->assertEquals(self::EMAIL_DANYELLE, $AcolheSUS->get_email_by_responsible('danyelle'));
        $this->assertEquals('diegop.santos@saude.gov.br', $AcolheSUS->get_email_by_responsible('diego'));
        $this->assertEquals('', $AcolheSUS->get_email_by_responsible('giovanna'),'Deveria ter saído do projeto');
        $this->assertEquals('', $AcolheSUS->get_email_by_responsible('marilia'), 'Deveria ter saído do projeto');
        $this->assertEquals('', $AcolheSUS->get_email_by_responsible('janaina'),'Deveria ter saído do projeto');
    }

    public function test_get_forward_mail() {
        global $AcolheSUS;

        $this->assertContains(self::EMAIL_AILANA, $AcolheSUS->get_forward_mail_by_state('AM'));
        $this->assertContains(self::EMAIL_DANYELLE, $AcolheSUS->get_forward_mail_by_state('MS'));
    }
}