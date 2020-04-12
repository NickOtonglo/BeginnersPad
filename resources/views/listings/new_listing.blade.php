@extends('layouts.base_new_listing')

@section('title')
    <title>New Listing | Beginners Pad</title>
@endsection

@section('listing-form')
  <div class="container-width">
     <div class="flex-title">Create new listing</div>
     <div class="flex-desc">Fill in the required details in the fields below:</div>
     <div class="container">
        <div class="container-width">
        @if(count($errors)>0)
             <ul>
                 @foreach($errors->all() as $error)
                    <li class="alert alert-danger">{{$error}}</li>
                 @endforeach
             </ul>
         @endif
        </div>
        {{ Form::open(array('url'=>'/manage_listings/new', 'files'=>true))}}
          {{csrf_field()}} 
          <div class="form-group">
            {{ Form::label('property_name','Property name') }}
            {{ Form::text('property_name','', ['class'=>'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('description','Description') }}
            {{ Form::textarea('description','', ['class'=>'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('location','Location (Area)') }}
            {{ Form::text('location','', ['class'=>'form-control']) }}
          </div>
          <div class="column">
             <div class="form-group">
              {{ Form::label('lat','Latitude') }}
              {{ Form::text('lat','', ['class'=>'form-control']) }}
             </div>
             <div class="form-group">
              {{ Form::label('lng','Longitude') }}
              {{ Form::text('lng','', ['class'=>'form-control']) }}
             </div>
          </div>
          <!--  -->
          <div class="form-group" style="height:100%; width:100%;">
            <div id="map" style="clear:both; height:400px;"></div>
          </div>
          <div class="form-group">
            {{ Form::label('available_units','Number of units available') }}
            {{ Form::text('available_units','', ['class'=>'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('units_sum','Total number of units') }}
            {{ Form::text('units_sum','', ['class'=>'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('unit_area','Unit area (sq. M)') }}
            {{ Form::text('unit_area','', ['class'=>'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('cost','Rent cost per unit') }}
            {{ Form::text('cost','', ['class'=>'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('post_images','Upload image(s)') }}
            <br>
            {{ Form::file('post_images[]', ['class'=>'file-path-wrapper','style'=>'visibility:visible','accept'=>"image/*",'multiple']) }}
          </div>
          {{ Form::submit('Submit', ['class'=>'btn btn-primary','value'=>'Submit']) }}
        {{ Form::close() }}
     </div>
  </div>
@endsection