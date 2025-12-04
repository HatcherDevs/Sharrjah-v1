<!-- The Modal -->
<div class="modal" id="subscribeModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
	<div class="modal-content">
	  <!-- Modal body -->
	  <div class="modal-body">
		<div id="mc_embed_signup">
            <!-- https://sharjaharchitecture.us12.list-manage.com/subscribe/post?u=5a585772a2245642af776f3f3&amp;id=e15c493039 -->
		<form action="{{ url('subscribe') }}" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div id="mc_embed_signup_scroll">
			<h2>Subscribe to our Mailing List / <span class="ar" style="font-size: 16px;">سجّل لاستلام بريدنا الإلكتروني</span></h2>
		<div class="mc-field-group">
			<label for="mce-EMAIL">Email Address / <span class="ar">البريد الإلكتروني</span></label>
		</label>
			<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
		</div>
		<div class="mc-field-group">
			<label for="mce-FNAME">First Name / <span class="ar">الاسم الأول</span></label>
			<input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
		</div>
		<div class="mc-field-group">
			<label for="mce-LNAME">Last Name / <span class="ar">اسم العائلة</span></label>
			<input type="text" value="" name="LNAME" class="required" id="mce-LNAME">
		</div>
		<div class="mc-field-group">
			<label for="mce-MMERGE5">City /<span class="ar"> المدينة</span></label>
		</label>
			<input type="text" value="" name="MMERGE5" class="required" id="mce-MMERGE5">
		</div>
		<div class="mc-field-group">
			<label for="mce-MMERGE6">Affiliation / <span class="ar">الإنتساب </span></label>
		</label>
			<select name="MMERGE6" class="required" id="mce-MMERGE6">
				<option value=""></option>
				<option value="Academia / المجال الأكاديمي">Academia / <span class="ar">المجال الأكاديمي</span></option>
				<option value="Research Institution / مؤسسة أبحاث">Research Institution / مؤسسة أبحاث</option>
				<option value="Architecture Firm / شركة معمارية">Architecture Firm / شركة معمارية</option>
				<option value="Independent Architect / معماري مستقل">Independent Architect / معماري مستقل</option>
				<option value="Independent Artist / فنان مستقل">Independent Artist / فنان مستقل</option>
				<option value="Art and Cultural Institution / هيئة فنية و ثقافية">Art and Cultural Institution / هيئة فنية و ثقافية</option>
				<option value="Government Department / هيئة حكومية">Government Department / هيئة حكومية</option>
				<option value="Media / الإعلام">Media / الإعلام</option>
				<option value="Development / مجال التطوير">Development / مجال التطوير</option>
				<option value="Real Estate / العقارات">Real Estate / العقارات</option>
				<option value="Architecture Enthusiast / شغوف بالعمارة">Architecture Enthusiast / شغوف بالعمارة</option>
			</select>
		</div>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			<div class="clear"><input type="submit" value="Subscribe / سجّل" name="subscribe" class="button"></div>
			</div>
		</form>
		</div>
		<!--End mc_embed_signup-->
	  </div>
	</div>
  </div>
</div>
