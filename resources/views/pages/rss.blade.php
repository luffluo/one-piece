<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ setting('title', config('app.name')) }}</title>
        <description>{{ setting('description', config('app.name')) }}</description>
        <link>{{ route('home') }}</link>
        <atom:link href="{{ route('feed') }}" rel="self" type="application/rss+xml"/>
        <?php
        $date = ! empty($posts) && count($posts) ? $posts[0]->updated_at->format('D, d M Y H:i:s O') : date("D, d M Y H:i:s O", time())
        ?>
        <pubDate>{{ $date }}</pubDate>
        <lastBuildDate>{{ $date }}</lastBuildDate>
        <generator>{{ count($posts) > 0 ? $posts[0]->user->showName() : config('app.name') }}</generator>
        @foreach ($posts as $post)
            <item>
                <title>{{ $post->title }}</title>
                <link>{{ route('posts.show',$post->id) }}</link>
                <description>{{ $post->excerpt() }}</description>
                <pubDate>{{ $post->created_at->format('D, d M Y H:i:s T') }}</pubDate>
                <author>{{ $post->user->email }} ({{$post->user->showName()}})</author>
                <guid>{{ route('posts.show', $post->id) }}</guid>
                @foreach ($post->tags as $tag)
                    <tag>{{ $tag->name }}</tag>
                @endforeach
            </item>
        @endforeach
    </channel>
</rss>