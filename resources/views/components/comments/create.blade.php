<form action="{{ route('comment.new') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <input
                type="text"
                name="content"
                placeholder="What's happening?"
                class="main-content"
                style="height: 80px;"
        >
        <input
                type="submit"
                value="Post"
                class="submit-content"
                style="height: 80px;"
        >
    </div>
    <div>
        @if ($errors->has('content'))
            <span class="help-block" style="color: red">
                <strong>
                    {{ $errors->first('content') }}
                </strong>
            </span>
        @endif
    </div>
    <div>
        <input id="photo" type="file" name="photo" accept=".png, .jpg, .jpeg">
    </div>
</form>