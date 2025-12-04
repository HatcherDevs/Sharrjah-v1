<div class="row">
    @if (Session::has('error'))
        <div class="col-md-12 grid-margin stretch-card">
            <div class="alert alert-info">{{ Session::get('error') }}</div>
        </div>
    @endif

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">English</h4>
                <div class="form-group">
                    <label for="exampleInputNamea1">Title</label>
                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" required value="{{ isset($page) ? $page->title : '' }}">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" placeholder="External link" name="description" value="{{ isset($page) ? $page->description : '' }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Arabic</h4>
                <div class="form-group">
                    <label for="exampleInputNamea1">Title</label>
                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title_ar" required value="{{ isset($page) ? $page->title_ar : '' }}">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" placeholder="External link" name="description_ar" value="{{ isset($page) ? $page->description_ar : '' }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @include('admin.presskits.file-form')
            </div>
        </div>
    </div>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @include('admin.partials.posts.publish-date')

                <div class="form-group">
                    <label for="exampleInputNamea1">Username</label>
                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="username" required value="{{ isset($page) ? $page->username : '' }}">
                </div>

                <div class="form-group">
                    <label for="exampleInputNamea1">Password</label>
                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="password" required value="{{ isset($page) ? $page->password : '' }}">
                </div>

                <button type="submit" class="btn btn-success mr-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
            </div>
        </div>
    </div>
</div