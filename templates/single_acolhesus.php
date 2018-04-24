<style>
    .acolhesus-form-container {
        background: white;
        padding: 3%;
        margin-bottom: 30px;
    }
    .acolhesus-form-container h3 {
        margin: 0;
        color: #003c46;
    }
</style>

<?php include_once( get_theme_file_path('header-full.php') ); ?>

<div class="acolhesus-form-container">
    <h3> <?php the_title(); ?></h3>
    <hr>
    <?php the_content(); ?>
</div>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>