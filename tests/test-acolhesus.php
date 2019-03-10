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

    public function test_has_15_different_form_types() {
        global $AcolheSUS;
        self::assertCount(self::TOTAL_FORMS, $AcolheSUS->forms);
    }

    public function test_get_mail_by_responsible() {
        global $AcolheSUS;

        $this->assertEquals('ailana.lira@saude.gov.br', $AcolheSUS->get_email_by_responsible('ailana'));
        $this->assertEquals('danyelle.cavalcante@saude.gov.br', $AcolheSUS->get_email_by_responsible('danyelle'));
        $this->assertEquals('diegop.santos@saude.gov.br', $AcolheSUS->get_email_by_responsible('diego'));
        $this->assertEquals('', $AcolheSUS->get_email_by_responsible('giovanna'),'Deveria ter saído do projeto');
        $this->assertEquals('', $AcolheSUS->get_email_by_responsible('marilia'), 'Deveria ter saído do projeto');
        $this->assertEquals('', $AcolheSUS->get_email_by_responsible('janaina'),'Deveria ter saído do projeto');
    }
}