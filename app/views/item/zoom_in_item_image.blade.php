@extends('layouts.popup_master')

@section('content')
	<script>
	
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
						<table align='center' cellspacing='2'>
					    	<?for($j = 0; $j < 8; $j++) {?>
					    		<tr>
									<td align='center' width='65'>
										<?if(sizeof($item_images) > $j) {?>
											<img src='../<?=$item_images[$j]->upload_path?><?=$item_images[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:60px;' />	
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
						<table>
							<tr>
								<td>
									<img src='../<?=$item->upload_path?><?=$item->physical_image_name?>' border='0' align='absmiddle' />
								</td>
							</tr>
						</table>
					</td>
					</tr>	
			</table>
		<p>
  	</div>
  	</form> 
@stop      