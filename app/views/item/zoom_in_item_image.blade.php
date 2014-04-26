@extends('layouts.popup_master')

@section('content')
	<script>
		var item_image_seq = '<?=$item_image_seq?>';

		function changeLargeImage(seq) {
      		item_image_seq = seq;

      		for(var i = 1; i <= 8; i++) {
      			if($('#large_image_' + i).length == 0)
      				continue;

      			if(seq == i)
   					$('#large_image_' + i).attr('style', 'display:block;');
   				else
   					$('#large_image_' + i).attr('style', 'display:none;');
      		}
      	}
	</script>
	<style> 
	    <!--
		fieldset ul, fieldset li{
			border:0; margin:0; padding:0; list-style:none;
		}
		fieldset li{
			clear:both;
			list-style:none;
			padding-bottom:10px;
		}

		fieldset input{
			float:left;
		}
		fieldset label{
			width:120px;
			float:left;
		}
	    -->
   	</style>

	<div class='well'>
	    <p>
	    	<table width='100%' align='center'>
	    		<tr valign='top'>
	    			<td align='center' width='70'>
						<table align='center' cellspacing='2' width='70'>
					    	<?for($j = 0; $j < 8; $j++) {?>
					    		<tr>
									<td align='center' width='65'>
										<?if(sizeof($item_images) > $j) {?>
											<a href='#'><img src='../<?=$item_images[$j]->upload_path?><?=$item_images[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:60px;' onclick='changeLargeImage("<?=$j+1?>");' /></a>	
										<?}else{?>
											<img src='../images/camera.png' border='0' align='absmiddle' style='width:80px;opacity:0.2;filter:alpha(opacity=40);' />
										<?}?>	
									</td>
					    		</tr>
							<?}?>
						</table>
	    			</td>
	    			<td width='10'></td>
					<td align='center' valign='middle'>
						<table width='100%'>
							<?for($j = 0; $j < 8; $j++) {?>
					    		<tr>
									<td align='center' width='100%'>
										<?if(sizeof($item_images) > $j) {?>
											<img id='large_image_<?=$j+1?>' src='../<?=$item_images[$j]->upload_path?><?=$item_images[$j]->physical_image_name?>' border='0' align='absmiddle' style='<?if($j + 1 != $item_image_seq){?>display:none;<?}?>' />	
										<?}?>	
									</td>
					    		</tr>
							<?}?>
						</table>
					</td>
				</tr>	
			</table>
		<p>
  	</div>
  	</form> 
@stop      