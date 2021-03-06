@extends('layouts.app')

@inject('navigation', 'App\T\Navigation\Navigation')

@section('content')
    <div class="content container">
        {!! Breadcrumbs::render('category', $navigation) !!}
        <div class="main col-lg-9 col-md-9 col-sm-12 col-xs-12">
            @include('layouts.particals.banner')
            <div id="order" class="header">
                @php
                    $request = request();
                    $order = $request->get('order', 'default');
                @endphp
                @foreach(['default', 'recent', 'popular'] as $item)
                    <a href="{!! $request->fullUrlWithQuery(['order' => $item]).'#order' !!}"@if($order==$item) class="active"@endif>{!! trans('app.'.$item) !!}</a>
                @endforeach
            </div>
            <ul class="list">
                @foreach($postList as $post)
                    <li>
                        @if(!is_null($post->cover))
                        <a class="cover" href="{!! $post->present()->getUrl() !!}" title="{!! $post->title !!}" style="">
                            <img lazy src="http://i0.hdslb.com/bfs/archive/dfa4385619bc1833c8c38d47146b0b857bc6813a.jpg@.webp"/>
                        </a>
                        @endif
                        <div class="info @if(is_null($post->cover)) no_cover @endif">
                            <a href="{!! $post->present()->getUrl() !!}" title="{!! $post->title !!}">
                                <h3>@if($post->isTop())<span class="label label-danger">置顶</span>@endif{!! $post->present()->suitedTitle() !!}</h3>
                            </a>
                            <p class="describe">{!! $post->excerpt !!}</p>
                            <div class="list_footer">
                                <p class="avatar">
                                    <img src="http://i0.hdslb.com/bfs/archive/dfa4385619bc1833c8c38d47146b0b857bc6813a.jpg@.webp" alt="">
                                    <span class="uname">一家专卖店</span>
                                </p>
                                <p class="time">{!! $post->published_at !!}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            {{--分页--}}
            {!! $postList->links() !!}
        </div>
        @include('post.particals.list_side')
    </div>
@endsection