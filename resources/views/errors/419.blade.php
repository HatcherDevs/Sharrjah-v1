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
                <h1 style="font-size: 120px; margin-bottom: 20px; font-weight: bold;">419</h1>
                <h2 style="margin-bottom: 30px;">
                    <span class="ar">انتهت صلاحية الصفحة</span>
                    <br>
                    <span class="en">Page Expired</span>
                </h2>
                <p style="margin-bottom: 40px; font-size: 18px;line-height: 2;">
                    <span class="ar">.انتهت صلاحية جلستك. يرجى تحديث الصفحة والمحاولة مرة أخرى</span>

                    <br>
                    <span class="en">Your session has expired. Please refresh the page and try again.</span>
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
