<?php /* Template Name: Search Result */ ?>

<?php get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();
                $totalResults = $_POST['total_results'];
                $results = unserialize(base64_decode($_POST['results'])) ;
                $email = $_POST['user_email'];
//                echo "<pre>";
//                    print_r($results);
//                    print_r($_POST);
//                echo "</pre>";
                    $addressList = array();
                if($totalResults > 0) {
                    ?>
                    <div class="cry-map-address-list-area">
                        <ul class="map-address-list">
                        <?php
                        foreach ($results as $key => $result){
                            $addressList['address'][] = $result['properties']['name'] . ' ' . $result['properties']['city'] . ' ' . $result['properties']['state'] . ' ' . $result['properties']['postcode'] . ' ' . $result['properties']['country'];
                            $addressList['latitude'][] = $result['geometry']['coordinates'][0];
                            $addressList['longitude'][] = $result['geometry']['coordinates'][1];
                            ?>
                                <li><a href="#" class="map-addres-cry" id="address<?php echo $key;?>"><?php echo $result['properties']['name'] . ' ' . $result['properties']['city'] . ' ' . $result['properties']['state'] . ' ' . $result['properties']['postcode'] . ' ' . $result['properties']['country']; ?></a></li>
                            <?php
                        }
                        ?>
                        </ul>
                        <input type="hidden" name="totalResults" id="totalResults" value="<?php echo $totalResults; ?>">
                        <input type="hidden" name="email"  id="email" value="<?php echo $email; ?>">
                    </div>
                    <?php
                }

?>
<div class="map-file-format-area" style="display: none;">

</div>
<?php
//                // Include the page content template.
//                get_template_part( 'template-parts/content', 'page' );
//
//                // If comments are open or we have at least one comment, load up the comment template.
//                if ( comments_open() || get_comments_number() ) {
//                    comments_template();
//                }

                // End of the loop.
            endwhile;
            ?>

        </main><!-- .site-main -->

        <?php //get_sidebar( 'content-bottom' ); ?>

    </div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>