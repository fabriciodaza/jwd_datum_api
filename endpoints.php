<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//--- INI :: API endpoints ---------------------------------------------------------------------------
    //http://localhost/srvr_jwd/hurricanefabric/webutils/apiserver/hello01/fabricio
    $app->get('/hello01/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");

        return $response;
    });
    
    //http://localhost/srvr_jwd/datum/apiserver/posttest
    //$app->post('/posttest', function (Request $request, Response $response, array $args) {
    $app->get('/showposts', function (Request $request, Response $response, array $args) {
        try{
            $name = $request->getParam('name');
            $email = $request->getParam('email');

            $dbObj = new dbConn();
            //$qry = 'select `ID`, `post_author`, `post_title`, `post_type` from `wp_posts` order by `ID` desc limit 3;';
            $qry = 'select `ID`, `post_author`, `post_title`, `post_type` from `wp_posts` where `post_type`="product";';
            $data_arr = array();
            $dblink = $dbObj->connect();
            $stmt	= $dblink->prepare($qry);
            $stmt->execute();
            if($stmt->rowCount()>0):
                while($data = $stmt->fetch(PDO::FETCH_ASSOC)):
                    //echo "<pre>"; print_r($data); echo "</pre>";
                    $data_arr[] = $data;
                endwhile;
            endif;
            
            echo json_encode($data_arr);
        }
        catch(Exception $e){
            die('Error: ' . $e->GetMessage() );
        }
        finally{
            $dblink = null;
        }

    });

    //http://localhost/srvr_jwd/datum/apiserver/wccreateproduct
    //$app->post('/wccreateproduct', function (Request $request, Response $response, array $args){
    $app->get('/wccreateproduct', function (Request $request, Response $response, array $args){
        //$name = $request->getParam('name'); $request->getAttribute('name'); //$args['name'];
        //$email = $request->getParam('email'); $request->getAttribute('email'); //$args['email'];
        if( 1 == 2 ){
            echo 'hola';
        }
        else{

            //--- INI :: Get POST Data -------------------------------------------------------
                $useRealData = false;
                if( $useRealData ){
                    $user_id = $request->getParam('user_id');
                    $_fabricname = $request->getParam('fabricname');

                    $_usrInfo01 = $request->getParam('usrInfo01');
                    $_usrInfo02 = $request->getParam('usrInfo02');
                    $_streetaddr = $request->getParam('streetaddr');
                    $_city = $request->getParam('city');
                    $_state = $request->getParam('state');
                    $_zip = $request->getParam('zip');
                    $_pressures = $request->getParam('pressures');
                    $_county = $request->getParam('county');
                    $_wspeed = $request->getParam('wspeed');
                    $_wfront = $request->getParam('wfront');
                    $_roofType = $request->getParam('roofType');
                    $_roofheight = $request->getParam('roofheight');
                    $_dimension = $request->getParam('dimension');
                    $_prodsqf = $request->getParam('prodsqf');
                    $_pprice = $request->getParam('pprice');

                    $_qty = $request->getParam('qty');
                    $_fabric_color = $request->getParam('fabric_color');
                    $_substrate = $request->getParam('substrate');
                    $_within = $request->getParam('within');
                    $_attach = $request->getParam('attach');
                    $_anchor_type = $request->getParam('anchor_type');
                    $_opening_desc = $request->getParam('opening_desc');
                    $_width = $request->getParam('width');
                    $_height = $request->getParam('height');
                    $_clip_num = $request->getParam('clip_num');
                    $_prod_spacing = $request->getParam('prod_spacing');
                    $_windp_pos = $request->getParam('windp_pos');
                    $_windp_neg = $request->getParam('windp_neg');
                    $_sqf = $request->getParam('sqf');
                    $_prod_price = $request->getParam('prod_price');
                    $_include_anchors = $request->getParam('include_anchors');
                }
                else{
                    //$user_id = 2;
                    $user_id = 1; //user = devadmin
                    $_fabricname = 'AstroFlex'; //'AstroGuard';

                    $_usrInfo01 = "Fabricio Daza";
                    $_usrInfo02 = 'fab@gmail.com';
                    $_streetaddr = '234 Seabreeze Circle';
                    $_city = 'Jupiter';
                    $_state = 'FL';
                    $_zip = '33477';
                    $_pressures = 'no';
                    $_county = 'FL17661';
                    $_wspeed = '150';
                    $_wfront = 'yes';
                    $_roofType = 'gable';
                    $_roofheight = '180';
                    $_dimension = '600';
                    $_prodsqf = '208.33';
                    $_pprice = '1354.88';

                    $_qty = '1,2';
                    $_fabric_color = 'Tan,Tan';
                    $_substrate = 'Solid Concrete,Solid Concrete';
                    $_within = 'no,no';
                    $_attach = 'y,y';
                    $_anchor_type = 'Concrete Flush (Short),Concrete Flush (Short)';
                    $_opening_desc = '1,2';
                    $_width = '100,100';
                    $_height = '100,100';
                    $_clip_num = '22,44';

                    $_prod_spacing = '9,9';
                    $_windp_pos = '25.719009525307,25.719009525307';
                    $_windp_neg = '-28.21269161045,-28.212691610451';
                    $_sqf = '69.44,138.89';
                    $_prod_price = '451.63,903.26';
                    $_include_anchors = 'y,y';
                }
            //--- END :: Get POST Data -------------------------------------------------------

            //--- INI :: Get arrays (topform and bottomform) -------------------------------------------------
                $tform_arr = get_topform_arr($_usrInfo01, $_usrInfo02, $_streetaddr, $_city, $_state, $_zip, $_pressures, $_county, $_wspeed, $_wfront, $_roofType, $_roofheight, $_dimension, $_prodsqf, $_pprice);
                $tform_json01 = json_encode($tform_arr); //if($ddebug) echo $tform_json01."<br /><br /><br />";
                $tform_json01 = addslashes( $tform_json01 ); //htmlspecialchars( addslashes( $tform_json01 ) );
            
                $bform_arr = get_bottomform_arr($_qty, $_fabric_color, $_substrate, $_within, $_attach, $_anchor_type, $_opening_desc, $_width, $_height, $_clip_num, $_prod_spacing, $_windp_pos, $_windp_neg, $_sqf, $_prod_price, $_include_anchors);
                $bform_json = json_encode($bform_arr);
            //--- END :: Get arrays (topform and bottomform) -------------------------------------------------

            //--- INI :: Get other info ----------------------------------------------------------------------
                $subprod = 0;
                $ran = gen_random_str(5);
                $curdate = date('ymdHis');
                $_sku = "HF_".$ran."_".$curdate; //if($ddebug) echo "SKU: ".$_sku."<br />";
            //--- END :: Get other info ----------------------------------------------------------------------

            //--- Var set -----------------------------------------------------------------------------
                $post_ids = array();


            foreach( $bform_arr as $singleprod ):
                $subprod++;
                $_form2JSON = json_encode($singleprod); //if($ddebug) echo $_form2JSON."<br /><br />";
                $_form2JSON = addslashes( $_form2JSON ); //htmlspecialchars( addslashes( $_form2JSON ) );
                $openingName = $_fabricname." ".$singleprod['width']." x ".$singleprod['height']." ".$singleprod['fabric_color']; //if($ddebug) echo "openingName: ".$openingName."<br />";
                $openingSKU = $_sku."_".$subprod; //if($ddebug) echo "openingSKU: ".$openingSKU."<br />";
                $openingPrice = $singleprod['opening_price'] / $singleprod['quantity']; //if($ddebug) echo "openingPrice: ".$openingPrice."<br />";
                $opening_clip_num = $singleprod['clip_num'] / $singleprod['quantity'] ; //if($ddebug) echo "opening_clip_num: ".$opening_clip_num."<br />";
                
                //--- INI :: Calculate opening weight -----------------------------------------------------------
                    $fabricWeight = calculate_fabric_weight($singleprod['width'], $singleprod['height']); //if($ddebug) echo "fabricWeight: ".$fabricWeight."<br />";
                    $clipsWeight = calculate_clips_weight($opening_clip_num); ////if($ddebug) echo "clipsWeight: ".$clipsWeight."<br />";
                    if( $singleprod['include_anchors'] == 'y' ):
                        $anchorWeight = calculate_anchors_weight($singleprod['clip_num'], $singleprod['anchor_type']); ////if($ddebug): echo "anchorWeight ".$anchorWeight."<br />"; endif;
                    else:
                        $anchorWeight = 0; ////if($ddebug) echo "anchorWeight: ".$anchorWeight."<br />";
                    endif;

                    $openingWeight = $clipsWeight + $anchorWeight + $fabricWeight; ////if($ddebug) echo "openingWeight: ".$openingWeight."<br />";
                //--- END :: Calculate opening weight -----------------------------------------------------------
                
                //--- INI :: Calculate opening dimensions -------------------------------------------------------
                    $openingLength = calculate_length($singleprod['width'], $singleprod['height']); //if($ddebug) echo "openingLength: ".$openingLength."<br />";
                    $openingWidth = 12; //if($ddebug) echo "openingWidth: ".$openingWidth."<br />";
                    $openingHeight = 12; //if($ddebug) echo "openingHeight: ".$openingHeight."<br />";
                //--- END :: Calculate opening dimensions -------------------------------------------------------

                //--- INI :: built opening description ----------------------------------------------------------
                    if( 1 == 1 ):
                        $_usrInfo01a = htmlspecialchars( addslashes( $_usrInfo01 ) );
                        $newline = "\r\n";
                        $openingDescription = '';
                        $openingDescription .= 'PRODUCT SUMMARY'.$newline;
                        $openingDescription .= '============= ============= ============= ============='.$newline;
                        $openingDescription .= 'Name: '. $_usrInfo01a.$newline;
                        $openingDescription .= 'Email: '. $_usrInfo02.$newline;
                        $openingDescription .= '============= ============= ============= ============='.$newline;
                        $openingDescription .= 'Address: '.$tform_arr['street_address']." ".$tform_arr['city'].", ".$tform_arr['state']." ".$tform_arr['zip'].$newline;
                        $openingDescription .= 'pressures: '.$tform_arr['pressures'].$newline;
                        $openingDescription .= 'county: '.$tform_arr['county'].$newline;
                        $openingDescription .= 'Wind speed: '.$tform_arr['wind_speed'].$newline;
                        $openingDescription .= 'Waterfront: '.$tform_arr['waterfront'].$newline;
                        $openingDescription .= 'Roof Type: '.$tform_arr['roof_type'].$newline;
                        $openingDescription .= 'Mean Roof Height: '.$tform_arr['roof_height'].$newline;
                        $openingDescription .= 'Min Building Dimension: '.$tform_arr['dimension'].$newline;
                        $openingDescription .= 'Product_sqf: '.$tform_arr['product_sqf'].$newline;
                        $openingDescription .= 'Product_price: '.$tform_arr['product_price'].$newline.$newline;
                        $openingDescription .= '============= ============= ============= ============='.$newline;
                        $openingDescription .= 'Quantity: '.$singleprod['quantity'].$newline;
                        $openingDescription .= 'Fabric color: '.$singleprod['fabric_color'].$newline;
                        $openingDescription .= 'Substrate: '.$singleprod['substrate'].$newline;
                        $openingDescription .= 'Within 3 feet: '.$singleprod['within_3_feet'].$newline;
                        $openingDescription .= 'Attachment sides: '.$singleprod['attachment_sides'].$newline;
                        $openingDescription .= 'Anchor type: '.$singleprod['anchor_type'].$newline;
                        $openingDescription .= 'Opening desc: '.$singleprod['opening_desc'].$newline;
                        $openingDescription .= 'Width: '.$singleprod['width'].$newline;
                        $openingDescription .= 'Height: '.$singleprod['height'].$newline;
                        $openingDescription .= 'Number of clips: '.$singleprod['clip_num'].$newline;
                        $openingDescription .= 'Spacing: '.$singleprod['spacing'].$newline;
                        $openingDescription .= 'Wind pressure pos: '.$singleprod['wind_pressure_pos'].$newline;
                        $openingDescription .= 'wind pressure neg: '.$singleprod['wind_pressure_neg'].$newline;
                        $openingDescription .= 'SQF: '.$singleprod['sqf'].$newline;
                        $openingDescription .= 'Opening price: '.$singleprod['opening_price'].$newline;
                        $openingDescription .= 'Include anchors: '.$singleprod['include_anchors'].$newline;
                    endif;
                //--- END :: built opening description ----------------------------------------------------------

                //--- INI :: built opening Json data (20180831-Fri) ---------------------------------------------
                    if( 1 == 1 ):
                        $openingJsonData = "[".$tform_json01.",".$_form2JSON."]"; 
                        //if($ddebug) echo $openingJsonData."<br />";
                    endif;
                //--- END :: built opening Json data (20180831-Fri) ---------------------------------------------
                
                //--- INI :: create WC Product ------------------------------------------------------------------
                    $post_name = get_valid_post_name($openingName); //if($ddebug) echo "post_name: ".$post_name."<br />";
                    $next_post_name = get_next_postname($post_name); //if($ddebug) echo "next_post_name: ".$next_post_name."<br />";
                    $post_id = create_wp_post_product($user_id, $openingName, $openingDescription, $next_post_name);
                    create_wp_term_relationships($post_id);
                    create_wp_postmeta($post_id, $openingPrice, $openingWeight, $openingLength, $openingWidth, $openingHeight, $openingSKU, $openingJsonData);
                    $post_ids[] = $post_id;
                //--- END :: create WC Product ------------------------------------------------------------------

                //if($ddebug) echo "<hr />";
            endforeach;
            
            echo json_encode($post_ids);
        }
    });
//--- END :: API endpoints ---------------------------------------------------------------------------

//--- INI :: Utils Functions -------------------------------------------------------------------------
    //--- Create WC product utils-------------------------------------------------------------------
    function get_topform_arr($_usrInfo01, $_usrInfo02, $_streetaddr, $_city, $_state, $_zip, $_pressures, $_county, $_wspeed, $_wfront, $_roofType, $_roofheight, $_dimension, $_prodsqf, $_pprice){
        $_arr01 = array(
            //"address" => $_address,
            "name" => $_usrInfo01,
            "email" => $_usrInfo02,
            "street_address" => $_streetaddr,
            "city" => $_city,
            "state" => $_state,
            "zip" => $_zip,
            "pressures" => $_pressures,
            "county" => $_county,
            "wind_speed" => $_wspeed,
            "waterfront" => $_wfront,
            "roof_type" => $_roofType,
            "roof_height" => $_roofheight,
            "dimension" => $_dimension,
            "product_sqf" => $_prodsqf,
            "product_price" => $_pprice
        );
        return $_arr01;
    }

    function get_bottomform_arr($_qty, $_fabric_color, $_substrate, $_within, $_attach, $_anchor_type, $_opening_desc, $_width, $_height, $_clip_num, $_prod_spacing, $_windp_pos, $_windp_neg, $_sqf, $_prod_price, $_include_anchors){
	
        $arr_qty = explode(",", $_qty);
        $arr_fabric_color = explode(",", $_fabric_color);
        $arr_substrate = explode(",", $_substrate);
        $arr_within = explode(",", $_within);
        $arr_attach = explode(",", $_attach);
        $arr_anchor_type = explode(",", $_anchor_type);
        $arr_opening_desc = explode(",", $_opening_desc);
        $arr_width = explode(",", $_width);
        $arr_height = explode(",", $_height);
        $arr_clip_num = explode(",", $_clip_num);
        
        $arr_prod_spacing = explode(",", $_prod_spacing);
        $arr_windp_pos = explode(",", $_windp_pos);
        $arr_windp_neg = explode(",", $_windp_neg);
    
        $arr_sqf = explode(",", $_sqf);
        $arr_prod_price = explode(",", $_prod_price);
        
        $arr_include_anchors = explode(",", $_include_anchors);
    
        $arr = array();
        $c = count($arr_qty);
        for($i=0;$i<$c; $i++):
            $arr[$i] = array(
                    "quantity" => $arr_qty[$i],
                    "fabric_color" => $arr_fabric_color[$i],
                    "substrate" => $arr_substrate[$i],
                    "within_3_feet" => $arr_within[$i],
                    "attachment_sides" => $arr_attach[$i],
                    "anchor_type" => $arr_anchor_type[$i],
                    "opening_desc" => $arr_opening_desc[$i],
                    "width" => $arr_width[$i],
                    "height" =>$arr_height[$i],
                    "clip_num" => $arr_clip_num[$i],
                    
                    "spacing" => $arr_prod_spacing[$i],
                    "wind_pressure_pos" => $arr_windp_pos[$i],
                    "wind_pressure_neg" => $arr_windp_neg[$i],
    
                    "sqf" => $arr_sqf[$i],
                    "opening_price" => $arr_prod_price[$i],
                    "include_anchors" => $arr_include_anchors[$i]
                );
        endfor;
    
        return $arr;
    }

    function gen_random_str($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function calculate_fabric_weight($w, $h){
        $sqf_inch = 144;
        //$v = 0.100;
        $v = 0.096;
        $sqf = 0;
        $weight = 0;
        $sqf = (($w * $h) / $sqf_inch);
        $weight =  $sqf * $v;
        $weight = ceil($weight);
        return $weight; 
    }

    function calculate_clips_weight($_clip_num){

        //$weight = 0.010;
        $weight = 0.097;
        $totalWeight = 0;
        if( $_clip_num >= 0 ):
            $totalWeight = $_clip_num * $weight;
        endif;
        
        return $totalWeight;
    }

    function get_anchor_type_weight($anchor_type){
        $weight = 0;
    
        if( $anchor_type == "Male Panelmate 2 1/4" ):
            $weight = 0.055;
        elseif( $anchor_type == "Male Panelmate 3 1/4" ):
            $weight = 0.060;
        elseif( $anchor_type == "Male Panelmate 4 1/2" ):
            $weight = 0.075;
        elseif( $anchor_type == "Male Panelmate 5 1/2" ):
            $weight = 0.085;
        elseif( $anchor_type == "Male Panelmate TVAS 7 3/8" ):
            $weight = 0.105;
        elseif( $anchor_type == "Female Panelmate 2 5/8" ):
            $weight = 0.080;
        elseif( $anchor_type == "Female Panelmate 3 1/4" ):
            $weight = 0.085;
        elseif( $anchor_type == "Female Panelmate 4 1/2" ):
            $weight = 0.100;
        elseif( $anchor_type == "Female Panelmate 5 1/2" ):
            $weight = 0.110;
        elseif( $anchor_type == "Female Panelmate TVAS 7 3/8" ):
            $weight = 0.130;
        elseif( $anchor_type == "Concrete Flush (Short)" ):
            $weight = 0.065;
        elseif( $anchor_type == "Concrete Flush (Long)" ):
            $weight = 0.070;
        endif;
        return $weight;
    }

    function calculate_anchors_weight($_clip_num, $_anchor_type){
        $totalWeight = 0;
        $w = 0;
    
        $w = get_anchor_type_weight($_anchor_type);
        $totalWeight = $_clip_num * $w;
        
        return $totalWeight;
    }

    function calculate_length($w, $h){
        $sqf_inch = 144;
        $v = 0.045;
        $sqf = 0;
        $length = 0;
        $sqf = (($w * $h) / $sqf_inch);
        $length =  $sqf * $v;
        $length = ceil($length);
        return $length;
    }

    function get_valid_post_name($post_title){
        $post_name = str_replace(" ", "-", $post_title);
        $post_name = strtolower($post_name);
        return $post_name;
    }
    
    function get_next_postname($post_name){
        try{

            //$postName = 

            $dbObj = new dbConn();
            $dblink = $dbObj->connect();            
            //--- Get the last post_name based on the post_title ---------------------
                $qry = "select `ID`, `post_title`, `post_name` from `wp_posts` where `post_name` like '".$post_name."%' order by `ID` desc limit 1";
                $stmt = $dblink->prepare($qry);
                $stmt->execute();

                $last_post_name = '';
                if($stmt->rowCount()>0 ):
                    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ):
                        //echo $row['ID']." :: ".$row['post_title']." :: ".$row['post_name']."<br />";
                        $last_post_name = $row['post_name'];
                    endwhile;

                    $name_arr = explode("-", $last_post_name);
                    //echo "<pre>"; print_r($name_arr); echo "</pre>";
                    $postfix = end($name_arr);
                    if( strtolower($postfix) == 'tan' || strtolower($postfix) == 'white' ):
                        $postfix = 1;
                    endif;
                else:
                    $postfix = 1;
                endif;
                $postfix++;
                
            //--- get the next valid post_name ---------------------------------------
                $name_ok = false;
                while($name_ok === false ):
                    $next = $post_name.'-'.$postfix;
                    $qry = "select * from `wp_posts` where post_name = '".$next."'"; 
                    //echo $next."<br />";
                    $stmt = $dblink->prepare($qry);
                    $stmt->execute();
                    if($stmt->rowCount()>0):
                        $postfix++;
                    else:
                        $name_ok = true;
                    endif;
                endwhile;
                
            
            //$next_post_name = $post_name."-".$postfix;
            $next_post_name = $next;

            return $next_post_name;
        }
        catch(Exception $e){
            die('Error: ' . $e->GetMessage() );
        }
        finally{
            $dblink = null;
        }
    }

    function create_wp_post_product($user_id, $title, $content, $next_post_name){
        try{
            //--- Set the variables ------------------------------------------------------
                if( $_SERVER['SERVER_NAME'] == 'localhost' ):
                    $base_url = 'http://localhost/srvr_jwd/datum/product/';
                elseif( $_SERVER['SERVER_NAME'] == 'v2.hurricanefabric.com' ):
                    $base_url = 'https://v2.hurricanefabric/product/';
                elseif( $_SERVER['SERVER_NAME'] == 'www.hurricanefabric.com' || $_SERVER['SERVER_NAME'] == 'hurricanefabric.com' ):
                    $base_url = 'https://www.hurricanefabric/product/';
                endif;

                $date1 = date("Y-m-d H:i:s");
                $date2 = date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($date1)));
                $post_author=$user_id;
                $post_date = $date1;
                $post_date_gmt = $date2;
                $post_content = $content;
                $post_title = $title;
                $post_excerpt = "";
                $post_status = "publish";
                $comment_status = "open";
                $ping_status = "closed";
                $post_password = "";
                $post_name = $next_post_name;
                $to_ping = "";
                $pinged = "";
                $post_modified = $date1;
                $post_modified_gmt = $date2;
                $post_content_filtered = "";
                $post_parent = 0;
                $guid = $base_url.$next_post_name."/"; //[http://localhost/srvr_jwd/hurricanefabric/product/$openingName(-95)/]
                $menu_order = 0;
                $post_type = "product";
                $post_mime_type = "";
                $comment_count = 0;
            
            //--- Insert WC Product ------------------------------------------------------
                $dbObj = new dbConn();
                $qry = "INSERT INTO `wp_posts`(`post_author`, `post_date`, `post_date_gmt`, `post_content`,     `post_title`,     `post_excerpt`,     `post_status`,     `comment_status`,    `ping_status`,      `post_password`,     `post_name`,     `to_ping`,     `pinged`,     `post_modified`,     `post_modified_gmt`,     `post_content_filtered`,     `post_parent`,     `guid`,     `menu_order`,     `post_type`,     `post_mime_type`,     `comment_count`) 
                        VALUES ('".$post_author."','".$post_date."','".$post_date_gmt."','".$post_content."','".$post_title."','".$post_excerpt."','".$post_status."','".$comment_status."','".$ping_status."','".$post_password."','".$post_name."','".$to_ping."','".$pinged."','".$post_modified."','".$post_modified_gmt."','".$post_content_filtered."','".$post_parent."','".$guid."','".$menu_order."','".$post_type."','".$post_mime_type."','".$comment_count."')";
                $dblink = $dbObj->connect();
                $stmt = $dblink->prepare($qry);
                $stmt->execute();
                $lastId = $dblink->lastInsertId();

                return $lastId;
        }
        catch(Exception $e){
            die('Error: ' . $e->GetMessage() );
        }
        finally{
            $dblink = null;
        }
    }

    function create_wp_term_relationships($post_id){
        try{
            $prod_type = 3;
            $prod_cat  = 17;
            $dbObj = new dbConn();
            $qry = "insert into `wp_term_relationships`(`object_id`,`term_taxonomy_id`,`term_order`) values (".$post_id.", ".$prod_type.", 0),(".$post_id.", ".$prod_cat.", 0)";
            $dblink = $dbObj->connect();
            $stmt = $dblink->prepare($qry);
            $stmt->execute();
        }
        catch(Exception $e){
            die('Error: ' . $e->GetMessage() );
        }
        finally{
            $dblink = null;
        }
    }

    function create_wp_postmeta($post_id, $openingPrice, $openingWeight, $openingLength, $openingWidth, $openingHeight, $openingSKU, $openingJsonData){
        try{
            $dbObj = new dbConn();

            $qry = "";
            $qry .= "INSERT INTO `wp_postmeta`(`post_id`, `meta_key`, `meta_value`) VALUES ";
            $qry .= "(".$post_id.", '_visibility', 'visible'),";
            $qry .= "(".$post_id.", '_stock_status', 'instock'),";
            $qry .= "(".$post_id.", 'total_sales', '0' ),";
            $qry .= "(".$post_id.", '_downloadable', 'no' ),";
            $qry .= "(".$post_id.", '_virtual', 'no' ),";
            $qry .= "(".$post_id.", '_regular_price', '".$openingPrice."' ),";
            $qry .= "(".$post_id.", '_sale_price', '' ),";
            $qry .= "(".$post_id.", '_purchase_note', '' ),";
            $qry .= "(".$post_id.", '_featured', 'no' ),";
            $qry .= "(".$post_id.", '_weight', '".$openingWeight."' ),";
            $qry .= "(".$post_id.", '_length', '".$openingLength."' ),";
            $qry .= "(".$post_id.", '_width', '".$openingWidth."' ),";
            $qry .= "(".$post_id.", '_height', '".$openingHeight."' ),";
            $qry .= "(".$post_id.", '_sku', '".$openingSKU."' ),";
            $qry .= "(".$post_id.", '_product_attributes', 'a:0:{}' ),";
            $qry .= "(".$post_id.", '_sale_price_dates_from', '' ),";
            $qry .= "(".$post_id.", '_sale_price_dates_to', '' ),";
            $qry .= "(".$post_id.", '_price', '".$openingPrice."' ),";
            $qry .= "(".$post_id.", '_sold_individually', '' ),";
            $qry .= "(".$post_id.", '_manage_stock', 'no' ),";
            $qry .= "(".$post_id.", '_backorders', 'no' ),";
            $qry .= "(".$post_id.", '_stock', '' ),";
            $qry .= "(".$post_id.", '_dprod_data', '".$openingJsonData."'),";
            $qry .= "(".$post_id.", '_wc_review_count', '0'),";
            $qry .= "(".$post_id.", '_wc_rating_count', 'a:0:{}'),";
            $qry .= "(".$post_id.", '_wc_average_rating', '0');";
            
            $dblink = $dbObj->connect();
            $stmt = $dblink->prepare($qry);
            $stmt->execute();

        }
        catch(Exception $e){
            die('Error: ' . $e->GetMessage() );
        }
        finally{
            $dblink = null;
        }
    }
//--- END :: Utils Functions -------------------------------------------------------------------------