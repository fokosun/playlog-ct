<form action="{{ route('comment.new') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <input type="text" name="content" placeholder="Add a new comment" class="main-content">
        <input type="submit" value="Post" class="submit-content">
    </div>
    <div>
        <input id="photo" type="file" name="photo" accept=".png, .jpg, .jpeg">
    </div>
</form>