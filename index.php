<?php

 $uch = array(); 
 $arr = array();
 $handle = fopen("areas.txt", "r");

 while (!feof($handle)) 
 {
 	$buffer = fgets($handle, 4096);
    $arr = explode("|",$buffer);
    
	$uch[$arr[0]][$arr[1]]['number']=$arr[1];
 	$uch[$arr[0]][$arr[1]]['coords']=$arr[2];
    
 }
 fclose($handle); 
 
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
            					echo '<div class="plan_product saled" style="'.substr($uch1['coords'],0,strlen($uch1['coords'])-1).'">';
                        			echo chr(10).'<a style="cursor:handler;cursor:pointer;">'.
                            		chr(10).$uch1['number'].chr(10).'               
                            		<div class="plan_product__overlay">'.chr(10).'
                  						<div class="plan_product__wrap">'; 
                  						$j=1;               						
                    					foreach ($uch1['users'] as $uch2)
            							{	
                    					echo chr(10).'	
                    						<a href="'.substr($uch2['link'],0,strlen($uch2['link'])-1).'" target="_blank">'.chr(10).'
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