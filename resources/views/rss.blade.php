<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ option('site.name', 'Luff') }}</title>
        <description>{{ option('site.description', 'Luff') }}</description>
        <link>{{ route('home') }}</link>
        <atom:link href="{{ route('feed.xml') }}" rel="self" type="application/rss+xml"/>
        <?php
        $date = ! empty($posts) && count($posts) ? $posts[0]->updated_at->format('D, d M Y H:i:s O') : date("D, d M Y H:i:s O", time())
        ?>
        <pubDate>{{ $date }}</pubDate>
        <lastBuildDate>{{ $date }}</lastBuildDate>
        <generator>{{ option('site.author', 'Luff') }}</generator>
        @foreach ($posts as $post)
            <item>
                <title>{{ $post->title }}</title>
                <link>{{ route('post.show',$post->id) }}</link>
                <description>{{ $post->summary() }}</description>
                <pubDate>{{ $post->created_at->format('D, d M Y H:i:s T') }}</pubDate>
                <author>{{ $post->user->email }} ({{$post->user->name}})</author>
                <guid>{{ route('post.show', $post->id) }}</guid>
                @foreach ($post->tags as $tag)
                    <category>{{ $tag->name }}</category>
                @endforeach
            </item>
        @endforeach
    </channel>
</rss>