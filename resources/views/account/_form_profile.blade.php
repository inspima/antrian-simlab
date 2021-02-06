<form method="POST" action="{{ route("account.profile-update")}}">
    @csrf
    @if($organization->type!='Individu')
        <h4 class="mt-0 header-title">Organisasi</h4>
        <p class="text-muted m-b-30 font-14">Informasi organisasi.</p>
        <div class="row form-group">
            <div class="col-sm-2">
                <label for="organization_name">Nama Organisasi</label>
            </div>
            <div class="col-sm-10">
                <input id="organization_name" name="organization_name" type="text" class="form-control" placeholder="Nama Organisasi" value="{{$organization->name}}" required>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-2">
                <label for="organization_address">Alamat Organisasi</label>
            </div>
            <div class="col-sm-10">
                <input id="organization_address" name="organization_address" type="text" class="form-control" placeholder="Alamat Organisasi" value="{{$organization->address}}" required>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-2">
                <label for="organization_phone">Telephone Organisasi</label>
            </div>
            <div class="col-sm-10">
                <input id="organization_phone" name="organization_phone" type="text" class="form-control" placeholder="Telephone Organisasi" value="{{$organization->phone}}" required>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-2">
                <label for="organization_email">Email Organisasi</label>
            </div>
            <div class="col-sm-10">
                <input id="organization_email" name="organization_email" type="text" class="form-control" placeholder="Email Organisasi" value="{{$organization->email}}" required>
            </div>
        </div>
    @endif

    <h4 class="mt-0 header-title"> Personal</h4>
    <p class="text-muted m-b-30 font-14">Informasi tentang data diri.</p>
    <div class="row form-group">
        <div class="col-sm-2">
            <label for="name">Nama PIC</label>
        </div>
        <div class="col-sm-10">
            <input id="name" name="name" type="text" class="form-control" placeholder="Name" value="{{$user->name}}" required>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-2">
            <label for="name">Address</label>
        </div>
        <div class="col-sm-10">
            <input name="address" type="text" class="form-control" placeholder="Address" value="{{$personal->address}}" required>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-2" >
            <label for="name">Nomor Whatsapp</label>
            <span class="badge badge-info">Jangan hilangkan kode +62</span>
        </div>
        <div class="col-sm-5">
            <input name="mobile" type="text" class="form-control" placeholder="Mobile 1" value="{{$organization->whatsapp}}">
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-2">
            <label for="name">Email</label>
        </div>
        <div class="col-sm-10">
            <input name="email" type="email" class="form-control" placeholder="Email" required value="{{$user->email}}">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <input type="hidden" name="personal_id" value="{{$personal->id}}">
            <input type="hidden" name="organization_id" value="{{$organization->id}}">
            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light">
                <i class="ion-checkmark-round"></i> Save
            </button>
        </div>
    </div>
</form>
