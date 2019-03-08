<div class="clear"></div>
<table class="table table-hover">
    <thead>
    <tr>
        <th> Campo de Atuação </th>
			
        <?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
            <th> Fase </th>

            <?php if ($AcolheSUS->form_type_has_axis($current_acolhesus_formtype)): ?>
                <th> Eixo </th>
            <?php endif; ?>

        <?php endif; ?>

        <?php if ("indicadores" === $current_acolhesus_formtype): ?>
            <th> Mês/Ano de ocorrência </th>
        <?php endif; ?>

        <th> Nome </th>
			
        <?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
            <th> Data Criação </th>
            <th> Autor </th>
        <?php endif; ?>

        <?php if ($AcolheSUS->has_validations($current_acolhesus_formtype)): ?>

            <th> Status </th>
            <?php if (current_user_can('acolhesus_cgpnh')) { ?>
                <th> Ação </th>
            <?php } ?>

        <?php endif; ?>

        <?php if (current_user_can('acolhesus_cgpnh') && $AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
            <th> Excluir </th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php
    if ( have_posts() ) {
        while(have_posts()): the_post();
        $author_id = get_the_author_meta( 'ID' );
        $entry_id = get_the_ID();
        $uf_atuacao = get_post_meta($entry_id, "acolhesus_campo")[0];
        ?>
            <tr id="entry-<?php echo $entry_id; ?>">
                <td> <strong> <?php echo $uf_atuacao; ?> </strong> </td>
					
                <?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>

                    <td> <?php echo $AcolheSUS->get_entry_phase($entry_id); ?> </td>

                    <?php if ($AcolheSUS->form_type_has_axis($current_acolhesus_formtype)): ?>
                        <td> <?php echo $AcolheSUS->get_entry_axis($entry_id); ?> </td>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if ("indicadores" === $current_acolhesus_formtype): ?>
                    <td>
                        <?php echo $AcolheSUS->get_entry_date($entry_id); ?>
                    </td>
                <?php endif; ?>

                <td>
                    <a href="<?php echo the_permalink($entry_id); ?>">
                        <?php the_title( '<h3 class="panel-title">', '</h3>' ); ?>
                    </a>
                </td>
                    
                <?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
                    <td> <?php the_time( 'd/m/Y - G:i:s'); ?> </td>
                    <td> <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author(); ?></a> </td>
                <?php endif; ?>

                <?php if ($AcolheSUS->has_validations($current_acolhesus_formtype)): ?>
                    <td> <?php $AcolheSUS->render_entry_status($entry_id); ?> </td>

                    <?php if (current_user_can('acolhesus_cgpnh')) { ?>
                        <td> <?php $AcolheSUS->render_entry_action($entry_id, get_the_title()); ?> </td>
                    <?php } ?>

                <?php endif; ?>

                <?php if (current_user_can('acolhesus_cgpnh') && $AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
                    <td> <?php echo $AcolheSUS->remove_entry($entry_id, get_the_title()); ?> </td>
                <?php endif; ?>
            </tr>
        <?php
        endwhile;
    }
    ?>
    </tbody>
</table>