@if(count($page->sliders))
    <div class="form-group" style="border-top:3px solid #ccc">
    <br/>
    <strong>Featured Images</strong>
    <br/><br/>

        <div class="row" id="current-images">
            @foreach($page->sliders as $slide)
                <div class="file-upload">
                    <div class="row">
                        <div class="col-md-6">
                            @if($slide->landscape)
                                <img src="{{ asset('public'.$slide->landscape->url) }}" width="100%">
                                <br/>
                                <br/>
                            @endif
                            @if($slide->square)
                                <img src="{{ asset('public'.$slide->square->url) }}" width="100%">
                            @endif
                            <input type="hidden" name="uploads[{{$slide->landscape->id}}][id]" value="{{ $slide->landscape->id }}" width="100%">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image Caption EN:</label>
                                <input type="text" class="form-control" placeholder="Image Caption EN" name="upload-captions[{{$slide->landscape->id}}][EN]"  value="{{ $slide->landscape->caption }}">
                            </div>
                            <div class="form-group">
                                <label>Image Caption AR:</label>
                                <input type="text" class="form-control" placeholder="Image Caption AR" name="upload-captions[{{$slide->landscape->id}}][AR]"  value="{{ $slide->landscape->caption_ar }}">
                            </div>

                            @if($slide->square)
                                <div class="form-group">
                                    <label>Replace Square:</label>
                                    <input type="file" class="form-control" name="uploads[{{$slide->square->id}}]" placeholder="Upload Image">
                                </div>
                            @else
                                <div class="form-group">
                                    <label>Add Square:</label>
                                    <input type="hidden" name="newUploads[slide_id]" value="{{$slide->id}}">
                                    <input type="file" class="form-control" name="newUploads[square]" placeholder="Upload Image">
                                </div>
                            @endif

                            @if($slide->landscape)
                                <div class="form-group">
                                    <label>Replace Landscape:</label>
                                    <input type="file" class="form-control" name="uploads[{{$slide->landscape->id}}]" placeholder="Upload Image">
                                </div>
                            @else
                                <div class="form-group">
                                    <label>Add Landscape:</label>
                                    <input type="hidden" name="newUploads[slide_id]" value="{{$slide->id}}">
                                    <input type="file" class="form-control" name="newUploads[landscape]" placeholder="Upload Image">
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Remove Slide:<input type="checkbox" class="form-control" name="delete[{{$slide->id}}]" placeholder="Upload Image" value="{{$slide->id}}"></label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif