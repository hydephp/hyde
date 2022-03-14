<article itemscope itemtype="http://schema.org/Article">
    <header>
        <h1 itemprop="headline">{{ $title ?? 'Blog Post' }}</h1>
		@includeWhen(isset($post->matter['date']), 'post.datePublished')
		@includeWhen(isset($post->matter['author']), 'post.author')
		@includeWhen(isset($post->matter['category']), 'post.category')
    </header>
    <main itemprop="articleBody">
        {!! $post->body !!}
    </main>
</article>