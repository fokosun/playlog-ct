<form action="{{ route('reaction.new', [\Illuminate\Support\Facades\Auth::user()->id, $comment->id]) }}" method="POST">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    <div>
        <input type="text" name="new_comment" id="new_comment" placeholder="write a comment ..." class="main-content" required>
        <input type="submit" value="Post" class="submit-content">
    </div>
</form>