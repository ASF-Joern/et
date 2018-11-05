<?php

class Shopware_Controllers_Widgets_AsfRingManager extends Enlight_Controller_Action
{

    use AsfAfterbuy\Traits\Calculator;

    /**
     * @var int
     */
    private $catID;

    /**
     * @var array
     */
    private $config;

    public function init() {
        $this->config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('AsfRingManager');
    }

    /**
     * Is always called before the requested controller action is called
     */
    public function preDispatch() {
        Shopware()->Front()->Plugins()->ViewRenderer()->setNoRender();
    }

    /**
     * Return the new ring properties
     *
     * @return string
     */
    public function indexAction() {

        $params = $this->Request()->getParams();
//
        $_SESSION[session_id()] = $params['hash'];

        if(true) {

            $articleParts = explode(" ", $params['articleName']);
            $stone = $params['stone'];
            $hash = $params['hash'];

            if(preg_match("/Memoire/",$params['articleName'])) {

                if($articleParts[1] === "MR09" && $params['kranz'] === "Vollkranz") {
                    $articleParts[1] = "MR10";
                }

                if($articleParts[1] === "MR10" && $params['kranz'] === "Halbkranz") {
                    $articleParts[1] = "MR09";
                }

                if($articleParts[1] !== "MR09" && $articleParts[1] !== "MR10") {

                    $number = (int)substr($articleParts[1],3,1);

                    if(($articleParts[1] === "MR01" || $articleParts[1] === "MR02" || $articleParts[1] === "MR03" ||
                            $articleParts[1] === "MR04")  && $params['profile'] == 4) {
                        $number += 4;
                    }
                    if(($articleParts[1] === "MR01" || $articleParts[1] === "MR03" || $articleParts[1] === "MR05" ||
                            $articleParts[1] === "MR07")  && $params['kranz'] == "Vollkranz") {
                        $number += 1;
                    }
                    if(($articleParts[1] === "MR05" || $articleParts[1] === "MR06" || $articleParts[1] === "MR07" ||
                            $articleParts[1] === "MR08")  && $params['profile'] == 3) {
                        $number -= 4;
                    }
                    if(($articleParts[1] === "MR02" || $articleParts[1] === "MR04" || $articleParts[1] === "MR06" ||
                            $articleParts[1] === "MR08")  && $params['kranz'] == "Halbkranz") {
                        $number -= 1;
                    }

                    $articleParts[1] = "MR0".$number;

                }

            }
            if(count($articleParts) === 5) {
                $result = Shopware()->Db()->fetchRow("SELECT a.id,c.id as dID,a.name,ordernumber,path,categoryID,attr11,attr20,attr21,attr22,attr23,attr6,c.width,c.height,c.weight FROM s_articles a 
                LEFT JOIN s_articles_attributes b 
                ON a.id = b.articleID
                LEFT JOIN s_articles_details c 
                ON a.id = c.articleID
                LEFT JOIN s_articles_img d
                ON a.id = d.articleID
                LEFT JOIN s_media e 
                ON d.media_id = e.id
                LEFT JOIN s_articles_categories f 
                ON a.id = f.articleID
                WHERE attr6 LIKE '%" . $stone . "%' AND attr7 = ? AND attr13 = ? AND attr12 = ?",
                    [$articleParts[3], $articleParts[4], $articleParts[1]." ".$articleParts[2]]);
            } else {
                $result = Shopware()->Db()->fetchRow("SELECT a.id,c.id as dID,a.name,ordernumber,path,categoryID,attr11,attr20,attr21,attr22,attr23,attr6,c.width,c.height,c.weight FROM s_articles a 
                LEFT JOIN s_articles_attributes b 
                ON a.id = b.articleID
                LEFT JOIN s_articles_details c 
                ON a.id = c.articleID
                LEFT JOIN s_articles_img d
                ON a.id = d.articleID
                LEFT JOIN s_media e 
                ON d.media_id = e.id
                LEFT JOIN s_articles_categories f 
                ON a.id = f.articleID
                WHERE attr6 LIKE '%" . $stone . "%' AND attr7 = ? AND attr13 = ? AND attr12 = ?",
                    [$articleParts[2], $articleParts[3], $articleParts[1]]);
            }

            $_SESSION['Shopware'][$result['id']] = $hash;

            $mediaService = Shopware()->Container()->get('shopware_media.media_service');

            $catUrl = Shopware()->Db()->fetchOne("SELECT path FROM s_core_rewrite_urls WHERE org_path = ? AND main = 1", "sViewport=cat&sCategory=" . $result['categoryID']);
            $articleUrl = Shopware()->Db()->fetchOne("SELECT path FROM s_core_rewrite_urls WHERE org_path = ? AND main = 1", "sViewport=detail&sArticle=" . $result['id']);

            if (empty($catUrl)) {
                $catUrl = Shopware()->Router()->assemble(['controller' => 'listing', 'sCategory' => $result['categoryID']]);
            }

            if (empty($articleUrl)) {
                $articleUrl = Shopware()->Router()->assemble(['controller' => 'detail', 'sArticle' => $result['id']]);
            }

            $original = $mediaService->getUrl($result['path']);
            $certificate = str_replace(["image/", ".jpg"], ["image/thumbnails/", "_130x130.jpg"], $mediaService->getUrl($result['path']));
            $small = str_replace(["image/", ".jpg"], ["image/thumbnails/", "_200x200.jpg"], $mediaService->getUrl($result['path']));
            $big = str_replace(["image/", ".jpg"], ["image/thumbnails/", "_800x800.jpg"], $mediaService->getUrl($result['path']));

            if($catUrl === "https://www.ewigetrauringe.de/listing/index/sCategory/") {
                $catUrl = "";
            } else {
                $catUrl = "https://" . Shopware()->Config()->BasePath . "/" . $catUrl;
            }

            if(strtolower($articleUrl) === "https://www.ewigetrauringe.de/detail/index/sarticle/") {
                $articleUrl = "https://www.ewigetrauringe.de/media/image/bd/45/73/artikel-nicht-verfuegbar.jpg";
            } else {
                $articleUrl ="https://" . Shopware()->Config()->BasePath . "/" . strtolower($articleUrl);
            }

            $answer = [
                "articleName" => $result['name'],
                "articleID" => $result['id'],
                "dID" => $result['dID'],
                "ordernumber" => $result['ordernumber'],
                "minWidth" => $result['attr20'],
                "maxWidth" => $result['attr21'],
                "minThickness" => $result['attr22'],
                "maxThickness" => $result['attr23'],
                "categoryUrl" => $catUrl,
                "articleUrl" => $articleUrl,
                "original" => $original,
                "certificate" => $certificate,
                "small" => $small,
                "big" => $big,
                "ct" => str_replace(".",",",$this->getAmountOfCarat($result['attr6'],$result['attr11'])) . "ct.",
                "netCt" => $this->getAmountOfCarat($result['attr6'],$result['attr11']),
                "width" => str_replace(".",",",($result['width'] + 0)),
                "height" => str_replace(".",",",($result['height'] + 0)),
                "weight" => str_replace(".",",",($result['weight'] + 0)),
            ];

            $_SESSION[$params['articleName'] . " " . $params['stone']] = $answer;

        } else {
            $answer = $_SESSION[$params['articleName'] . " " . $params['stone']];
        }

        echo json_encode($answer);

    }

    /**
     * Return the new price for a given configuration
     *
     * @return bool|string
     */
    public function priceAction() {

        $params = $this->Request()->getParams();

        $this->clarity = str_replace("/","-",strtolower($params['clarity']));

        if($params['isVerlobungsring'] === "true") {

            $article = Shopware()->Db()->fetchRow("SELECT a.id, a.name, b.attr5 as profile, b.attr6 as stone, b.attr7 as alloy,
                attr8 as width, weight, attr11 as quantity, attr13 as material, attr14, price,pseudoprice FROM s_articles a LEFT JOIN s_articles_attributes b ON a.id = b.articleID
                LEFT JOIN s_articles_details d ON a.id=d.articleID LEFT JOIN s_articles_prices e ON d.articleID = e.articleID WHERE a.id = ?",$params['articleID']);

            $this->catID = $this->config['vr_catID'];

            $result = $this->calculateVerlobungsring($article['weight'],$article['material'],$article['alloy'],$article['stone'],$article['quantity'],$article['attr14']);

            if(is_array($result)) {
                if($article['pseudoprice'] > 0) {
                    die(var_dump(["dasdasd" => $result[4]]));
                    $percent = $result[4] * (100 - ($article['price'] * 100 / $article['pseudoprice']) / 100);
                } else {
                    $percent = 0;
                }
                $_SESSION[$params['articleID'].'-latestPrice'] = (ceil(($result[4] - $percent) / 5) * 5);
                echo $_SESSION[$params['articleID'].'-latestPrice'];
            }

            return true;

        }

        if($params['isMemoirering'] === "true") {

            $article = Shopware()->Db()->fetchRow("SELECT a.id, a.name, b.attr5 as profile, b.attr6 as stone, b.attr7 as alloy,
                width, d.height, weight, attr11 as quantity, attr13 as material, attr14, price,pseudoprice FROM s_articles a LEFT JOIN s_articles_attributes b ON a.id = b.articleID
                LEFT JOIN s_articles_details d ON a.id=d.articleID LEFT JOIN s_articles_prices e ON d.articleID = e.articleID WHERE d.id = ?",$params['articleID']);

            $this->catID = $this->config['ma_catID'];
            $stone = explode(" / ",$params['stone'])[0];
            $tmpStone = $stone;

            $outerDia = ((int)substr(trim($params['size']),0,2) / pi() + ((((float)$article['height']) * 2))) * pi();

            $factor = 1;

            if(substr($article['attr14'],0,1) === "V") {
                if(substr($article['attr14'],1,1) === "H") {
                    if($params['alloy'] === "925er") {
                        $stone = "Halbkranz";
                    }
                    $factor = 2;
                } else {
                    if($article['attr7'] === "925er") {
                        $stone = "Vollkranz";
                    }
                }
                $gap = 0.2;
            } else {
                if(preg_match("/Kr/",$article['attr14'])) {
                    if(substr($article['attr14'],2,1) === "H") {
                        if($params['alloy'] === "925er") {
                            $stone = "Halbkranz";
                        }
                        $factor = 2;
                    } else {
                        if($article['attr7'] === "925er") {
                            $stone = "Vollkranz";
                        }
                    }
                    $gap = 0.9;
                } else {
                    if(substr($article['attr14'],1,1) === "H") {
                        if($params['alloy'] === "925er") {
                            $stone = "Halbkranz";
                        }
                        $factor = 2;
                    } else {
                        if($article['attr7'] === "925er") {
                            $stone = "Vollkranz";
                        }
                    }
                    $gap = 0;
                }
            }

            $stoneDiameter = Shopware()->Db()->fetchOne("SELECT diameter FROM asf_price_manager_memoire WHERE carat = ?",
                str_replace([",","ct."],[".",""],$tmpStone));

            $stones = floor(floor(($outerDia) / ($stoneDiameter + $gap)) / $factor);

            $article['weight'] = $stones * str_replace(",",".",$article['width']);

            if($factor === 1 && $this->clarity === "zirkonia") {
                $stone = "Vollkranz";
            }
            if($factor === 2 && $this->clarity === "zirkonia") {
                $stone = "Halbkranz";
            }

            $result = $this->calculateMemoirering($article['width']*$article['height'], $article['material'], $params['alloy'],
                (int)$params['profile'], str_replace([",","ct."],[".",""],$stone),$stones,(int)substr(trim($params['size']),0,2));

            if($result === null) {
                die(var_dump($article));
            }

            if (is_array($result)) {
                $price = $result[2];
            } else {
                $price = $result;
            }

            echo json_encode(["price" => $price, "stones" => $stones, "ct" => str_replace(".",",",str_replace([",","ct."],[".",""],$tmpStone)*$stones)]);
            return true;

        }



        $handle = fopen(__DIR__ . "/info.log","a");

        if($params['area'] == "0" && $params['isMemoirering'] === "false") {

            $log = "";
            foreach($params as $key => $val) {

                if($key == "articleID") {
                    $log .= "name:" . Shopware()->Db()->fetchOne("SELECT `name` FROM s_articles WHERE id = ?",$val);
                }
                $log .= $key . ":" . $val . " ";

            }

            fwrite($handle, "[".date("d.m.Y H:i:s")."] " . $log ."\n\n");
            fclose($handle);

            return;
        }

        $_SESSION[$params['articleID'].'-withStones'] = $params['withStones'];

        $this->catID = Shopware()->Db()->fetchOne("SELECT parent FROM s_categories WHERE id = ?",
            Shopware()->Db()->fetchOne("SELECT categoryID FROM s_articles_categories WHERE articleID = ?",$params['articleID']));

        $attr = Shopware()->Db()->fetchRow("SELECT attr6,attr24,price,pseudoprice FROM s_articles_attributes a LEFT JOIN s_articles_prices b ON a.articleID = b.articleID WHERE a.articleID = ?",$params['articleID']);
        $function = $this->identifyStone($attr['attr6']);

        if($params['withStones'] === "false") {
            $function = "calculateMaterial";
        }

        if($function == "calculateTrauringe") {

            $result = $this->$function($params['area'],$params['color'],$params['alloy'],$params['profile'],$attr['attr6'],$this->getAmountOfStones($attr['attr24']));

            if($attr['pseudoprice'] > 0) {
                $percent = $result[4] * (100 - ($attr['price'] * 100 / $attr['pseudoprice'])) / 100;
            } else {
                $percent = 0;
            }
            $_SESSION[$params['articleID'].'-latestPrice'] = (ceil(($result[4] - $percent) / 5) * 5);
            echo $_SESSION[$params['articleID'].'-latestPrice'];

        }

        if($function == "calculateMaterial") {


            $result = $this->$function($params['area'],$params['color'],$params['alloy'],$params['profile'],$attr['attr6']);

            if($attr['percent'] > 0) {
                $percent = $result * (100 - ($result * 100 / $attr['pseudoprice'])) / 100;
            } else {
                $percent = 0;
            }
            $_SESSION[$params['articleID'].'-latestPrice'] = ceil(($result-$percent) / 5) * 5;
            echo ceil(($result) / 5) * 5;

        }

        if($function == "calculateZircon") {

            $result = $this->$function($params['area'],$params['color'],$params['alloy'],$params['profile'],$attr['attr6'],1);

            if($attr['pseudoprice'] > 0) {
                $percent = $result[4] * (100 - ($attr['price'] * 100 / $attr['pseudoprice'])) / 100;
            } else {
                $percent = 0;
            }
            $_SESSION[$params['articleID'].'-latestPrice'] = (ceil(($result[4] - $percent) / 5) * 5);
            echo $_SESSION[$params['articleID'].'-latestPrice'];

        }

    }

    public function uriAction() {

        $params = $this->Request()->getParams();

        $mediaService = Shopware()->Container()->get('shopware_media.media_service');

        if($params['model']) {

            $result = Shopware()->Db()->fetchAll("SELECT c.path FROM s_articles_attributes a LEFT JOIN s_articles_img b ON a.articleID = b.articleID 
                LEFT JOIN s_media c ON b.media_id = c.id WHERE attr12 = ?",$params['model']);

            foreach($result as $entry) {
                echo $mediaService->getUrl($entry['path']) . "<br>";
            }

        }

        if($params['album']) {

            $result = Shopware()->Db()->fetchAll("SELECT path FROM s_media a LEFT JOIN s_media_album b ON a.albumID = b.id WHERE b.name = ?",$params['album']);

            foreach($result as $entry) {
                echo $mediaService->getUrl($entry['path']) . "<br>";
            }

        }

    }

}
