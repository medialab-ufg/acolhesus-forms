<?php

trait AcolheSUSCommon {
    protected $fases = [
        'fase_1' => 'Fase | - Análise Situacional',
        'fase_2' => 'Fase || - Elaboração e Modelização do Plano de Trabalho',
        'fase_3' => 'Fase ||| - Implementação, Monitoramento e Avaliação',
        'macrogestao' => 'Macrogestão'
    ];

    public $eixos = [
        'Acolhimento',
        'Qualificação Profissional',
        'Gestão de Processos de Trabalho',
        'Organização do Cuidado',
        'Ambiência'
    ];

    private $campos_completos = [
        'AC' => 'AC - Rio Branco - Hospital de Urgência e Emergência',
        'AL' => 'AL - Arapiraca - Hospital de Emergência Dr. Daniel Houly',
        'AM' => 'AM - Manaus - Hospital Dr. João Lúcio Pereira Machado',
        'AP' => 'AP - Macapá - Hospital Dr. Oswaldo Cruz',
        'BA' => 'BA - Salvador - Hospital Geral do Estado',
        'CE' => 'CE - Fortaleza - Hospital São José',
        'DF' => 'DF - Brasília - Regional Macro Centro-Norte - APS',
        'MA' => 'MA - São Luís - UPA Itaqui Bacana',
        'MG' => 'MG - Juiz de Fora - Hospital Regional Dr. João Penido',
        'MS' => 'MS - Campo Grande - Hospital Regional de Mato Grosso do Sul',
        'MT' => 'MT - Várzea Grande - Hospital e Pronto Socorro Municipal de Várzea Grande',
        'PB' => 'PB - João Pessoa - Maternidade Frei Damião',
        'PI' => 'PI - Parnaíba - Hospital Estadual Dirceu Arcoverde',
        'RN' => 'RN - Natal - Hospital José Pedro Bezerra',
        'SC' => 'SC - São José - Hospital Regional de São José Dr. Homero Miranda',
        'TO' => 'TO - Palmas - Hospital Geral de Palmas'
    ];

    public $campos = [
        'AC',
        'AL',
        'AM',
        'AP',
        'BA',
        'CE',
        'DF',
        'GO',
        'MA',
        'MG',
        'MS',
        'MT',
        'PA',
        'PB',
        'PI',
        'RJ',
        'RN',
        'RR',
        'SC',
        'TO'
    ];

    private $campos_fora = [
        'ES' => 'ES',
        'PE' => 'PE',
        'PR' => 'PR',
        'RO' => 'RO',
        'RS' => 'RS',
        'SE' => 'SE',
        'SP' => 'SP',
        'GO' => 'GO',
        'PA' => 'PA',
        'RJ' => 'RJ',
        'RR' => 'RR',
    ];

    protected function get_title()
    {
        return 'Plataforma de Gestão AcolheSUS';
    }
}
