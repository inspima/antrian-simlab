<form method="POST" action="{{ route("account.profile-update-password")}}">
    @csrf
    <div class="row form-group">
        <div class="col-sm-2">
            <label for="name">Password Lama</label>
        </div>
        <div class="col-sm-4">
            <input name="old_password" type="password" class="form-control" placeholder="Password" required>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-2">
            <label for="name">Password</label>
        </div>
        <div class="col-sm-4">
            <input name="password" type="password" class="form-control" placeholder="Password" required>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            @if($personal)
                <input type="hidden" name="personal_id" value="{{$personal->id}}">
            @endif
            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light"><i
                    class="ion-checkmark-round"></i> Save
            </button>
        </div>
    </div>
</form>
