@php
    $lang = request()->get('lang', 'en');
    $sort = request()->get('sort', 'publish_date');
    $order = request()->get('order', 'ASC');
    $publicationFilter = request()->get('publication', 'all');
@endphp

<form action="{{ url('pages/' . $page->parent->slug . '/conditions') }}" method="get" id="sort-form">

    @if ($lang == 'ar')
        <input type="hidden" value="ar" name="lang">
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="select-style {{ $lang == 'ar' ? 'ar' : '' }}">
                <select class="form-control filter-select" id="sort" name="sort">
                    <option value="publish_date" {{ $sort == 'publish_date' ? 'selected' : '' }}>
                        {{ $lang == 'ar' ? 'رتب حسب التاريخ' : 'Sort by Date' }}</option>
                    <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>
                        {{ $lang == 'ar' ? 'الترتيب حسب عنوان' : 'Sort by Title' }}</option>
                    <option value="author" {{ $sort == 'author' ? 'selected' : '' }}>
                        {{ $lang == 'ar' ? 'الترتيب حسب المؤلف' : 'Sort by Author' }}</option>
                    <option value="publication" {{ $sort == 'publication' ? 'selected' : '' }}>
                        {{ $lang == 'ar' ? 'الترتيب حسب اسم المنشور' : 'Sort by Publication Name' }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ $lang == 'ar' ? 'ar' : '' }}">
                <select class="form-control filter-select" id="order" name="order">
                    <option value="ASC" {{ $order == 'ASC' ? 'selected' : '' }}>
                        {{ $lang == 'ar' ? 'تصاعدي' : 'Ascending' }}</option>
                    <option value="DESC" {{ $order == 'DESC' ? 'selected' : '' }}>
                        {{ $lang == 'ar' ? 'تنازلي' : 'Descending' }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="select-style {{ $lang == 'ar' ? 'ar' : '' }}">
                <select class="form-control filter-select" id="publication" name="publication">
                    <option value="all" {{ $publicationFilter == 'All Publications' ? 'selected' : '' }}>
                        {{ $lang == 'ar' ? 'جميع المنشورات' : 'All Publications' }}</option>
                    @foreach ($publications as $publication)
                        <option value="{{ $publication->publication }}"
                            {{ $publicationFilter == $publication->publication ? 'selected' : '' }}>
                            {{ $lang == 'ar' ? $publication->publication_ar : $publication->publication }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 {{ $lang == 'ar' ? 'text-right' : 'text-left' }}">
            <input type="submit" value="{{ $lang == 'ar' ? 'اشترك' : 'SUBMIT' }}" style="width:auto;">
        </div>
    </div>
</form>
