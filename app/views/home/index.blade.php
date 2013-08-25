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
			<a>Home</a> >> 
			<?for($i = 0; $i < sizeof($categories); $i++) {?>
				<a><a><?=$categories[0]['code']?></a></a>
			<?}?>
		<p>
		<?}?>
  	</div>
	<div class='well'>
	    <p>
			
		<p>
  	</div>
	


  	</form> 
@stop      