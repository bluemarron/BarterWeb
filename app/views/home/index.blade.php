@extends('layouts.master')

@section('content')
	
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
			<i class='icon-plus'></i> 카테고리 : 
			<?for($j = 0; $j < sizeof($root_categories); $j++) {?>
				<i class='icon-th-large'></i> <a href='../home/index?category_code=<?=$root_categories[$j]->code?>'><?=$root_categories[$j]->label?></a>
			<?}?>
		<p>
		<?if(sizeof($categories) > 0) {?>		
	    <p>
			<i class='icon-plus'></i> 현재위치 : 
			<a href='../home/index/'>Home</a>
			<?for($i = 0; $i < sizeof($categories); $i++) {?>
				>> <a href='../home/index?category_code=<?=$categories[$i]["code"]?>'><?=$categories[$i]['label']?></a>
			<?}?>
		<p>
		<?}?>
		<?if(sizeof($child_categories) > 0) {?>		
	    <p>
			<?for($i = 0; $i < sizeof($child_categories); $i++) {?>
				<i class='icon-th'></i>
				<a href='../home/index?category_code=<?=$child_categories[$i]->code?>'><?=$child_categories[$i]->label?></a></a>
			<?}?>
		<p>
		<?}?>
  	</div>
	<div class='well'>
		<p>
			<table width='100%'>
	    		<tr>
	    			<td>
						<i class='icon-ok'></i> 총 <strong><?=sizeof($items)?></strong>개의 상품이 진열되어 있습니다.
					</td>
					<td align='right'>
						<i class='icon-calendar'></i> <a>등록순</a>
						<i class='icon-star-empty'></i> <a>인기순</a>
					</td>
				</tr>
			</table>			
		</p>
	    <p>
	    	<table>
		    	<?for($j = 0; $j < sizeof($items); $j++) {?>
		    		<?if($j % 4 == 0){?><tr><?}?>
					<td align='center'>
						<table>
							<tr>
								<td align='center' width='180' height='200'>
									<a href='../item/view?item_id=<?=$items[$j]->id?>&category_code=<?=$category_code?>'>
									<img src='../<?=$items[$j]->upload_path?><?=$items[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:150px;' />									
									</a>
								</td>
							</tr>
							<tr>
								<td align='center'>
									<a href='../item/view?item_id=<?=$items[$j]->id?>&category_code=<?=$category_code?>'>
									<?=$items[$j]->name?>
									</a>
									<br/><?=$items[$j]->address?>
								</td>
							</tr>	
						</table>	
					</td>
		    		<?if($j % 4 == 3){?></tr><?}?>
				<?}?>
			</table>
		<p>
  	</div>
	


  	</form> 
@stop      