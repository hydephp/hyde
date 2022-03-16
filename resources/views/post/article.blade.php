<article id="post-article" itemscope itemtype="http://schema.org/Article" 
    @class(['mx-auto prose', 'torchlight-enabled' => App\Hyde\Hyde::hasTorchlight()])>
    <header>
        <h1 itemprop="headline" class="mb-4">{{ $post->matter['title'] ?? 'Blog Post' }}</h1>
		<div id="byline">
            @includeWhen(isset($post->matter['date']), 'post.datePublished')
		    @includeWhen(isset($post->matter['author']), 'post.author')
            @includeWhen(isset($post->matter['category']), 'post.category')
        </div>
    </header>
    <div itemprop="articleBody">
        {!! $markdown !!}
    </div>
</article>