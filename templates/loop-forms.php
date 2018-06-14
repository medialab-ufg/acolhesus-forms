<table class="table table-hover">
        <thead>
        <tr>
            <th> Campo de Atuação </th>
			
			<?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
				<th> Fase </th>
				<th> Eixo </th>
			<?php endif; ?>

			<th> Nome </th>
			
			<?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
	            <th> Data Criação </th>
	            <th> Autor </th>
			<?php endif; ?>

            <th> Status </th>
            <?php if (current_user_can('acolhesus_cgpnh')) { ?>
                <th> Ação </th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if ( have_posts() ) {
            while(have_posts()): the_post();
            $author_id = get_the_author_meta( 'ID' );
            $entry_id = get_the_ID();
            $fase = get_post_meta(get_the_ID(), 'acolhesus_fase', true);
            ?>
                <tr>
                    <td> 
						<strong> 
							<?php echo get_post_meta($entry_id, "acolhesus_campo")[0];  ?>
						</strong> 
					</td>
					
					<?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
						<td> <?php echo $AcolheSUS->fases[$fase]; ?> </td>
						<td> <?php echo get_post_meta(get_the_ID(), 'acolhesus_eixo', true); ?> </td>
					<?php endif; ?>
					
					<td>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title( '<h3 class="panel-title">', '</h3>' ); ?>
                        </a>
                    </td>
                    
					<?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
						<td> <?php the_time( 'd/m/Y - G:i:s'); ?> </td>
	                    <td> <a href="<?php echo home_url('formularios-acolhesus/?usuario=' . $author_id); ?>"><?php echo get_the_author(); ?></a> </td>
					<?php endif; ?>

                    <td> <?php $AcolheSUS->render_entry_status($entry_id); ?> </td>

                    <?php if (current_user_can('acolhesus_cgpnh')) { ?>
                        <td> <?php $AcolheSUS->render_entry_action($entry_id, get_the_title()); ?> </td>
                    <?php } ?>
                </tr>
            <?php
            endwhile;
        }
        ?>
        </tbody>
    </table>

    <?php
    if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)) {
        $post_type_data = get_post_type_object($current_acolhesus_formtype);
        if(is_object($post_type_data)) {
            $f_name = $post_type_data->labels->singular_name;
        ?>
            <div class="col-md-12 add-entry">
                <p>
                    <button class="add_acolhesus_entry btn btn-info"
                            data-newTitle="<?php echo $f_name ?>"
                            data-postType="<?php echo $current_acolhesus_formtype; ?>">
                        Nova resposta de <?php echo $f_name ?>
                    </button>
                </p>
            </div>
        <?php
        }
    }
    ?>
<hr>
