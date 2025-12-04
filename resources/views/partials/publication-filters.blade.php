<form action="{{ url('pages/'.$page->parent->slug.'/conditions') }}" method="get" id="sort-form">

    @if($_GET['lang']=='ar')
        <input type="hidden" value="ar" name="lang">
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="select-style {{ $_GET['lang'] == 'ar' ? 'ar' : ''  }}">
                <select class="form-control filter-select" id="sort" name="sort">
                    <option value="publish_date" {{ $_GET['sort'] == 'publish_dae' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'رتب حسب التاريخ' : 'Sort by Date' }}</option>
                    <option value="title" {{ $_GET['sort'] == 'title' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'الترتيب حسب عنوان' : 'Sort by Title' }}</option>
                    <option value="author" {{ $_GET['sort'] == 'author' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'الترتيب حسب المؤلف' : 'Sort by Author' }}</option>
                    <option value="publication" {{ $_GET['sort'] == 'publication' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'الترتيب حسب اسم المنشور' : 'Sort by Publication Name' }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ $_GET['lang'] == 'ar' ? 'ar' : ''  }}">
                <select class="form-control filter-select" id="order" name="order">
                    <option value="ASC" {{ $_GET['order'] == 'ASC' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'تصاعدي' : 'Ascending' }}</option>
                    <option value="DESC" {{ $_GET['order'] == 'DESC' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'تنازلي' : 'Descending' }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ $_GET['lang'] == 'ar' ? 'ar' : ''  }}">
                <select class="form-control filter-select" id="publication" name="publication">
                    <option value="all" {{ $_GET['publication'] == 'All Publications' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'جميع المنشورات' : 'All Publications' }}</option>
                    @foreach($publications as $publication)
                        <option value="{{$publication->publication}}" {{ $_GET['publication'] == $publication->publication ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? $publication->publication_ar : $publication->publication }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 {{ $_GET['lang']=='ar' ? 'text-right' : 'text-left' }}">
            <input type="submit" value="{{ $_GET['lang']=='ar' ? 'اشترك' : 'SUBMIT' }}" style="width:auto;">
        </div>
    </div>
</form>
