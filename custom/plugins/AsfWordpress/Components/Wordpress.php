<?php

namespace AsfWordpress\Components;

/**
 * Class Wordpress
 * @package AsfAfterbuy\Components
 */
final class Wordpress {

    private $WP = null;

    private $SW = null;


    public function __construct() {

        $this->SW = \AsfWordpress\Components\Db::getInstance('shop');
        $this->WP = \AsfWordpress\Components\Db::getOtherInstance('wordpress');

    }

    public function importArticles() {

        $keywords = "trauringe, eheringe, hochzeit, hochzeitsratgeber, hochzeitsblog, trauringeratgeber, trauringeblog";

        /**
         * @mapping
         * post_date => display_date
         * post_content => description
         * post_title => meta_title, title
         * post_name => SEO-URL
         * author_id = 53
         * active = 1
         * views = 0
         * category_id = 32
         * postmeta._yoast_wpseo_metadesc => meta_description
         * postmeta._thumbnail_id => posts.id(image_url_id)
         */
        $articles = $this->WP->fetchAll("SELECT *  FROM `wp_posts` WHERE `post_type` LIKE 'post' AND `post_status` LIKE 'publish'");

        $mediaResource = \Shopware\Components\Api\Manager::getResource('media');

        foreach($articles as $article) {

            $id = Shopware()->Db()->fetchOne("SELECT id FROM `s_blog` WHERE `title` = ?",$article['post_title']);

            if(!empty($id)) {
                continue;
            }

            $meta = $this->WP->fetchAll("SELECT * FROM `wp_postmeta` WHERE `post_id` = ?",$article['ID']);
            $image = "";
            $metaDesc = "";

            foreach($meta as $data) {

                if($data['meta_key'] === "_thumbnail_id") {
                    $image = $this->WP->fetchRow("SELECT * FROM `wp_posts` WHERE id = ?",$data['meta_value']);
                }

                if($data['meta_key'] === "_yoast_wpseo_metadesc") {
                    $metaDesc = $data['meta_value'];
                }

                if(!empty($image) && !empty($metaDesc)) {
                    break;
                }

            }

            $parts = explode("\n",$article['post_content']);

            $content = "";
            foreach($parts as $part) {
                if(strlen($part) < 13) {
                    continue;
                } else {

                    if(preg_match("/<h2>/",$part) || preg_match("/<p>/",$part) || preg_match("/<li>/",$part) || preg_match("/<ul>/",$part)) {
                        $content .= $part;
                    } else {
                        $content .= "<p>".$part."</p>";
                    }

                }
            }

            Shopware()->Db()->query("INSERT INTO `s_blog` (`title`,`active`,`author_id`,`description`,`views`,`display_date`,`category_id`,
                `meta_keywords`,`meta_description`,`meta_title`) VALUES (?,?,?,?,?,?,?,?,?,?)",[$article['post_title'],1,5,$content,
                0,$article['post_date'],32,$keywords,$metaDesc,$article['post_title']]);

            $blogID = Shopware()->Db()->lastInsertId();

            Shopware()->Db()->query("INSERT INTO `s_blog_attributes` (`blog_id`,`attribute1`) VALUES (?,?)",[$blogID, $article['post_name']]);

            $mediaID = $mediaResource->create($this->prepareImage($image['post_name'],$image['post_title'],$image['guid']))->getId();

            Shopware()->Db()->query("INSERT INTO `s_media_attributes` (`mediaID`,`copyright`) VALUES (?,?)",[$mediaID,$image['post_excerpt']]);
            Shopware()->Db()->query("INSERT INTO `s_blog_media` (`blog_id`,`media_id`,`preview`) VALUES (?,?,?)",[$blogID,$mediaID,1]);

        }

    }

    public function updateArticles() {

        $articles = $this->WP->fetchAll("SELECT *  FROM `wp_posts` WHERE `post_type` LIKE 'post' AND `post_status` LIKE 'publish'");

        foreach($articles as $article) {
            Shopware()->Db()->query("UPDATE s_blog SET display_date = ? WHERE title = ?",[$article['post_title'],$article['post_date']]);
        }

    }

    /**
     * @return array
     */
    private function prepareImage($name,$description,$file) {
        return ["album" => -11, "name" => $name, "description" => $description, "file" => $file, "userId" => 1];
    }

}

?>