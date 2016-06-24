<html>
	<table>


	 <tr>
    @foreach($report as $key => $r)

    		<th align="center" >{{$key}}</th>

    @endforeach
    </tr>
    <tr></tr>
    <?php $endLine = 1;?>
    <?php $count = count($report);?>
	    @foreach($testArray as $key => $r)
	    	@if($endLine > $count)
				<tr></tr>
				<?php $endLine = 1?>
	    	@endif
				<td align="left">{{$r}}</td>

			<?php $endLine++?>
		@endforeach


	</table>
</html>
