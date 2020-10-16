<form action="{{ route('reaction.new', [\Illuminate\Support\Facades\Auth::user()->id, $comment->id]) }}" method="POST">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    <div>
        <input type="text" name="comment" id="{{ $comment->id }}" placeholder="write a comment ..." class="main-content" required />
        <input type="hidden" name="author_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}" />
        <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
        <input type="submit" value="Post" class="submit-content" />
    </div>
</form>