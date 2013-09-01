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
	    	<table>
	    		<tr>
			    	<?for($j = 0; $j < sizeof($items); $j++) {?>
						<td align='center' width='170'>
							<a href='#'>
								<img src='../<?=$items[$j]->upload_path?><?=$items[$j]->physical_image_name?>' border='0' align='absmiddle' style='width:150px;height:150px;' />
								<br/>
								<?=$items[$j]->name?>
							</a>
						</td>
					<?}?>
				</tr>
			</table>
		<p>
  	</div>
	


  	</form> 
@stop      