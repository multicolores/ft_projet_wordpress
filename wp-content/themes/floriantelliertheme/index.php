<!DOCTYPE html>
<html lang="fr">

<head>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header>
        <h1>Le projet wordpress de Florian TELLIER</h1>
    </header>

    <div class="ft_main_content_container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <!-- <a href="<?php the_permalink() ?>"><?php the_title() ?></a> -->
                <?php the_content() ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p>There are no posts !</p>
        <?php endif; ?>
    </div>

    <div id="ft-loading-container">
        <div class="ft-loading">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <footer>
        <p>Projet wordpress de Florian TELLIER</p>
    </footer>
    <?php wp_footer(); ?>

</body>

</html>