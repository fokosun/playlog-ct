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
                                @if($comment->photo_url)
                                    <img src="{{url('uploads/'. $comment->photo_url)}}" style="width: 100%;">
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="col-md-10">
                            <span style="font-weight: bold">
                                {{ $comment->reactions()->get()->count() }}
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
                                @if(count($comment->reactions()->get()) > 0)
                                    @foreach($comment->reactions()->get()->sortByDesc('id') as $reaction)
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <img src="https://megatherm-dev.in/rba/wp-content/uploads/2019/02/noavatar-profile.jpg"
                                                     style="vertical-align: middle;width: 25px;height: 25px;border-radius: 50%;" />
                                                {{ $reaction->username() }} - {{ $reaction->posted_on }}
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
                                                    <div
                                                            class="col-md-2 btn-info like-btn"
                                                            style="width: 50px!important;"
                                                            data-icmt="{{ $reaction->id }}"
                                                    >
                                                        Like
                                                    </div>
                                                    <div>
                                                <span>
                                                    <i class="fa fa-heart"></i>
                                                </span>
                                                        <span id="{{ 'reaction-' . $reaction->id  }}">
                                                    {{ $reaction->likes }}
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                    @endforeach
                                @endif
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