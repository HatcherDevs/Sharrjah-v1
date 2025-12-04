<div class="form-group" style="border-top:3px solid #ccc" >
    <br/>
    <strong>Add files</strong>
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-12" id="file-uploads">
            <div class="file-upload card-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            File:
                            <input type="file" class="form-control" name="files[1]" placeholder="Upload Image">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>File name EN:</label>
                            <input type="text" class="form-control" placeholder="Title EN" name="captions[1][EN]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>File name AR:</label>
                            <input type="text" class="form-control" placeholder="Title AR" name="captions[1][AR]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($page->items as $item)
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ $item->title }} <br/>
                                {{ $item->uploads()->first()->original_name }} <br/><br/>
                                Link: {{ asset('/public'.$item->uploads()->first()->path.'/'.$item->uploads()->first()->file_name) }} <br/><br/>
                                <label>Remove file:</label>
                                <input type="checkbox" name="delete[{{ $item->id }}]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="form-group">--}}
{{--                <button class="form-control" id="add-file" type="button">Add more files</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>