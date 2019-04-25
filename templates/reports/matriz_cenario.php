<div class="matriz-cenario-single-report">
    <p> A referência técnica da CGPNH/SAS/MS para este campo é
        <strong><?php echo $data['A Referência estadual da CGPNH/SAS/MS']; ?></strong>.
        O campo de atuação atinge um total de <strong><?php echo $count_cities; ?> municípios</strong>, que, em conjunto, representam uma população de <strong><?php echo $populacao; ?> habitantes</strong>.
        <?php echo $data['C Quantos profissionais estão alocados no serviço'] ;?> profissionais estão alocados neste serviço.</p>

    <h3>1 Eixo 1: Acolhimento e Classificação/Avaliação de risco e vulnerabilidade</h3>
    <h4>1.1 Acolhimento</h4>

    <?php if($data['1.1.1'] == 'Sim'){?>
        <p>Existe uma referência técnica ou grupo responsável para o processo de Acolhimento no Estado.
            A referência é <strong><?php echo $data['1.1.1.1'];?></strong>.</p>
    <?php } ?>

    <?php if($data['1.1.2'] == 'Sim'){?>
        <p>Foi implantado processo de Acolhimento no(s) serviço(s) que compõe(m) o projeto.
            Em  <strong><?php echo $data['1.1.2.1'];?></strong>.
            <?php if($data['1.1.2.2'] == 'Sim') {?>
                A implantação foi parcial.
            <?php } ?>
            <?php if($data['1.1.2.3'] == 'Sim'){ ?>
            Foram capacitados: <?php echo $data['1.1.2.3.1']; ?> <?php if($data['1.1.2.3.1.1']){ echo '; '.$data['1.1.2.3.1.1']; } ?> <?php if($data['1.1.2.3.1.2']){ echo '; '.$data['1.1.2.3.1.2'];} ?>.
            <?php } ?>
            Foram construídos os fluxos internos do Acolhimento: <strong><?php echo $data['1.1.2.4']; ?></strong>.
            <?php if($data['1.1.2.4.1.1']){?>
            De forma pactuada com as seguintes categorias profissionais: <strong><?php echo $data['1.1.2.4.1.1']; ?></strong>.</p>
            <?php } ?>
    <?php } ?>

    <p>
        <?php if($data['1.1.3'] == 'Sim') { ?>O usuário foi incluído no processo de implantação/implementação do Acolhimento. <?php } ?>
        <?php if($data['1.1.4'] == "Sim"){ ?>
        Existe avaliação de satisfação do usuário a partir das ações de Acolhimento implantadas.
        Observações pertinentes:  <?php echo $data['1.1.4.1']; ?>.</p>
<?php } ?>

    <?php if($data['1.1.5'] != 'Não'){?>
        <p>Existe listagem de ações/ofertas de serviços para os usuários (carta de serviço) <?php echo $data['1.1.5']."."; ?>
            <?php if($data['1.1.5.1'] == 'Sim'){ ?>A oferta de serviços foi construída com os trabalhadores e gestores das unidades de saúde. <?php } ?>
            <?php if(!empty($data['1.1.5.1.1'])){?> Observações pertinentes <?php echo $data['1.1.5.1.1'].'.'; }?>
            <?php if($data['1.1.5.2']){?>
            *Existe listagem para as seguintes Unidades de Saúde: <?php echo $data['1.1.5.2']; ?> <?php if($data['1.1.5.2.1']) { echo "; ".$data['1.1.5.2.1']; }?> .
            <?php } ?>
            <?php if($data['1.1.5.3']) {?>
            A(s) forma(s) de disponibilização da listagem (escopo) de ações/ofertas de serviços para os usuários é (são) a(s) seguinte(s): <?php echo $data['1.1.5.3']; ?> <?php if($data['1.1.5.3.1']){ echo "; ".$data['1.1.5.3.1']; }?>.</p>
            <?php } ?>
    <?php } ?>

    <h4>1.2 Classificação de Risco</h4>

    <p>
        <?php if($data['1.2.1'] == 'Sim'){?>
            Os serviços têm implantado protocolo de classificação/avaliação de risco e vulnerabilidade na porta de entrada. O(s) protocolo(s) utilizado(s) é (são) o(s) seguinte(s): <?php echo $data['1.2.1.1']."."; } ?>
        <?php if($data['1.2.2'] == 'Sim'){ ?>
            Os seguintes profissionais foram capacitados para a implantação do protocolo de classificação/avaliação de risco e vulnerabilidade de risco:  <?php echo $data['1.2.2.1'] ?> <?php if($data['1.2.2.1.1']) echo '; '.$data['1.2.2.1.1']."."; } ?>
        <?php if($data['1.2.3'] == 'Sim'){ ?>
            O protocolo foi pactuado pela equipe multiprofissional da unidade de saúde.
        <?php } ?>
        <?php if($data['1.2.4'] == 'Sim'){ ?>
            A estratégia de monitoramento e avaliação dos indicadores de classificação/avaliação de risco e vulnerabilidade de risco utilizada é: <?php echo $data['1.2.4.1']; ?>.
            <?php if(!empty($data['1.2.4.2'])){ ?>Observações pertinentes: <?php echo $data['1.2.4.2'].'.'; } ?>
        <?php } ?>
    </p>

    <h3>2 Eixo 2: Ambiência</h3>

    <p>
        <?php if($data['2.1'] == 'Sim'){?>
            Os seguintes projetos de reforma ou adequações de layout e de mudanças de fluxos, que envolvem o serviço, foram construídos de forma cogerida e a partir da diretriz Ambiência da PNH: <strong><?php echo $data['2.1.1']; ?></strong>.
        <?php } ?>
        <?php if($data['2.2'] == 'Sim'){?>
            Os profissionais da engenharia e arquitetura da SES foram qualificados na diretriz ambiência da PNH [2.2.].
        <?php } ?>
        <?php if($data['2.3'] == 'Sim'){?>
            Foram realizadas avaliações de satisfação dos usuários.
        <?php } ?>
        <?php if($data['2.4'] == 'Sim'){?>
            Foram realizadas avaliações de satisfação dos trabalhadores.
        <?php } ?>
        <?php if($data['2.5'] == 'Sim'){?>
            Foram realizadas avaliações de satisfação dos gestores.
        <?php } ?>
    </p>

    <h3>3 Eixo 3: Qualificação Profissional</h3>

    <p>
        <?php if($data['3.1'] == 'Sim'){?>
            Existe mecanismo de educação permanente no Estado para gestores e trabalhadores, com ampliação de métodos de discussão e produção coletiva de conhecimento e qualificação do trabalho.
        <?php } ?>

        <?php if($data['3.1'] != 'Não'){?>
            A coordenação de humanização do Estado tem plano de formação e intervenção em humanização de acordo com a PNH, <strong><?php echo $data['3.2']?></strong>.
        <?php } ?>

        <?php if($data['3.3'] == 'Sim'){?>
            A SES conta com apoiadores institucionais do Estado formados na PNH.
        <?php } ?>

        <?php if($data['3.1'] == 'Sim'){?>
            Existe uma rede/grupos para intercâmbio entre os níveis de atenção para compartilhamento das experiências.
        <?php } ?>
    </p>

    <h3>4 Eixo 4: Gestão e Organização do Cuidado</h3>

    <h4>4.1 Gestão compartilhada</h4>

    <p>
        <?php if($data['4.1.1'] == 'Sim'){?>
            Existem os seguintes espaços coletivos/colegiados instituídos e com funcionamento sistemático efetivo na SES com plano de trabalho elaborado: <strong><?php echo $data['4.1.1.1']?></strong>. Sua forma de funcionamento é: <strong><?php echo $data['4.1.1.2']; ?></strong>.
        <?php } ?>
        <?php if($data['4.1.2'] == 'Sim'){?>
            Existem os seguintes espaços coletivos/colegiados instituídos nos serviços de saúde com plano de trabalho elaborado: <strong><?php echo $data['4.1.2.1']?></strong>. Sua forma de funcionamento é: <strong><?php echo $data['4.1.2.2']; ?></strong>.
        <?php } ?>
        <?php if($data['4.1.1'] == 'Sim'){?>
            Existem os seguintes espaços constituídos de gestão e deliberação na região de saúde que compõe o projeto: <strong><?php echo $data['4.1.3.1']?></strong>. Sua forma de funcionamento é: <strong><?php echo $data['4.1.3.2']; ?></strong>.
        <?php } ?>
    </p>

    <h4>4.2 Garantia dos direitos dos usuários</h4>

    <?php if($data['4.2.1'] == 'Sim'){?>
        Existe ouvidoria institucional ou serviço implementado para escuta dos usuários, com sistema de divulgação dos resultados/avaliações na SES.
    <?php } ?>
    <?php if($data['4.1.2'] == 'Sim'){?>
        Existe ouvidoria institucional ou serviço implementado para escuta dos usuários, com sistema de divulgação dos resultados/avaliações nas unidades de saúde.
    <?php } ?>

    <h4>4.3 Continuidade do cuidado</h4>

    <?php if($data['4.3.1'] == 'Sim'){?>
        Existe articulação entre o campo de atuação e os demais pontos da RAS.
        A articulação é feita entre as seguintes unidades e da seguinte forma: <strong><?php echo $data['4.3.1.1']; ?></strong>.
    <?php } ?>

    <?php if($data['4.3.2'] == 'Sim'){?>
        Existem instrumentos de referência e transferência do cuidado construídos e pactuados entre os municípios para a conformação da RAS.
    <?php } ?>
    <?php if($data['4.3.2.1'] == 'Sim'){?>
        A construção e pactuação de instrumentos de referência e transferência foram produzidos com a participação dos gestores e trabalhadores dos serviços.
    <?php } ?>

    <h4>4.4 Monitoramento e avaliação</h4>

    <?php if($data['4.4.1'] == 'Sim'){?>
        Existe núcleo/coordenação de monitoramento e avaliação na SES.
    <?php } ?>
    <?php if($data['4.4.1.1'] == 'Sim'){?>
        O processo de trabalho é realizado de forma articulada e alinhada com as áreas /coordenações da SES com encontros programáticos.
    <?php } ?>

    O processo metodológico de monitoramento e avaliação dos indicadores que compõem o planejamento da SES é o seguinte: <strong><?php echo $data['4.4.1.2']?></strong>.

    <?php if($data['4.4.1.3'] == 'Sim'){?>
        O processo de trabalho é realizado de forma articulada e alinhada com a Coordenação Estadual de Humanização com encontros programáticos.
    <?php } ?>
    <?php if($data['4.4.1.3.1'] == 'Sim'){?>
        Por fim, agenda de encontros com a coordenação de humanização está acontecendo dentro do que foi pactuado.
    <?php } ?>
</div>