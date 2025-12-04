<form action="{{ url('pages/'.$page->parent->slug.'/architecture-plus') }}" method="get" id="sort-form">

    @if($_GET['lang']=='ar')
        <input type="hidden" value="ar" name="lang">
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="select-style {{ $_GET['lang'] == 'ar' ? 'ar' : ''  }}">
                <select class="form-control filter-select" id="sort" name="sort">
                    <option value="title" {{ $_GET['sort'] == 'title' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'التصنيف بحسب العنوان' : 'Sort by Title' }}</option>
                    <option value="speaker" {{ $_GET['sort'] == 'speaker' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'التصنيف بحسب المتحدث' : 'Sort by Speaker' }}</option>
                    <option value="series" {{ $_GET['sort'] == 'series' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'التصنيف بحسب السلسلة' : 'Sort by Series' }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ $_GET['lang'] == 'ar' ? 'ar' : ''  }}">
                <select class="form-control filter-select" id="order" name="order">
                    <option value="ASC" {{ $_GET['order'] == 'ASC' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'من الأقدم إلى الأحدث' : 'Ascending' }}</option>
                    <option value="DESC" {{ $_GET['order'] == 'DESC' ? 'selected' : ''  }}>{{ $_GET['lang'] == 'ar' ? 'من الأحدث إلى الأقدم' : 'Descending' }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ $_GET['lang'] == 'ar' ? 'ar' : ''  }}">
                <select class="form-control filter-select" id="publication" name="series">
                    <option value="all" {{ $_GET['series'] == 'all' ? 'selected' : ''  }} {{ !isset($_GET['series']) ? 'selected' : ''  }}>{{ isset($_GET['lang']) ? 'السلسلة كاملة' : 'Series' }}</option>

                    @if(count($publications))
                        @foreach($publications as $publication)
                            @if(!isset($_GET['series']))
                                <option value="{{$publication->series}}">{{ isset($_GET['lang']) ? $publication->series_ar : $publication->series }}</option>
                            @else
                                <option value="{{$publication->series}}" {{ $_GET['series'] == $publication->series ? 'selected' : ''  }}>{{ isset($_GET['lang']) ? $publication->series_ar : $publication->series }}</option>
                            @endif
                        @endforeach
                    @endif

                </select>
            </div>
        </div>
        <div class="col-md-3 {{ $_GET['lang']=='ar' ? 'text-right' : 'text-left' }}">
            <input type="submit" value="{{ $_GET['lang']=='ar' ? 'إرسال' : 'SUBMIT' }}" style="width:auto;">
        </div>
    </div>
</form>
