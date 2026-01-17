<div class="form-group">
    <div class="row ">
        <div class="col-md-12">
            <strong>Addition Button/Link</strong>
            <br />
            <br />
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Text EN:</label>
                <input type="text" class="form-control" placeholder="Submit" name="buttonLink[title]"
                    value="{{ isset($page) && $page->buttonLinks ? $page->buttonLinks->title : '' }}">
            </div>
            <div class="form-group">
                <label>Link EN:</label>
                <input type="text" class="form-control" placeholder="mailto:info@sharjaharchicture.com"
                    name="buttonLink[value]"
                    value="{{ isset($page) && $page->buttonLinks ? $page->buttonLinks->value : '' }}">
            </div>
        </div>
        <div class="col-md-6 text-right">
            <div class="form-group">
                <label>Text AR:</label>
                <input type="text" class="form-control" placeholder="Submit" name="buttonLink[title_ar]"
                    value="{{ isset($page) && $page->buttonLinksAr ? $page->buttonLinksAr->title_ar : '' }}">
            </div>
            <div class="form-group">
                <label>Link AR:</label>
                <input type="text" class="form-control" placeholder="mailto:info@sharjaharchicture.com"
                    name="buttonLink[value_ar]"
                    value="{{ isset($page) && $page->buttonLinksAr ? $page->buttonLinksAr->value_ar : '' }}">
            </div>
        </div>
    </div>
</div>
