@extends('website.layout')

@section('title', 'کاخ‌سازان داروگ - داستان ساخت و ساز')
@section('description', 'کاخ‌سازان داروگ با بیش از دو دهه تجربه در زمینه‌های سلر‌سازی، محوطه‌سازی، جاده‌سازی و تسهیل تأسیسات سرچاهی')

@section('content')
<!-- Hero Slider Section -->
<div class="slider-container">
    <div class="swiper hero-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="slider-item">
                    <img src="{{ asset('assets/images/1.webp') }}" alt="اسلاید ۱" />
                    <div class="slider-content">
                        <div class="slider-title">داروگ پیشرو در صنعت عمران</div>
                        <div class="slider-description">
                            توضیحات کوتاه درباره این اسلاید که به کاربران اطلاعات می‌دهد.
                        </div>
                        <div class="slider-buttons">
                            <button class="btn btn-light">
                                <span>تماس با ما</span>
                                <span><i class="bi bi-telephone"></i></span>
                            </button>
                            <button class="btn btn-outline-light display-6 fw-bolder px-3">
                                ثبت نام
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slider-item">
                    <img src="{{ asset('assets/images/2.webp') }}" alt="اسلاید ۲" />
                    <div class="slider-content">
                        <div class="slider-title">عنوان دوم</div>
                        <div class="slider-description">
                            یک متن دیگر برای توضیح این اسلاید که جذاب باشد.
                        </div>
                        <div class="slider-buttons">
                            <button class="btn btn-light">
                                <span>زمان بندی های ما</span>
                                <i class="bi bi-calendar-date"></i>
                            </button>
                            <button class="btn btn-outline-light display-6 fw-bolder px-3">
                                شروع کنید
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slider-item">
                    <img src="{{ asset('assets/images/3.webp') }}" alt="اسلاید ۳" />
                    <div class="slider-content">
                        <div class="slider-title">عنوان سوم</div>
                        <div class="slider-description">
                            آخرین توضیحات درباره این اسلاید که مرتبط باشد.
                        </div>
                        <div class="slider-buttons">
                            <button class="btn btn-light">همین حالا</button>
                            <button class="btn btn-outline-light display-6 fw-bolder px-3">
                                بیشتر بدانید
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- دکمه‌های ناوبری -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<!-- About Section -->
<div class="container mt-128">
    <!-- عنوان بخش -->
    <div class="section-title">درباره داروگ</div>
    <div class="divider"></div>
    <!-- توضیح بخش -->
    <div class="section-description">
        کارخانه کاخ سازان داروگ در سال ۱۳۵۳ با هدف تولید محصولات ساختمانی تأسیس
        شده است و بیش از دو دهه است که داروگ با تمرکز بر طراحی، تدارک و تولید
        ساختمان‌های پیش ساخته، اجرای کمپ‌ و تجهیز کارگاه پروژه‌های بزرگ عمرانی
        فعالیت می‌کند.
    </div>

    <div class="row justify-content-center px-5">
        <div class="col-6 col-md-2">
            <div class="image-item">
                <div class="image-box">
                    <img src="{{ asset('assets/images/files/1.png') }}" alt="Image 1" />
                </div>
                <p>عنوان 1</p>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="image-item">
                <div class="image-box">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/5448c0a2b5b6f0efe0807e94d13fbc59-300x300.png" alt="Image 2" />
                </div>
                <p>عنوان 2</p>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="image-item">
                <div class="image-box">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/machine-300x300.png" alt="Image 3" />
                </div>
                <p>عنوان 3</p>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="image-item">
                <div class="image-box">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/customer-support-300x300.png" alt="Image 4" />
                </div>
                <p>عنوان 4</p>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="image-item">
                <div class="image-box">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/building-300x300.png" alt="Image 5" />
                </div>
                <p>عنوان 5</p>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="image-item">
                <div class="image-box">
                    <img src="https://vima-ir.com/wp-content/uploads/2023/11/house-300x300.png" alt="Image 6" />
                </div>
                <p>عنوان 6</p>
            </div>
        </div>
    </div>
</div>

<!-- Projects Slider Section -->
<div class="swiper-container custom-swiper mt-128">
    <div class="swiper-wrapper">
        <!-- اسلاید ۱ -->
        <div class="swiper-slide">
            <img src="https://vima-ir.com/wp-content/uploads/2023/11/Banner-Shorijeh-camp-jpg.webp" alt="Banner 1" />
            <div class="slide-content">
                <h2>شاخص‌ترین پروژه‌های داروگ</h2>
                <h5>کمپ اقامتی پردیس آذر</h5>
                <ul>
                    <li>طراحی، تأمین و ساخت تجهیزات کمپ پروژه شوریجه</li>
                    <li>کمپ اقامتی پردیس آذر</li>
                    <li>محل اجرا: خراسان رضوی، سرخس</li>
                </ul>
                <div class="btn-group">
                    <button class="btn btn-gold">بیشتر بدانید</button>
                </div>
            </div>
        </div>

        <!-- اسلاید ۲ -->
        <div class="swiper-slide">
            <img src="https://vima-ir.com/wp-content/uploads/2023/12/pic-no-201-copy-2048x852.webp" alt="Banner 2" />
            <div class="slide-content">
                <h2>شاخص‌ترین پروژه‌های داروگ</h2>
                <h5 class="mt-3">پروژه پتروشیمی بوشهر</h5>
                <ul>
                    <li>طراحی و اجرای کمپ اقامتی کارکنان</li>
                    <li>ساخت و تجهیز فضاهای اداری و رفاهی</li>
                    <li>محل اجرا: عسلویه، بوشهر</li>
                </ul>
                <div class="btn-group">
                    <button class="btn btn-gold">بیشتر بدانید</button>
                </div>
            </div>
        </div>

        <!-- اسلاید ۳ -->
        <div class="swiper-slide">
            <img src="https://vima-ir.com/wp-content/uploads/2023/11/Tabnak-project-1-jpg.webp" alt="Banner 3" />
            <div class="slide-content">
                <h2>شاخص‌ترین پروژه‌های داروگ</h2>
                <h5 class="mt-3">پروژه مسکونی و رفاهی تابناک</h5>
                <ul>
                    <li>تأمین و تجهیز واحدهای مسکونی</li>
                    <li>ساخت و بهره‌برداری از مراکز تفریحی و تجاری</li>
                    <li>محل اجرا: تهران، ایران</li>
                </ul>
                <div class="btn-group">
                    <button class="btn btn-gold">بیشتر بدانید</button>
                </div>
            </div>
        </div>

        <!-- اسلاید ۴ -->
        <div class="swiper-slide">
            <img src="https://vima-ir.com/wp-content/uploads/2023/11/Homma-baner-jpg.webp" alt="Banner 4" />
            <div class="slide-content">
                <h2>شاخص‌ترین پروژه‌های داروگ</h2>
                <h5 class="mt-3">مرکز نوآوری و فناوری هُما</h5>
                <ul>
                    <li>ایجاد فضای کاری مدرن و خلاقانه</li>
                    <li>همکاری با استارتاپ‌ها و شرکت‌های دانش‌بنیان</li>
                    <li>محل اجرا: تهران، ایران</li>
                </ul>
                <div class="btn-group">
                    <button class="btn btn-gold">بیشتر بدانید</button>
                </div>
            </div>
        </div>
    </div>

    <!-- پاژینیشن -->
    <div class="swiper-pagination"></div>
</div>

<!-- Products Section -->
<div class="container mt-128 chair-sec">
    <section>
        <div class="section-title">محصولات پیش‌ساخته داروگ</div>
        <div class="divider"></div>

        <!-- اسلایدر Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- آیتم ۱ -->
                <div class="swiper-slide">
                    <figure class="chair">
                        <div class="img-box-prj">
                            <img src="https://vima-ir.com/wp-content/uploads/2023/11/Foldable-porta-cabin-768x512.webp" alt="کانکس تاشو" />
                            <div class="img-text">
                                کانکس تاشو <br />
                                Foldable porta cabin
                            </div>
                        </div>
                        <div class="chair-box">
                            <h3>لورم ایپسوم متن</h3>
                            <ul class="chair-details">
                                <li>
                                    <i class="bi bi-calendar-date"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-person-fill-check"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-bank"></i> <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                            </ul>
                        </div>
                    </figure>
                </div>

                <!-- آیتم ۲ -->
                <div class="swiper-slide">
                    <figure class="chair">
                        <div class="img-box-prj">
                            <img src="https://vima-ir.com/wp-content/uploads/2023/11/IMG_0653-768x576.webp" alt="کانکس تاشو" />
                            <div class="img-text">
                                کانکس تاشو <br />
                                Foldable porta cabin
                            </div>
                        </div>
                        <div class="chair-box">
                            <h3>لورم ایپسوم متن</h3>
                            <ul class="chair-details">
                                <li>
                                    <i class="bi bi-calendar-date"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-person-fill-check"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-bank"></i> <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                            </ul>
                        </div>
                    </figure>
                </div>

                <!-- آیتم ۳ -->
                <div class="swiper-slide">
                    <figure class="chair">
                        <div class="img-box-prj">
                            <img src="https://vima-ir.com/wp-content/uploads/2023/11/IMG_1361-1-768x576.webp" alt="کانکس تاشو" />
                            <div class="img-text">
                                کانکس تاشو <br />
                                Foldable porta cabin
                            </div>
                        </div>
                        <div class="chair-box">
                            <h3>لورم ایپسوم متن</h3>
                            <ul class="chair-details">
                                <li>
                                    <i class="bi bi-calendar-date"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-person-fill-check"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-bank"></i> <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                            </ul>
                        </div>
                    </figure>
                </div>

                <div class="swiper-slide">
                    <figure class="chair">
                        <div class="img-box-prj">
                            <img src="https://vima-ir.com/wp-content/uploads/2023/11/Foldable-porta-cabin-768x512.webp" alt="کانکس تاشو" />
                            <div class="img-text">
                                کانکس تاشو <br />
                                Foldable porta cabin
                            </div>
                        </div>
                        <div class="chair-box">
                            <h3>لورم ایپسوم متن</h3>
                            <ul class="chair-details">
                                <li>
                                    <i class="bi bi-calendar-date"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-person-fill-check"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-bank"></i> <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                            </ul>
                        </div>
                    </figure>
                </div>

                <div class="swiper-slide">
                    <figure class="chair">
                        <div class="img-box-prj">
                            <img src="https://vima-ir.com/wp-content/uploads/2023/11/Foldable-porta-cabin-768x512.webp" alt="کانکس تاشو" />
                            <div class="img-text">
                                کانکس تاشو <br />
                                Foldable porta cabin
                            </div>
                        </div>
                        <div class="chair-box">
                            <h3>لورم ایپسوم متن</h3>
                            <ul class="chair-details">
                                <li>
                                    <i class="bi bi-calendar-date"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-person-fill-check"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-bank"></i> <span>لورم ایپسوم متن</span>
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>لورم ایپسوم متن</span>
                                </li>
                            </ul>
                        </div>
                    </figure>
                </div>
            </div>

            <!-- دکمه‌های ناوبری -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- دایره‌های صفحه‌بندی -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
</div>

<!-- Experience Section -->
<section class="scroll-section mt-128 d-flex align-items-center justify-content-center text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 look_at_darvag d-flex flex-column align-content-start justify-content-start text-right">
                <h3 class="fw-bolder">نگاهی به تجربه داروگ در سال های اخیر</h3>
                <p>مجموعه ای از فعالیت‌های داروگ</p>
                <div class="row">
                    <div class="d-flex align-items-center justify-content-right gap-3">
                        <button class="btn btn-outline-light display-6 border-2 px-4">
                            کاتالوگ پروژه ها
                        </button>
                        <button class="btn btn-outline-light display-6 border-2 px-4">
                            کاتالوگ محصولات
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 darvag-statisicd">
                <div class="row">
                    <div class="col-6">
                        <h5>
                            <span>+70</span>
                            <lord-icon src="{{ asset('assets/js/lord/hmzvkifi.json') }}" trigger="loop" delay="1500" stroke="bold" state="hover-loading" colors="primary:#ffe500" style="width: 40px; height: 40px">
                            </lord-icon>
                        </h5>
                        <p>پروژه های انجام شده</p>
                    </div>
                    <div class="col-6">
                        <h5>
                            <span>+70</span>
                            <lord-icon src="{{ asset('assets/js/lord/hmzvkifi.json') }}" trigger="loop" delay="1500" stroke="bold" state="hover-loading" colors="primary:#ffe500" style="width: 40px; height: 40px">
                            </lord-icon>
                        </h5>
                        <p>پروژه های انجام شده</p>
                    </div>
                    <div class="col-6 mt-5">
                        <h5>
                            <span>+70</span>
                            <lord-icon src="{{ asset('assets/js/lord/hmzvkifi.json') }}" trigger="loop" delay="1500" stroke="bold" state="hover-loading" colors="primary:#ffe500" style="width: 40px; height: 40px">
                            </lord-icon>
                        </h5>
                        <p>پروژه های انجام شده</p>
                    </div>
                    <div class="col-6 mt-5">
                        <h5>
                            <span>+70</span>
                            <lord-icon src="{{ asset('assets/js/lord/hmzvkifi.json') }}" trigger="loop" delay="1500" stroke="bold" state="hover-loading" colors="primary:#ffe500" style="width: 40px; height: 40px">
                            </lord-icon>
                        </h5>
                        <p>پروژه های انجام شده</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<div class="container mt-128">
    <div class="section-title">همکاری با برندهای معتبر</div>
    <div class="divider"></div>

    <div class="swiper companySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/11/%D9%BE%D8%B1%D8%B4%DB%8C%D8%A7-jpg.webp" alt="Company 1" />
            </div>
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/12/%DA%AF%D8%B1%D9%88%D9%87-OIEC-jpg.webp" alt="Company 2" />
            </div>
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/11/%D9%BE%D8%B1%D8%B4%DB%8C%D8%A7-jpg.webp" alt="Company 3" />
            </div>
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/12/%DA%AF%D8%B1%D9%88%D9%87-OIEC-jpg.webp" alt="Company 4" />
            </div>
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/11/%D9%BE%D8%B1%D8%B4%DB%8C%D8%A7-jpg.webp" alt="Company 5" />
            </div>
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/12/%DA%AF%D8%B1%D9%88%D9%87-OIEC-jpg.webp" alt="Company 6" />
            </div>
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/11/%D9%BE%D8%B1%D8%B4%DB%8C%D8%A7-jpg.webp" alt="Company 7" />
            </div>
            <div class="swiper-slide">
                <img src="https://vima-ir.com/wp-content/uploads/2023/12/%DA%AF%D8%B1%D9%88%D9%87-OIEC-jpg.webp" alt="Company 8" />
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- FAQ Section -->
<div class="faq-section mt-128">
    <div class="container">
        <h2 class="my-4">سوالات متداول</h2>

        <div class="faq-item">
            <div class="faq-question">
                <span>چگونه ثبت‌نام کنم؟</span>
                <span class="faq-icon">+</span>
            </div>
            <div class="faq-answer">
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
                استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در
                ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز،
                و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای
                زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و
                متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان
                رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد
                کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه
                راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل
                حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود
                طراحی اساسا مورد استفاده قرار گیرد.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>چگونه پسورد خود را بازیابی کنم؟</span>
                <span class="faq-icon">+</span>
            </div>
            <div class="faq-answer">
                می‌توانید از طریق گزینه "فراموشی رمز عبور" درخواست بازیابی رمز دهید.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>چگونه با پشتیبانی تماس بگیرم؟</span>
                <span class="faq-icon">+</span>
            </div>
            <div class="faq-answer">
                شما می‌توانید از طریق ایمیل یا شماره تماس درج شده در سایت، با ما در
                ارتباط باشید.
            </div>
        </div>
    </div>
</div>

<!-- Company Info Section -->
<div class="container mt-128">
    <div class="section-title">شرکت کاخ سازان داروگ</div>
    <div class="divider"></div>
    <div class="content-container p-3 rounded" id="textContainer">
        <p class="vima-company-content">
            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
            استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در
            ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و
            کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی
            در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می
            طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی
            الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این
            صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها،
            <br />
            و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی
            دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا
            مورد استفاده قرار گیرد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم
            از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه
            روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
            تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می
            باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان
            جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای
            طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی
            ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در
            ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل
            حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود
            طراحی اساسا مورد استفاده قرار گیرد.لورم ایپسوم متن ساختگی با تولید
            سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها
            و متون بلکه روزنامه و
            <br />
            مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
            نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای
            زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان
            را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای
            علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این
            صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و
            شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای
            اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده
            قرار گیرد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و
            با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در
            ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و
            کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی
            در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می
            طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی
            الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این
            صورت می توان امید داشت که
            <br />
            تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و
            زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته
            اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.لورم ایپسوم متن
            ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان
            گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که
            لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با
            هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد
            گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم
            افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی،
            و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت
            که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان
            رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات
            پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
        </p>
        <div class="fade-out"></div>
    </div>

    <div class="text-center mt-3">
        <button class="toggle-button" id="toggleButton">
            <i class="bi bi-chevron-down"></i> مشاهده بیشتر
        </button>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
    // FAQ Toggle functionality
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".faq-item").forEach((item) => {
            item.addEventListener("click", function () {
                this.classList.toggle("active");

                let answer = this.querySelector(".faq-answer");
                if (this.classList.contains("active")) {
                    answer.style.maxHeight = answer.scrollHeight + "px";
                } else {
                    answer.style.maxHeight = null;
                }
            });
        });

        // Toggle button functionality
        const toggleButton = document.getElementById('toggleButton');
        const textContainer = document.getElementById('textContainer');

        if (toggleButton && textContainer) {
            toggleButton.addEventListener('click', function() {
                textContainer.classList.toggle('expanded');
                const icon = this.querySelector('i');
                if (textContainer.classList.contains('expanded')) {
                    icon.classList.remove('bi-chevron-down');
                    icon.classList.add('bi-chevron-up');
                    this.innerHTML = '<i class="bi bi-chevron-up"></i> مشاهده کمتر';
                } else {
                    icon.classList.remove('bi-chevron-up');
                    icon.classList.add('bi-chevron-down');
                    this.innerHTML = '<i class="bi bi-chevron-down"></i> مشاهده بیشتر';
                }
            });
        }
    });
</script>
@endpush
