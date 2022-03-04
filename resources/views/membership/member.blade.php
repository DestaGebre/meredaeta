@extends('layouts.app')

@section('htmlheader_title')
    ዞባ
@endsection
ወረዳ
@section('contentheader_title')
    ወረዳ መመዝገቢ ቅጥዒ
@endsection

@section('main-content')

    <div class="x_content">
      <br />
        <form id="demo-formZone" data-parsley-validate class="form-horizontal form-label-left">
		<div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="text-center">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22366%22%20height%3D%22218%22%20viewBox%3D%220%200%20366%20218%22%20preserveAspectRatio%3D%22none%22%3E%3C%21--%0ASource%20URL%3A%20holder.js%2F366x218%2F%23fff%3A%23000%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A%28c%29%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C%21%5BCDATA%5B%23holder_15df6903dd1%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A18pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15df6903dd1%22%3E%3Crect%20width%3D%22366%22%20height%3D%22218%22%20fill%3D%22%23EEEEEE%22%2F%3E%3Cg%3E%3Ctext%20x%3D%22136.23333358764648%22%20y%3D%22117.4%22%3E366x218%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-src="holder.js/366x218/#fff:#000" class="img-responsive" alt="366x218" style="width: 366px; height: 218px;" data-holder-rendered="true">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-default btn-file btn_file">
                                                    <span class="fileinput-new cont_color">
                                                        Select image
                                                    </span>
                                                <span class="fileinput-exists cont_color">Change</span>
                                                <input name="..." type="file">
                                                </span>
                                                <a href="#" class="btn btn-default fileinput-exists cont_color" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table  table-striped" id="users">
                                        <tbody><tr>
                                            <td>User Name</td>
                                            <td>
                                                <a href="#" data-pk="1" class="editable editable-click" data-title="Edit User Name">Bella</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <a href="#" data-pk="1" class="editable editable-click" data-title="Edit E-mail">
                                                    gankunding@hotmail.com
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Phone Number
                                            </td>
                                            <td>
                                                <a href="#" data-pk="1" class="editable editable-click" data-title="Edit Phone Number">
                                                    (999) 999-9999
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>
                                                <a href="#" data-pk="1" class="editable editable-click" data-title="Edit Address">
                                                    Sydney, Australia
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>
                                                <a href="#" id="status" data-type="select" data-pk="1" data-value="1" data-title="Status" class="editable editable-click text-success">Activated</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Created At</td>
                                            <td>
                                                1 month ago
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>
                                                <a href="#" data-pk="1" class="editable editable-click" data-title="Edit City">Nakia</a>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </div>
                                <div class="row ">
                                    <div class="panel colr-hed">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Friends</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" class="thumbnail img-responsive" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar.jpg" alt=""><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar3.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar3.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar7.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar7.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar5.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar5.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar4.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar4.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar3.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar3.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar2.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar2.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar3.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar3.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar4.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar4.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar7.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar7.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" class="thumbnail img-responsive" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar1.jpg" alt=""><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar1.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar2.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar2.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar3.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar3.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xs-6">
                                                <div class="mag img-responsive">
                                                    <br>
                                                    <div class="magnify"><img data-toggle="magnify" src="User%20Profile%20_%20Josh%20Admin%20Template_files/avatar4.jpg" alt="" class="thumbnail img-responsive"><div class="magnify-large" style="background: rgba(0, 0, 0, 0) url(&quot;img/authors/avatar4.jpg&quot;) no-repeat scroll 0% 0%;"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
					</div>
     </form>
   </div>

@endsection

