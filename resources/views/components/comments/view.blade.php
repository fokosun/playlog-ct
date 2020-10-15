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
                            <h4>
                                Posted by: {{ $comment->user->username }} - {{ $comment->posted_on }}
                            </h4>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            {{ $comment->content }}
                        </div>
                        <div class="col-md-2">
                            @if($comment->author_id == \Illuminate\Support\Facades\Auth::user()->id)
                                <form action="{{ route('comment.delete', [$comment->id, \Illuminate\Support\Facades\Auth::user()->id]) }}" method="POST">
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
                                Comment(s)
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            @include('components.comments.reaction')
                        </div>
                    </div>
                    <div>
                        <div class="col-md-10">
                            <br />
                            @foreach($comment->reactions as $reaction)
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <img src="https://megatherm-dev.in/rba/wp-content/uploads/2019/02/noavatar-profile.jpg"
                                             style="vertical-align: middle;width: 25px;height: 25px;border-radius: 50%;" />
                                        {{ $reaction->user()->get()->first()->username }} - {{ $reaction->posted_on }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="container">
                                        <div>
                                            <div class="col-md-8">
                                                <div style="padding: 12px;">
                                                    {{ $reaction->content }}
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <form action="{{ route('like.new', ['comment_id' => $reaction->id]) }}" method="POST">
                                                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                                <button>
                                                    Like
                                                </button>
                                                <i class="fa fa-heart"></i>
                                                {{ $reaction->likes }}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="container">

                                    </div>
                                </div>
                                <br />
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