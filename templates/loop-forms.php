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
				<th> Fase </th>
				<th> Eixo </th>
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
            ?>
                <tr>
                    <td> 
						<strong> 
							<?php echo get_post_meta($entry_id, "acolhesus_campo")[0];  ?>
						</strong> 
					</td>
					
					<?php if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)): ?>
						<td> <?php echo get_post_meta(get_the_ID(), 'acolhesus_fase', true); ?> </td>
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
						<td> <?php echo get_post_meta(get_the_ID(), 'acolhesus_fase', true); ?> </td>
						<td> <?php echo get_post_meta(get_the_ID(), 'acolhesus_eixo', true); ?> </td>
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
    if ($AcolheSUS->can_add_entry($current_acolhesus_formtype)) { ?>
        <div class="col-md-12">
            <p>
                <input type="hidden" id="new_post_type" name="new_post_type" value="<?php echo $current_acolhesus_formtype; ?>">
                <button class="btn btn-info" id="add_acolhesus_entry">Nova resposta de <?php echo post_type_archive_title(); ?> </button>
            </p>
        </div>
        <?php
    }
    ?>

