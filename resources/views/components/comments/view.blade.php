<hr />
<div class="container">
    @if(count($comments) == 0)
        <div>
            Nothing to see here
        </div>
    @else
    @foreach($comments as $comment)
        <div>
            <div class="container-fluid">
                <div class="content">
                    <div>
                        <div style="font-weight: bold">
                            <h3>
                                Posted by: {{ $comment->user->username }} - {{ $comment->posted_on }}
                            </h3>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            {{ $comment->content }}
                        </div>
                        <div class="col-md-2">
                            @if($comment->author_id == \Illuminate\Support\Facades\Auth::user()->id)
                                <form action="{{ route('comment.delete', $comment->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                    <div>
                                        <button>
                                            <i class="fas fa-trash black"></i>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            <img src="{{ $comment->photo_url }}">
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            <span style="font-weight: bold">
                                {{ $comment->reactions->count() }}
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
                            @foreach($comment->reactions as $reaction)
                                <div>
                                    <label>
                                        {{ $reaction->user()->get()->first()->username }} - {{ $reaction->posted_on }}
                                    </label>
                                    <p>
                                        {{ $reaction->content }}
                                    </p>
                                </div>
                                <div>
                                    <i class="fas fa-heart"></i> Like
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br /> <br />
    @endforeach
        {{ $comments->links() }}
    @endif
</div>