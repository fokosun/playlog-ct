<hr />
<div class="container">
    @if(count($items) == 0)
        <div>
            Nothing to see here
        </div>
    @else
    @foreach($items as $item)
        <div>
            <div class="container-fluid">
                <div class="content">
                    <div>
                        <div style="font-weight: bold">
                            Posted by: {{ $item['author']['username'] }} - {{ $item['created_at'] }}
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            {{ $item['description'] }}
                        </div>
                        <div class="col-md-2">
                            @if($item['author']['id'] == Auth::user()->id)
                                <a href="{{ route('comment.delete', $item['comment_id']) }}" style="text-decoration: none; color: #090909">
                                    <i class="fas fa-trash black"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            <img src="{{ $item['photo_url'] }}">
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            <span style="font-weight: bold">
                                {{ count($item['comments']) }}
                            </span>
                            <span>
                                <a href="">Comments</a>
                            </span>
                            |
                            <span style="font-weight: bold">
                                80k
                            </span>
                            <span>
                                <a href="">Likes</a>
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            <input type="text" name="new_comment" id="new_comment" placeholder="write a comment ..." style="width: 100%;">
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            @foreach($item['comments'] as $comment)
                                <div>
                                    <label>
                                        {{ $comment['author']['username'] }} - 10h
                                    </label>
                                    <p>
                                        {{ $comment['description'] }}
                                    </p>
                                </div>
                                <div>
                                    <i class="fas fa-heart"></i>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>