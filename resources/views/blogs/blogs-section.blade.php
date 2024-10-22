@isset($blogs)
    <!-- blog section starts -->
    <section class="blog_section blog_black">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>Blogs & News</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog_wrapper blog_column3 owl-carousel">
                    @foreach ($blogs as $item)
                        <div class="col-lg-4">
                           <x-blog :blog="$item" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- blog section ends -->
@endisset
