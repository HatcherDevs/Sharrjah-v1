<!-- The Modal -->
<div class="modal" id="searchModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
	<div class="modal-content">
	  <!-- Modal body -->
	  <div class="modal-body" style="position:relative">
		<form action="{{ url('search') }}" method="post">
			<input type="hidden" value="{!! csrf_token() !!}" name="_token">
			<input type="text" placeholder="Search" placeholder=" " name="keyword">
			<input type="submit" value="">
		</form>
	  </div>
	</div>
  </div>
</div>