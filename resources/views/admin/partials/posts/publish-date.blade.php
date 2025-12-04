<div class="form-group">
    <label>Publish date</label>
    <?php
    $date = \Carbon\Carbon::now()->format('m/d/y');

    if(isset($page))
        if($page->publish_date)
            $date = $page->publish_date->format('m/d/y');
    ?>
    <input type="text" class="form-control datetimepicker" readonly placeholder="" name="publish_date" value="{{ $date }}">
</div>