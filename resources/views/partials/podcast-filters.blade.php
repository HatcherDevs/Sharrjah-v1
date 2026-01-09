<form action="{{ url('pages/' . ($page->parent->slug ?? 'programs') . '/' . $page->slug) }}" method="get" id="sort-form">

    @if (isset($_GET['lang']) && $_GET['lang'] == 'ar')
        <input type="hidden" value="ar" name="lang">
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="select-style {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'ar' : '' }}">
                <select class="form-control filter-select" id="sort" name="sort">
                    <option value="title" {{ isset($_GET['sort']) && $_GET['sort'] == 'title' ? 'selected' : '' }}>
                        {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'التصنيف بحسب العنوان' : 'Sort by Title' }}
                    </option>
                    <option value="speaker" {{ isset($_GET['sort']) && $_GET['sort'] == 'speaker' ? 'selected' : '' }}>
                        {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'التصنيف بحسب المتحدث' : 'Sort by Speaker' }}
                    </option>
                    <option value="series" {{ isset($_GET['sort']) && $_GET['sort'] == 'series' ? 'selected' : '' }}>
                        {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'التصنيف بحسب السلسلة' : 'Sort by Series' }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'ar' : '' }}">
                <select class="form-control filter-select" id="order" name="order">
                    <option value="ASC" {{ isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected' : '' }}>
                        {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'من الأقدم إلى الأحدث' : 'Ascending' }}
                    </option>
                    <option value="DESC" {{ isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'selected' : '' }}>
                        {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'من الأحدث إلى الأقدم' : 'Descending' }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'ar' : '' }}">
                <select class="form-control filter-select" id="publication" name="series">
                    <option value="all" {{ isset($_GET['series']) && $_GET['series'] == 'all' ? 'selected' : '' }}
                        {{ !isset($_GET['series']) ? 'selected' : '' }}>
                        {{ isset($_GET['lang']) ? 'السلسلة كاملة' : 'Series' }}</option>

                    @if (count($publications))
                        @foreach ($publications as $publication)
                            @if (!isset($_GET['series']))
                                <option value="{{ $publication->series }}">
                                    {{ isset($_GET['lang']) ? $publication->series_ar : $publication->series }}
                                </option>
                            @else
                                <option value="{{ $publication->series }}"
                                    {{ $_GET['series'] == $publication->series ? 'selected' : '' }}>
                                    {{ isset($_GET['lang']) ? $publication->series_ar : $publication->series }}
                                </option>
                            @endif
                        @endforeach
                    @endif

                </select>
            </div>
        </div>
        <div class="col-md-3 {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'text-right' : 'text-left' }}">
            <input type="submit" value="{{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'إرسال' : 'SUBMIT' }}"
                style="width:auto;">
        </div>
    </div>
</form>
