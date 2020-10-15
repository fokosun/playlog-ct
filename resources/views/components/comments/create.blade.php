<form action="{{ route('comment.new') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <input type="text" name="comment" placeholder="Add a new comment" style="width: 100%;">
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <input id="photo" type="file" class="form-control" name="photo">
        </div>
        <div class="col-md-6">
            <input type="submit" class="form-control" value="Post">
        </div>
    </div>
</form>