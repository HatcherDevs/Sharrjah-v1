@include('header-inner')
<style>
.innerpage a:hover, .innerpage a:hover span {
    color: #000000ad !important;
    text-decoration: none;
}

.innerpage {
    padding-top: 140px;
    min-height: 900px;
}
</style>
<div class="innerpage">
    <div class="container text-center" style="display: flex;justify-content: center;">
        <div class="body-section contents"
            style="min-height: 60vh; display: flex; align-items: center; justify-content: center;">
            <div>
                <h1 style="font-size: 120px; margin-bottom: 20px; font-weight: bold;">404</h1>
                <h2 style="margin-bottom: 30px;">
                    <span class="ar">الصفحة غير موجودة</span>
                    <br>
                    <span class="en">Page Not Found</span>
                </h2>
                <p style="margin-bottom: 40px; font-size: 18px;line-height: 2;">
                    <span class="ar">.الصفحة التي تبحث عنها قد تكون قد أزيلت أو تغير اسمها أو غير متاحة
                        مؤقتاً</span>
                    <br>
                    <span class="en">The page you are looking for might have been removed, had its name changed, or
                        is temporarily unavailable.</span>
                </p>
                <a href="{{ url('/') }}" style="padding: 12px 30px;font-size: 16px;background: transparent;border-color: #000;border-radius: 0 !important;border: 2px solid;">
                    <span class="en">Go to Homepage</span>
                    <span class="ar">العودة للصفحة الرئيسية</span>
                </a>
            </div>
        </div>
    </div>
</div>

@include('footer-inner')
