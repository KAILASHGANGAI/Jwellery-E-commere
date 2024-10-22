<div>
    <div class="single_blog">
        <div class="blog_thumb">
            <a href="{{ route('blog.show', $blog->slug) }}"><img src="{{ asset($blog->featured_image ?? 'images/default-img.jpg') }}" alt="{{ $blog->title }}"></a>
        </div>
        <div class="blog_content">
            <h3><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a></h3>
            <div class="author_name">
                <p>
                    <span>by</span>
                    <span class="themes">{{ $blog->createdBy->name }}</span>
                    <span class="post_by">/ {{ $blog->created_at->format('d M Y') }}</span>
                </p>
            </div>

            <div class="post_desc">
                <p>{{ $blog->description }}</p>
            </div>
            <div class="read_more">
                <a href="{{ route('blog.show', $blog->slug) }}">Continue Reading</a>
            </div>
        </div>
    </div>
</div>
