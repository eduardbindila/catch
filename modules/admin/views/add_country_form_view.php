<form id="userData" method="post" action='' enctype="multipart/form-data" >
    <div class="input-group">
        <h3>Country Info</h3>
        <div class="form-line">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="id" maxlength="2" onkeyup="this.value = this.value.toUpperCase();" placeholder="Country Code" >
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button id="submitUserData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit Country  data</button>
        </div>
    </div>
</form>