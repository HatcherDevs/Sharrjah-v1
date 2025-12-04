@if(count($similar))
    <b>MORE FROM THIS SERIES</b><br/>
    <br/>
    @foreach($similar as $pod)
        <a href="{{ url('pages/podcasts/'.$pod->slug) }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}">

            @if($page->slider->landscape)
                <img src="{{url('public/'.$pod->slider->landscape->url)}}" width="100%" class="featured-img"><br/>
            @elseif($page->slider->square)
                <img src="{{url('public/'.$pod->slider->square->url)}}" width="100%" class="featured-img"><br/>
            @else
                <img src="https://via.placeholder.com/250" width="100%" class="featured-img"><br/>
            @endif
            <p style="margin-top:5px;">{{ isset($_GET['lang']) ? $pod->title_ar : $pod->title }}</p>
        </a>
        <hr/>
    @endforeach
    <br/>
    <br/>
@endif
<b>{{ isset($_GET['lang']) ? 'شارك هذا الرابط' : 'SHARE THIS' }}</b><br/>
<ul class="socials">
    <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url('pages/podcasts/'.$post->slug) }}&picture={{url('public/'.$page->slider->square->url)}}&title={{ $post->title }}&description={{ $post->excerpt }}" class="fb"></a></li>
    <li><a target="_blank" href="https://twitter.com/intent/tweet?text={{ url('pages/podcasts/'.$post->slug) }}" class="tw"></a></li>
    <li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ url('pages/podcasts/'.$post->slug) }}&summary=&source=" class="ln"></a></li>
</ul>

@if($page->links)
    <hr/>
    <br/>
    <div id="desk-other-links" class="clearfix">
    @if(isset($_GET['lang']))
        <b>طرق أكثر للاستماع</b><br/><br/>
    @else
        <b>MORE WAYS TO LISTEN</b><br/><br/>
    @endif

    @if($page->links->soundcloud_url)
        <a href="{{$page->links->soundcloud_url}}" target="_blank"><svg style="{{ isset($_GET['lang']) ? 'float: right; margin-left:10px;' : 'float: left;' }} display: block" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="25px" id="Layer_1" version="1.1" viewBox="0 0 100 100" width="25px" xml:space="preserve"><defs><path id="SVGID_1_" d="M0 0h100v100H0z"/></defs><path d="M5 59.023c0 3.044 1.385 5.764 3.568 7.598V51.43C6.385 53.259 5 55.982 5 59.023m7.342-9.591v19.183c.891.246 1.832.385 2.801.385h.974V49.094a10.365 10.365 0 0 0-3.775.338m8.336 1.245a9.632 9.632 0 0 0-.789-.457V69h3.773V43.881a15.49 15.49 0 0 0-2.984 6.796m6.759-10.328V69h3.774V38.491a16.044 16.044 0 0 0-3.774 1.858m7.547-2.639V69h3.774V37.825a16.18 16.18 0 0 0-3.774-.115m9.628 2.206a16.068 16.068 0 0 0-3.966-1.69V69h5.66V37.646a19.432 19.432 0 0 0-1.694 2.27m3.583-4.162V69h35.852v-.044C91.596 68.473 95 63.79 95 58.075c0-6.035-4.562-10.925-10.703-10.925-1.576 0-2.874.325-4.245.913C79.069 38.481 70.941 31 60.932 31c-4.896 0-9.346 1.793-12.737 4.754"/><metadata><rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" xmlns:dc="http://purl.org/dc/elements/1.1/"><rdf:Description about="https://iconscout.com/legal#licenses" dc:title="soundcloud" dc:description="soundcloud" dc:publisher="Iconscout" dc:date="2017-09-19" dc:format="image/svg+xml" dc:language="en"><dc:creator><rdf:Bag><rdf:li></rdf:li></rdf:Bag></dc:creator></rdf:Description></rdf:RDF></metadata></svg>
            <span style="    display: block;
            {{ isset($_GET['lang']) ? 'float: right;' : 'float: left;' }}
                    height: 25px;
    line-height: 28px !important;
    margin-left: 10px;">SoundCloud</span></a><br/><br/>
    @endif
    @if($page->links->apple_url)
    <a href="{{$page->links->apple_url}}" target="_blank"><svg  style="{{ isset($_GET['lang']) ? 'float: right;margin-left:10px;' : 'float: left;' }} display: block" width="25" height="25" viewBox="0 0 18 20" class="podcast__meta-icon__svg podcast__section-icon__svg inline-apple-podcasts__svg inline-journalism/audio__svg">
            <g fill="#000">
                <path d="M11.84 17.624c.027-.282.066-.522.07-.763.006-.38.223-.543.54-.705 2.289-1.172 3.742-3.018 4.25-5.56.489-2.453-.091-4.672-1.666-6.596-1.241-1.515-2.85-2.442-4.793-2.744-2.364-.366-4.48.23-6.3 1.77-1.477 1.25-2.4 2.851-2.69 4.788-.366 2.435.261 4.585 1.85 6.457a7.615 7.615 0 0 0 2.497 1.915c.272.133.49.252.475.608-.009.204.055.41.08.617.022.18-.05.215-.217.153a8.877 8.877 0 0 1-2.486-1.392C1.783 14.84.7 13.128.228 11.037a8.801 8.801 0 0 1-.143-3.133c.215-1.613.8-3.062 1.789-4.346C3.181 1.861 4.873.76 6.95.252A8.436 8.436 0 0 1 9.94.053c1.74.202 3.308.837 4.678 1.948 1.639 1.331 2.71 3.03 3.155 5.093.575 2.667.047 5.127-1.55 7.336-1.077 1.492-2.507 2.526-4.228 3.155-.021.01-.045.014-.155.04z"></path>
                <path d="M6.809 13.403c0-.243-.024-.489.005-.728.056-.463.321-.787.72-1.017a2.778 2.778 0 0 1 1.375-.36c.632-.01 1.23.107 1.756.498.35.26.515.608.532 1.026.039 1.006-.047 2.003-.19 2.996-.132.913-.268 1.824-.408 2.736-.088.575-.319 1.047-.918 1.241-.655.213-1.275.159-1.834-.266-.292-.22-.378-.566-.435-.9-.15-.9-.293-1.802-.407-2.709-.106-.835-.17-1.676-.25-2.515l.054-.002z"></path>
                <path d="M15.025 9.006c-.047 2.097-.873 3.729-2.484 4.956-.072.055-.171.072-.258.106-.011-.087-.022-.174-.035-.261-.105-.7.15-1.223.617-1.761.785-.904 1.095-2.034 1.029-3.23a4.935 4.935 0 0 0-4.039-4.598c-2.615-.47-5.1 1.267-5.636 3.835-.359 1.725.138 3.231 1.341 4.5.145.15.212.295.2.506-.014.266.018.535.02.803a.84.84 0 0 1-.05.205c-.065-.021-.14-.029-.194-.067-1.313-.943-2.136-2.208-2.436-3.805-.319-1.717.022-3.303 1.057-4.707 1.008-1.37 2.357-2.197 4.05-2.42 1.691-.223 3.21.196 4.538 1.258 1.239.989 1.983 2.284 2.203 3.869.043.288.056.58.077.81z"></path>
                <path d="M9.008 6.236c.555-.01 1.09.207 1.482.602.391.395.606.933.595 1.491-.01 1.255-.988 2.102-2.118 2.084-1.113-.018-2.053-.865-2.05-2.1a2.057 2.057 0 0 1 .606-1.487c.395-.392.931-.605 1.486-.59z"></path>
            </g>
        </svg> <span style="    display: block;
        {{ isset($_GET['lang']) ? 'float: right;' : 'float: left;' }}
                height: 25px;
    line-height: 28px !important;
    margin-left: 10px;">Apple iTunes</span></a><br/><br/>
    @endif
    @if($page->links->google_url)
    <a href="{{$page->links->google_url}}" target="_blank"><svg style="{{ isset($_GET['lang']) ? 'float: right;margin-left:10px;' : 'float: left;' }} display: block" width="25" height="25" viewBox="0 0 17 17" class="podcast__meta-icon__svg podcast__section-icon__svg inline-google-podcasts__svg inline-journalism/audio__svg">
            <g fill="#000">
                <path d="M7.299 5.308v6.067h2.085V5.308z"></path>
                <circle cx="1.043" cy="7.773" r="1.043"></circle>
                <circle cx="1.043" cy="8.91" r="1.043"></circle>
                <path d="M0 7.773h2.085V8.91H0z"></path>
                <circle cx="15.64" cy="8.91" r="1.043"></circle>
                <circle cx="15.64" cy="7.773" r="1.043"></circle>
                <path d="M16.683 8.909h-2.085V7.772h2.085z"></path>
                <circle cx="4.645" cy="11.185" r="1.043"></circle>
                <circle cx="4.645" cy="12.323" r="1.043"></circle>
                <path d="M3.602 11.185h2.085v1.137H3.602z"></path>
                <circle cx="4.645" cy="4.36" r="1.043"></circle>
                <circle cx="4.645" cy="8.057" r="1.043"></circle>
                <path d="M3.602 4.36h2.085v3.72H3.602z"></path>
                <circle cx="12.038" cy="5.498" r="1.043"></circle>
                <circle cx="12.038" cy="4.36" r="1.043"></circle>
                <path d="M13.08 5.498h-2.085V4.361h2.085z"></path>
                <circle cx="8.341" cy="2.18" r="1.043"></circle>
                <circle cx="8.341" cy="1.043" r="1.043"></circle>
                <path d="M9.383 2.179H7.298V1.042h2.085z"></path>
                <circle cx="8.341" cy="15.64" r="1.043"></circle>
                <circle cx="8.341" cy="14.503" r="1.043"></circle>
                <path d="M9.383 15.639H7.298v-1.137h2.085z"></path>
                <circle cx="12.038" cy="12.323" r="1.043"></circle>
                <circle cx="12.038" cy="8.626" r="1.043"></circle>
                <path d="M13.08 12.322h-2.085V8.625h2.085z"></path>
                <circle cx="8.341" cy="5.308" r="1.043"></circle>
                <circle cx="8.341" cy="11.375" r="1.043"></circle>
            </g>
        </svg> <span style="    display: block;
        {{ isset($_GET['lang']) ? 'float: right;' : 'float: left;' }}
                height: 25px;
    line-height: 28px !important;
    margin-left: 10px;">Google Podcasts</span></a>
    @endif
    </div>
@endif