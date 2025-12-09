<!-- The Modal -->
<div class="modal" id="searchModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
	<div class="modal-content">
	  <!-- Modal body -->
	  <div class="modal-body" style="position:relative">
		<form action="<?php echo e(url('search')); ?>" method="post">
			<input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
			<input type="text" placeholder="Search" placeholder=" " name="keyword">
			<input type="submit" value="">
		</form>
	  </div>
	</div>
  </div>
</div><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/search.blade.php ENDPATH**/ ?>