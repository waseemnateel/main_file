{{Form::model($ducumentUpload,array('route' => array('document-upload.update', $ducumentUpload->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
       
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('role',__('Role'),['class'=>'form-label'])}}
                {{Form::select('role',$roles,null,array('class'=>'form-control select'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
                {{ Form::textarea('description',null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('document',__('Document'),['class'=>'form-label'])}}
                <div class="choose-file form-group">
                    <label for="document" class="form-label">
                        <div>{{__('Choose file here')}}</div>
                        <input type="file" class="form-control" name="document" id="document" data-filename="document_update">
                    </label>
                </div>
            </div>
        </div>
        
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

