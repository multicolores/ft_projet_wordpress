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
                <?php the_content() ?>
            <?php endwhile; ?>
        <?php else : ?>

            <ul class="links_list">
                <li>
                    <a href="<?php print get_permalink(get_page_by_path("/choix-voyage")->ID) ?>">/choix-voyage</a>
                </li>
                <li>
                    <a href="<?php print get_permalink(get_page_by_path("/choix-voyage-step-select")->ID) ?>">/choix-voyage-step-select</a>
                </li>
                <li>
                    <a href="<?php print get_permalink(get_page_by_path("/choix-voyage-step-final")->ID) ?>">/choix-voyage-step-final</a>
                </li>
            </ul>
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