<form id="userData" method="post" action='' enctype="multipart/form-data" >
    <div class="input-group">
        <h3>User Info</h3>
        <div class="form-line">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="email" class="form-control" name="email" placeholder="Email address" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="phone" placeholder="Phone" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="password" placeholder="Password" required>
        </div>
    </div>
    <div class="alert userTypesSelectorError hidden bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        User types could not be retrieved. <b>Please contact the administrator</b>
    </div>
    <div class="input-group">
        <select class="form-control userTypesSelector" required name="user_type">
            <option value="">Select user type</option>
        </select>
    </div>
    <div class="alert clientSelectorError hidden bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Clients could not be retrieved. <b>Please contact the administrator</b>
    </div>
     <div class="input-group">
        <select class="form-control clientSelector" name="client_id">
            <option value="">Link client to this user (user when User Type is Self customer)>
        </select>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button id="submitUserData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit user data</button>
        </div>
    </div>
</form>