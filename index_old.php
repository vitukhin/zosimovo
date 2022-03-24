<?php

require_once './simplehtmldom_1_5/simple_html_dom.php'; // библиотека для парсинга

 $html = new simple_html_dom();
 $html->load_file('http://www.sit-company.ru/zosimovo/');
 
 $uch = array();
 $i = 1; 

 //$html->load_file('full.htm');
 
 $ret = $html->find('.plan_product');     
 $j=0;
 foreach ($ret as $ret1) 
 {
 	$uch_num_arr = $ret1->find('.plan_product__name');
 	$uch_num = $uch_num_arr[0]->innertext;
 	$uch_num_int = $uch_num*1;
 	if ($uch_num_int<$j)
 	{
 		$i++;
 	}
 	$uch[$i][$uch_num]['number']=$uch_num;
 	$uch[$i][$uch_num]['coords']=$ret1->style;
	$j = $uch_num_int;
 }   
 
 $arr = array();
 $arr2 = array();
 $handle = fopen("users.txt", "r");
 $i=0;
 while (!feof($handle)) 
 {
 	$buffer = fgets($handle, 4096);
    $arr = explode("-",$buffer);
    $arr2 = explode(";",$arr[2]);

    if (isset($arr[0])&&isset($arr[1])&&isset($arr[2]))
    {
    	$uch[$arr[0]*1][$arr[1]*1]['users'][$i]['name']=$arr2[0];
    	$uch[$arr[0]*1][$arr[1]*1]['users'][$i]['link']=$arr2[1];
    	$i++;
    }
 }
 fclose($handle); 
  
 /*echo '<pre>';  
 	print_r($uch);
 echo '</pre>'; */
  
 $num_och = $_GET['och'];
 if (!intval($num_och))
 {
 	$num_och = 1;
 }
 
             
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>КП Зосимово, <?php echo $num_och; ?>-ая очередь</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
  	<div class="wrapper">      
    	<?php echo '<div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height:'.($num_och == 1 ? '1350' : '1100' ).'px; ">'; ?>
    		<div class="full_width" style="float: left; list-style: none; position: relative; width: 1168px;">
         		<div class="block_content plan">
            		<?php
            		echo '<img src="s'.$num_och.'.jpg" alt="" class="plan_image">';
            		?>
            			
            			<?php 
            			
            			foreach ($uch[$num_och] as $uch1)
            			{

							if (isset($uch1['users']))
							{
            					echo '<div class="plan_product saled" style="'.$uch1['coords'].';">';
                        			echo '<a style="cursor:handler;cursor:pointer;">'.
                            		$uch1['number'].'               
                            		<div class="plan_product__overlay">
                  						<div class="plan_product__wrap">'; 
                  						$j=1;               						
                    					foreach ($uch1['users'] as $uch2)
            							{	
                    					echo '	
                    						<a href="'.$uch2['link'].'" target="_blank">
                    							<div class="plan_product__name">
                    								'.$uch2['name'].'
                    							</div>
                    							<div class="plan_product__image">
                    								<img src="foto.jpg">
                    							</div>
                    						</a>';
                                    		if ((count($uch1['users'])>1) && (count($uch1['users'])>$j))
                                    		{	
                                    			echo '<hr>';
                                    		}
                                    		$j++;
                                    	}
 	
                						echo '	
                						</div>
                					</div>
                					</a>';
              					echo '</div>';
              				}
            			}
            			
            			?>

				</div>
			</div>
		</div>
	</div>	
</body>

</html>