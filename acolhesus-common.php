<?php

trait AcolheSUSCommon {
    private $fases = [
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
        'GO' => 'GO - Cristalina - Hospital Municipal de Cristalina Chaud Salles',
        'MA' => 'MA - São Luís - UPA Itaqui Bacana',
        'MG' => 'MG - Juiz de Fora - Hospital Regional Dr. João Penido',
        'MS' => 'MS - Campo Grande - Hospital Regional de Mato Grosso do Sul',
        'MT' => 'MT - Várzea Grande - Hospital e Pronto Socorre Municipal de Várzea Grande',
        'PA' => 'PA - Belém - CAPS Renascer',
        'PB' => 'PB - João Pessoa - Maternidade Frei Damião',
        'PI' => 'PI - Parnaíba - Hospital Estadual Dirceu Arcoverde',
        'RJ' => 'RJ - Duque de Caxias - Hospital Estadual Adão Pereira Nunes',
        'RN' => 'RN - Natal - Hospital José Pedro Bezerra',
        'RR' => 'RR - Boa Vista - Pronto Atendimento Airton Rocha',
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

    // Estados que não participam por enquanto do AcolheSUS
    // Deixar aqui a título de conhecimento
    private $estados_fora = [
        'ES' => 'ES',
        'PE' => 'PE',
        'PR' => 'PR',
        'RO' => 'RO',
        'RS' => 'RS',
        'SE' => 'SE',
        'SP' => 'SP'
    ];
}
